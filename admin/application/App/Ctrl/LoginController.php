<?php
namespace App\Ctrl;
use Bootstrap;
use App\Lib\Debug\Debugger;

class LoginController extends AbstractController
{
    private $_SALT = '2yl*__mMH3__ij';

    /**
     * initial procedures,set page identifier here!
     */
    public function init()
    {
        $this->identifier = 'login';
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
            'login.php',
        );

        parent::_printView($templates);
    }

    /**
     * @return string|void
     */
    public function loginAction()
    {
        $postParams = $this->_request->post();

        if (isset($postParams['username'])) {
            $username = $this->db->quoteValue($postParams['username']);
        }

        if (isset($postParams['password'])) {
            $password = $this->db->quoteValue($postParams['password']);
        }

        if(!empty($username) && !empty($password)) {
            $query = 'SELECT COUNT(*) AS CNT FROM login WHERE user=' . $username
                . ' AND pwd=' . $password;

            $result = $this->db->getOne($query);

            if ($result['CNT'] == 1) {
                // login successfull
                $_SESSION['user'] = $postParams['username'];
                $_SESSION['sess_start_time'] = time();

                if (isset($_SESSION['redirect'])) {
                    $redirect = $_SESSION['redirect'];
                    unset($_SESSION['redirect']);
                } else {
                    $redirect = '/' . \Bootstrap::getBasePath()
                                    . 'index.php?show=index';
                }

                header('Location: ' . $redirect);
                exit;
            }
        }

        $this->message = 'Login nicht erfolgreich. Bitte versuchen Sie es noch einmal';
        $this->view();
    }

    public function logoutAction()
    {
        $_SESSION=array();
        session_destroy();
        $this->view();
    }

    /**
     * @return string
     */
    function handlePostData()
    {
        // TODO: Implement handlePostData() method.
    }
}
