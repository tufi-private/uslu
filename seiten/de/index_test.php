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

$query = 'select * from pages where identifier like "index"';
$pageInfos = $db->getRow($query);

$assetHandler = new AssetHandler('objects', $db);

$contentId = 1; // zur zeit in der Datenbank Objekt: Business Park I
$assets = $assetHandler->getAssets($contentId);

$pageTitle = $pageInfos->title;
$pageDescription = $pageInfos->description;
$pageKeywords = $pageInfos->keywords;
$backgroundImage = $pageInfos->backgroundImage;

?>

<!DOCTYPE HTML>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="description" content="<?= $pageDescription ?>" />
    <meta name="keywords" content="<?= $pageKeywords ?>" />
	<title><?= $pageTitle ?></title>

<link rel="stylesheet" type="text/css" href="/<?= $WEBPATH ?>/css/allgemein.css">
<link rel="stylesheet" type="text/css" href="/<?= $WEBPATH ?>/css/supersized.css">

<script type="text/javascript" src="/<?= $WEBPATH ?>/scripte/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="/<?= $WEBPATH ?>/scripte/supersized.3.2.7.js"></script>
<script type="text/javascript" src="/<?= $WEBPATH ?>/scripte/startseite.js"></script>

</head>

<body marginheight="0" marginwidth="0" bottommargin="0" leftmargin="0" style="height:100%; margin:0px; padding:0px;">


<!-- player 
<div id="sound"><?php //include("../../sound/sound.html") ?></div>
<!-- /player -->

<?php include("menu.php") ?>

<img src="/<?= $WEBPATH ?>/assets/<?=$backgroundImage?>" style="display:none;" id="bg_groundImage">

</body>
</html>
