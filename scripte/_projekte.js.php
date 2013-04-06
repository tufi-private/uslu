<?php
$serverStage = 'live';
if ($_SERVER['SERVER_NAME'] == 'localhost'){
    $serverStage= 'dev';
}

header('Content-Type: application/javascript');

$config = require '../config/config.php';
require_once '../php_class/DBClient.php';
require_once '../php_class/AssetHandler.php';

$db = new DBClient($config[$serverStage]['database']);
$WEBPATH = $config[$serverStage]['httpd']['path'];

$query = 'SELECT id, customPageBackground FROM content WHERE pageId = 5 AND content NOT LIKE "" ';
$contentPages = $db->getRows($query);

$container = array();
if (false): ?> <script type="text/javascript"><?php endif; ?>
$(document).ready(function(){
	$(".fancybox").fancybox();

	var background;
	background = $('#bg_groundImage').attr('src');

	screenHeight  = window.screen.availHeight;
	screenWidth   = window.screen.availwidth;

//	var siteurl = $('a[name="4"]').attr('name');

// Background Slider -----------------------------------------------
			$.supersized({
				// Functionality
				slideshow				:	1,
				autoplay				:	0,
				start_slide             :   1,
				performance             :   3,
				//slide_interval          :   3000,		// Length between transitions
				transition              :   0, 			// 0-None, 1-Fade, 2-Slide Top, 3-Slide Right, 4-Slide Bottom, 5-Slide Left, 6-Carousel Right, 7-Carousel Left
				transition_speed		:	1000,		// Speed of transition

				// Components
				slide_links				:	'false',	// Individual links for each slide (Options: false, 'num', 'name', 'blank')
                slides: [			// Slideshow Images
                            {image: background}
                            <?php $i=1;?>
                            <?php foreach ($contentPages as $contentPageObj): ?>
                                <?php $container[$contentPageObj->id] = ++$i  ?>
                            ,{image: <?= !empty($contentPageObj->customPageBackground) ? "'/".$WEBPATH."/assets/".$contentPageObj->customPageBackground."'" : "background" ?>}
                            <?php endforeach; ?>
                        ]
			});
// Background Slider -----------------------------------------------/>


/* Cookie anlegen, auslesen, menü positionieren*/

function createCookie(name,value,days) {
	if (days) {
		var date = new Date();
		date.setTime(date.getTime()+(days*24*60*60*1000));
		var expires = "; expires="+date.toGMTString();
	}
	else expires = "";
	document.cookie = name+"="+value+expires+"; path=/";
}

function readCookie(name) {
	var nameEQ = name + "=";
	var ca = document.cookie.split(';');
	for(var i=0;i < ca.length;i++) {
		var c = ca[i];
		while (c.charAt(0)==' ') c = c.substring(1,c.length);
		if (c.indexOf(nameEQ) === 0) return c.substring(nameEQ.length,c.length);
	}
	return null;
}

function eraseCookie(name) {
	createCookie(name,"",-1);
}


var m_cookie = readCookie('m_position')
	if (m_cookie) {
		var felder = m_cookie.split('_');
		//alert("felder: "+felder);
		var menue = new Array(felder);

			for (var i=0; i<felder.length; i++) {
				menue[i] =  felder[i];
				menue[i] =  menue[i].split(':');
			}

				var position_top_u  = menue[0][0];
				var position_u      = menue[0][1];

				var position_top_o  = menue[1][0];
				var position_o      = menue[1][1];

				var position_top_p  = menue[2][0];
				var position_p      = menue[2][1];

				var position_top_ko = menue[3][0];
				var position_ko     = menue[3][1];

				var position_top_i = menue[4][0];
				var position_i     = menue[4][1];

				var position_top_ka = menue[5][0];
				var position_ka     = menue[5][1];

			//	alert(position_top+" _ "+position_u+" _ "+position_o+" _ "+position_p+" _ "+position_ko+" _ "+position_i+" _ "+position_ka);

			$("#m01_unternehmen").hide().css({top: position_top_u+'px', left: position_u+'px'});
			$("#m02_objekte").hide().css({top: position_top_o+'px', left: position_o+'px'});
			$("#m03_projekte").hide().css({top: position_top_p+'px', left: position_p+'px'});
			$("#m04_kontakt").hide().css({top: position_top_ko+'px', left: position_ko+'px'});
			$("#m05_impressum").hide().css({top: position_top_i+'px', left: position_i+'px'});
			$("#m07_karriere").hide().css({top: position_top_ka+'px', left: position_ka+'px'});
			$("#m06_start").hide().css({top: '50px', left: '150px'});

	}


/* Menüpunkte werden an Position bewegt*/
	$("#m01_unternehmen").show().animate({top: "50px", left: "150px"},2000);
	$("#m02_objekte").show().animate({top: "50px", left: "250px"},2000);
	$("#m03_projekte").show().animate({top: "200px", left: "150px"},2000);
	$("#m04_kontakt").show().animate({top: "50px", left: "350px"},2000);
	$("#m05_impressum").show().animate({top: "50px", left: "450px"},2000);
	$("#m07_karriere").show().animate({top: "50px", left: "550px"},2000);
	$("#m06_start").hide().css({top : "50px", left : "150px"});

/* neue menü positionen in Cookie spiechern */
var c_name = "m_position";
var c_wert = "50:150_50:250_200:150_50:350_50:450_50:550_50:150";

createCookie(c_name,c_wert);


/* Objektpunkte ausblenden */
	$("#p_17,#p_18,#p_19,#p_20,#p_21,#p_22,#p_23,#p_24,#p_25,#p_26,#p_27,#p_28,#p_29,#p_30,#p_31").hide().css({top: '0px;', left: '0px;'})



// Impressum Footer -------------------------------------------------
	$("#footer_inhalt").load("../../seiten/de/content.php?table=pages&cnt=content&id=3").html();

	$("a#open").click(
		function(){
			$("div#footer").animate({height:"+=200px"},1000);
			$("a#open>img").hide();
			$("a#close>img").fadeIn();
		})
	$("a#close").click(
		function(){
			$("div#footer").animate({height:"+=-200px"},1000);
			$("a#close>img").hide();
			$("a#open>img").fadeIn();

		})
// Impressum Footer -------------------------------------------------/>

// Objekte -----------------------------------------------------/>
// mauszeiger wird auf pointer gewechselt, wenn man mit dem Maus darauf bewegt wird.
//$("#p_17,#p_18,#p_19,#p_20,#p_21,#p_22,#p_23,#p_24,#p_25,#p_26,#p_27,#p_28,#p_29,#p_30,#p_31").css({cursor:'pointer'});

    var obj= new Object();
<?php
    foreach ($container as $id => $key) {
        echo "obj[\"$id\"] = '$key';\n";
    }
?>
    jQuery('div[id^="container_p"]').first().fadeOut("slow");
    $('div[class^="btn-p_"]').click(function (event) {
        event.preventDefault();
        jQuery('div[id^="container_p"]').hide();
        var id = this.id.split('_')[1];
        jQuery('#container_p' + id).fadeIn("slow");
        var idx = +obj[''+id];
                console.log(id, idx);
                console.log(api.options);
        api.goTo(idx);
    });
});
