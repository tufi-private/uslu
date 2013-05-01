<?php
require_once '../../config/init.inc.php';

$query = 'select * from pages where identifier like "contact" AND lang = "DE"';
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
<title><?=$pageTitle?></title>

<link rel="stylesheet" type="text/css" href="/<?= $WEBPATH ?>/css/allgemein.css">
<link rel="stylesheet" type="text/css" href="/<?= $WEBPATH ?>/css/kontakt.css">
<link rel="stylesheet" type="text/css" href="/<?= $WEBPATH ?>/css/supersized.css">
<!-- <link rel="stylesheet" type="text/css" href="/<?= $WEBPATH ?>/css/jquery.qtip.min.css"> -->

<script type="text/javascript" src="/<?= $WEBPATH ?>/scripte/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="/<?= $WEBPATH ?>/scripte/jquery.animate-shadow.js"></script>
<script type="text/javascript" src="/<?= $WEBPATH ?>/scripte/supersized.3.2.7.js"></script>
<!-- <script type="text/javascript" src="/<?= $WEBPATH ?>/scripte/runonload.js"></script>
<script type="text/javascript" src="/<?= $WEBPATH ?>/scripte/jquery.qtip.min.js"></script> -->
<script type="text/javascript" src="/<?= $WEBPATH ?>/scripte/kontakt.js?lang=de"></script>
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
<form action="#" method="POST" id="formail">
<input type="hidden" id="versteckt" value="12_%r!Afq">
          <table width="550" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td style="padding-left:25px; padding-top:15px; padding-bottom:10px;"><span style="font-family:Arial, Helvetica, sans-serif; font-size: x-large;"><strong>Kontakt</strong></span></td>
              </tr>
              <tr>
                <td height="1" bgcolor="#FF0000"></td>
              </tr>
              <tr>
                <td height="10"></td>
              </tr>
        </table>
        <table width="550" border="0" cellspacing="0" cellpadding="0">
        <tr>
        	<td width="550">
                <table width="550" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="130" height="25" style="padding-left:25px;"><label>Name, Vorname(*)</label></td>
                <td width="420"><input type="text" name="name" id="name" size="30" style="width:350px; height:15px;"/></td>
              </tr>
              <tr>
                <td height="25" style="padding-left:25px;"><label>Strasse</label></td>
                <td><input type="text" name="strasse" id="strasse" size="30" style="width:350px; height:15px;" /></td>
              </tr>
              <tr>
                <td height="25" style="padding-left:25px;"><label>Plz/Ort</label></td>
                <td><input type="text" name="plz" id="plz" size="6" maxlength="5" style="width:45px; height:15px;" /><img src="/<?= $WEBPATH ?>/bilder/space.gif" width="5" height="1" border="0" style="border:none;" /><input type="text" name="ort" id="ort" size="17" style="size:17px; width:295px; height:15px;" /></td>
              </tr>
              <tr>
                <td height="25" style="padding-left:25px;"><label>E-Mail(*)</label></td>
                <td><input type="text" name="email" id="email" size="30" style="width:350px; height:15px;"/></td>
              </tr>
              <tr>
                <td height="25" style="padding-left:25px;"><label>Telefon(*)</label></td>
                <td><input type="text" name="telefon" id="telefon" size="30" style="width:350px; height:15px;" /></td>
              </tr>
              <tr>
                <td height="25" style="padding-left:25px;"><label>Mobil Telefon(*)</label></td>
                <td><input type="text" name="mobil" id="mobil" size="30" style="width:350px; height:15px;"/></td>
              </tr>
              <tr>
                <td height="25" style="padding-left:25px;padding-top:6px;" valign="top"><label>Ihre Nachricht(*)</label></td>
                <td style="padding-top:2px;"><textarea name="notiz" id="notiz" cols="30" rows="10" style="size:30px; width:350px; height:160px; font-family:Arial, Helvetica, sans-serif; font-size:12px;" /></textarea></td>
              </tr>
            </table></td>
         </tr>
         </table>
        <table width="550" border="0" cellspacing="0" cellpadding="0" height="30">
              <tr>
                <td style="height:30px;"><img src="/<?= $WEBPATH ?>/bilder/space.gif" width="1" height="30" border="0" style="border:none;" /></td>
              </tr>
        </table>
        <table width="550" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="right" style="padding-right:50px;"><input type="submit" id="submit" value="Absenden" />&nbsp;</td>
          </tr>
        </table>
        <table width="550" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td ><img src="/<?= $WEBPATH ?>/bilder/space.gif" width="1" height="35" border="0" style="border:none;" /></td>
              </tr>
        </table>
        <table width="550" border="0" cellspacing="0" cellpadding="0" id="meldung">
           <tr>
              <td><div id="response"></div></td>
           </tr>
        </table>

</form>
</div>
<!-- ****************  -->

<!-- künye am Footer & logo
<div id="footer">
	<a href="#" id="open" style="float:right; padding-right:10px;"><img src="/<?= $WEBPATH ?>/bilder/open.gif" width="20" height="20" alt="Open" border="0"></a> <strong>Uslu Plaza Estates</strong> <a href="#" id="close" style="float:right; padding-right:10px;"><img src="/<?= $WEBPATH ?>/bilder/close.gif" alt="close" width="20" height="20" border="0" style="display:none;"></a>

    <div id="footer_inhalt"></div>

</div>
-->
<!-- ****************  -->

<img src="/<?= $WEBPATH ?>/assets/<?=$backgroundImage?>" style="display:none;" id="bg_groundImage">
</body>
</html>
