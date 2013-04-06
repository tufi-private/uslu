// JavaScript Document

$(document).ready(function(){
	screenHeight  = window.screen.availHeight;
	screenWidth   = window.screen.availwidth;

	var background;
	background = $('#bg_groundImage').attr('src');

	var siteurl = $("a[name]").attr('name');

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
	//$.fn.body = api.goTo(1);
	
	$("#m06_start").css({display:"none"});
	$("#m01_unternehmen,#m02_objekte,#m03_projekte,#m04_kontakt,#m05_impressum,#m07_karriere,#m06_start")
				.css({
					top: function() {
			        return (screenHeight*70)/100;
					}
				});
	
	$("#m01_unternehmen").animate({
		left: '+=50'
		}, 5000, function() {    
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
  
  
	$("#m02_objekte").animate({
		left: '+=170'
		}, 5000, function() {  
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
  
	$("#m03_projekte").animate({
		left: '+=290'
		}, 5000, function() {    
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
  
	$("#m04_kontakt").animate({
		left: '+=410'
		}, 5000, function() {   
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
  
	$("#m05_impressum").animate({
		left: '+=530'
		}, 5000, function() {
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
  
	$("#m07_karriere").animate({
		left: '+=650'
		}, 5000, function() {   
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
  
  
  function aniM01_01() {
    $('#m01_unternehmen').stop().animate({boxShadow: '0 0 11px #fff'}, 1000, aniM01_02);
  }
  
  function aniM01_02() {
    $('#m01_unternehmen').stop().animate({boxShadow: '0 0 0px #fff'}, 1000, aniM01_01);
  }
  
  
  function aniM02_01() {
    $('#m02_objekte').stop().animate({boxShadow: '0 0 11px #fff'}, 1000, aniM02_02);
  }
  
  function aniM02_02() {
    $('#m02_objekte').stop().animate({boxShadow: '0 0 0px #fff'}, 1000, aniM02_01);
  }
		
		
	function aniM03_01() {
    $('#m03_projekte').stop().animate({boxShadow: '0 0 11px #fff'}, 1000, aniM03_02);
  }
  
  function aniM03_02() {
    $('#m03_projekte').stop().animate({boxShadow: '0 0 0px #fff'}, 1000, aniM03_01);
  }
  
	
  function aniM04_01() {
    $('#m04_kontakt').stop().animate({boxShadow: '0 0 11px #fff'}, 1000, aniM04_02);
  }
  
  function aniM04_02() {
    $('#m04_kontakt').stop().animate({boxShadow: '0 0 0px #fff'}, 1000, aniM04_01);
  }
  
  
  function aniM05_01() {
    $('#m05_impressum').stop().animate({boxShadow: '0 0 11px #fff'}, 1000, aniM05_02);
  }
  
  function aniM05_02() {
    $('#m05_impressum').stop().animate({boxShadow: '0 0 0px #fff'}, 1000, aniM05_01);
  }
  
  
  function aniM07_01() {
    $('#m07_karriere').stop().animate({boxShadow: '0 0 11px #fff'}, 1000, aniM07_02);
  }
  
  function aniM07_02() {
    $('#m07_karriere').stop().animate({boxShadow: '0 0 0px #fff'}, 1000, aniM07_01);
  }
  
  
  
  
  
  
/* Menüposition in die Datei speichern */
var top_position = (screenHeight*70)/100;

var c_name = "m_position";
var c_wert = top_position+":50_"+top_position+":170_"+top_position+":290_"+top_position+":410_"+top_position+":530_"+top_position+":650";


/* cookie funktionen */
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


createCookie(c_name,c_wert);

});