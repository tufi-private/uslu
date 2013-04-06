<?php
error_reporting(E_ALL);
ini_set('display_errors', 'on');
$serverStage = 'live';
if ($_SERVER['SERVER_NAME'] == 'localhost'){
    $serverStage= 'dev';
}
$config = require '../../config/config.php';
require_once '../../php_class/DBClient.php';
require_once '../../php_class/AssetHandler.php';

$db = new DBClient($config[$serverStage]['database']);
$WEBPATH = $config[$serverStage]['httpd']['path'];

$query = 'select * from pages where identifier like "imprint"';
$pageInfos = $db->getRow($query);

$assetHandler = new AssetHandler('objects', $db);

$contentId = 2; // zur zeit in der Datenbank Objekt: Business Park I
$assets = $assetHandler->getAssets($contentId);

$pageTitle = $pageInfos->title;
$pageDescription = $pageInfos->description;
$pageKeywords = $pageInfos->keywords;
$backgroundImage = $pageInfos->backgroundImage;
$page_online = $pageInfos->online;

?>

<!DOCTYPE HTML>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="description" content="<?= $pageDescription ?>" />
    <meta name="keywords" content="<?= $pageKeywords ?>" />
	<title><?= $pageTitle ?></title>

<link rel="stylesheet" type="text/css" href="/<?= $WEBPATH ?>/css/allgemein.css">
<link rel="stylesheet" type="text/css" href="/<?= $WEBPATH ?>/css/impressum.css">
<link rel="stylesheet" type="text/css" href="/<?= $WEBPATH ?>/css/supersized.css">

<script type="text/javascript" src="/<?= $WEBPATH ?>/scripte/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="/<?= $WEBPATH ?>/scripte/supersized.3.2.7.js"></script>
<script type="text/javascript" src="/<?= $WEBPATH ?>/scripte/impressum.js"></script>
<script type="text/javascript" src="/<?= $WEBPATH ?>/scripte/jquery.jmp3.js"></script>

</head>

<body marginheight="0" marginwidth="0" bottommargin="0" leftmargin="0" style="height:100%; margin:0px; padding:0px;">

<!-- player
<div id="sound"><?php // include("../../sound/sound.html") ?></div>
<!-- /player -->

<?php include("menu.php"); ?>


<!-- headerbild für Impressum
<div id="i_headerbild"><img src="../../bilder/header_impressum.png" alt="Impressum" width="764" height="176" border="0"></div>
-->


<!-- Inhaltsblock für Seitentexte -->
<div id="i_inhalt"></div>
<!-- ****************  -->


<!-- künye am Footer & logo -->
<div id="footer">
	<a href="#" id="open" style="float:right; padding-right:10px;"><img src="/<?= $WEBPATH ?>/bilder/open.gif" width="20" height="20" alt="Open" border="0"></a> <strong>Uslu Plaza Estates</strong> <a href="#" id="close" style="float:right; padding-right:10px;"><img src="/<?= $WEBPATH ?>/bilder/close.gif" alt="close" width="20" height="20" border="0" style="display:none;"></a>

    <div id="footer_inhalt"></div>

</div>
<!-- ****************  -->

<img src="/<?= $WEBPATH ?>/assets/<?=$backgroundImage?>" style="display:none;" id="bg_groundImage">
</body>
</html>
