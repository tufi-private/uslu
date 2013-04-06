<?php
error_reporting(E_ALL);
ini_set('display_errors', 'on');
$serverStage = 'live';
if ($_SERVER['SERVER_NAME'] == 'localhost'){
    $serverStage= 'dev';
}
$config = require './config/config.php';
require_once './php_class/DBClient.php';
require_once './php_class/AssetHandler.php';

$db = new DBClient($config[$serverStage]['database']);
$WEBPATH = $config[$serverStage]['httpd']['path'];
// beispiel für siteInfos
/*$query = 'select * from site';
$siteInfos = $db->getRow($query);
var_dump($siteInfos);*/
$query = 'select * from pages where identifier like "index"';
$pageInfos = $db->getRow($query);

$assetHandler = new AssetHandler('objects', $db);

$contentId = 1; // zur zeit in der Datenbank Objekt: Business Park I
$assets = $assetHandler->getAssets($contentId);

echo "<pre>", print_r($assets), "</pre>";

$pageTitle = $pageInfos->title;
$pageDescription = $pageInfos->description;
$pageKeywords = $pageInfos->keywords;
$backgroundImage = $pageInfos->backgroundImage;
?>
<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title><?= $pageTitle ?>></title>
    <meta name="description" content="<?= $pageDescription ?>" />
    <meta name="keywords" content="<?= $pageKeywords ?>" />
    <title><?= $pageTitle ?>></title>
    <link rel="stylesheet" type="text/css" href="/<?= $WEBPATH ?>/css/willkommen.css">

    <script type="text/javascript"
            src="/<?= $WEBPATH ?>/scripte/jquery-1.7.1.min.js"></script>
    <script type="text/javascript" src="/<?= $WEBPATH ?>/scripte/willkommen.js"
            async=""></script>

</head>
<body marginheight="0" marginwidth="0" bottommargin="0" leftmargin="0"
      background="/<?= $WEBPATH .$backgroundImage ?>" id="html"
      style="">
<div id="page-wrap">
    <img class="willkommen_bild_de"
         style="visibility:hidden; margin-top:10px; margin-left:50px;"
         src="/<?= $WEBPATH ?>/bilder/flagge_de.gif" alt="Deutsch" width="30" height="19">
    <img class="willkommen_bild_en"
         style="visibility:hidden; margin-top:10px; margin-left:90px;"
         src="/<?= $WEBPATH ?>/bilder/flagge_en.gif" alt="English" width="30" height="19">

    <p id="willkommen">
        <a href="/<?= $WEBPATH ?>/seiten/de/index.html" id="willkommen_de">WILLKOMMEN</a> | <a
        href="/<?= $WEBPATH ?>/seiten/en/index.html" id="willkommen_en">WELLCOME</a>
    </p>

</div>

</body>
</html>
