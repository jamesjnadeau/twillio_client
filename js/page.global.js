$(document).ready(function() {

	//$("html.js body").fadeIn('slow');
	
	$("a").each(function() {
		$(this).addClass("pagelink");
	});
	
	$(window).unload( function () { 
	    $("html.js body").fadeOut('slow');
	} );
	
	// Reset page scroll
	$.scrollTo( 0 );

});
