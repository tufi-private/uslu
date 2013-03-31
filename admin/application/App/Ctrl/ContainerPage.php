<?php
namespace App\Ctrl;
use App\Ctrl\AbstractController;
use Bootstrap;
use Exception;
use App\Dispatcher;
use App\Lib\Debug\Debugger;
use App\Lib\Image\Image;
use App\Lang;
/**
 * User: tufi
 * Date: 22.09.12
 * Time: 23:07
 * To change this template use File | Settings | File Templates.
 */
class ContainerPage extends AbstractController
{

    /**
     * updates the title of the objects or projects
     */
    public function updateContentTitle()
    {
        $params = $this->_request->post()->get('params');
        if (is_array($params) && array_key_exists('title', $params)) {
            $title = $this->db->quoteValue($params['title']);
            $contentId = (int)$params['id'];
            if (trim($title) != '') {
                $sql = 'update content '
                    . 'set title=' . $title
                    . ' where id=' . $contentId;
                $this->db->execute($sql);
            }
        }
    }

    /**
     * updates the contents of objects or projects
     */
    public function updateObjectPageContentAction()
    {
        $content = $this->_request->post()->get('page-content-object');
        $contentId = (int)$this->_request->post()->get('contentId');

        if ($contentId > 0) {
            $sql = 'update content '
                . 'set content=' . $this->db->quoteValue($content)
                . ' where id=' . $contentId;
            $result = $this->db->execute($sql);
            $affected = $result->getAffectedRows();
            $this->messageSuccess = $affected > 0
                ? \App\Lang::DE_MSG_SAVE_OK
                : \App\Lang::DE_MSG_SAVED_NOTHING;
            $this->init();
            $this->view($this->identifier);
        } else {
            header(
                'Location: /' . Bootstrap::getBasePath() . '/index.php?show='
                    . $this->identifier
            );
            exit;
        }
    }

    /**
     * gets detailled data of the projects/objects
     */
    protected function getInnerPages()
    {
        if ((int)$this->id <= 0) {
            $this->objects = array();
            return;
        }

        $data = $this->db->getRows(
            'select * from content
            where pageId=' . $this->id
        );

        foreach ($data as $key => &$innerPageDetails) {
            $assetSql= "select
             `id`,
             `original_filename`, `thumbnail_filename`,
             `width`, `height`,
             `thumbnail_width`, `thumbnail_height`,
             `path`, `thumbnail_path`,
             `category`
             from assets where contentPageId=" . $innerPageDetails['id'];
            $assets = $this->db->getRows($assetSql);
            $innerPageDetails['assets'] = $assets;
        }

        $this->innerPages = $data;
    }

