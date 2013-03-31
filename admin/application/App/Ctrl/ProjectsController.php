<?php
namespace App\Ctrl;
use Bootstrap;
use App\Ctrl\ContainerPage;
use App\Lib\Debug\Debugger;
use App\Lib\Image\Image;

/**
 *
 */
class ProjectsController extends ContainerPage
{
    protected  $postData;
    /**
     * initial procedures,set page identifier here!
     */
    public function init()
    {
        $this->identifier = 'projects';
        $this->htmlPage = 'projekte.html';

        $this->innerPageDefinition = 'Projekte';

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
     * @param string $forwardShowAction
     *
     * @return mixed
     */
    public function view($forwardShowAction = '')
    {
        if (trim($forwardShowAction) != '') {
            $registry = Bootstrap::getRegistry();
            $cfg = $registry::get('CONFIG');

            $this->forward = '/' . $cfg->httpd->path . 'index.php?show='
                . $forwardShowAction;
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

    }

}
