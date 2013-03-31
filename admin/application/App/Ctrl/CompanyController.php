<?php
namespace App\Ctrl;
use Bootstrap;
use App\Lib\Debug\Debugger;

class CompanyController extends AbstractController
{
    protected  $postData;
    /**
     * initial procedures,set page identifier here!
     */
    public function init()
    {
        $this->identifier = 'company';
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
            'company.php',
        );

        parent::_printView($templates);
    }

    /**
     * @return string|void
     */
    public function handlePostData()
    {

    }

}
