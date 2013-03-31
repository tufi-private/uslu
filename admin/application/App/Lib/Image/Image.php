<?php
namespace App\Lib\Image;
/*****************************************************************************************************
 * @author          Michael Conroy (mconroy@buffalo.edu)
 * @class           myImage
 * @version         0.2.1
 * @language        PHP 5
 * @description     class for image manipulation / information
 * @requirements    image constants (folder - constants)
 *
 * @created         May 17, 2004
 *
 * @updated         July 15, 2004
 *     - added
 *         * about
 *         * setImageDir
 *         * setThumbDir
 *         * getImageStats
 *     - altered
 *         * setThumbSize - took out thumbnail directory parameter
 *         * makeThumbnail - removed thumbnail directory parameter and automatic save
 *         * saveThumbnail - removed unnecessary code and made it a public function
 *         * saveImage - removed code that would destroy image data after a save
 *         * clean - added thumbnail variables and destory image data functions
 *
 * @updated         April 26, 2005
 *     - removed
 *         * error functions for Exception clauses
 *     -altered
 *         * displayImage() to display()
 *
 * ***************************************************************************************************/

/***** DEFINED CONSTANTS *****/

define('NOGDLIB', 'erforderliche (\'GD\') Bibliothek ist nicht installiert oder nicht geladen');
define('NOURL', 'bild url string ist leer');
define('NOIMAGE', 'es konnte keine Bilddatei gefunden werden, aus der Informationen gelesen werden konnten ');
define('NOMIME', 'Bild mime type unbekannt');
define('NOWIDTH', 'Bild breite (width) unbekannt');
define('NOHEIGHT', 'Bild hoehe (height) unbekannt');
define('NODEPTH', 'Bild Bittiefe unbekannt');
define('NOCHANNELS', 'Anzahl der Farbkanaele im Bild unbekannt');
define('NOTYPE', 'Bildtyp unbekannt');
define('NOTTHUMBDIR', 'thumbnail-Verzeichnis existiert nicht');
define('NODIR', 'verzeichnis existiert nicht');
define('NOIMGDATA', 'kein Bild-Data');
define('FAILEDSAVETHUMB', 'konnte Thumbnail nicht speichern');
define('FAILEDSAVE', 'konnte Bilddatei nicht speichern');
define('FAILEDLOADIMAGE', 'laden des Bildes fehlgeschlagen');
define('FAILEDCROP', 'Ausschneiden fehlgeschlagen');
define('FAILEDROTATE', 'Rotieren fehlgeschlagen');
define('FAILEDRESIZE', 'Bildgroesse aendern fehlgeschlagen');
define('FAILEDINFO', 'konnte Bildinformationen nicht erhalten');
define('FAILEDTHUMB', 'Thumbnailerstellung fehlgeschlagen');
define('FAILEDTHMBSIZE', 'Setzen des Klassen Objects thumb size fehlgeschlagen');
define('INVALIDPARAM', 'ungueltige Parameter liste für Methode');
define('OUTOFBOUNDS', 'Bilddimensionen ueberschritten');

class Image
{

    /***** OBJECT VARS *****/
    protected $imgUrl = null; //location of image
    protected $imgName = null; //image name
    protected $imgFileType = null; //file type of an image (ie ".jpg")
    protected $imgWidth = null; //image dimensional width
    protected $imgHeight = null; //image dimensional height
    protected $imgDepth = null; //image bit depth
    protected $imgChannels = null; //image number of channels
    protected $imgMime = null; //mimetype of image (ie "image/jpeg")
    protected $imgType = null; //image type (ie "GIF")
    protected $imgDir = null; //directory for which to save images on the system

    protected $imgData = null; //holds the loaded image data

    protected $thmbUrl = null; //url of thumbnail once made
    protected $thmbWidth = null; //max width of thumbnail
    protected $thmbHeight = null; //max height of thumbnail
    protected $thmbType = 'exact'; //how to make thumbnail (exact,percentage)
    protected $thmbDir = null; //where to store the thumbnail

    protected $thmbData = null; //holds the thumbnail image data

