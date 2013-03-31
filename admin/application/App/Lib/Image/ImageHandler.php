<?php
/**
 * Author: tufi
 * Date: 26.07.12
 * Time: 00:00
 */
namespace App\Lib\Image;
use Bootstrap;

/**
 *
 */
class ImageHandler
{
    /**
     * detects only by extension
     *
     * @static
     *
     * @param $file
     *
     * @return bool
     */
    public static function isImage($file)
    {
        $parts = explode('.', $file);
        $extension = $parts[(count($parts) - 1)];

        return in_array($extension, array('jpg', 'jpeg', 'gif', 'png'));
    }


    /**
     * Resize given (uploaded) image.
     * Generares an image of 450x450px and a 140x200px thumbnail image.
     *
     * @param array $_arr_file
     *              ['name'] The original name of the file
     *                      on the client machine.
     *              ['type'] The mime type of the file, if
     *                      the browser provided this information. An example would be
     *                      "image/gif". This mime type is however not checked on the
     *                      PHP side and therefore don't take its value for granted.
     *              ['size'] The size, in bytes, of the
     *                      uploaded file.
     *              ['tmp_name'] The temporary filename of
     *                      the file in which the uploaded file was stored on the
     *                      server.
     *              ['error'] The error code associated with this file upload.
     *              ['target_path'] The target path of the resized image.
     *              ['target_name'] target file name
     *              ['target_thumbnail_name'] target file thumbnail name
     *              ['orig_width'] The original width of the resized image.
     *              ['orig_height'] The original height of the resized image.
     *              ['target_width'] The target width of the resized image.
     *              ['target_height'] The target height of the resized image.
     *              ['target_thumbnail_width'] The target thumbnail width of
     *                      the resized image.
     *              ['target_thumbnail_height'] The target thumbnail height of
     *                      the resized image.
     *
     * @return boolean
     */
    public function resizeImage($_arr_file)
    {
        $registry = Bootstrap::getRegistry();
        $cfg = $registry::get('CONFIG');
        $assetCfg = $cfg->backend->assets->toArray();
        $targetImageWidth = (!array_key_exists('target_width', $_arr_file)
            || (int)$_arr_file['target_width'] <= 0)
            ? $assetCfg['width']
            : (int)$_arr_file['target_width'];

        $targetImageHeight = (!array_key_exists('target_height', $_arr_file)
            || (int)$_arr_file['target_height'] <= 0)
            ? $assetCfg['height']
            : (int)$_arr_file['target_height'];

        $targetImageThumbnailWidth = (
            !array_key_exists(
                'target_thumbnail_width',
                $_arr_file
            )
            || (int)$_arr_file['target_thumbnail_width'] <= 0)
            ? $assetCfg['thumbnail_width']
            : (int)$_arr_file['target_thumbnail_width'];

        $targetImageThumbnailHeight = (
            !array_key_exists(
                'target_thumbnail_height',
                $_arr_file
            )
            || (int)$_arr_file['target_thumbnail_height'] <= 0)
            ? $assetCfg['thumbnail_height']
            : (int)$_arr_file['target_thumbnail_height'];

        $targetImageDir= (!array_key_exists('target_path', $_arr_file)
            || trim($_arr_file['target_path']) == '')
            ? $assetCfg['path']
            : $_arr_file['target_path'];

        $targetImagePath = (!array_key_exists('target_name', $_arr_file)
            || trim($_arr_file['target_name']) == '')
            ? $targetImageDir. '/' . $_arr_file['name'] // original filename
            : $_arr_file['target_name'];

        $targetImageThumbnailPath = (
            !array_key_exists('target_thumbnail_name', $_arr_file)
            || trim($_arr_file['target_thumbnail_name']) == ''
        )
            ? $targetImageDir. '/' . 'thumb_'.$_arr_file['name'] // original filename
            : $_arr_file['target_thumbnail_name'];

        $jpegQuality = $assetCfg['jpeg_quality'];

        $_output = array();

        $_arr_file['target_width'] = $targetImageWidth;
        $_arr_file['target_height'] = $targetImageHeight;
        $_arr_file['target_thumbnail_width'] = $targetImageThumbnailWidth;
        $_arr_file['target_thumbnail_height'] = $targetImageThumbnailHeight;
        $_arr_file['target_path'] = $targetImageDir;


        if (!$this->useImageMagick()) {

            // no ImageMagick available -> using GD-Lib..
            return $this->resizeImageGD($_arr_file);
        }
        // we can use ImageMagick..
        $execoutput = array();
        # create big thumbnail...
        exec(
            'convert ' . $_arr_file ['tmp_name'] . ' -resize ' . $targetImageWidth
                . 'x' . $targetImageHeight
                . ' -density 150 ' . $targetImagePath, &$execoutput
        );
        echo'convert ' . $_arr_file ['tmp_name'] . ' -resize '
            . $targetImageWidth
            . 'x' . $targetImageHeight . ' -quality ' . $jpegQuality
            . ' -density 150 ' . $targetImagePath;
        # check if creation successfull
        if (file_exists($targetImagePath)) {
            # create small thumbnail...
            exec(
                'convert ' . $_arr_file ['tmp_name'] . ' -resize '
                    . $targetImageThumbnailWidth . 'x'
                    . $targetImageThumbnailHeight
                    . ' -density 150 '
                    . $targetImageThumbnailPath, &$execoutput
            );
        }

        if (!file_exists($targetImageThumbnailPath)) {
            // ImageMagick did not work; try GD-LIB:
            return $this->resizeImageGD($_arr_file);
        }

        /*$_output ['orig'] = getimagesize($targetImagePath);
        $_output ['thumb'] = getimagesize($targetImageThumbnailPath);

        return $_output;*/
        return true;
    }