    /**
     * handles file uploads
     *
     * @throws \Exception
     */
    public function uploadAction()
    {
        $isPdfUpload = false;
        try {
            $contentId = (int)$this->_request->post()->get('contentId');
            if ($contentId <= 0) {
                throw new \Exception('Invalid content id found!');
            }

            $registry = Bootstrap::getRegistry();
            $cfg = $registry::get('CONFIG');

            // Define a destination
            $targetFolder = ROOT_PATH . '/' . $cfg->backend->assets->path;
            if (!is_dir($targetFolder)) {
                throw new \Exception(
                    'Target folder does not exist: ' . $targetFolder);
            }

            if (!is_writable($targetFolder)) {
                throw new \Exception(
                    'Target folder is not writable: ' . $targetFolder);
            }

            $fileData = $this->_request->file()->get('Filedata');
            if (!empty($fileData)
                && $this->_request->post()->get('token')
                    == Bootstrap::generateUploadToken(
                        $this->_request->post()->get('timestamp')
                    )
            ) {
                if (intval($fileData['error']) > 0) {
                    throw new Exception(
                        constant(
                            "App\Lang::" . Bootstrap::getLang() . "_UPLOAD_ERR_"
                                . $fileData['error']
                        )
                    );
                }

                // Validate the file type
                $fileTypesImage = $cfg
                    ->backend
                    ->assets
                    ->allowed
                    ->image
                    ->toArray();

                $fileParts = pathinfo($fileData['name']);

                $extension = strtolower($fileParts['extension']);
                if (!in_array($extension, $fileTypesImage)) {
                    throw new \Exception('Invalid file type.');
                }
                $pageId = $this->db->getVal(
                    'select pageId from content where id=' . $contentId
                );
                $original_filename = md5($fileData['name'])
                    . '_orig.'
                    . $extension;
                $thumbnail_filename = md5($fileData['name'])
                    . '_thumb.'
                    . $extension;
                $targetFileOrig = rtrim($targetFolder, '/')
                    . '/'
                    . $original_filename;

                $targetFileThumbnail = rtrim($targetFolder, '/')
                    . '/'
                    . $thumbnail_filename;

                $fileData['target_name'] = $targetFileOrig;
                $fileData['target_thumbnail_name'] = $targetFileThumbnail;

                $imageHandler = new \App\Lib\Image\ImageHandler();
                if ($imageHandler->resizeImage($fileData)) {
                    list($width, $height) = getimagesize(
                        $targetFileOrig
                    );
                    list($thumbnail_width, $thumbnail_height)
                        = getimagesize(
                        $targetFileThumbnail
                    );

                    $asset = array(
                        'pageId'             => $pageId,
                        'contentPageId'      => $contentId,
                        'width'              => $width,
                        'height'             => $height,
                        'thumbnail_width'    => $thumbnail_width,
                        'thumbnail_height'   => $thumbnail_height,
                        'original_filename'  => $original_filename,
                        'thumbnail_filename' => $thumbnail_filename,
                        'path'               =>
                        $cfg->backend->assets->foldername
                            . '/'
                            . $original_filename,
                        'thumbnail_path'     =>
                        $cfg->backend->assets->foldername
                            . '/'
                            . $thumbnail_filename,
                        'category'           => 'bilder',
                    );
                    $this->addToAssets($asset);
                }

                $result = array(
                    'success'   => true,
                    'message'   => \App\Lang::DE_UPLOAD_OK,
                    'uploaded'  => $asset,
                    'contentId' => $contentId
                );

                echo json_encode($result);
                return;
            }

            // pdf upload?
            $pdfArray = $this->_request->file()->get('pdf-file');
            if (!empty($pdfArray)) {

                if (intval($pdfArray['error']) > 0) {
                    throw new Exception(
                        constant(
                            "App\Lang::" . Bootstrap::getLang() . "_UPLOAD_ERR_"
                                . $pdfArray['error']
                        )
                    );
                }
                $isPdfUpload = true;
                $tempFile = $pdfArray['tmp_name'];
                $pageId = $this->db->getVal(
                    'select pageId from content where id=' . $contentId
                );
                // Validate the file type for pdf
                $fileTypesDocument = $cfg
                    ->backend
                    ->assets
                    ->allowed
                    ->asset
                    ->toArray();

                $fileParts = pathinfo($pdfArray['name']);
                $extension = strtolower($fileParts['extension']);

                if (!in_array($extension, $fileTypesDocument)) {
                    throw new \Exception('Invalid file type.');
                }

                $uniqueName = $pageId . "|"
                    . $contentId . "|"
                    . $pdfArray['name'];

                $pdfFilename = md5($uniqueName) . '.' . $extension;

                $targetFile = rtrim($targetFolder, '/')
                    . '/' . $pdfFilename;

                move_uploaded_file($tempFile, $targetFile);
                $pdfThumbnailArray = $this->_request->file()->get(
                    'pdf-thumbnail-file'
                );
                $hasThumbnail = false;
                if (!empty($pdfThumbnailArray)
                    && $pdfThumbnailArray['error'] == 0
                ) {
                    $fileTypesImage = $cfg
                        ->backend
                        ->assets
                        ->allowed
                        ->image
                        ->toArray();
                    $fileParts = pathinfo($pdfThumbnailArray['name']);
                    $extension = strtolower($fileParts['extension']);

                    if (in_array($extension, $fileTypesImage)) {
                        $pdfThumbnailFilename = md5($uniqueName)
                            . '.' . $extension;

                        $targetFile = rtrim($targetFolder, '/')
                            . '/' . $pdfThumbnailFilename;

                        $pdfThumbnailArray['target_name'] = $targetFile;
                        $pdfThumbnailArray['target_width'] = $cfg
                            ->backend
                            ->assets
                            ->thumbnail_width;

                        $pdfThumbnailArray['target_height'] = $cfg
                            ->backend
                            ->assets
                            ->thumbnail_height;

                        $imageHandler = new \App\Lib\Image\ImageHandler();
                        $hasThumbnail = $imageHandler->resizeOne(
                            $pdfThumbnailArray
                        );
                    }
                }

                list($thumbnail_width, $thumbnail_height) = $hasThumbnail
                    ? getimagesize($targetFile)
                    : array(null, null);

                $asset = array(
                    'pageId'             => $pageId,
                    'contentPageId'      => $contentId,
                    'original_filename'  => $pdfFilename,
                    'thumbnail_filename' => ($hasThumbnail
                        ? $pdfThumbnailFilename : ''),
                    'path'               => $cfg->backend->assets->foldername
                        . '/' . $pdfFilename,
                    'thumbnail_path'     => ($hasThumbnail
                        ? $cfg->backend->assets->foldername
                            . '/'
                            . $pdfThumbnailFilename
                        : ''),
                    'thumbnail_width'    => $thumbnail_width,
                    'thumbnail_height'   => $thumbnail_height,
                    'category'           => 'pdf',
                );
                $this->addToAssets($asset);
            }
        } catch (Exception $e) {
            if ($isPdfUpload) {
                $this->messageError = $e->getMessage();
            } else {
                $result = array(
                    'success' => false,
                    'error'   => $e->getMessage()
                );

                echo json_encode($result);
                return;
            }
        }

        if (is_null($this->messageError)) {
            $this->messageSuccess = \App\Lang::DE_UPLOAD_OK;
        }

        $forwardAction = $isPdfUpload
            ? $this->identifier
            : '';

        $this->init();
        $this->view($forwardAction);
    }