    protected $gdlib = true; //GD library flag

    //about variables
    private $a_created = 'May 17, 2004';
    private $a_updated = 'April 26, 2005';
    private $a_version = '0.2.1';


    /***** PUBLIC METHODS *****/

    /**
     * Gives information about this class object.
     *
     * @return    string
     */
    public function about()
    {
        return "Created by:  Michael Conroy (mconroy@buffalo.edu)\nDate:  "
            . $this->a_created . "\nLast Updated: " . $this->a_updated
            . "\nLang:  PHP5\nVersion:  " . $this->a_version;
    }

    //end about

    /**
     * Sets location of image to load into the object and manipulate.
     *
     * @param    url    the string of the path to the image file
     *
     * @return    boolean
     */
    public function setImageUrl($url = '')
    {
        if ($this->gdlib) { //check to see if the GD graphics library is available
            if ($url !== '') { //check to see URL of image not empty
                $this->imgUrl = $url; //assign image URL
                if ($this->setImageName()) {
                    if ($this->getImageInfo()) {
                        return $this->loadImage();
                    }
                }
            } else {
                throw new Exception(NOURL); //set error
            }
        } else {
            throw new Exception(NOGDLIB); //set error
        }
    }

    //end setImage

    /**
     * Sets the image's data, the data is the information about each pixel of the image.
     *
     * @param    data    image data
     *
     * @return    boolean
     */
    public function setImageData($data = null)
    {
        if (isset($data)) {
            $this->imgData = $data;
            return true;
        }
        throw new Exception(NOIMGDATA);
    }

    //end setImageData

    /**
     * Sets the object's thumbnail size, directory for which to write the thumbnail image and the style by which to make the thumbnail.
     *
     * @param    height    height in pixels (number) of the thumbnail image to be produced
     *                     width    width in pixels (number) of the thumbnail image to be produced
     *                     type    string (exact,percentage) describing what method to use to make the thumbnail
     *
     * @return    boolean
     */
    public function setThumbSize($height = null, $width = null, $type = 'exact')
    {
        if ($height && $width && $type) {
            $this->thmbHeight = $height;
            $this->thmbWidth = $width;
            $this->thmbType = $type;
            return true;
        }
        throw new Exception(FAILEDTHMBSIZE);
    }

    //end setThumbSize

    /**
     * Sets the image directory to use if we need to save images or look up other images
     *
     * @param    dir    string, path of the directory we want to use
     *
     * @return    boolean    true if the directory was set, false otherwise
     */
    public function setImageDir($dir = '')
    {
        if (is_dir($dir)) {
            $this->imgDir = $dir;
            return true;
        }
        throw new Exception(NODIR);
    }

    //end setImageDir

    /**
     * Sets the thumbnail directory to use if we need to save images or look up other images
     *
     * @param    dir    string, path of the directory we want to use
     *
     * @return    boolean    true if the directory was set, false otherwise
     */
    public function setThumbDir($dir = '')
    {
        if (is_dir($dir)) {
            $this->thmbDir = $dir;
            return true;
        }
        throw new Exception(NOTTHUMBDIR);
    }

    //end setThumbDir

    /**
     * Checks to see if the image data is loaded from the given image url.
     *
     * @return boolean
     */
    public function isImageSet()
    {
        if (isset($this->imgData)) { //check the image data variable to see if it contains anything
            return true;
        }
        return false;
    }

    //end isImageSet

    /**
     * Returns the URL of the image.
     *
     * @return    mixed    if the url of the image for the object is set then return the image's path otherwise return false
     */
    public function getImageUrl()
    {
        if (isset($this->imgUrl)) {
            return $this->imgUrl;
        }
        throw new Exception(NOURL);
    }

    //end getImage

    /**
     * Returns the MIME type of the loaded image.
     *
     * @return    mixed    if the image's mime type object variable is set it will return the image's mime type otherwise return false
     */
    public function getImageMimeType()
    {
        if (isset($this->imgMime)) {
            return $this->imgMime;
        }
        throw new Exception(NOMIME);
    }

