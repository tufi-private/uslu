<?php
namespace App\Ctrl;
use Bootstrap;
use App\Lib\Debug\Debugger;

/**
 *
 */
class ContactController extends AbstractController
{
    protected  $postData;
    /**
     * initial procedures,set page identifier here!
     */
    public function init()
    {
        $this->identifier = 'contact';
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
            'contact.php',
        );

        parent::_printView($templates);
    }

    public function handlePostData()
    {

    }
}
