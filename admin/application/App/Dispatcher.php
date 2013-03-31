<?php

namespace App;
use \Zend\Http\PhpEnvironment\Request,
\Zend\Http\Response;
use App\Lib\Debug\Debugger;
use Exception;
use Bootstrap;
use Zend\Log\Logger;

class Dispatcher
{
    /**
     * @var string
     */
    protected $controllerClassSuffix = 'Controller';

    /**
     * @var string
     */
    protected $actionMethodSuffix = 'Action';

    /**
     * Controller
     * @var string
     */
    protected $_controller;

    /**
     * Action
     * @var string
     */
    protected $_action;

    /**
     * @var \Zend\Http\PhpEnvironment\Request
     */
    protected $_request;

    /**
     * @var Response
     */
    protected $_response;

    /**
   	 * Create controller and call the run() method
   	 */
    public function dispatch()
    {
        $this->_request = new Request();
        $this->_response = new Response();

        if ($this->_request->isXmlHttpRequest()) {
            $this->dispatchXmlHttp();
            return;
        }
        $controller = $this->getControllerName();
        $action = $this->getActionName();

        // sanitize controllera
        $controller = preg_replace('#[^a-z0-9-]#', '', strtolower($controller));
        if (\Bootstrap::verifySession()!== true
            && $controller !== 'login'
            && $action !== 'uploadBgImage'
            && $action !== 'upload'
        ) {
            switch (\Bootstrap::verifySession()) {
                case \Bootstrap::SESSION_TIMEOUT:
                    $_SESSION['errorMessage'] = 'Session timeout. Please login.';
                    break;
                case \Bootstrap::SESSION_FINGERPRINTCHECK_FAIL:
                    $_SESSION['errorMessage'] = 'Invalid session. Please login.';
                    break;
                case \Bootstrap::NO_SESSION:
                default:
                    $_SESSION['errorMessage'] = 'No session. Please login.';
                    break;
            }

            $_SESSION['redirect'] = '/' . \Bootstrap::getBasePath()
                . 'index.php?show='.$controller . '&do='.$action;
            header('Location: /' . \Bootstrap::getBasePath() . 'index.php?show=login');
            exit;
        }

        if ($controller == '') {
            $controller = 'index';
        }

        // sanitize action
        $action = preg_replace('#[^a-zA-Z0-9-]#', '', $action);

        if ($action == '') {
            $action = 'index';
        }

        $controllerClassName =  ucfirst($controller)
            . $this->controllerClassSuffix;
        $actionMethodName = $action . $this->actionMethodSuffix;

        $_SESSION['sess_start_time'] = time();

        try {
            if (!file_exists(CTRL_PATH . '/' . $controllerClassName . ".php")) {

                header('Location: /'.\Bootstrap::getBasePath().'404.html');
                exit;
            }

            if (class_exists('\\App\\Ctrl\\'.$controllerClassName,true)) {

                $fullClassname = '\\App\\Ctrl\\' .$controllerClassName;
                /* @var $controllerClass \App\Ctrl\AbstractController */
                $controllerClass = new $fullClassname();

                $controllerClass->setRequest($this->_request);
                $controllerClass->setResponse($this->_response);
                $controllerClass->init();

                if (method_exists($controllerClass, $actionMethodName)) {
                    $controllerClass->$actionMethodName();
                } else {
                    // method does not exist, fallback to index Action
                    $controllerClass->indexAction();
                }

            } else {
                // controller not found, use error controller:
                $controllerClass = new \App\Ctrl\ErrorController();
                $controllerClass->setRequest($this->_request);
                $controllerClass->setResponse($this->_response);
                $controllerClass->indexAction();
            }
        } catch (Exception $e) {
            if (strtolower($_SERVER['HTTP_HOST']) == 'localhost'){
                echo $e->getMessage()." \n ". $e->getFile()."::".$e->getLine();
                echo "<pre>", $e->getTraceAsString(),"</pre>";
            } else {
                echo 'Es ist ein unerwarteter Fehler aufgetreten. Bitte versuchen Sie es erneut!';
            }
            exit;
        }
    }

