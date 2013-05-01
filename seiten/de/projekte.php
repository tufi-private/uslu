<?php
require_once '../../config/init.inc.php';

$query = 'select * from pages where identifier like "projects" AND lang="DE"';
$pageInfos = $db->getRow($query);

$assetHandler = new AssetHandler('projects', $db);

$pageTitle = $pageInfos->title;
$pageDescription = $pageInfos->description;
$pageKeywords = $pageInfos->keywords;
$backgroundImage = $pageInfos->backgroundImage;
$page_online = $pageInfos->online;
?><!DOCTYPE HTML>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="description" content="<?= $pageDescription ?>" />
    <meta name="keywords" content="<?= $pageKeywords ?>" />
	<title><?= $pageTitle ?></title>

<link rel="stylesheet" type="text/css" href="/<?= $WEBPATH ?>/css/allgemein.css">
<link rel="stylesheet" type="text/css" href="/<?= $WEBPATH ?>/css/supersized.css">
<link rel="stylesheet" type="text/css" href="/<?= $WEBPATH ?>/css/projekte.css">
<link rel="stylesheet" href="/<?= $WEBPATH ?>/scripte/fancybox/source/jquery.fancybox.css?v=2.1.0" type="text/css" media="screen" />

<script type="text/javascript" src="/<?= $WEBPATH ?>/scripte/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="/<?= $WEBPATH ?>/scripte/jquery.animate-shadow.js"></script>
<script type="text/javascript" src="/<?= $WEBPATH ?>/scripte/supersized.3.2.7.js"></script>
<script type="text/javascript" src="/<?= $WEBPATH ?>/scripte/projekte.js.php?lang=de&c=<?= time();?>"></script>
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
$query = 'select * FROM content WHERE PageId = 5';
$ergebnis = $db->getRows($query);
$anzahl_bilder = count($ergebnis);

echo "<script language=\"javascript\">

		jQuery(function () {

		/* Projektpunkte werden an Position bewegt */
			$('#p_17').hide().animate({top : '300px', left : '150px'},2000).fadeIn(1000);
			$('#p_18').hide().animate({top : '300px', left : '210px'},2000).fadeIn(1000);
			$('#p_19').hide().animate({top : '300px', left : '270px'},2000).fadeIn(1000);
			$('#p_20').hide().animate({top : '360px', left : '150px'},2000).fadeIn(1000);
			$('#p_21').hide().animate({top : '360px', left : '210px'},2000).fadeIn(1000);
			$('#p_22').hide().animate({top : '360px', left : '270px'},2000).fadeIn(1000);
			$('#p_23').hide().animate({top : '360px', left : '330px'},2000).fadeIn(1000);
			$('#p_24').hide().animate({top : '420px', left : '150px'},2000).fadeIn(1000);
			$('#p_25').hide().animate({top : '420px', left : '210px'},2000).fadeIn(1000);
			$('#p_26').hide().animate({top : '420px', left : '270px'},2000).fadeIn(1000);
			$('#p_27').hide().animate({top : '420px', left : '330px'},2000).fadeIn(1000);
			$('#p_28').hide().animate({top : '420px', left : '390px'},2000).fadeIn(1000);
			$('#p_29').hide().animate({top : '480px', left : '150px'},2000).fadeIn(1000);
			$('#p_30').hide().animate({top : '480px', left : '210px'},2000).fadeIn(1000);
			$('#p_31').hide().animate({top : '480px', left : '270px'},2000).fadeIn(1000);
		});

		</script>";

foreach ($ergebnis as $key => $object) {
	$id = (int)$object->id;
    $content = $object->content;
    $contentId = $id;
    $assets = $assetHandler->getAssets($contentId);

    if (empty($assets)) :?>
        <script language="javascript">
            jQuery(function () {
                $('#p_gallerie_<?= $id ?>').hide();
                $('#p_pdf_<?= $id ?>').hide();
            });
        </script>
    <?php endif; ?>
    <?php if (!empty($content)): ?>
        <div class="btn-p_<?=$id?> menuButton" id="p_<?=$id?>"><?= $object->menuAbbr?></div>
    <? endif; ?>

<div id="container_p<?= $id ?>" class="container">
    <!-- Inhaltsblock für Seitentexte -->
    <div id="p_inhalt_<?=$id ?>" class="p_inhalt">
        <?=$content?>

    <!-- Inhaltsblock für Galerie -->
    <?php
    $hasImage=false;
    if (is_array($assets) && !empty($assets)){
        foreach ($assets as $key=> $value) {
            if ($value['category'] == 'bilder') {
                $hasImage = true;
                break;
            }
        }
    }
    if ($hasImage) :
    ?>
    <div id="p_gallerie_<?=$id ?>" class="p_gallerie">
        <?php
			foreach ($assets as $key=>$value)
			{
				if ($value['category'] == 'bilder' && substr ($value['path'],40,4) == 'orig')
				{
					$path_orig = trim($value['path']);
					$path_thumb = str_replace('orig', 'thumb', $path_orig);

                    $dimensions = '';
                    $thumbnail = realpath(
                        dirname(__FILE__) . '/../../' . $path_thumb
                    );
                    if (is_file($thumbnail)) {
                        $dimensionsArray = getimagesize($thumbnail);
                        $dimensions = $dimensionsArray[3];
                    }


					echo "<a href='../../".$path_orig."' class='fancybox' target='_blank'><img src='../../".$path_thumb."' $dimensions style='margin: 10px 3px 10px 3px;'></a>";

				}
			}
        ?>
  </div>
        <?php endif; ?>
    <!-- /Inhaltsblock für Galerie -->

    <!-- Inhaltsblock für PDF-Galerie -->
<?php
    $hasPdf=false;
    if (is_array($assets) && !empty($assets)){
        foreach ($assets as $key=> $value) {
            if ($value['category'] == 'pdf') {
                $hasPdf = true;
                break;
            }
        }
    }
    ?>
    <?php if ($hasPdf) : ?>

    <div id="p_pdf_<?=$id ?>" class="p_pdf">
        <?php
			foreach ($assets as $key=>$value) {

				if ($value['category'] == 'pdf') {
					$pdfPath = trim($value['path']);
					$thumbnailPath = trim($value['thumbnail_path']);
                    $dimensions = '';
                    if (!empty($thumbnailPath)) {
                        $thumbnail = realpath(dirname(__FILE__).'/../../'.$thumbnailPath);
                        if (is_file($thumbnail)) {
                            $dimensionsArray = getimagesize($thumbnail);
                            $dimensions = $dimensionsArray[3];
                        }
                    }
                    ?>
                    <a href="../../<?= $pdfPath ?>" target="_blank"><img src='../../<?= $thumbnailPath ?>' <?= $dimensions?> style="padding-left:3px; padding-top:10px; padding-bottom:10px;"></a>
                    <?php
				}
			}
        ?>
    </div>
        <?php endif; ?>
    <!-- /Inhaltsblock für PDF-Galerie -->

    </div>

</div>
    <?php
}
	?>
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
