<?php
namespace App\Ctrl;
use Bootstrap;
use App\Lib\Debug\Debugger;

class ImprintController extends AbstractController
{
    protected  $postData;
    /**
     * initial procedures,set page identifier here!
     */
    public function init()
    {
        $this->identifier = 'imprint';
        $this->setPageData();

        $this->getFrontendData();
    }

    /**
     * @return mixed|void
     */
    public function indexAction()
    {
        $this->view();
    }

    /**
     * @return mixed
     */
    public function view()
    {
        $templates = array(
            'imprint.php',
        );

        parent::_printView($templates);
    }

    public function handlePostData()
    {

    }
}
