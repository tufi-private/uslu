<?php
namespace App\Ctrl;
use Bootstrap;
use App\Lib\Debug\Debugger;

class IndexController extends AbstractController
{
    /**
     * initial procedures,set page identifier here!
     */
    public function init()
    {
        $this->identifier = 'index';
        $this->setPageData();
        $this->getFrontendData();
    }

    /**
     * @return mixed|void
     */
    public function indexAction()
    {
        if (class_exists('PDO')) {
           $this->flag = 'PDO';
          } elseif (class_exists('mysqli')) {
           $this->flag = 'MYSQLI';
          } else {
           $this->flag = 'mysql';
          }

        $this->view();
    }

    /**
     * @return mixed
     */
    public function view()
    {
        $templates = array(
            'index.php',
        );

        parent::_printView($templates);
    }

    /**
     * @return string|void
     */
    public function handlePostData()
    {
        $postParams = $this->_request->post();/*
        foreach ($postParams['params'] as $key => $val) {
            Debugger::clog(
                $key . " => " . urldecode($val), __METHOD__ . '::' . __LINE__,
                Debugger::INFO
            );
        }*/
        }
}
