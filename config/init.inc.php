<?php
if (strpos($_SERVER['PHP_SELF'], 'init.inc.php') !== false) {
    header('Status: 403 Forbidden');
    exit;
}
// detect environment first:
$serverStage = strtolower($_SERVER['HTTP_HOST']) == 'localhost'
    ? 'local'
    : (strtolower($_SERVER['HTTP_HOST']) == 'dev.tufi.de'
        ? 'dev'
        : 'live');

if ($serverStage != 'live') {
    error_reporting(E_ALL);
    ini_set('display_errors', 'on');
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}
$config = require dirname(__FILE__) .'/config.php';
require_once dirname(__FILE__) .'/../php_class/DBClient.php';
require_once dirname(__FILE__) .'/../php_class/AssetHandler.php';

$db = new DBClient($config[$serverStage]['database']);
$WEBPATH = $config[$serverStage]['httpd']['path'];