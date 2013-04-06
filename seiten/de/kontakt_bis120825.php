<?php
//echo 'hallo welt'; exit;

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

$assetHandler = new AssetHandler('objects', $db);

$contentId = 2; // zur zeit in der Datenbank Objekt: Business Park I
$assets = $assetHandler->getAssets($contentId);

$pageTitle = $pageInfos->title;
$pageDescription = $pageInfos->description;
$pageKeywords = $pageInfos->keywords;
$backgroundImage = $pageInfos->backgroundImage;

?>
<!DOCTYPE HTML>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="description" content="<?= $pageDescription ?>" />
    <meta name="keywords" content="<?= $pageKeywords ?>" />
	<title><?= $pageTitle ?></title>

<link rel="stylesheet" type="text/css" href="/<?= $WEBPATH ?>/css/kontakt.css">
<link rel="stylesheet" type="text/css" href="/<?= $WEBPATH ?>/css/supersized.css">
<link rel="stylesheet" type="text/css" href="/<?= $WEBPATH ?>/css/jquery.validity.css">

<script type="text/javascript" src="/<?= $WEBPATH ?>/scripte/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="/<?= $WEBPATH ?>/scripte/supersized.3.2.7.js"></script>
<script type="text/javascript" src="/<?= $WEBPATH ?>/scripte/jQuery.validity.min.js"></script>
<script type="text/javascript" src="/<?= $WEBPATH ?>/scripte/kontakt.js"></script>

</head>

<body marginheight="0" marginwidth="0" bottommargin="0" leftmargin="0" style="height:100%; margin:0px; padding:0px;">

<div id="loading_icon"></div>

<div id="m01_unternehmen">
	<a href="unternehmen.php" id="link_unternehmen" name="4" style="text-decoration:none; color:#FFF;">
    	<img src="/<?= $WEBPATH ?>/bilder/button_unternehmen_de.jpg" alt="Unternehmen" width="80" height="80" border="0"></a>
</div>

<div id="m02_objekte">
	<a href="" id="objekte.php" name="4" style="text-decoration:none; color:#FFF;">
    	<img src="/<?= $WEBPATH ?>/bilder/button_objekte_de.jpg" alt="Objekte" width="80" height="80" border="0"></a>
</div>

<div id="m03_projekte">
	<a href="" id="projekte.php" name="4" style="text-decoration:none; color:#FFF;">
    	<img src="/<?= $WEBPATH ?>/bilder/button_projekte_de.jpg" alt="Projekte" width="80" height="80" border="0"></a>
</div>

<div id="m04_kontakt">
	<a href="#" id="link_kontakt" name="4" style="text-decoration:none; color:#FFF;">
    	<img src="/<?= $WEBPATH ?>/bilder/button_kontakt_de.jpg" alt="Kontakt" width="80" height="80" border="0"></a>
</div>

<div id="m05_impressum">
	<a href="impressum.php" id="link_impressum" name="4" style="text-decoration:none; color:#FFF;">
    	<img src="/<?= $WEBPATH ?>/bilder/button_impressum_de.jpg" alt="Impressum" width="80" height="80" border="0"></a>
</div>

<div id="m07_karriere">
	<a href="#" id="link_karriere" style="text-decoration:none; color:#FFF;">
    	<img src="/<?= $WEBPATH ?>/bilder/button_karriere_de.jpg" alt="Karriere" width="80" height="80" border="0"></a>
</div>

<div id="m06_start">
	<a href="/<?= $WEBPATH ?>/seiten/index.html" id="link_startseite" name="4" style="text-decoration:none; color:#FFF;">
    	<img src="/<?= $WEBPATH ?>/bilder/button_startseite_de.jpg" alt="Startseite" width="80" height="80" border="0"></a>
</div>


<!-- unternehmen seite -->
<div id="k_headerbild"></div>

