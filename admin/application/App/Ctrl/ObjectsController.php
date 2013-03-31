<?php
namespace App\Ctrl;
use Bootstrap;
use App\Ctrl\ContainerPage;
use Exception;
use App\Dispatcher;
use App\Lib\Debug\Debugger;
use App\Lib\Image\Image;
/**
 *
 */
class ObjectsController extends ContainerPage
{
    protected  $postData;
    /**
     * initial procedures,set page identifier here!
     */
    public function init()
    {
        $this->identifier = 'objects';
        $this->htmlPage = 'objekte.html';

        $this->innerPageDefinition = 'Objekte';

        $this->setPageData();

        $this->getFrontendData();
        $this->getInnerPages();
    }

    /**
     * @return mixed|void
     */
    public function indexAction()
    {
        $this->view();
    }

    /**
     * @param string $forwardShowAction if set an internal redirect to the
     *                                  given forward show action will be
     *                                  performed via javascript (footer.php)
     *
     * @return mixed
     */
    public function view($forwardShowAction='')
    {
        if (trim($forwardShowAction) != '') {
            $registry = Bootstrap::getRegistry();
            $cfg = $registry::get('CONFIG');

            $this->forward = '/'.$cfg->httpd->path.'index.php?show='
                .$forwardShowAction;
        }

        $templates = array(
            'default-container-page.php',
        );

        parent::_printView($templates);
    }

    /**
     * handles post data incl. image and file uploads
     */
    public function handlePostData()
    {
        throw new Exception('Usage of '.__METHOD__.' without post action!');
        /*
        try {
            $this->messageSuccess = $this->handleMetaInformation(
                $this->_request->post()->toArray()
            );
            $this->init();
            $this->view();
        } catch (Exception $e) {
            return array(
                'error'
            );
        }*/
    }

}
