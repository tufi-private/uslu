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
		}, 5000);
	$("#m02_objekte").animate({
		left: '+=160'
		}, 5000);
	$("#m03_projekte").animate({
		left: '+=270'
		}, 5000);
	$("#m04_kontakt").animate({
		left: '+=380'
		}, 5000);
	$("#m05_impressum").animate({
		left: '+=490'
		}, 5000);
	$("#m07_karriere").animate({
		left: '+=590'
		}, 5000);

/* Menüposition in die Datei speichern */
var top_position = (screenHeight*70)/100;

var c_name = "m_position";
var c_wert = top_position+":50_"+top_position+":160_"+top_position+":270_"+top_position+":380_"+top_position+":490_"+top_position+":590";


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