    /**
     *
     */
    public function dispatchXmlHttp()
    {
        $responseData = array(
            'success' => false,
            'result'  => '',
            'dbg'     => '',
        );

        if (\Bootstrap::verifySession() !== true) {
            $responseData['success'] = false;
            switch (\Bootstrap::verifySession()) {
                case \Bootstrap::SESSION_TIMEOUT:
                    $errorMessage = 'Session timeout. Please login.';
                    break;
                case \Bootstrap::SESSION_FINGERPRINTCHECK_FAIL:
                    $errorMessage = 'Invalid session. Please login.';
                    break;
                case \Bootstrap::NO_SESSION:
                default:
                    $errorMessage = 'No session. Please login.';
                    break;
            }

            $responseData['error'] = $errorMessage;
            echo json_encode($responseData);
            exit;
        }


        $requestParams = json_decode($this->getXMLRpcRequest(),true);
        if(is_null($requestParams)) {
            $responseData['success'] = false;
            $responseData['error'] = 'invalid request';

            echo json_encode($responseData);
            exit;
        }

        $this->_request->setPost(
            new \Zend\Stdlib\Parameters(
                $requestParams
            )
        );

        $controller = $this->_request->post()->get('controller');
        $action = $this->_request->post()->get('do');

        // sanitize controller
        $controller = preg_replace('#[^a-z0-9-]#', '', strtolower($controller));

        if ($controller == '') {
            $controller = 'index';
        }

        // sanitize action
        $action = preg_replace('#[^a-zA-Z0-9-]#', '', $action);
        if ($action == '') {
            throw new Exception(
                'Usage without post action!'
            );
//            $action = 'handlePostData';
        }

        $controllerClassName =  ucfirst($controller)
            . $this->controllerClassSuffix;

        $actionMethodName = $action;
        $resultContent = '';
        $errorContent = '';
        $debug = '';
        try {
            if (!file_exists(CTRL_PATH . '/' . $controllerClassName . ".php")) {
                throw new Exception('file not found: '.$controllerClassName);
            }

            if (class_exists('\\App\\Ctrl\\'.$controllerClassName,true)) {

                $fullClassname = '\\App\\Ctrl\\' .$controllerClassName;
                $isXmlHttpRequest = true; // logischerweise!
                /* @var $controllerClass \App\Ctrl\AbstractController */
                $controllerClass = new $fullClassname($isXmlHttpRequest);

                $controllerClass->setRequest($this->_request);
                $controllerClass->setResponse($this->_response);

                $controllerClass->init();

                ob_start();
                if (method_exists($controllerClass, $actionMethodName)) {
                    $resultContent = $controllerClass->$actionMethodName();
                } else {
                    // method does not exist, fallback to index Action
                    $controllerClass->indexAction();
                }

                $resultContent || $resultContent = ob_get_contents();
                ob_end_clean();

            } else{
                ob_start();
                // controller not found, use error controller:
                $controllerClass = new \App\Ctrl\ErrorController();
                $controllerClass->setRequest($this->_request);
                $controllerClass->setResponse($this->_response);
                $controllerClass->indexAction();

                $errorContent = ob_get_contents();
                ob_end_clean();
            }
        } catch (Exception $e) {
            $errorContent =  $e->getMessage()." \n "
                . $e->getFile()."::".$e->getLine();
            $debug = $e->getTraceAsString();
        }

        $responseData = array(
            'success' => ($errorContent === ''),
        );

        if ($errorContent != '') {
            $responseData['error'] = $errorContent;
            $responseData['debug'] = $debug;
        }

        $responseData['result'] = $resultContent;
        echo json_encode($responseData);
    }


    /**
     * Retrieve the controller name from query string
     *
     * @return string
     */
    public function getControllerName()
    {
        /*$pathItems = explode('/', $request->getBasePath());
        array_shift($pathItems); //remove trailing slash*/
        return $this->_request->query()->get('show');

    }

    /**
     * Retrieve the action name
     *
     * @return string
     */
    public function getActionName()
    {
        return $this->_request->query()->get('do');
    }


    /**
     * @return string
     */
    public function getXMLRpcRequest()
    {
        return file_get_contents("php://input");
    }
}
