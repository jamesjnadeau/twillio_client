$(document).bind("mobileinit", function() {
	$.mobile.defaultPageTransition = 'slidefade';
	//$.mobile.page.prototype.options.addBackBtn = true;
	$.mobile.page.prototype.options.backBtnTheme = 'a';
});


function open_menu(panel_selector)
{
	try
	{
		if ($(window).width() >= 880) 
		{
			$.mobile.activePage.find(panel_selector).panel( "open");
		}
		else  
		{
			$(panel_selector).panel( "option", "animate", true );
			$.mobile.activePage.find(panel_selector).panel( "close" );
		}
	}
	catch(error)
	{
		//console.log('cannot find panel');
	}
}

$(window).resize(function() 
{
	open_menu('#panel_left');
});

auto_open_menu = true;
main_panel_selector = '#panel_left'
$(document).live("pageshow.init", function() 
{
	
	if(auto_open_menu)
	{
		open_menu(main_panel_selector);
	}
	
	try
	{
		$( ".panel_right_mobile" ).on( "panelclose", 
			function( event, ui ) 
			{
				open_menu(main_panel_selector);
			} 
		);
	}
	catch(error)
	{
		//console.log('cannot find panel');
	}
});

$(document).on( "pagechangefailed", function( event ) 
{
	console.log('pagechangefailed, reloading page');
	window.location.reload(true)
});

$(document).on( "pageloadfailed", function( event ) 
{
	console.log('pageloadfailed, reloading page');
	window.location.reload(true)
});
