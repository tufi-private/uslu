<?php
/**
 * Contains Debugger class
 * User: tufi
 * Date: 07.07.12
 * Time: 17:30
 */

namespace App\Lib\Debug;
use Bootstrap;
use Contrib\ChromePhp\ChromePhp;

/**
 * provides shortcut alike methods for easy debugging
 */
class Debugger
{
    /**
     * Firebug INFO level
     *
     * Logs a message to firebug console and displays an info icon before the
     * message.
     *
     * @var string
     */
    const INFO = 'INFO';

    /**
     * Firebug WARN level
     *
     * Logs a message to firebug console, displays an warning icon before the
     * message and colors the line turquoise.
     *
     * @var string
     */
    const WARN = 'WARN';

    /**
     * Firebug ERROR level
     *
     * Logs a message to firebug console, displays an error icon before the
     * message and colors the line yellow. Also increments the firebug error
     * count.
     *
     * @var string
     */
    const ERROR = 'ERROR';

    /**
     * Dumps a variable to firebug's server panel
     *
     * @var string
     */
    const DUMP = 'DUMP';

    /**
     * Displays a stack trace in firebug console
     *
     * @var string
     */
    const TRACE = 'TRACE';

    /**
     * Displays an exception in firebug console
     *
     * Increments the firebug error count.
     *
     * @var string
     */
    const EXCEPTION = 'EXCEPTION';

    /**
     * Displays an table in firebug console
     *
     * @var string
     */
    const TABLE = 'TABLE';

    public static function clog($logObject, $label, $type = self::INFO)
    {
        $registry = Bootstrap::getRegistry();
        $logger = $registry::get('CLOG');
        if ($logger instanceof ChromePhp) {
            $logger::log($label, $logObject, $type);
        } else {
            $logger->fb($logObject, $label, $type);
        }
    }

    /**
     * @static
     *
     * @param $logObject
     * @param $label
     */
    public static function dumpSimple($logObject, $label)
    {
        echo '<pre>' . print_r($logObject,true) . '</pre>';
    }
}
