<?php
use \App\Dispatcher;
use Zend\Registry;
use \Zend\Config\Config;
use App\Lib\Debug\Debugger;
/**
 * Bootstrap Class
 */
class Bootstrap
{

    const LOG_TYPE_HTTPD    = 'httpd';
   	const LOG_TYPE_CLI      = 'cli';

    const SESSION_TIMEOUT = 9001;
    const NO_SESSION = 9002;
    const SESSION_FINGERPRINTCHECK_FAIL = 9002;

    private static $DEBUG = true;


    /**
     * @var Bootstrap
     */
    private static $_instance;


    /**
     * @var Zend\Registry
     */
    protected $_registry;

    /**
     * @var bool
     */
    protected $_isInitialized = false;

    private function __construct()
    {
        self::$DEBUG = (strtolower($_SERVER['HTTP_HOST']) == 'localhost');
    }

    /**
     * @static
     * @return Bootstrap
     */
    public static function getInstance()
    {
        if ((self::$_instance instanceof self) !== true) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * @static
     * @return Zend\Registry
     */
    public static function getRegistry()
    {
        $instance = self::getInstance();

        if (!($instance->_registry instanceof Zend\Registry)) {
            $instance->_registry = new Zend\Registry();
        }

        return $instance->_registry;
    }

    /**
     * @static
     *
     * @param string $mode
     *
     * @return bool
     */
    public static function init($mode = 'DEFAULT')
    {
        if (self::getInstance()->_isInitialized) {
            return;
        }

        self::getInstance()->_isInitialized = true;

        if (self::$DEBUG) {
            ini_set('display_errors', 1);
            error_reporting(E_ALL ^ E_DEPRECATED);
        } else {
            ini_set('display_errors', 0);
            error_reporting(0);
        }

        session_start();
        if (isset($_POST['PHPSESSID']) && !empty($_POST['PHPSESSID'])) {
            session_id($_POST['PHPSESSID']);
        }
//        session_regenerate_id(true);

        set_error_handler(array('Bootstrap', 'handleError'));
        register_shutdown_function(array('Bootstrap', 'handleShutdown'));

        define('SRC_PATH', realpath(dirname(__FILE__)));
        define('ROOT_PATH', realpath(dirname(__FILE__) . '/..'));
        define('CTRL_PATH', SRC_PATH . '/App/Ctrl/');
        define('LIB_PATH', SRC_PATH . '/App/Lib');
        define('CONTRIB_PATH', SRC_PATH . '/Contrib/');

        // setup include path:
        $origIncludePath = get_include_path();
        set_include_path(
            $origIncludePath
                . PATH_SEPARATOR . SRC_PATH
        );

        $libPath = __DIR__ . '/Contrib';

        include($libPath . '/Zend/Loader/StandardAutoloader.php');
        // Setup autoloading
        $loader = new Zend\Loader\StandardAutoloader();
        $loader->register();
        $loader->registerNamespace('App', SRC_PATH . '/App');


        // load basic config and put it in registry
        $cfgSuffix = self::$DEBUG
            ? '.local'
            : '';
        $config = new Config(
            require SRC_PATH . '/../etc/config'.$cfgSuffix.'.php'
        );
        $registry = Bootstrap::getRegistry();
        $registry::set('CONFIG', $config);

        // setup locale:
        setlocale(LC_ALL, $config->locale->default->lc_all);

        date_default_timezone_set(
            $config->locale->default->timezone
        );

        $instance = self::getInstance();

        // setup logger und put in registry
        $instance->_initLogging(self::LOG_TYPE_HTTPD);


        // setup database connection and put it in registry
        $dbAdapter = new Zend\Db\Adapter\Adapter(
            $config->database->params->toArray()
        );
        $registry::set('DB_ADAPTER', $dbAdapter);

        $dbClient = App\DB\Client::getInstance();
        $registry::set('DB_CLIENT', $dbClient);

        return true;
    }

    /**
     * @return bool|int
     */
    public static function verifySession()
    {
        if (!isset($_SESSION['user'])) {
            return self::NO_SESSION;
        }
        if ($_SESSION['sess_start_time'] < (time() - (30*60))) {
            return self::SESSION_TIMEOUT;
        }

        // todo: implement fingerprintcheck

        return true;
    }

    /**
     * Initializes the logging subsystem
     *
     * @param string $type LOG_TYPE_HTTPD|LOG_TYPE_CLI
     *
     * @return boolean true on success
     *
     */
    private function _initLogging($type)
    {
        $writer_default = new Zend\Log\Writer\Stream(
            SRC_PATH . '/../var/log/'.date('Y-m').'_'. $type . '_default.log'
        );

        $writer_critical = new Zend\Log\Writer\Stream(
            SRC_PATH . '/../var/log/'
                . date('Y-m').'_'. $type . '_critical.log'
        );

        $format = '%timestamp%;%pid%;%priorityName%;%priority%;%message%'
            . PHP_EOL;

        $formatter = new Zend\Log\Formatter\Simple($format);

        $writer_default->setFormatter($formatter);
        $writer_critical->setFormatter($formatter);

        $filter_critical = new Zend\Log\Filter\Priority(Zend\Log\Logger::CRIT);
        $writer_critical->addFilter($filter_critical);

        $logger = new Zend\Log\Logger();
        $logger->addWriter($writer_default);
        $logger->addWriter($writer_critical);

        $registry = Bootstrap::getRegistry();
        $registry::set('LOG', $logger);

        if ($type == self::LOG_TYPE_HTTPD) {

            switch (self::isChrome()){
                case true:
                    include CONTRIB_PATH . '/ChromePhp/ChromePhp.php';
                    $logger_chromePhp= \Contrib\ChromePhp\ChromePhp::getInstance();
                    $registry::set('CLOG', $logger_chromePhp);
                    break;
                case false:
                default:
                    include CONTRIB_PATH . '/FirePHP/FirePHP.class.php';
                    $logger_firebug = \Contrib\FirePHP\FirePHP::getInstance(true);
                    $registry::set('CLOG', $logger_firebug);
                    break;
            }
        }

        return true;
    }

    /**
     * detects if the browser request is coming from chrome
     * @return bool
     */
    public static function isChrome()
    {
        return (isset($_SERVER['HTTP_USER_AGENT'])
            && strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome') !== false);
    }

    /**
     *
     * @param int        $errorNumber
     * @param string     $errorString
     * @param string     $errorFile
     * @param int        $errorLine
     * @param array|null $errorContext
     *
     * @return bool
     * @throws ErrorException
     * @throws Exception
     */
    public static function handleError(
        $errorNumber,
        $errorString,
        $errorFile,
        $errorLine,
        $errorContext = null
    )
    {

        if (!class_exists('Zend\Registry')) {
            throw new Exception(
                "FATAL ERROR. Class Zend_Registry does not exist at "
                    . __METHOD__
            );
        }

        /** @var $log Zend_Log */
        //        $log = Zend_Registry::get('FIREBUG');

        switch ($errorNumber) {

            case E_USER_ERROR:
                $errorType = \Zend\Log\Logger::ERR;
                break;

            case E_USER_WARNING:
                $errorType = \Zend\Log\Logger::WARN;
                break;

            case E_USER_NOTICE:
                $errorType = \Zend\Log\Logger::NOTICE;
                break;

            case E_NOTICE:
                $errorType = \Zend\Log\Logger::NOTICE;
                break;

            default:
                $errorType = \Zend\Log\Logger::EMERG;
                break;
        }

        if ($errorNumber == E_DEPRECATED) {
            return true;
        }

        // output backtrace:
        ob_start();
        debug_print_backtrace();
        $msg = explode("\n", ob_get_clean());
        array_shift($msg);
        array_pop($msg);
        foreach ($msg as $k => $m) {
            $msg[$k] = str_replace(ROOT_PATH, '', $m);
        }
        // Don't execute PHP internal error handler

        // convert to exception and throw that shit
        // that is required for rpc global exception handlers
        // we need to pass a json-rpc-style exception IN ANY CASE !
        throw new ErrorException(
            $errorString,
            0,
            $errorNumber,
            $errorFile,
            $errorLine
        );

        //return true; // Don't execute PHP internal error handler
    }

    /**
     * Hardcoded shutdown handler to detect critical PHP errors.
     *
     * @static
     * @return void
     */
    public static function handleShutdown()
    {
        $error = error_get_last();
        if ($error !== null && $error['type'] != E_DEPRECATED) {
            // an error occurred and forced the shut down

            if (true || self::$DEBUG) {
                echo
                    '<div style="font-size: 16px; padding: 16px 32px 16px 32px; margin: 16px; border: solid red 3px; background: #000000; color: red;"><pre>'
                    . '<b>'
                    . 'ERROR #' . str_pad($error['type'], 3, '0', STR_PAD_LEFT)
                    . ': ' . $error['message'] . '</b><br /><br />'
                    . 'File: ' . str_replace(ROOT_PATH, '', $error['file'])
                    . ' [' . $error['line'] . ']'
                    . '</pre></div>';

            } else {
                echo "An Error Occured. Please retry lateron!";
            }

            return;
        }

        // no error, we have a "normal" shut down (script is finished).
    }

    /**
     * @static
     * @return String base path defined in the config
     */
    public static function getBasePath()
    {
        $registry = Bootstrap::getRegistry();
        $cfg =  $registry::get('CONFIG');

        return $cfg->httpd->path;
    }
    /**
     * @static
     * @return String base path defined in the config
     */
    public static function getFrontendBasePath()
    {
        $registry = Bootstrap::getRegistry();
        $cfg =  $registry::get('CONFIG');

        return $cfg->httpd->frontend_path;
    }
    /**
     * @static
     * @return String frontend uri
     */
    public static function getFrontendURI()
    {
        $registry = Bootstrap::getRegistry();
        $cfg =  $registry::get('CONFIG');

        return $cfg->httpd->protocol
            .'://'
            .$cfg->httpd->host
            .'/'
            .$cfg->httpd->frontend_path;
    }

    /**
     * returns logger
     * @return  \Zend\Log\Logger
     */
    public static function getLogger()
    {
        $registry = Bootstrap::getRegistry();
        return $registry::get('LOG');
    }

    /**
     * generates a secure token for uploading
     * @param $timestamp
     *
     * @return string generated token
     */
    public static function generateUploadToken($timestamp)
    {
        $registry = Bootstrap::getRegistry();
        $cfg = $registry::get('CONFIG');
        $salt = $cfg->backend->upload->salt;
        return sha1($timestamp . '+' . $salt);
    }

    /**
     * @return string
     */
    public static function getLang(){
        return 'DE';
    }

    /**
     * @return mixed
     */
    public static function getConfig()
    {
        $registry = Bootstrap::getRegistry();
        return $registry::get('CONFIG');
    }
}
