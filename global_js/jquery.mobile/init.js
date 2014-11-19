$(document).bind("mobileinit", function() {
	$.mobile.defaultPageTransition = 'none';
	$.mobile.loader.prototype.options.text = 'Loading...';
	$.mobile.loader.prototype.options.textVisible = true;
	//$.mobile.page.prototype.options.domCache = true;
});


function open_menu(panel_selector)
{
	try
	{
		if ($(window).width() >= 880) 
		{
			$.mobile.activePage.find(panel_selector).panel( "open");
			$.mobile.activePage.find('#nav_logo').hide();
			$.mobile.activePage.find('#menu_logo').show();
		}
		else  
		{
			$(panel_selector).panel( "option", "animate", true );
			$.mobile.activePage.find(panel_selector).panel( "close" );
			$.mobile.activePage.find('#nav_logo').show();
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
main_panel_selector = '#panel_right'
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
	setTimeout(window.location.reload(true), 3000);
});

$(document).on( "pageloadfailed", function( event ) 
{
	console.log('pageloadfailed, reloading page');
	setTimeout(window.location.reload(true), 3000);
});

/*
 * Page events
 */
//$.mobile.activePage.attr('id')
/*
$(document).live("pageload", function() {console.log('pageload');});
$(document).live("pagebeforechange", function() {console.log('pagebeforechange');});
$(document).live("pagebeforecreate", function() {console.log('pagebeforecreate');});
$(document).live("pagecreate", function() {console.log('pagecreate');});
$(document).live("pageinit", function() {console.log('pageinit');});
$(document).live("pagebeforeshow", function() {console.log('pagebeforeshow');});
$(document).live("pageshow", function() {console.log('pageshow');});
$(document).live("pagechange", function() {console.log('pagechange');});
$(document).live("pagebeforehide", function() {console.log('pagebeforehide');});
*/