    //end getImageMimeType

    /**
     * Returns the width of the currently loaded image.
     *
     * @return    mixed    if the image's width is known return the width in pixels otherwise return false
     */
    public function getImageWidth()
    {
        if (isset($this->imgWidth)) {
            return $this->imgWidth;
        }
        throw new Exception(NOWIDTH);
    }

    //end getImageWidth

    /**
     * Returns the height of the currently loaded image.
     *
     * @return    mixed    if the image's height is known return the height in pixels otherwise return false
     */
    public function getImageHeight()
    {
        if (isset($this->imgHeight)) {
            return $this->imgHeight;
        }
        throw new Exception(NOHEIGHT);
    }

    //end getImageHeight

    /**
     * Returns the bit depth of the currently loaded image.
     *
     * @return    mixed    if the image's bit depth is known that return it as a numerical value otherwise return false
     */
    public function getImageBitDepth()
    {
        if (isset($this->imgDepth)) {
            return $this->imgDepth;
        }
        throw new Exception(NODEPTH);
    }

    //end getImageBitDepth

    /**
     * Returns the number of channels within the currently loaded image.
     *
     * @return    mixed    if the image's number of channels is known return the numerical value describing how many otherwise return false
     */
    public function getImageChannels()
    {
        if (isset($this->imgChannels)) {
            return $this->imgChannels;
        }
        throw new Exception(NOCHANNELS);
    }

    //end getImageChannels

    /**
     * Returns the type of image that is currently loaded.
     *
     * @return    mixed    returns the type of image (ie. JPEG,GIF,PNG,etc) otherwise returns false
     */
    public function getImageType()
    {
        if (isset($this->imgType)) {
            return $this->imgType;
        }
        throw new Exception(NOTYPE);
    }

    //end getImageType

    /**
     * Returns the image's raw data information.
     *
     * @return    mixed    returns the raw image data if the data is loaded otherwise returns false
     */
    public function getImageData()
    {
        if (isset($this->imgData)) {
            return $this->imgData;
        }
        throw new Exception(NOIMGDATA);
    }

    //end getImageData

    /**
     * Returns the URL of the produced thumbnail from the currently loaded image.
     *
     * @return    mixed    returns the path to the image's thumbnail, false otherise
     */
    public function getThumbUrl()
    {
        if (isset($this->thmbUrl)) {
            return $this->thmbUrl;
        }
        throw new Exception(NOTHUMBURL);
    }

    //end getThumbUrl

    /**
     * Returns all information obtained about the current loaded image
     *
     * @return    array    associative array of image information
     */
    public function getImageStats()
    {
        if ($this->imgUrl) {
            return array(
                'url'     => $this->imgUrl, 'name'=> $this->imgName,
                'filetype'=> $this->imgFileType, 'width'   => $this->imgWidth,
                'height'  => $this->imgHeight, 'depth'   => $this->imgDepth,
                'channels'=> $this->imgChannels, 'mime'    => $this->imgMime,
                'type'    => $this->imgType
            );
        }
        throw new Exception(NOIMAGE);
    }

    //end getImageStats

    /**
     * Creates a thumbnail image of the currently loaded image and saves it to the specified directory.
     *
     * @return    boolean
     */
    public function makeThumbnail()
    {
        if ($this->gdlib) {
            if ((isset($this->thmbWidth)) && (isset($this->thmbHeight))
                && (isset($this->thmbType))
            ) {
                //proceed with making thumbnail image
                switch ($this->thmbType) {
                    case 'percentage':
                        $this->thmbData =& $this->makeThumbnailPercentage();
                        break;
                    case 'exact':
                    default:
                        $this->thmbData =& $this->makeThumbnailExact();
                        break;
                }
                if ($this->thmbData) {
                    return true;
                }
            }
            throw new Exception(FAILEDTHUMB);
        }
        throw new Exception(NOGDLIB);
    }

    //end makeThumbnail

