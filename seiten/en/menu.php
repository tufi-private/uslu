<?php
$query_job = 'select online from pages where identifier like "jobs"';
$jobInfo = $db->getRow($query_job);
$job_online = $jobInfo->online;
?>
<div style="box-shadow: 0px 0px 10px 0px rgba(0,0,0,1);" id="m01_unternehmen" >
  <a href="unternehmen.php" id="link_unternehmen" name="2" style="text-decoration:none; color:#FFF;">About Us</a>
</div>

<div style="box-shadow: 0px 0px 10px 0px rgba(0,0,0,1);" id="m02_objekte" >
  <a href="objekte.php" id="link_objekte" name="3" style="text-decoration:none; color:#FFF;">Objects</a>
</div>

<div style="box-shadow: 0px 0px 10px 0px rgba(0,0,0,1);" id="m03_projekte" >
  <a href="projekte.php" id="link_projekte" name="4" style="text-decoration:none; color:#FFF;">Projects</a>
</div>


<div style="box-shadow: 0px 0px 10px 0px rgba(0,0,0,1);" id="m04_kontakt" >
  <a href="kontakt.php" id="link_kontakt" name="5" style="text-decoration:none; color:#FFF;">Contact</a>
</div>

<div style="box-shadow: 0px 0px 10px 0px rgba(0,0,0,1);" id="m05_impressum" >
  <a href="impressum.php" id="link_impressum" name="6" style="text-decoration:none; color:#FFF;">Imprint</a>
</div>
<?php
	if ($job_online == "1") {
?>
<div style="box-shadow: 0px 0px 10px 0px rgba(0,0,0,1);" id="m07_karriere" >
  <a href="karriere.php" id="link_karriere" name="7" style="text-decoration:none; color:#FFF;">Career</a>
</div>
<?php }else {} ?>

<div style="box-shadow: 0px 0px 10px 0px rgba(0,0,0,1);" id="m06_start" >
  <a href="/<?= $WEBPATH ?>/seiten/index.html" target="_top" name="1" id="link_startseite" style="text-decoration:none; color:#FFF;">Startseite</a>
</div>