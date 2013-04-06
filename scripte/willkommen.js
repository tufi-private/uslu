// JavaScript Document
	$(document).ready(function(){
		$("#starmenu").fadeIn(5000);
/* fahne austauschen on mouseover */

		$("a#willkommen_de").mouseover(function(){
			$(".willkommen_bild_de").attr({src: "../neu/bilder/flagge_de.png"});
		});
		$("a#willkommen_de").mouseout(function(){
		    $(".willkommen_bild_de").attr({src: "../neu/bilder/flagge_de_70.png"});
		});

		$("a#willkommen_en").mouseover(function(){
			$(".willkommen_bild_en").attr({src: "../neu/bilder/flagge_en.png"});
		});
		$("a#willkommen_en").mouseout(function(){
			$(".willkommen_bild_en").attr({src: "../neu/bilder/flagge_en_70.png"});
		});

		$("a#willkommen_en").click(function(){
			
			alert("Our page in english is coming soon!");	
			
		});
/* /fahne austauschen on mouseover */

	});