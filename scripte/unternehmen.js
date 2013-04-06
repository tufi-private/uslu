// JavaScript Document

$(document).ready(function(){

	
	var background;
	background = $('#bg_groundImage').attr('src');

	screenHeight  = window.screen.availHeight;
	screenWidth   = window.screen.availwidth;

	var siteurl = $('a[name="2"]').attr('name');

// Background Slider -----------------------------------------------
			$.supersized({
				// Functionality
				slideshow				:	0,
				autoplay				:	0,
				start_slide             :   siteurl,
				performance             :   3,
				//slide_interval          :   3000,		// Length between transitions
				transition              :   6, 			// 0-None, 1-Fade, 2-Slide Top, 3-Slide Right, 4-Slide Bottom, 5-Slide Left, 6-Carousel Right, 7-Carousel Left
				transition_speed		:	1000,		// Speed of transition
																	   
				// Components							
				slide_links				:	'false',	// Individual links for each slide (Options: false, 'num', 'name', 'blank')
				slides 					:  	[			// Slideshow Images
											{image : background},
											{image : background},
											{image : background},
											{image : background},
											{image : background},
											{image : background},
											{image : background}
											]
			});
	//$.fn.body = api.goTo(2);

// Background Slider -----------------------------------------------/>

// Unternehmen -----------------------------------------------------

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

				var position_top = menue[0][0];
				//alert("position_top: "+position_top);
				var position_u   = menue[0][1];
				//alert("position_u: "+position_u);
				var position_o   = menue[1][1];
				var position_p   = menue[2][1];
				var position_ko  = menue[3][1];
				var position_i   = menue[4][1];
				var position_ka  = menue[5][1];

			//	alert(position_top+" _ "+position_u+" _ "+position_o+" _ "+position_p+" _ "+position_ko+" _ "+position_i+" _ "+position_ka);

			$("#m01_unternehmen").hide().css({top: position_top+'px', left: position_u+'px'});
			$("#m02_objekte").hide().css({top: position_top+'px', left: position_o+'px'});
			$("#m03_projekte").hide().css({top: position_top+'px', left: position_p+'px'});
			$("#m04_kontakt").hide().css({top: position_top+'px', left: position_ko+'px'});
			$("#m05_impressum").hide().css({top: position_top+'px', left: position_i+'px'});
			$("#m07_karriere").hide().css({top: position_top+'px', left: position_ka+'px'});
			$("#m06_start").hide().css({top: '220px', left: '160px'});

	}


	
		
/* Menüpunkte werden an Position bewegt*/
	$("#m01_unternehmen").show().animate({top: "240px", left: "160px"},2000, function() {    
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
  
	$("#m02_objekte").show().animate({top: "20px", left: "160px"},2000, function() {  
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
  
	$("#m03_projekte").show().animate({top: "20px", left: "270px"},2000, function() {    
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
  
	$("#m04_kontakt").show().animate({top: "130px", left: "160px"},2000, function() {   
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
  
	$("#m05_impressum").show().animate({top: "130px", left: "270px"},2000, function() {
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
  
	$("#m07_karriere").show().animate({top: "240px", left: "270px"},2000, function() {   
      
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
  
	$("#m06_start").hide().css({top: "220px", left: "160px"},2000);
	
  function aniM01_01() {
    $('#m01_unternehmen').stop().animate({boxShadow: '0 0 35px #fff'}, 1000, aniM01_02);
  }
  
  function aniM01_02() {
    $('#m01_unternehmen').stop().animate({boxShadow: '0 0 0px #fff'}, 1500, aniM01_01);
  }  

/* neue menü positionen in Cookie spiechern */
var c_name = "m_position";
var c_wert = "220:160_240:270_20:160_20:270_130:160_130:270_240:160";
/* start_karriere_objekte_projekte_kontakt_impressum_unternehmen */

createCookie(c_name,c_wert);


/* inhaltsblock definieren und mit inhalt befüllen*/
	$("#u_inhalt").animate({top:"+=20px", left:"+=390px"},1000).fadeIn(1000).load("../../seiten/de/content.php?table=pages&cnt=content&id=2").html();
	$("<img src='../../bilder/themenbild_munster_transparent.png' width='188' height='344' border='0' style='display:none;'>")
	.appendTo("#u_themenbild")
	.css({"padding-top":"360px","padding-left":"160px"})
	.animate({top:"+=360px", left:"+=160px"},1000)
	.fadeIn(1000);
	
/*
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
*/

});