<!-- Inhaltsblock für Seitentexte -->
<div id="myForm">
<form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" id="formular1">
          <table width="750" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td style="padding-left:25px;"><span class="Stil4"><strong>persönliche daten</strong></span></td>
              </tr>
              <tr>
                <td height="1" bgcolor="#6F87A1"></td>
              </tr>
              <tr>
                <td height="10"></td>
              </tr>
        </table>
        <table width="400" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="127" height="25" style="padding-left:25px;"><label>name, vorname</label></td>
            <td><input type="text" name="name" id="name" size="30"/></td>
          </tr>
          <tr>
            <td height="25" style="padding-left:25px;"><label>strasse</label></td>
            <td><input type="text" name="strasse" id="strasse" placeholder="strasse, nr" size="30" /></td>
          </tr>
          <tr>
            <td height="25" style="padding-left:25px;"><label>plz/ort</label></td>
            <td><input type="text" name="plz" id="plz" placeholder="12345" size="6" maxlength="5" /><img src="img/x.gif" width="5" height="1" /><input type="text" name="ort" id="ort" placeholder="ort" size="17" /></td>
          </tr>
          <tr>
            <td height="25" style="padding-left:25px;"><label>email</label></td>
            <td><input type="text" name="email" id="email" placeholder="max@mustermann.de" size="30" /></td>
          </tr>
          <tr>
            <td height="25" style="padding-left:25px;"><label>telefon</label></td>
            <td><input type="text" name="telefon" id="telefon" placeholder="0123-12345678" size="30" /></td>
          </tr>
          <tr>
            <td height="25" style="padding-left:25px;"><label>mobil telefon</label></td>
            <td><input type="text" name="mobil" id="mobil" placeholder="0123-12345678" size="30"/></td>
          </tr>
        </table>
          <table width="750" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td height="10"></td>
              </tr>
              <tr>
                <td style="padding-left:25px;"><span class="Stil4"><strong>thema</strong></span></td>
              </tr>
              <tr>
                <td height="1" bgcolor="#6F87A1"></td>
              </tr>
              <tr>
                <td height="10"></td>
              </tr>
        </table>
          <table width="700" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="150"><img src="img/x.gif" width="150" height="1" /></td>
            <td width="255" valign="top">
            	<select name="objekte" id="objekte" size="10" multiple>
                	<option value="bp1">businesspark ulm I</option>
                	<option value="bp2">businesspark ulm II</option>
                	<option value="bp3">businesspark ulm III</option>
                	<option value="lindenstr">linden strasse</option>
                	<option value="wku">wohn &amp; geschäftshaus kornhausgasse</option>
                	<option value="plazacenter">plaza center ulm</option>
           	</select></td>
            <td width="100" rowspan="6" align="right" valign="top">notiz&nbsp;&nbsp;</td>
            <td width="257" rowspan="6" valign="top"><textarea name="notiz" id="notiz" placeholder="ihr notiz" cols="40" rows="10" /></textarea></td>
          </tr>
        </table>
          <table width="750" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td height="10"></td>
              </tr>
              <tr>
                <td style="padding-left:25px;"><span class="Stil4"><strong>kontaktieren sie mich</strong></span></td>
              </tr>
              <tr>
                <td height="1" bgcolor="#6F87A1"></td>
              </tr>
              <tr>
                <td height="10"></td>
              </tr>
        </table>
          <table width="700" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td height="25" align="left" style="padding-left:25px;">&nbsp;per email<img src="img/x.gif" width="5" height="1" /><input name="radiobuttons" type="radio" value="per email" /><img src="img/x.gif" width="30" height="1" />per anruf<img src="img/x.gif" width="5" height="1" /><input name="radiobuttons" type="radio" value="per anruf" /><img src="img/x.gif" width="30" height="1" />per post<img src="img/x.gif" width="5" height="1" /><input name="radiobuttons" type="radio" value="per post" /><img src="img/x.gif" width="230" height="1" />	<input type="submit" id="submit" value="formualar senden" /></td>
          </tr>
        </table>
</form>
</div>
<!-- ****************  -->

<!-- künye am Footer & logo -->
<div id="footer">
	<a href="#" id="open" style="float:right; padding-right:10px;"><img src="../../bilder/open.gif" width="20" height="20" alt="Open" border="0"></a> <strong>uslu projektentwicklung</strong> <a href="#" id="close" style="float:right; padding-right:10px;"><img src="../../bilder/close.gif" alt="close" width="20" height="20" border="0" style="display:none;"></a>

    <div id="footer_inhalt"></div>

</div>
<!-- ****************  -->


</body>
</html>
<?php
//if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')

//sende mail -------------------------------------------------
function mailsend(
    $name, $strasse, $plz, $ort, $email, $telefon, $mobil, $objekte, $radio,
    $notiz
)
{
		$to = "e-devrim@t-online.de";
		$betreff = "Sie haben eine Anfrage erhalten";
		$headers = "From: $email\nContent-type: text/html; charset=\"ISO-8859-1\"\n";


		$body = "
		<!DOCTYPE html PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\" \"http://www.w3.org/TR/html4/loose.dtd\">
<html xmlns=\"http://www.w3.org/1999/xhtml\">
<head>
<meta http-equiv=\"Content-Type\" content=\"text/html\" charset=\"ISO-8859-15\" />
<title>uslu plaza estates</title>
<style type=\"text/css\">
<!--
#table {
font-family:Arial, Helvetica, sans-serif;
font-size:12px;
padding-left:2px;
}

