<?php
error_reporting(E_ALL);
ini_set('display_errors', 'on');
require_once dirname(__FILE__) . '/application/Bootstrap.php';
Bootstrap::init();
try {
    $dispatcher = new App\Dispatcher();
    $dispatcher->dispatch();

} catch (Exception $exception) {
    // @todo use trigger_error?
    echo '<pre>' . $exception->getMessage() . '</pre>';
}
?>