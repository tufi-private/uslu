<?php

$query_job = 'select online from pages where identifier like "jobs"';
$jobInfo = $db->getRow($query_job);
$job_online = $jobInfo->online;

?>

<div id="m01_unternehmen">
	<a href="unternehmen.php" id="link_unternehmen" name="2" style="text-decoration:none; color:#FFF;">
    	<img src="/<?= $WEBPATH ?>/bilder/button_unternehmen_de.png" alt="Unternehmen" width="80" height="80" border="0"></a>
</div>

<div id="m02_objekte">
	<a href="objekte.php" id="link_objekte" name="3" style="text-decoration:none; color:#FFF;">
    	<img src="/<?= $WEBPATH ?>/bilder/button_objekte_de.png" alt="Objekte" width="80" height="80" border="0"></a>
</div>

<div id="m03_projekte">
	<a href="projekte.php" id="link_projekte" name="4" style="text-decoration:none; color:#FFF;">
    	<img src="/<?= $WEBPATH ?>/bilder/button_projekte_de.png" alt="Projekte" width="80" height="80" border="0"></a>
</div>

<div id="m04_kontakt">
	<a href="kontakt.php" id="link_kontakt" name="5" style="text-decoration:none; color:#FFF;">
    	<img src="/<?= $WEBPATH ?>/bilder/button_kontakt_de.png" alt="Kontakt" width="80" height="80" border="0"></a>
</div>

<div id="m05_impressum">
	<a href="impressum.php" id="link_impressum" name="6" style="text-decoration:none; color:#FFF;">
    	<img src="/<?= $WEBPATH ?>/bilder/button_impressum_de.png" alt="Impressum" width="80" height="80" border="0"></a>
</div>


<?php
	if ($job_online == "1") {
?>
<div id="m07_karriere">
	<a href="karriere.php" id="link_karriere" name="7" style="text-decoration:none; color:#FFF;">
    	<img src="/<?= $WEBPATH ?>/bilder/button_karriere_de.png" alt="Karriere" width="80" height="80" border="0"></a>
</div>
<?php }else {} ?>

<div id="m06_start">
	<a href="/<?= $WEBPATH ?>/seiten/index.html" target="_top" name="1" id="link_startseite" style="text-decoration:none; color:#FFF;">
    	<img src="/<?= $WEBPATH ?>/bilder/button_startseite_de.png" alt="Startseite" width="80" height="80" border="0"></a>
</div>
