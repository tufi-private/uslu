<?php
namespace App\Ctrl;
class ErrorController extends \App\Ctrl\AbstractController
{
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
        $this->view();
    }

    /**
     * @return mixed
     */
    function view()
    {
        echo 'An error occured!';

    }
}