    /**
     * Resizes the currently loaded image to the specified width and height.
     *
     * @param    width    new width in pixels of the resized image
     *                    height    new height in pixels fo the resized image
     *
     * @return    boolean
     */
    public function resize($width = null, $height = null)
    {
        if ($width && $height) {
            $resized = @imagecreatetruecolor($width, $height);
            if (@imagecopyresampled(
                $resized, $this->imgData, 0, 0, 0, 0, $width, $height,
                $this->imgWidth, $this->imgHeight
            )
            ) {
                $this->imgData = $resized;
                $this->imgWidth = $width;
                $this->imgHeight = $height;
                return true;
            }
            throw new Exception(FAILEDRESIZE);
        }
        throw new Exception(INVALIDPARAM);
    }

    //end resize

    /**
     * Will delete portions of the image not defined within the parameters of the user described box.  The user described box is defined by a top left (x,y) coordinate pairing and the height and width of this box.
     *
     * @param    x    starting x coordinate (number) within the image's pixel boundaries
     *                y    starting y coordinate (number) within the image's pixel boundaries
     *                width    width in pixels of the virtual box for which any image data outside the box will be deleted
     *                height    height in pixels of the virtual box for which any image data outside the box will be deleted
     *
     * @return    boolean
     */
    public function crop($x = 0, $y = 0, $width = 0, $height = 0)
    {
        if ($width && $height) {
            $cropped = @imagecreatetruecolor($width, $height);
            if ((!($x + $width > $this->imgWidth))
                && (!($y + $height > $this->imgHeight))
                && ($x > 0)
                && ($y > 0)
            ) {
                if (@imagecopyresampled(
                    $cropped, $this->imgData, 0, 0, $x, $y, $width, $height,
                    $width, $height
                )
                ) {
                    $this->imgData = $cropped;
                    $this->imgWidth = $width;
                    $this->imgHeight = $height;
                    return true;
                }
                throw new Exception(FAILEDCROP);
            }
            throw new Exception(OUTOFBOUNDS);
        }
        throw new Exception(INVALIDPARAM);
    }

    //end crop

    /**
     * Attempts to rotate the image a specified number of degrees.
     *
     * @param    degrees    angle of rotation
     *
     * @return    boolean
     */
    public function rotate($degrees = 90.0)
    {
        if ($this->setImageData(@imagerotate($this->imgData, $degrees, 0))) {
            return true;
        }
        throw new Exception(FAILEDROTATE);
    }

    //end rotate


    /**
     * Writes the image to the screen.
     */

    /*********** NEEDS WORK ****************/
    public function display()
    {
        if ($this->imgData) {
            @imagejpeg($this->imgData);
        }
        throw new Exception(NOIMGDATA);
    }

    //end display

    /**
     * Writes the thumbnail image to the screen
     */

    /*********** NEEDS WORK ****************/
    public function displayThumb()
    {
        if ($this->thmbData) {
            @imagejpeg($this->thmbData);
        }
        throw new Exception(NOIMGDATA);
    }

    //end displayThumb

    /**
     * Given a file path name and the raw data of an image this will attempt to save the image to the file system.
     *
     * @param    file    a string describing the path and file name for which to save the image as
     *                   image    image data
     *
     * @return    boolean
     */
    public function saveImage($file = null, $image = null)
    {
        switch (strtolower($this->imgType)) {
            case 'jpeg':
            case 'jpg': //save as a jpeg
            if (substr(strtolower($file), -4) != '.jpg'
                && substr(strtolower($file), -5) != '.jpeg'
            ) {
                $file .= '.jpg';
            }
                $writeflag = @imagejpeg($image, $file);
                break;
            case 'gif':
            case 'png': //save as a portable network graphic
            if (substr(strtolower($file), -4) != '.png'
                && substr(strtolower($file), -4) != '.gif'
            ) {
                $file .= '.png';
            }
                $writeflag = @imagepng($image, $file);
                break;
            case 'bmp':
            case 'wbmp': //save as a bitmap
            if (substr(strtolower($file), -4) != '.bmp') {
                $file .= '.bmp';
            }
                $writeflag = @imagewbmp($image, $file);
                break;
            default:
                $writeflag = false;
                break;
        }
        if (!$writeflag) { //checks to see if the image was written
            throw new Exception(FAILEDSAVE);
        }
        return true;
    }

