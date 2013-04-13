<?php
require_once '../../config/init.inc.php';

$query = 'select * from pages where identifier like "company"';
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
    <meta name="description" content="<?php echo $pageDescription; ?>" />
    <meta name="keywords" content="<?php echo $pageKeywords; ?>" />
	<title><?php echo $pageTitle; ?></title>

<link rel="stylesheet" type="text/css" href="/<?= $WEBPATH ?>/css/allgemein.css">
<link rel="stylesheet" type="text/css" href="/<?= $WEBPATH ?>/css/unternehmen.css">
<link rel="stylesheet" type="text/css" href="/<?= $WEBPATH ?>/css/supersized.css">

<script type="text/javascript" src="/<?= $WEBPATH ?>/scripte/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="/<?= $WEBPATH ?>/scripte/jquery.animate-shadow.js"></script>
<script type="text/javascript" src="/<?= $WEBPATH ?>/scripte/supersized.3.2.7.js"></script>
<script type="text/javascript" src="/<?= $WEBPATH ?>/scripte/jquery.jmp3.js"></script>
<script type="text/javascript" src="/<?= $WEBPATH ?>/scripte/unternehmen.js"></script>

</head>

<body marginheight="0" marginwidth="0" bottommargin="0" leftmargin="0" style="height:100%; margin:0px; padding:0px;">

<!-- player
<div id="sound"><?php // include("../../sound/sound.html") ?></div>
<!-- /player -->

<?php include("menu.php") ?>

<!-- unternehmen seite -->
<div id="u_themenbild"></div>

<!-- Inhaltsblock für Seitentexte -->
<div id="u_inhalt_en"></div>
<!-- ****************  -->

<!--
<div id="footer">
	<a href="#" id="open" style="float:right; padding-right:10px;"><img src="/<?= $WEBPATH ?>/bilder/open.gif" width="20" height="20" alt="Open" border="0"></a> <strong>Uslu Plaza Estates</strong> <a href="#" id="close" style="float:right; padding-right:10px;"><img src="/<?= $WEBPATH ?>/bilder/close.gif" alt="close" width="20" height="20" border="0" style="display:none;"></a>

    <div id="footer_inhalt" style="padding-left:150px;"></div>

</div>
künye am Footer & logo -->
<!-- ****************  -->
<img src="/<?= $WEBPATH ?>/assets/<?=$backgroundImage?>" style="display:none;" id="bg_groundImage">
</body>
</html>