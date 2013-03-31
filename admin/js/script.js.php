<?php
require_once dirname(__FILE__) . '/../application/Bootstrap.php';
Bootstrap::init();
require_once CONTRIB_PATH . '/JSMin/JSMin.php';
header('Content-Type: application/javascript; charset=utf-8');
ob_start();

$timestamp = time();
$token = Bootstrap::generateUploadToken($timestamp);


include 'libs/tt_lib.js';

if (isset($_GET['l'])) {
    $identifier = $_GET['l'];
}
if (in_array(
    $identifier,
    array(
        'index', 'imprint', 'company', 'objects', 'projects', 'siteinfo', 'contact', 'jobs'
    ))
) {

    is_file(realpath(dirname(__FILE__) . '/page/' . $identifier . '.js'))
        && include './page/' . $identifier . '.js';
}

$scriptContent = ob_get_contents();
ob_end_clean();
echo "\n";
try {
//    echo JSMin::minify($scriptContent);
    echo $scriptContent;
} catch (JSMinException $e) {
    echo $scriptContent;
}
exit;