#table td {
border:#999999 solid 1px;
}
-->
</style>
</head>

<body>
<table width=\"400\" border=\"0\" cellspacing=\"3\" cellpadding=\"0\" id=\"table\">
	<tr><td>sie haben eine anfrage &#252;ber ihre internetseite erhalten<br><br></td></tr>
</table>
<table width=\"400\" border=\"0\" cellspacing=\"3\" cellpadding=\"0\" id=\"table\">
  <tr>
    <td width=\"150\">name/vorname</td>
    <td width=\"10\" style=\"border:0;\">&nbsp;</td>
    <td width=\"240\">$name</td>
  </tr>
  <tr>
    <td width=\"150\">strasse</td>
    <td width=\"10\" style=\"border:0;\">&nbsp;</td>
    <td width=\"240\">$strasse</td>
  </tr>
  <tr>
    <td width=\"150\">plz/ort</td>
    <td width=\"10\" style=\"border:0;\">&nbsp;</td>
    <td width=\"240\">$plz / $ort</td>
  </tr>
  <tr>
    <td width=\"150\">email</td>
    <td width=\"10\" style=\"border:0;\">&nbsp;</td>
    <td width=\"240\">$email</td>
  </tr>
  <tr>
    <td width=\"150\">telefon</td>
    <td width=\"10\" style=\"border:0;\">&nbsp;</td>
    <td width=\"240\">$telefon</td>
  </tr>
  <tr>
    <td width=\"150\">mobil</td>
    <td width=\"10\" style=\"border:0;\">&nbsp;</td>
    <td width=\"240\">$mobil</td>
  </tr>
  <tr>
    <td colspan=\"3\" height=\"5\"></td>
  </tr>
  <tr>
    <td colspan=\"3\" height=\"1\" bgcolor=\"#999999\"></td>
  </tr>
  <tr>
    <td colspan=\"3\" height=\"5\"></td>
  </tr>
  <tr>
    <td width=\"150\">objekte</td>
    <td width=\"10\" style=\"border:0;\">&nbsp;</td>
    <td width=\"240\">$objekte</td>
  </tr>
  <tr>
    <td colspan=\"3\" height=\"5\"></td>
  </tr>
  <tr>
    <td colspan=\"3\" height=\"1\" bgcolor=\"#999999\"></td>
  </tr>
  <tr>
    <td colspan=\"3\" height=\"5\"></td>
  </tr>
   <tr>
    <td width=\"150\">kontaktweg</td>
    <td width=\"10\" style=\"border:0;\">&nbsp;</td>
    <td width=\"240\">$radio</td>
  </tr>
  <tr>
    <td colspan=\"3\" height=\"5\"></td>
  </tr>
  <tr>
    <td colspan=\"3\" height=\"1\" bgcolor=\"#999999\"></td>
  </tr>
  <tr>
    <td colspan=\"3\" height=\"5\"></td>
  </tr>
   <tr>
    <td width=\"150\">notiz</td>
    <td width=\"10\" style=\"border:0;\">&nbsp;</td>
    <td width=\"240\">$notiz</td>
  </tr>
</table>

</body>
</html>
		";
		mail ($to, $betreff, $body, $headers);
	}

// \ sende mail ------------------------------------------------------------->

$allGood = true;
 if($_POST){
     $name 					= utf8_decode($_POST['name']);
     $strasse 				= utf8_decode($_POST['strasse']);
     $plz					= utf8_decode($_POST['plz']);
     $ort					= utf8_decode($_POST['ort']);
     $email					= utf8_decode($_POST['email']);
     $telefon				= utf8_decode($_POST['telefon']);
     $mobil					= utf8_decode($_POST['mobil']);
     $objekte				= utf8_decode($_POST['objekte']);
     $radio					= utf8_decode($_POST['radio']);
     $notiz					= utf8_decode($_POST['notiz']);

     mailsend($name,$strasse,$plz,$ort,$email,$telefon,$mobil,$objekte,$radio,$notiz);
}else{
    echo 2;
}

?>