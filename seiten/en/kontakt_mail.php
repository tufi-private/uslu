<?php
if (isset($_POST['versteckt']) AND $_POST['versteckt'] == '12_%r!Afq') {

	$name       = $_POST['name'];
	$strasse    = $_POST['strasse'];
	$plz        = $_POST['plz'];
	$ort        = $_POST['ort'];
	$email      = $_POST['email'];
	$telefon    = $_POST['telefon'];
	$mobil      = $_POST['mobil'];
	$notiz      = $_POST['notiz'];
	$subject    = "Anfrage über Kontaktformular";

 $to = "c.uslu@uslu.com";
 $headers = "From: $email\nContent-type: text/html; charset=\"utf-8\"\r\n";
 $body ="<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml'>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
<title>Plaza Estates - Kontaktanfrage</title>
<style type='text/css'>
<!--
.format td {
	font-family:Arial, Helvetica, sans-serif;
	font-size:12px;
	height:25px;
	padding-left:5px;
	vertical-align:middle;
	border-bottom:#CCCCCC thin solid;

}
-->
</style>

</head>

<body>
<table width='600' border='0' cellspacing='0' cellpadding='0' class='format' id='table' style='border:#CCCCCC thin solid;'>
  <tr>
    <td width='100' style='color:#900000;'><strong>Name</strong></td>
    <td width='500'>$name</td>
  </tr>
  <tr>
    <td style='color:#900000;'><strong>Strasse</strong></td>
    <td>$strasse</td>
  </tr>
  <tr>
    <td style='color:#900000;'><strong>PLZ</strong></td>
    <td>$plz</td>
  </tr>
  <tr>
    <td style='color:#900000;'><strong>Ort</strong></td>
    <td>$ort</td>
  </tr>
  <tr>
    <td style='color:#900000;'><strong>E-Mail</strong></td>
    <td>$email</td>
  </tr>
  <tr>
    <td style='color:#900000;'><strong>Telefon</strong></td>
    <td>$telefon</td>
  </tr>
  <tr>
    <td style='color:#900000;'><strong>Mobil</strong></td>
    <td>$mobil</td>
  </tr>
  <tr>
    <td style='color:#900000;'><strong>Nachricht</strong></td>
    <td>$notiz</td>
  </tr>
</table>
</body>
</html>";
	 if(mail($to, '=?UTF-8?B?'.base64_encode($subject).'?=', $body, $headers)){
		echo "<strong>Vielen Dank!</strong><br>
		Ihre Nachricht wurde erfolgreich an uns gesendet!<br><br>
		Wir werden uns in Kürze bei Ihnen melden.";
	}
	else{
		echo "Ihr Nachricht konnte aufgrund eines Fehlers <u>nicht gesendet</u>!<br>
		Versuchen Sie bei späterem Zeitpunkt noch ein mal oder<br>
		rufen Sie uns einfach an.";
	}
}
else {
	echo $_POST['versteckt']." - Dieses Formular kann nicht direkt aufgerufen werden!";
}
?>