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

$query = 'SELECT id, customPageBackground FROM content WHERE pageId = 4 AND content NOT LIKE "" ';
$contentPages = $db->getRows($query);

//print_r($contentPages);
//include_once 'objekte.js';
$container = array();
if (false): ?> <script type="text/javascript"><?php endif; ?>
$(document).ready(function () {
    $(".fancybox").fancybox();

    var background;
    background = $('#bg_groundImage').attr('src');

    screenHeight = window.screen.availHeight;
    screenWidth = window.screen.availwidth;

    var siteurl = $('a[name="3"]').attr('name');

// Background Slider -----------------------------------------------
    $.supersized({
        // Functionality
        slideshow: 1,
        autoplay: 0,
        start_slide: 1,
        performance: 3,
        //slide_interval          :   3000,		// Length between transitions
        transition: 0, 			// 0-None, 1-Fade, 2-Slide Top, 3-Slide Right, 4-Slide Bottom, 5-Slide Left, 6-Carousel Right, 7-Carousel Left
        transition_speed: 1000,		// Speed of transition

        // Components
        slide_links: 'false',	// Individual links for each slide (Options: false, 'num', 'name', 'blank')
        slides: [			// Slideshow Images
            {image: background}
            <?php $i=1;?>
            <?php foreach ($contentPages as $contentPageObj): ?>
                <?php $container[$contentPageObj->id] = ++$i  ?>
            ,{image: <?= !empty($contentPageObj->customPageBackground) ? "'/".$WEBPATH."/assets/".$contentPageObj->customPageBackground."'" : "background" ?>}
            <?php endforeach; ?>
        ]
    });
    //$.fn.body = api.goTo(6);

// Background Slider -----------------------------------------------/>


    /* Cookie anlegen, auslesen, menü positionieren*/

    function createCookie(name, value, days) {
        if (days) {
            var date = new Date();
            date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
            var expires = "; expires=" + date.toGMTString();
        }
        else expires = "";
        document.cookie = name + "=" + value + expires + "; path=/";
    }

    function readCookie(name) {
        var nameEQ = name + "=";
        var ca = document.cookie.split(';');
        for (var i = 0; i < ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ') c = c.substring(1, c.length);
            if (c.indexOf(nameEQ) === 0) return c.substring(nameEQ.length, c.length);
        }
        return null;
    }

    function eraseCookie(name) {
        createCookie(name, "", -1);
    }


    var m_cookie = readCookie('m_position')
    if (m_cookie) {
        var felder = m_cookie.split('_');
        //alert("felder: "+felder);
        var menue = new Array(felder);

        for (var i = 0; i < felder.length; i++) {
            menue[i] = felder[i];
            menue[i] = menue[i].split(':');
        }

        var position_top_u = menue[0][0];
        var position_u = menue[0][1];

        var position_top_o = menue[1][0];
        var position_o = menue[1][1];

        var position_top_p = menue[2][0];
        var position_p = menue[2][1];

        var position_top_ko = menue[3][0];
        var position_ko = menue[3][1];

        var position_top_i = menue[4][0];
        var position_i = menue[4][1];

        var position_top_ka = menue[5][0];
        var position_ka = menue[5][1];

        //	alert(position_top+" _ "+position_u+" _ "+position_o+" _ "+position_p+" _ "+position_ko+" _ "+position_i+" _ "+position_ka);

        $("#m01_unternehmen").hide().css({top: position_top_u + 'px', left: position_u + 'px'});
        $("#m02_objekte").hide().css({top: position_top_o + 'px', left: position_o + 'px'});
        $("#m03_projekte").hide().css({top: position_top_p + 'px', left: position_p + 'px'});
        $("#m04_kontakt").hide().css({top: position_top_ko + 'px', left: position_ko + 'px'});
        $("#m05_impressum").hide().css({top: position_top_i + 'px', left: position_i + 'px'});
        $("#m07_karriere").hide().css({top: position_top_ka + 'px', left: position_ka + 'px'});
        $("#m06_start").hide().css({top: '50px', left: '150px'});

    }



/* Menüpunkte werden an Position bewegt*/
	$("#m01_unternehmen").show().animate({top: "50px", left: "150px"},2000, function() {    
		  $('#m01_unternehmen').stop().animate({boxShadow: '0 0 25px #ffffff'});
	  
      $('#m01_unternehmen').mouseover(function() {  
        $('#m01_unternehmen').stop().animate({boxShadow: '0 0 0px #ffffff'});
      });
      $('#m01_unternehmen').mouseout(function() {  
        $('#m01_unternehmen').stop().animate({boxShadow: '0 0 25px #ffffff'});
      });
  });
  $("#m01_unternehmen").click(function() {  
    location.href="unternehmen.php";
  });
  
	$("#m02_objekte").show().animate({top: "180px", left: "150px"},2000, function() {  
      $('#m02_objekte').stop().animate({boxShadow: '0 0 25px #ffffff'});
        
      $('#m02_objekte').mouseover(function() {  
        $('#m02_objekte').stop().animate({boxShadow: '0 0 0px #ffffff'});
      });
      $('#m02_objekte').mouseout(function() {  
        $('#m02_objekte').stop().animate({boxShadow: '0 0 25px #ffffff'});
      });
  });
  $("#m02_objekte").click(function() {  
    location.href="objekte.php";
  });
  
	$("#m03_projekte").show().animate({top: "50px", left: "260px"},2000, function() {    
		  $('#m03_projekte').stop().animate({boxShadow: '0 0 25px #ffffff'});
		  
      $('#m03_projekte').mouseover(function() {  
        $('#m03_projekte').stop().animate({boxShadow: '0 0 0px #ffffff'});
      });
      $('#m03_projekte').mouseout(function() {  
        $('#m03_projekte').stop().animate({boxShadow: '0 0 25px #ffffff'});
      });
  });
  $("#m03_projekte").click(function() {  
    location.href="projekte.php";
  });
  
	$("#m04_kontakt").show().animate({top: "50px", left: "370px"},2000, function() {   
      $('#m04_kontakt').stop().animate({boxShadow: '0 0 25px #ffffff'});
       
      $('#m04_kontakt').mouseover(function() {  
        $('#m04_kontakt').stop().animate({boxShadow: '0 0 0px #ffffff'});
      });
      $('#m04_kontakt').mouseout(function() {  
        $('#m04_kontakt').stop().animate({boxShadow: '0 0 25px #ffffff'});
      });
  });
  $("#m04_kontakt").click(function() {  
    location.href="kontakt.php";
  });
  
	$("#m05_impressum").show().animate({top: "50px", left: "480px"},2000, function() {
      $('#m05_impressum').stop().animate({boxShadow: '0 0 25px #ffffff'});
          
      $('#m05_impressum').mouseover(function() {  
        $('#m05_impressum').stop().animate({boxShadow: '0 0 0px #ffffff'});
      });
      $('#m05_impressum').mouseout(function() {  
        $('#m05_impressum').stop().animate({boxShadow: '0 0 25px #ffffff'});
      });
  });
  $("#m05_impressum").click(function() {  
    location.href="impressum.php";
  });
  
	$("#m07_karriere").show().animate({top: "50px", left: "590px"},2000, function() {   
      
      $('#m07_karriere').stop().animate({boxShadow: '0 0 25px #ffffff'});
       
      $('#m07_karriere').mouseover(function() {  
        $('#m07_karriere').stop().animate({boxShadow: '0 0 0px #ffffff'});
      });
      $('#m07_karriere').mouseout(function() {  
        $('#m07_karriere').stop().animate({boxShadow: '0 0 25px #ffffff'});
      });
  });
  $("#m07_karriere").click(function() {  
    location.href="karriere.php";
  });
  
  
      
		  $('#o_1').stop().animate({boxShadow: '0 0 25px #ffffff'});
	  
      $('#o_1').mouseover(function() {  
        $('#o_1').stop().animate({boxShadow: '0 0 0px #ffffff'});
      });
      $('#o_1').mouseout(function() {  
        $('#o_1').stop().animate({boxShadow: '0 0 25px #ffffff'});
      });
      
      $('#o_2').stop().animate({boxShadow: '0 0 25px #ffffff'});
	  
      $('#o_2').mouseover(function() {  
        $('#o_2').stop().animate({boxShadow: '0 0 0px #ffffff'});
      });
      $('#o_2').mouseout(function() {  
        $('#o_2').stop().animate({boxShadow: '0 0 25px #ffffff'});
      });
      
      $('#o_4').stop().animate({boxShadow: '0 0 25px #ffffff'});
	  
      $('#o_4').mouseover(function() {  
        $('#o_4').stop().animate({boxShadow: '0 0 0px #ffffff'});
      });
      $('#o_4').mouseout(function() {  
        $('#o_4').stop().animate({boxShadow: '0 0 25px #ffffff'});
      });
  
  
  
	$("#m06_start").hide().css({top : "50px", left : "150px"});



/* neue menü positionen in Cookie spiechern */
var c_name = "m_position";
var c_wert = "50:150_180:150_50:260_50:370_50:480_50:590_50:150";
/*Reihenfolge u_o_p_k_i_k_s */

    createCookie(c_name, c_wert);


    /* Objektpunkte ausblenden */
    $("#o_1,#o_2,#o_3,#o_4,#o_6,#o_7,#o_8,#o_9,#o_10,#o_11,#o_12,#o_13,#o_14,#o_15,#o_16").hide().css({top: '0px;', left: '0px;'})


// Impressum Footer -------------------------------------------------
    $("#footer_inhalt").load("../../seiten/de/content.php?table=pages&cnt=content&id=3").html();

    $("a#open").click(
        function () {
            $("div#footer").animate({height: "+=200px"}, 1000);
            $("a#open>img").hide();
            $("a#close>img").fadeIn();
        })
    $("a#close").click(
        function () {
            $("div#footer").animate({height: "+=-200px"}, 1000);
            $("a#close>img").hide();
            $("a#open>img").fadeIn();

        })
// Impressum Footer -------------------------------------------------/>

// Objekte -----------------------------------------------------/>
// mauszeiger wird auf pointer gewechselt, wenn man mit dem Maus darauf bewegt wird.
//    $("#o_1,#o_2,#o_3,#o_4,#o_6,#o_7,#o_8,#o_9,#o_10,#o_11,#o_12,#o_13,#o_14,#o_15,#o_16").css({cursor: 'pointer'});

    var obj= new Object();
<?php
    foreach ($container as $id => $key) {
        echo "obj[\"$id\"] = '$key';\n";
    }
?>
    jQuery('div[id^="container_o"]').first().fadeOut("slow");
    $('div[class^="btn-o_"]').click(function (event) {
            event.preventDefault();
            jQuery('div[id^="container_o"]').hide();
            var id = this.id.split('_')[1];
            jQuery('#container_o' + id).fadeIn("slow");
            var idx = +obj[''+id];
            api.goTo(idx);
    });
});