    /**
     * General Function for resizing Images
     *
     * @param String $_inPath  path to the original Image
     * @param String $_outPath path to the resized Image
     * @param int    $_max_x   max width
     * @param int    $_max_y   max height
     *
     * @return array
     */
    public function resize($_inPath, $_outPath, $_max_x, $_max_y)
    {
        $_output = array();
        $execoutput = array();
        if (!file_exists($_inPath)) {
            $_output ['error'][]
                = ERR_CODE8 . ' Datei nicht gefunden: ' . $_inPath;
            errorHandler(__FUNCTION__, 8, 'Datei nicht gefunden: ' . $_inPath);
            return $_output;
        }
        # create big thumbnail...
        exec(
            'convert ' . $_inPath . ' -resize ' . $_max_x . 'x' . $_max_y
                . ' -quality ' . IMG_JPEGQUALITY_ORIG . ' -density 150 '
                . $_outPath, &$execoutput
        );

        # check if creation successfull
        if (!file_exists($_outPath)) {
            $_output ['error'][]
                =
                ERR_CODE8 . ' Datei konnte nicht skaliert werden: ' . $_inPath;
            $_output ['error'][]
                = 'convert ' . $_inPath . ' -resize ' . $_max_x . 'x' . $_max_y
                . ' -quality ' . IMG_JPEGQUALITY_ORIG . ' -density 150 '
                . $_outPath;
            errorHandler(
                __FUNCTION__, 8, 'dump(exec)' . getLogEntry($execoutput)
            );
            return $_output;
        }

        $_output ['success'][] = $_outPath;
        $_output ['success'][] = getimagesize($_outPath);
        return $_output;
    }
    /**
     * Resize given (uploaded) image.
     * Generares an image of 450x450px and a 140x200px thumbnail image.
     *
     * @param array $_arr_file
     *              ['name'] The original name of the file
     *                      on the client machine.
     *              ['type'] The mime type of the file, if
     *                      the browser provided this information. An example would be
     *                      "image/gif". This mime type is however not checked on the
     *                      PHP side and therefore don't take its value for granted.
     *              ['size'] The size, in bytes, of the
     *                      uploaded file.
     *              ['tmp_name'] The temporary filename of
     *                      the file in which the uploaded file was stored on the
     *                      server.
     *              ['error'] The error code associated with this file upload.
     *              ['target_path'] The target path of the resized image.
     *              ['target_name'] target file name
     *              ['target_thumbnail_name'] target file thumbnail name
     *              ['orig_width'] The original width of the resized image.
     *              ['orig_height'] The original height of the resized image.
     *              ['target_width'] The target width of the resized image.
     *              ['target_height'] The target height of the resized image.
     *              ['target_thumbnail_width'] The target thumbnail width of
     *                      the resized image.
     *              ['target_thumbnail_height'] The target thumbnail height of
     *                      the resized image.
     *
     * @return array
     */
    public function resizeImageGD($_arr_file)
    {
        $_big_thumbnail_path = $_arr_file['target_name'];
        $_small_thumbnail_path =  $_arr_file['target_thumbnail_name'];

        // get image size - requires GD library
        list ($width, $height) = getimagesize($_arr_file ['tmp_name']);
        $_dimensionsBig = self::newSize(
            $width, $_arr_file['target_width'],
            $height, $_arr_file['target_height']
        );
        $_dimensionsSmall = self::newSize(
            $width, $_arr_file['target_thumbnail_width'],
            $height, $_arr_file['target_thumbnail_height']
        );

        // create first big thumbnail with image_class
        //include_once ('library/image/class.image.inc.php');
//        set_time_limit(140);
            // create new image from posted Image
            $image = new Image($_arr_file ['tmp_name']);
            // resize the big image first..
            $image->resize(
                round($_dimensionsBig ['w']),
                round($_dimensionsBig ['h'])
            );
            // save image
            $image->saveImage(
                $_big_thumbnail_path,
                $image->getImageData()
            );
            // resize the small image now..
            $image->resize(
                round($_dimensionsSmall ['w']),
                round($_dimensionsSmall ['h'])
            );
            // save image to media/orig/ directory
            $image->saveImage(
                $_small_thumbnail_path,
                $image->getImageData()
            );

            $image->clean();
            // delete uploaded raw image from tmp folder:
            unlink($_arr_file ['tmp_name']);

        /*$_output ['orig'] = getimagesize($_big_thumbnail_path);
        $_output ['thumb'] = getimagesize($_small_thumbnail_path);
        return $_output;*/

        return true;
    }