    //end saveImage

    /**
     * Saves the thumbnail image of the currently loaded image.
     *
     * @return    boolean
     */
    public function saveThumbnail()
    {
        if ($this->thmbData) {
            $this->thmbUrl = $this->thmbDir . '/thmb_' . $this->imgName;
            if ($this->saveImage($this->thmbUrl, $this->thmbData)) {
                return true;
            }
        }
        throw new Exception(FAILEDSAVETHUMB);
    }

    //end saveThumbnail

    /**
     * Resets the object's variable data.
     */
    public function clean()
    {
        //main image variables
        $this->imgUrl = null;
        $this->imgName = null;
        $this->imgFileType = null;
        $this->imgWidth = null;
        $this->imgHeight = null;
        $this->imgDepth = null;
        $this->imgChannels = null;
        $this->imgMime = null;
        $this->imgType = null;
        $this->imgDir = null;
        if ($this->imgData) {
            @imagedestroy($this->imgData);
        }
        $this->imgData = null;

        //thumbnail variables
        $this->thmbUrl = null; //url of thumbnail once made
        $this->thmbWidth = null; //max width of thumbnail
        $this->thmbHeight = null; //max height of thumbnail
        $this->thmbType = 'exact'; //how to make thumbnail (exact,percentage)
        $this->thmbDir = null; //where to store the thumbnail
        if ($this->thmbData) {
            @imagedestroy($this->thmbData);
        }
        $this->thmbData = null;
    }

    //end clean


    /***** PRIVATE METHODS *****/

    /**
     * Determines whether the library necessary to provide image functions is available and loaded.
     *
     * @return    boolean
     */
    private function is_gdLib()
    {
        if (!@extension_loaded('gd')) {
            $this->gdlib = false;
        }
        return $this->gdlib;
    }

    //end is_gdLib

    /**
     * Uses the image's URL to identify the image name and image type, then sets the appropriate object variables.
     *
     * @return boolean
     */
    private function setImageName()
    {
        if (isset($this->imgUrl)) {
            $name = explode('/', $this->imgUrl);
            $parts = explode('.', $name[(count($name) - 1)]);
            $this->imgName = $parts[0];
            if (array_key_exists(1, $parts)) {
                $this->imgFileType = $parts[1];
            }
            return true;
        }
        throw new Exception(NOURL);
    }

    //end setImageName

    /**
     * Sets the object variable for image type according to the type of the currently loaded image.
     *
     * @return    mixed    returns the image type if known otherwise false
     */
    private function setImageType()
    {
        if (isset($this->imgType)) {
            switch ($this->imgType) {
                case IMAGETYPE_GIF:
                    $this->imgType = 'GIF';
                    break;
                case IMAGETYPE_JPEG:
                    $this->imgType = 'JPG';
                    break;
                case IMAGETYPE_PNG:
                    $this->imgType = 'PNG';
                    break;
                case IMAGETYPE_SWF:
                    $this->imgType = 'SWF';
                    break;
                case IMAGETYPE_PSD:
                    $this->imgType = 'GIF';
                    break;
                case IMAGETYPE_BMP:
                    $this->imgType = 'BMP';
                    break;
                case IMAGETYPE_TIFF_II:
                case IMAGETYPE_TIFF_MM:
                    $this->imgType = 'TIF';
                    break;
                case IMAGETYPE_JPC:
                    $this->imgType = 'JPC';
                    break;
                case IMAGETYPE_JP2:
                    $this->imgType = 'JP2';
                    break;
                case IMAGETYPE_JPX:
                    $this->imgType = 'JPX';
                    break;
                case IMAGETYPE_JB2:
                    $this->imgType = 'JB2';
                    break;
                case IMAGETYPE_SWC:
                    $this->imgType = 'SWC';
                    break;
                case IMAGETYPE_IFF:
                    $this->imgType = 'IFF';
                    break;
                case IMAGETYPE_WBMP:
                    $this->imgType = 'WBMP';
                    break;
                case IMAGETYPE_XBM:
                    $this->imgType = 'XBM';
                    break;
                default:
                    throw new Exception(NOTYPE);
                    break;
            }
            return $this->imgType;
        }
        throw new Exception(NOTYPE);
    }

