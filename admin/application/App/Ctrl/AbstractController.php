<?php
/**
 * User: tufi
 * Date: 01.07.12
 * Time: 16:56
 * To change this template use File | Settings | File Templates.
 */

namespace App\Ctrl;
use App\Lang;
use Exception;
use App\Lib\Debug\Debugger;

abstract class AbstractController
{
    /**
     * @var \Zend\Http\PhpEnvironment\Request
     */
    protected $_request;
    /**
     * @var
     */
    protected $_response;

    /**
     * @var \App\DB\Client
     */
    protected $db;

    /**
     * @var String the page identifier
     */
    protected $identifier;

    /**
     * @var boolean
     */
    protected $isXmlHttpRequest;


    /**
     * default constructor
     * @param boolean $isXmlHttpRequest
     */
    public function __construct($isXmlHttpRequest=false)
    {
        $registry = \Bootstrap::getRegistry();
        $this->db = $registry::get('DB_CLIENT');
        $this->isXmlHttpRequest = (boolean) $isXmlHttpRequest;
    }

    /**
     * initial procedures,set page identifier here!
     */
    abstract public function init();

    /**
     * @abstract
     * @return mixed
     */
    abstract function indexAction();

    /**
     * @abstract
     * @return string
     */
    abstract function view();

    /**
     * @return string
     */
    abstract function handlePostData();

    /**
     * @param \Zend\Http\PhpEnvironment\Request $request
     */
    public function setRequest(\Zend\Http\PhpEnvironment\Request $request)
    {
        $this->_request = $request;
    }

    /**
     * @return \Zend\Http\PhpEnvironment\Request
     */
    public function getRequest()
    {
        return $this->_request;
    }

    /**
     * @param $response
     */
    public function setResponse($response)
    {
        $this->_response = $response;
    }

    /**
     * @return mixed
     */
    public function getResponse()
    {
        return $this->_response;
    }

    /**
     * @param array $tplArray
     * @param bool  $breakOnError throws an exception if a specified
     *                            template file is not found
     *
     * @throws \Exception
     */
    protected function _printView(array $tplArray, $breakOnError = false)
    {
        if (empty($tplArray)) {
            throw new Exception('ERROR 1200: TemplateSet cannot be empty');
        }

        if(!$this->isXmlHttpRequest){
            // Layout components first:
            foreach (
                array(
                    'header.php',
                ) as $key => $layoutTpl
            ) {
                include SRC_PATH . '/View/' . $layoutTpl;
            }
        }

        $content = '';

        ob_start();

        foreach ($tplArray as $key => $tpl) {
            $filename = SRC_PATH . '/View/' . $tpl;

            if (false == include($filename)) {
                if ($breakOnError) {
                    throw new Exception(
                        'ERROR 1201: Template file not found'
                            . $filename
                    );
                }
            }
        }

        /**
         * following variable $content will be issued on the page
         * content-frame.php
         */
        $content = ob_get_contents();
        ob_end_clean();

        include SRC_PATH . '/View/content-frame.php';
        !$this->isXmlHttpRequest && include SRC_PATH . '/View/footer.php';
    }

    /**
     * sets page parameters for backend admin pages. the values are in the
     * config.php
     */
    protected function setPageData()
    {
        if (!$this->identifier) {
            return;
        }

        $registry = \Bootstrap::getRegistry();
        $cfg = $registry::get('CONFIG');

        $this->title = $cfg->backend->pages->{$this->identifier}->title;
        $this->pageDescription = $cfg
            ->backend
            ->pages
            ->{$this->identifier}
            ->description;
    }

