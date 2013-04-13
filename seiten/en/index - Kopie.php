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

<div id="m01_unternehmen">
	<a href="/<?= $WEBPATH ?>/seiten/de/unternehmen.php" id="link_unternehmen" style="text-decoration:none; color:#FFF;">
    	<img src="/<?= $WEBPATH ?>/bilder/button_unternehmen_de.jpg" alt="Unternehmen" width="80" height="80" border="0"></a>
</div>

<div id="m02_objekte">
	<a href="/<?= $WEBPATH ?>/seiten/de/objekte.php" id="link_objekte" style="text-decoration:none; color:#FFF;">
    	<img src="/<?= $WEBPATH ?>/bilder/button_objekte_de.jpg" alt="Objekte" width="80" height="80" border="0"></a>
</div>

<div id="m03_projekte">
	<a href="/<?= $WEBPATH ?>/seiten/de/projekte.php" id="link_projekte" style="text-decoration:none; color:#FFF;">
    	<img src="/<?= $WEBPATH ?>/bilder/button_projekte_de.jpg" alt="Projekte" width="80" height="80" border="0"></a>
</div>

<div id="m04_kontakt">
	<a href="/<?= $WEBPATH ?>/seiten/de/kontakt.php" id="link_kontakt" style="text-decoration:none; color:#FFF;">
    	<img src="/<?= $WEBPATH ?>/bilder/button_kontakt_de.png" alt="Kontakt" width="80" height="80" border="0"></a>
</div>

<div id="m05_impressum">
	<a href="/<?= $WEBPATH ?>/seiten/de/impressum.php" id="link_impressum" style="text-decoration:none; color:#FFF;">
    	<img src="/<?= $WEBPATH ?>/bilder/button_impressum_de.jpg" alt="Impressum" width="80" height="80" border="0"></a>
</div>

<div id="m07_karriere">
	<a href="/<?= $WEBPATH ?>/seiten/de/karriere.php" id="link_karriere" style="text-decoration:none; color:#FFF;">
    	<img src="/<?= $WEBPATH ?>/bilder/button_karriere_de.jpg" alt="Karriere" width="80" height="80" border="0"></a>
</div>

<div id="m06_start">
	<a href="/<?= $WEBPATH ?>/seiten/index.html" id="link_startseite" style="text-decoration:none; color:#FFF;">
    	<img src="/<?= $WEBPATH ?>/bilder/button_startseite_de.jpg" alt="Startseite" width="80" height="80" border="0"></a>
</div>

<img src="/<?= $WEBPATH ?>/assets/<?=$backgroundImage?>" style="display:none;" id="bg_groundImage">
</body>
</html>
