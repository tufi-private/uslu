<?php
	function mailsend ($name,$strasse,$plz,$ort,$email,$telefon,$mobil,$thema_string,$radiobuttons_string,$notiz)
	{

		$to = "devrim@t-online.de";
		$betreff = "Sie haben eine Anfrage erhalten";
		$headers = "From: $email\nContent-type: text/html; charset=\"ISO-8859-15\"\n";
		

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

?>