    /**
     * Calculates new scaled sizes for an Image preserving aspect ratio.
     *
     * @param integer $_w
     * @param integer $max_w
     * @param integer $_h
     * @param integer $max_h
     *
     * @return array
     */
    public static function newSize($_w, $max_w, $_h, $max_h)
    {

        $_new = array();

        if ($_w > $max_w || $_h > $max_h) {
            $x_ratio = $max_w / $_w;
            $y_ratio = $max_h / $_h;
            if (($x_ratio * $_h) < $max_h) {
                $_new ['h'] = ceil($x_ratio * $_h);
                $_new ['w'] = $max_w;
            } else {
                $_new ['w'] = ceil($y_ratio * $_w);
                $_new ['h'] = $max_h;
            }
        } else {
            $_new ['w'] = $_w;
            $_new ['h'] = $_h;
        }

        return $_new;
    }

    /**
     * detects whether imagemagick is available.
     *
     * @return boolean
     * 			 - true if imagemagick is available on system
     * 			 - false if imagemagick is not available on system
     */
    private function useImageMagick()
    {
        return false;
        $_versionInfo = @`convert -version`;
        if ($_versionInfo !== null && !empty ($_versionInfo)) {
            return true;
        } else {
            return false;
        }
    }

    public function resizeOne($_arr_file)
    {
        $_big_thumbnail_path = $_arr_file['target_name'];

        // get image size - requires GD library
        list ($width, $height) = getimagesize($_arr_file ['tmp_name']);
        $_dimensionsBig = self::newSize(
            $width, $_arr_file['target_width'],
            $height, $_arr_file['target_height']
        );

        // create new image from posted Image
        $image = new Image($_arr_file ['tmp_name']);
        // resize the big image first..
        $image->resize(
            round($_dimensionsBig ['w']),
            round($_dimensionsBig ['h'])
        );
        // save image
        $image->saveImage(
            $_big_thumbnail_path,
            $image->getImageData()
        );

        $image->clean();
        unlink($_arr_file ['tmp_name']);
        return true;
    }
}