    /**
     * updates asset cache in the database
     *
     * @param $assetObject
     */
    protected function addToAssets($assetObject)
    {
        $keysString = '(`' . implode('`, `', array_keys($assetObject)) . '`)';
        $valuesString = '(\'' . implode('\', \'', $assetObject) . '\')';
        $insertQuery
            =
            'INSERT INTO `assets` ' . $keysString . ' VALUES ' . $valuesString;
        $this->db->execute($insertQuery);
    }
    /**
     * deleting any assets
     */
    public function deleteAssetsAction()
    {
        $deleteIds = $this->_request->post()->get('assetId');
        if (empty($deleteIds)) {
            $this->messageSuccess = Lang::DE_MSG_SAVED_NOTHING;
            $this->init();
            $this->view($this->identifier);
            return;
        }

        $logger = \Bootstrap::getLogger();

        $logMessageSuccess = array();
        $logMessageError = array();

        // be paranoid:
        foreach ($deleteIds as $key => &$deleteId) {
            $deleteIds[$key] = (int)$deleteId;
        }

        $assetList = $this->getAssetDetails($deleteIds);

        $registry = Bootstrap::getRegistry();
        $cfg = $registry::get('CONFIG');

        // Define a destination
        $assetFolder = ROOT_PATH . '/' . $cfg->backend->assets->path;

        foreach ($assetList as $key => $assetDetails) {
            $deleteArray = array();
            $assetFilenameOriginal = $assetDetails['original_filename'];
            $deleteArray[] = $assetFolder . '/' . $assetFilenameOriginal;

            if(!empty($assetDetails['thumbnail_filename'])) {
                $assetFilenameThumbnail = $assetDetails['thumbnail_filename'];
                $deleteArray[] = $assetFolder . '/' . $assetFilenameThumbnail;
            }
            foreach ($deleteArray as  $assetFile) {
                if (file_exists($assetFile) && is_file($assetFile)) {
                    if (unlink($assetFile)) {
                        $logMessageSuccess[] = sprintf(
                            Lang::DE_UNLINK_OK, $assetFile
                        );
                    } else {
                        $logMessageError[] = sprintf(
                            Lang::DE_UNLINK_ERROR, $assetFile
                        );

                        $logger->log(
                            \Zend\Log\Logger::ERR,
                            Lang::DE_UNLINK_ERROR, $assetFile
                        );
                    }
                } else {
                    $logMessageError[] = sprintf(
                        Lang::DE_FILE_NOT_FOUND, $assetFile
                    );
                }
            }

            $deleteQuery = 'DELETE FROM assets where id='
                . (int)$assetDetails['id'];
            $result = $this->db->execute($deleteQuery);
            $affected = $result->getAffectedRows();
            if ($affected == 1) {
                $logMessageSuccess[] = sprintf(
                    Lang::DE_DELETE_OK, $assetDetails['original_filename']
                );
            } elseif ($affected == 0) {
                $logMessageError[] = sprintf(
                    Lang::DE_DELETE_ERROR, 'assets', $assetDetails['id']
                );

                $logger->log(
                    \Zend\Log\Logger::ERR,
                    Lang::DE_DELETE_ERROR, 'assets', $assetDetails['id']
                );
            }
        }

        if (empty($logMessageError)) {
            $this->messageSuccess = json_encode(
                implode("<br />>\n", $logMessageSuccess)
            );
        } else {
            $this->messageError = json_encode(
                implode("<br />\n", $logMessageError)
                    . "<hr />"
                    . implode("<br />\n", $logMessageSuccess)
            );
        }

        $this->init();
        $this->view($this->identifier);
    }

    /**
     * @param array $assetIds
     *
     * @return array
     */
    public function getAssetDetails(array $assetIds)
    {
        if (empty($assetIds)) {
            return array();
        }

        $selectQuery = 'select * from assets'
            . ' where id IN (' . implode(',', $assetIds) . ')';

        return $this->db->getRows($selectQuery);
    }

    /**
     * @param $contentId
     *
     * @return array
     */
    protected function getAssets($contentId)
    {
        $selectQuery = 'select * from assets where contentPageId=' . (int)$contentId;
        return $this->db->getRows($selectQuery);
    }


    /**
     * initial procedures,set page identifier here!
     */
    public function init()
    {
        // TODO: Implement init() method.
    }

    /**
     * @return mixed
     */
    function indexAction()
    {
        // TODO: Implement indexAction() method.
    }

    /**
     * @return string
     */
    function view()
    {
        // TODO: Implement view() method.
    }

    /**
     * @return string
     */
    function handlePostData()
    {
        // TODO: Implement handlePostData() method.
    }
}
