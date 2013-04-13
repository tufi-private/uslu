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

$query = 'select * from pages where identifier like "contact"';
$pageInfos = $db->getRow($query);

$pageTitle = $pageInfos->title;
$pageDescription = $pageInfos->description;
$pageKeywords = $pageInfos->keywords;
$backgroundImage = $pageInfos->backgroundImage;
$content = $pageInfos->content;
$page_online = $pageInfos->online;

?>

<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>uslu plaza estates</title>

<link rel="stylesheet" type="text/css" href="/<?= $WEBPATH ?>/css/allgemein.css">
<link rel="stylesheet" type="text/css" href="/<?= $WEBPATH ?>/css/kontakt.css">
<link rel="stylesheet" type="text/css" href="/<?= $WEBPATH ?>/css/supersized.css">
<link rel="stylesheet" type="text/css" href="/<?= $WEBPATH ?>/css/jquery.qtip.min.css">

<script type="text/javascript" src="/<?= $WEBPATH ?>/scripte/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="/<?= $WEBPATH ?>/scripte/supersized.3.2.7.js"></script>
<script type="text/javascript" src="/<?= $WEBPATH ?>/scripte/runonload.js"></script>
<script type="text/javascript" src="/<?= $WEBPATH ?>/scripte/jquery.qtip.min.js"></script>
<script type="text/javascript" src="/<?= $WEBPATH ?>/scripte/kontakt.js"></script>
<script type="text/javascript" src="/<?= $WEBPATH ?>/scripte/jquery.jmp3.js"></script>

</head>

<body marginheight="0" marginwidth="0" bottommargin="0" leftmargin="0" style="height:100%; margin:0px; padding:0px;">

<!-- player 
<div id="sound"><?php // include("../../sound/sound.html") ?></div>
<!-- /player -->

<div id="loading_icon"></div>

<?php include("menu.php") ?>


<!-- unternehmen seite 
<div id="k_headerbild"><img src="../../bilder/header_kontakt.png" alt="plaza estate - kontakt" width="764" height="176"></div>
-->

<!-- Inhaltsblock für Seitentexte -->
<div id="myForm">
<form action="#" method="POST" id="formular1">
          <table width="750" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td style="padding-left:25px; padding-top:15px;"><strong>Persönliche Daten</strong></td>
              </tr>
              <tr>
                <td height="1" bgcolor="#FF0000"></td>
              </tr>
              <tr>
                <td height="10"></td>
              </tr>
        </table>
        <table width="400" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="127" height="25" style="padding-left:25px;"><label>Name, Vorname</label></td>
            <td><input type="text" name="name" id="name" placeholder="name, vorname" size="30"/></td>
          </tr>
          <tr>
            <td height="25" style="padding-left:25px;"><label>Strasse</label></td>
            <td><input type="text" name="strasse" id="strasse" placeholder="strasse, nr" size="30" /></td>
          </tr>
          <tr>
            <td height="25" style="padding-left:25px;"><label>Plz/Ort</label></td>
            <td><input type="text" name="plz" id="plz" placeholder="12345" size="6" maxlength="5" /><img src="/<?= $WEBPATH ?>/bilder/space.gif" width="5" height="1" border="0" style="border:none;" /><input type="text" name="ort" id="ort" placeholder="ort" size="17" style="size:17px; width:132px;" /></td>
          </tr>
          <tr>
            <td height="25" style="padding-left:25px;"><label>E-Mail</label></td>
            <td><input type="text" name="email" id="email" placeholder="max@mustermann.de" size="30"/></td>
          </tr>
          <tr>
            <td height="25" style="padding-left:25px;"><label>Telefon</label></td>
            <td><input type="text" name="telefon" id="telefon" placeholder="0123-12345678" size="30" /></td>
          </tr>
          <tr>
            <td height="25" style="padding-left:25px;"><label>Mobil Telefon</label></td>
            <td><input type="text" name="mobil" id="mobil" placeholder="0123-12345678" size="30"/></td>
          </tr>
        </table>
          <table width="750" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td height="10"></td>
              </tr>
              <tr>
                <td style="padding-left:25px;"><span class="Stil4"><strong>Thema</strong></span></td>
              </tr>
              <tr>
                <td height="1" bgcolor="#FF0000"></td>
              </tr>
              <tr>
                <td height="10"></td>
              </tr>
        </table>
          <table width="750" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="80"><img src="/<?= $WEBPATH ?>/bilder/space.gif" width="80" height="1" border="0" style="border:none;" /></td>
            <td width="300" valign="top">
            	<select name="objekte" id="objekte" style="size:10px; width:290px;" size="10" multiple>
                  <option value="bp1">Businesspark Ulm I</option>
                  <option value="bp2">Businesspark Ulm II</option>
                  <option value="bp3">Businesspark Ulm III</option>
                  <option value="lindenstr">Linden Strasse</option>
                  <option value="wku">Wohn &amp; Geschäftshaus Kornhausgasse</option>
                  <option value="plazacenter">Plaza Center Ulm</option>
                </select>
            </td>
            <td width="50" align="right" valign="top">Notiz&nbsp;&nbsp;</td>
            <td width="300" valign="top"><textarea name="notiz" id="notiz" placeholder="ihr notiz" cols="30" rows="10" style="size:30px; width:290px; font-family:Arial, Helvetica, sans-serif; font-size:12px;" /></textarea></td>
            <td width="20"></td>
          </tr>
        </table>
          <table width="750" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td height="10"></td>
              </tr>
              <tr>
                <td style="padding-left:25px;"><strong>Kontaktieren Sie mich</strong></td>
              </tr>
              <tr>
                <td height="1" bgcolor="#FF0000"></td>
              </tr>
              <tr>
                <td height="10"></td>
              </tr>
        </table>
          <table width="700" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td height="25" align="left" style="padding-left:25px;">&nbsp;per E-Mail<img src="/<?= $WEBPATH ?>/bilder/space.gif" width="5" height="1" border="0" style="border:none;" /><input name="radiobuttons" id="radio" type="radio" value="per email" /><img src="/<?= $WEBPATH ?>/bilder/space.gif" width="30" height="1" border="0" style="border:none;" />per Anruf<img src="/<?= $WEBPATH ?>/bilder/space.gif" width="5" height="1" style="border:none;" /><input name="radiobuttons" id="radio" type="radio" value="per anruf" /><img src="/<?= $WEBPATH ?>/bilder/space.gif" width="30" height="1" border="0" style="border:none;" />per Post<img src="/<?= $WEBPATH ?>/bilder/space.gif" width="5" height="1" border="0" style="border:none;" /><input name="radiobuttons" id="radio" type="radio" value="per post" /><img src="/<?= $WEBPATH ?>/bilder/space.gif" width="200" height="1" border="0" style="border:none;" /><input type="submit" id="submit" value="Formular Senden" /></td>
          </tr>
        </table>
</form>
</div>
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