    /**
     *
     */
    protected function getFrontendData()
    {
        $data = $this->db->getRows('
            SELECT * from pages
            WHERE identifier LIKE "' . $this->identifier . '"
            AND lang="'.\Bootstrap::getLang().'"
        ');
        if (count($data) > 0) {
            // assign all database properties to object, to be used in the view
            foreach ($data[0] as $key => $val) {
                $this->{$key} = $val;
            }
        }
    }

    /**
     * @param $property
     *
     * @return null|mixed
     */
    public function __get($property)
    {
        $obj = new \ReflectionClass($this);
        if ($obj->hasProperty($property)) {
            return $this->$property;
        }
        return null;
    }

    /**
     * @param $postData
     * @return array
     */
    protected function handleMetaInformation($postData)
    {
        if (
            array_key_exists(
                'form-' . $this->identifier . '-submit-meta',
                $postData)
           ) {
            $online = (isset($postData['page-online'])
                || $this->identifier == 'index')
                ? '1'
                : '0';

            $title = $this->db->quote($postData['page-title']);
            $keywords = $this->db->quote($postData['page-keywords']);
            $description = $this->db->quote($postData['page-description']);
            $online = $this->db->quote($online);

            $sql= 'UPDATE pages SET title='.$title.', description='.$description.', keywords='.$keywords.', online='.$online.'
                WHERE identifier LIKE "'.$this->identifier.'"'
                . ' AND lang="' . \Bootstrap::getLang().'"';
            $result = $this->db->execute($sql);

            $affected = $result->getAffectedRows();

            return $affected > 0
                ? Lang::getString(\Bootstrap::getLang(),'MSG_META_SAVE_OK')
                : Lang::getString(\Bootstrap::getLang(),'MSG_SAVED_NOTHING');
        }
        return Lang::getString(\Bootstrap::getLang(),'MSG_SAVED_NOTHING');
    }

    /**
     * writes meta data into db
     * @return array
     */
    public function metaAction()
    {
        try {
            $this->messageSuccess = $this->handleMetaInformation(
                $this->_request->post()->toArray()
            );
        } catch (Exception $e) {
            $this->messageError = $e->getMessage();
        }

        $this->init();
        $this->view($this->identifier);
    }



    /**
     * @return void
     */
    public function setPageContentAction()
    {
        $postData = $this->_request->post()->toArray();
        if (
            array_key_exists(
                'form-' . $this->identifier . '-submit-content',
                $postData
            )
        ) {
            try {
                $pageContent = $this->db->quoteValue($postData['page-content']);

                $sql = 'update pages set content=' . $pageContent
                    . ' where identifier like "' . $this->identifier . '"'
                    . ' AND lang="' . \Bootstrap::getLang().'"';
                $result = $this->db->execute($sql);

                $affected = $result->getAffectedRows();

                $this->messageSuccess = $affected > 0
                    ? Lang::getString(\Bootstrap::getLang(),'MSG_SAVE_OK')
                    : Lang::getString(\Bootstrap::getLang(),'MSG_SAVED_NOTHING');
            } catch (Exception $e) {
                $this->messageError = $e->getMessage();
            }
        }
        $this->init();
        $this->view($this->identifier);
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
        $insertQuery = 'INSERT INTO `assets` '
            . $keysString . ' VALUES ' . $valuesString;
        $this->db->execute($insertQuery);
    }

    /**
     * @throws \Exception
     */
    public function uploadBgImageAction()
    {
        try {
            $registry = \Bootstrap::getRegistry();
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
                    == \Bootstrap::generateUploadToken(
                        $this->_request->post()->get('timestamp')
                    )
            ) {
                if (intval($fileData['error']) > 0) {
                    throw new Exception(
                        Lang::getString(
                            \Bootstrap::getLang(),
                            "UPLOAD_ERR_" . $fileData['error']
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
                $tempFile = $fileData['tmp_name'];
                $fileParts = pathinfo($fileData['name']);

                $extension = strtolower($fileParts['extension']);
                if (in_array($extension, $fileTypesImage)) {
                    $original_filename = md5($fileData['name'])
                        . '_bg.'
                        . $extension;

                    $targetFile= rtrim($targetFolder, '/')
                        . '/'
                        . $original_filename;


                    $oldBgImage = $this->db->getVal(
                        'SELECT backgroundImage FROM pages where identifier like \''
                            . $this->identifier . '\''
                            . ' AND lang="' . \Bootstrap::getLang().'"'
                    );

                    // delete old image if exists
                    if (file_exists($targetFolder.'/'.$oldBgImage) && is_file($targetFolder.'/'.$oldBgImage)) {
                        unlink($targetFolder . '/' . $oldBgImage);
                    }

                    $updateQuery = 'UPDATE`pages`
                    SET backgroundImage="'.$original_filename.'"
                    WHERE
                        identifier LIKE "'.$this->identifier.'"'
                        . ' AND lang="' . \Bootstrap::getLang().'"';
                    $this->db->execute($updateQuery);
                    move_uploaded_file($tempFile, $targetFile);

                    list($w, $h) = getimagesize($targetFile);
                    $sizes = \App\Lib\Image\ImageHandler::newSize($w, 1920, $h, 1080);


                    $image = new \App\Lib\Image\Image($targetFile);
                    // resize the bg image
                    $image->resize($sizes['w'],$sizes['h']);
                    // save image
                    $image->saveImage(
                        $targetFile,
                        $image->getImageData()
                    );

                    $image->clean();

                } else {
                    throw new \Exception('Invalid file type.');
                }

                $result = array(
                    'success'   => true,
                    'message'   => Lang::DE_UPLOAD_OK,
                    'filename' => $original_filename,
                    'uploaded'  => 1,
                );

                echo json_encode($result);
                return;
            }
        } catch (Exception $e) {

            $result = array(
                'success' => false,
                'error'   => $e->getMessage()
            );

            echo json_encode($result);
            return;
        }
    }
}