    //end setImageType

    /**
     * Sets object variables for image width, height, type, bit depth, number of channels, and mime type.
     *
     * @return    boolean
     */
    private function getImageInfo()
    {
        if ($this->gdlib) { //make sure the GD library is loaded
            if (isset($this->imgUrl)) {
                if ($info = @getimagesize($this->imgUrl)) {
                    list($this->imgWidth, $this->imgHeight, $this->imgType,
                        $htmlstr, $this->imgDepth, $this->imgChannels,
                        $this->imgMime)
                        = explode(':', implode(':', $info));
                    if ($this->setImageType()) {
                        return true;
                    }
                } else {
                    throw new Exception(FAILEDINFO);
                }
            } else {
                throw new Exception(NOIMAGE);
            }
        }
        throw new Exception(NOGDLIB);
    }

    //end getImageInfo

    /**
     * Attempts to extract the raw image data from the image file.
     *
     * @return    boolean
     */
    private function loadImage()
    {
        switch ($this->imgType) {
            case 'JPG':
                $this->imgData = @imagecreatefromjpeg($this->imgUrl);
                break;
            case 'GIF':
                $this->imgData = @imagecreatefromgif($this->imgUrl);
                break;
            case 'PNG':
                $this->imgData = @imagecreatefrompng($this->imgUrl);
                break;
            case 'BMP':
            case 'WBMP':
                $this->imgData = @imagecreatefromwbmp($this->imgUrl);
                break;
            default:
                throw new Exception(FAILEDLOADIMAGE);
                break;
        }
        return true;
    }

    //end loadImage

    /**
     * Creates the raw image data for a thumbnail of the currently loaded image that needs to be exactly the height and width the user defined for the thumbnail.
     *
     * @return    mixed    if successful the raw image data of the thumbnail will be returned, false otherwise
     */
    private function makeThumbnailExact()
    {
        $thumb = @imagecreatetruecolor($this->thmbWidth, $this->thmbHeight);
        if (@imagecopyresampled(
            $thumb, $this->imgData, 0, 0, 0, 0, $this->thmbWidth,
            $this->thmbHeight, $this->imgWidth, $this->imgHeight
        )
        ) {
            return $thumb;
        }
        throw new Exception(FAILEDTHUMB);
    }

    //end makeThumbnailExact

    /**
     * Creates the raw image data for a thumbnail of the currently loaded image based on a user defined percentage.
     *
     * @return    mixed    if successful the raw image data of the thumbnail will be returned, false otherwise
     */
    private function makeThumbnailPercentage()
    {
        $width = $this->imgWidth * ($this->thmbWidth / 100);
        $height = $this->imgHeight * ($this->thmbHeight / 100);

        $thumb = @imagecreatetruecolor($width, $height);
        if (@imagecopyresampled(
            $thumb, $this->imgData, 0, 0, 0, 0, $width, $height,
            $this->imgWidth, $this->imgHeight
        )
        ) {
            return $thumb;
        }
        throw new Exception(FAILEDTHUMB);
    }

    //end makeThumbnailPercentage


    /***** CONSTRUCTOR *****/

    /**
     * Object's construct method.  This method is called if when the object is created.
     *
     * @param    url    optional string path to an image file
     */
    function __construct($url = '')
    {
        if ($this->is_gdLib()) {
            if ($url !== '') {
                $this->imgUrl = $url;
                if ($this->setImageName()) {
                    if ($this->getImageInfo()) {
                        $this->loadImage();
                    }
                }
            }
        }
    }

    //end __construct


    /***** DESTRUCTOR *****/

    /**
     * Object's desctruct method.  This method is called when the object is destroyed or garbage collected.
     */
    function __destruct()
    {
        $this->clean();
    }
    //end __destroy

}//end class image

