<?php
require_once '../../config/init.inc.php';

$query = 'SELECT * FROM pages WHERE identifier LIKE "objects" AND lang="EN"';
$pageInfos = $db->getRow($query);


$assetHandler = new AssetHandler('objects', $db);

$pageTitle = $pageInfos->title;
$pageDescription = $pageInfos->description;
$pageKeywords = $pageInfos->keywords;
$backgroundImage = $pageInfos->backgroundImage;
$page_online = $pageInfos->online;

$query_job = 'SELECT online FROM pages WHERE identifier LIKE "jobs"';
$jobInfo = $db->getRow($query_job);
$job_online = $jobInfo->online;
?><!DOCTYPE HTML>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="description" content="<?= $pageDescription ?>" />
    <meta name="keywords" content="<?= $pageKeywords ?>" />
	<title><?= $pageTitle ?></title>

<link rel="stylesheet" type="text/css" href="/<?= $WEBPATH ?>/css/allgemein.css">
<link rel="stylesheet" type="text/css" href="/<?= $WEBPATH ?>/css/supersized.css">
<link rel="stylesheet" type="text/css" href="/<?= $WEBPATH ?>/css/objekte.css">
<link rel="stylesheet" href="/<?= $WEBPATH ?>/scripte/fancybox/source/jquery.fancybox.css?v=2.1.0" type="text/css" media="screen" />

<script type="text/javascript" src="/<?= $WEBPATH ?>/scripte/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="/<?= $WEBPATH ?>/scripte/jquery.animate-shadow.js"></script>
<script type="text/javascript" src="/<?= $WEBPATH ?>/scripte/supersized.3.2.7.js"></script>
<script type="text/javascript" src="/<?= $WEBPATH ?>/scripte/objekte.js.php?lang=en"></script>
<script type="text/javascript" src="/<?= $WEBPATH ?>/scripte/fancybox/source/jquery.fancybox.pack.js?v=2.1.0"></script>
<script type="text/javascript" src="/<?= $WEBPATH ?>/scripte/jquery.jmp3.js"></script>
</head>

<body marginheight="0" marginwidth="0" bottommargin="0" leftmargin="0" style="height:100%; margin:0px; padding:0px;">

<!-- player
<div id="sound"><?php // include("../../sound/sound.html") ?></div>
<!-- /player -->

<!-- Menü punkte -->
<?php include("menu.php") ?>
<!-- ****************  -->
<?php
/* Zeige soviel Objekte-Button, die in DB eingetragen sind */
$query = 'SELECT * FROM content WHERE PageId = 11';
$ergebnis = $db->getRows($query);
$anzahl_bilder = count($ergebnis);

echo "<script language=\"javascript\">

		jQuery(function () {

		/* Objektpunkte werden an Position bewegt */
			$('#o_1').hide().animate({top : '300px', left : '150px'},2000).fadeIn(1000);
			$('#o_2').hide().animate({top : '300px', left : '210px'},2000).fadeIn(1000);
			$('#o_3').hide().animate({top : '300px', left : '270px'},2000).fadeIn(1000);
			$('#o_4').hide().animate({top : '360px', left : '150px'},2000).fadeIn(1000);
			$('#o_6').hide().animate({top : '360px', left : '210px'},2000).fadeIn(1000);
			$('#o_7').hide().animate({top : '360px', left : '270px'},2000).fadeIn(1000);
			$('#o_8').hide().animate({top : '360px', left : '330px'},2000).fadeIn(1000);
			$('#o_9').hide().animate({top : '420px', left : '150px'},2000).fadeIn(1000);
			$('#o_10').hide().animate({top : '420px', left : '210px'},2000).fadeIn(1000);
			$('#o_11').hide().animate({top : '420px', left : '270px'},2000).fadeIn(1000);
			$('#o_12').hide().animate({top : '420px', left : '330px'},2000).fadeIn(1000);
			$('#o_13').hide().animate({top : '420px', left : '390px'},2000).fadeIn(1000);
			$('#o_14').hide().animate({top : '480px', left : '150px'},2000).fadeIn(1000);
			$('#o_15').hide().animate({top : '480px', left : '210px'},2000).fadeIn(1000);
			$('#o_16').hide().animate({top : '480px', left : '270px'},2000).fadeIn(1000);

			$('#o_32').hide().animate({top : '300px', left : '150px'},2000).fadeIn(1000);
			$('#o_33').hide().animate({top : '300px', left : '210px'},2000).fadeIn(1000);
			$('#o_34').hide().animate({top : '300px', left : '270px'},2000).fadeIn(1000);
			$('#o_35').hide().animate({top : '360px', left : '150px'},2000).fadeIn(1000);
			$('#o_36').hide().animate({top : '360px', left : '210px'},2000).fadeIn(1000);
			$('#o_37').hide().animate({top : '360px', left : '270px'},2000).fadeIn(1000);
			$('#o_38').hide().animate({top : '360px', left : '330px'},2000).fadeIn(1000);
			$('#o_39').hide().animate({top : '420px', left : '150px'},2000).fadeIn(1000);
			$('#o_40').hide().animate({top : '420px', left : '210px'},2000).fadeIn(1000);
			$('#o_41').hide().animate({top : '420px', left : '270px'},2000).fadeIn(1000);
			$('#o_42').hide().animate({top : '420px', left : '330px'},2000).fadeIn(1000);
			$('#o_43').hide().animate({top : '420px', left : '390px'},2000).fadeIn(1000);
			$('#o_44').hide().animate({top : '480px', left : '150px'},2000).fadeIn(1000);
			$('#o_45').hide().animate({top : '480px', left : '210px'},2000).fadeIn(1000);
			$('#o_46').hide().animate({top : '480px', left : '270px'},2000).fadeIn(1000);
		});

		</script>";


