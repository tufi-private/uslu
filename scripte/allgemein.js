// JavaScript Document

$(document).ready(function(){

	screenHeight  = window.screen.availHeight;
	screenWidth   = window.screen.availwidth;

	jQuery(function($){
		$.supersized({
			// Functionality
			slideshow				:	1,
			autoplay				:	0,
			start_slide             :   1,
			//slide_interval          :   3000,		// Length between transitions
			transition              :   6, 			// 0-None, 1-Fade, 2-Slide Top, 3-Slide Right, 4-Slide Bottom, 5-Slide Left, 6-Carousel Right, 7-Carousel Left
			transition_speed		:	1000,		// Speed of transition
																   
			// Components							
			slide_links				:	'false',	// Individual links for each slide (Options: false, 'num', 'name', 'blank')
			slides 					:  	[			// Slideshow Images
										{image : '../../bilder/bild_startseite.jpg'},
										{image : '../../bilder/bild_unternehmen.jpg'},
										{image : '../../bilder/bild_impressum.jpg'}
										]
		});
	});

	$("#m01_unternehmen,#m02_objekte,#m03_projekte,#m04_kontakt,#m05_impressum,#m07_karriere,#m06_start").css({
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
	$("#m05_impressum").animate({
		left: '+=590'
		}, 5000);



});