foreach ($ergebnis as $key => $object):
    $id = (int)$object->id;
    $content = $object->content;
    $contentId = $id;
    $assets = $assetHandler->getAssets($contentId);

    if (empty($assets)) :?>
        <script language="javascript">
            jQuery(function () {
                $('#o_gallerie_<?= $id ?>').hide();
                $('#o_pdf_<?= $id ?>').hide();
            });
        </script>
    <?php endif; ?>

    <?php if (!empty($content)): ?>
        <div class="btn-o_<?=$id?> menuButton" id="o_<?=$id?>"><?= $object->menuAbbr?></div>
    <? endif; ?>

    <!-- Inhaltsblock für container -->
    <div id="container_o<?=$id?>" class="container">
        <!-- Inhaltsblock für Seitentexte -->
        <div id="o_inhalt_<?=$id?>" class="o_inhalt">
            <?=$content?>
            <!-- Inhaltsblock für Galerie -->
            <?php
            $hasImage = false;
            if (is_array($assets) && !empty($assets)) {
                foreach ($assets as $key => $value) {
                    if ($value['category'] == 'bilder') {
                        $hasImage = true;
                        break;
                    }
                }
            }
            if ($hasImage) :
                ?>
                <div id="o_gallerie_<?= $id ?>" class="o_gallerie">
                    <?php
                    foreach ($assets as $key => $value) {
                        if ($value['category'] == 'bilder'
                            && substr($value['path'], 40, 4) == 'orig'
                        ) {
                            $path_orig = trim($value['path']);
                            $path_thumb = str_replace(
                                'orig', 'thumb', $path_orig
                            );

                            $dimensions = '';
                            $thumbnail = realpath(
                                dirname(__FILE__) . '/../../' . $path_thumb
                            );
                            if (is_file($thumbnail)) {
                                $dimensionsArray = getimagesize($thumbnail);
                                $dimensions = $dimensionsArray[3];
                            }


                            echo"<a href='../../" . $path_orig
                                . "' class='fancybox' target='_blank'><img src='../../"
                                . $path_thumb
                                . "' $dimensions style='margin: 10px 3px 10px 3px;'></a>";
                        }
                    }
                    ?>
                </div>
            <?php endif; ?>
            <!-- /Inhaltsblock für Galerie -->

            <!-- Inhaltsblock für PDF-Galerie -->
            <?php
            $hasPdf = false;
            if (is_array($assets) && !empty($assets)) {
                foreach ($assets as $key => $value) {
                    if ($value['category'] == 'pdf') {
                        $hasPdf = true;
                        break;
                    }
                }
            }
            ?>
            <?php if ($hasPdf) : ?>
                <div id="o_pdf_<?=$id?>" class="o_pdf">
                    <?php
                    foreach ($assets as $key => $value) {

                        if ($value['category'] == 'pdf') {
                            $pdfPath = trim($value['path']);
                            $thumbnailPath = trim($value['thumbnail_path']);
                            $dimensions = '';
                            if (!empty($thumbnailPath)) {
                                $thumbnail = realpath(
                                    dirname(__FILE__) . '/../../'
                                        . $thumbnailPath
                                );
                                if (is_file($thumbnail)) {
                                    $dimensionsArray = getimagesize($thumbnail);
                                    $dimensions = $dimensionsArray[3];
                                }
                            }
                            ?>
                            <a href="../../<?= $pdfPath ?>" class="fancybox" target="_blank"><img src='../../<?= $thumbnailPath ?>' <?= $dimensions?> style='padding-left:3px; padding-top:10px; padding-bottom:10px;'></a>
                        <?php
                        }
                    }
                    ?>
                </div>
            <?php endif; ?>
            <!-- /Inhaltsblock für PDF-Galerie -->
        </div>
    </div>

<?php endforeach; ?>


<!-- impressum am Footer & logo
<div id="footer">
    <a href="#" id="open" style="float:right; padding-right:10px;">
        <img src="/<?= $WEBPATH ?>/bilder/open.gif" width="20" height="20"
             alt="Open" border="0"></a> <strong>Uslu Plaza Estates</strong>
    <a href="#" id="close" style="float:right; padding-right:10px;">
        <img src="/<?= $WEBPATH ?>/bilder/close.gif" alt="close" width="20"
             height="20" border="0" style="display:none;"></a>
    <div id="footer_inhalt"></div>
</div>
-->
<!-- ****************  -->

<img src="/<?= $WEBPATH ?>/assets/<?=$backgroundImage?>" style="display:none;" id="bg_groundImage">
</body>
</html>
