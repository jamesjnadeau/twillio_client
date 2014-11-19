<?php
session_start();
//Set www_includes directory location
if(php_sapi_name() == 'cli' && empty($_SERVER['REMOTE_ADDR'])) 
	$GLOBALS['includes_root'] = '/var/www/explorevermontfood.com/includes';
else
	$GLOBALS['includes_root'] = $_SERVER['DOCUMENT_ROOT'].'/includes';

include_once($GLOBALS['includes_root']."/global_applications/debug.php");

//global functions
include_once($GLOBALS['includes_root']."/global_applications/global_functions.php");

//if it's a mypoint employee, use our error handler
$old_error_handler = set_error_handler("mypointnow_error_handler");

//setup DB info
$GLOBALS['db_host']		= "localhost";
$GLOBALS['db_user']		= "explorevermont";
$GLOBALS['db_password']	= "x9Z3FztNwajw";
$GLOBALS['db_name']		= "explorevermontfood.com";
$GLOBALS['db_connection'] = mysql_connect($GLOBALS['db_host'], $GLOBALS['db_user'], $GLOBALS['db_password']) or debug_print(mysql_error());
mysql_select_db($GLOBALS['db_name'], $GLOBALS['db_connection']);

//CSS files
$GLOBALS['site_css'] = array( 
	"grid" => array(
		"media" => "all",
		"source" => "/global_css/fluid-grid.css"
	),
	
	"default" => array(
		"media" => "all",
		"source" => "/global_css/default.css"
	),
	
	"ui" => array(
		"media" => "all",
		"source" => "/global_css/ui/smoothness/jquery-ui.css"
	),
	"site" => array(
		"media" => "all",
		"source" => "/site.css"
	),
	"support" => array(
		"media" => "all",
		"source" => "/global_css/applications/support.css"
	),
	
	);


//Javascript files
$GLOBALS['site_js_header'] = array( 
									);
									
$GLOBALS['site_js_footer'] = array( "global" => "/js/global.js", 
									"superfish" => "/global_js/jquery/jquery.superfish.min.js", 
									"hoverIntent" => "/global_js/jquery/jquery.hoverIntent.min.js", 
									#"bgiframe" => "/global_js/jquery/bgiframe.min.js", 
									#"analytics" => "/global_js/applications/analytics-bosch.js"
									);
$GLOBALS['site_js_external'] = array( "jquery" => "//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js",
									  "jquery.ui" => "//ajax.googleapis.com/ajax/libs/jqueryui/1.8.23/jquery-ui.min.js"
									  );
										//"phpdefault" =>"/global_js/php.default.min.js"

$GLOBALS['google_api_key'] = 'AIzaSyB9SqulpFeIvspiIEwVqLYp34Nqwp-wIJ8';

$GLOBALS['footer_output'] = "
<footer id='footer'>
    <p>Made by Byte IT<br /></p>
    <p>Copyright &copy; James Nadeau " . date('Y') . "</p>
</footer>\n\n";


/*
 * jQuery Mobile settings
 */

$GLOBALS['is_mobile'] = true;

$GLOBALS['site_css_mobile']["jquery.mobile.custom"] = array(
		"media" => "all",
		"source" => "/global_js/jquery.mobile/explorevt.css"
	);
$GLOBALS['site_css_mobile']["jquery.mobile"] = array(
			"media" => "all",
			"source" => "/global_js/jquery.mobile/jquery.mobile.structure.css"
		);
$GLOBALS['site_css_mobile']["system"] = array(
			"media" => "all",
			"source" => "/global_js/jquery.mobile/default.css"
		);

$GLOBALS['site_js_external']["jquery"] = "//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js";
$GLOBALS['site_js_external']["jquery.ui"] = "//ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.min.js";
$GLOBALS['site_js_external']["google.maps"] = 'https://maps.googleapis.com/maps/api/js?sensor=false';

$GLOBALS['site_js_header_mobile']['jquery.init.mobile'] = '/global_js/jquery.mobile/init.js';
$GLOBALS['site_js_header_mobile']['jquery.mobile'] = '/global_js/jquery.mobile/jquery.mobile.min.js';

$GLOBALS['site_js_header_mobile']['location'] = '/global_js/location.js';

//these are needed for edit pages:
//$GLOBALS['site_js_header_mobile']['jquery.validate'] = '/global_js/jquery/jquery.validate.js';
//$GLOBALS['site_js_header_mobile']['jquery.validate_init'] = '/global_js/jquery.mobile/validate_init.js';

$GLOBALS['header_output_mobile'] = '
	<div class=" ui-grid-b" >
		<div class="ui-block-a">
			<a href="/" id="panel_left_button" data-role="button" data-icon="home" data-iconpos="left"
				data-iconshadow="false"  data-corners="false" data-theme="c"
				class="ui-icon-nodisc left ui-icon-alt header_button" >Home</a>
		</div>
		<div class="ui-block-b text-center">
			<img src="/images/logo.jpg" style="max-height: 40px; margin: 5px;" alt="Explore VT Food" id="nav_logo" />
		</div>
		<div class="ui-block-c" >
			<a href="#panel_left" id="panel_left_button" data-role="button" data-icon="bars" data-iconpos="right"
				data-iconshadow="false"  data-corners="false" data-theme="b"
				class="ui-icon-nodisc right header_button" >Menu</a>
			<a href="/all_options.php" id="panel_left_button" data-role="button" data-icon="bars" data-iconpos="right"
				data-iconshadow="false"  data-corners="false" data-theme="a"
				class="ui-icon-nodisc right header_button" >Options</a>
			
		</div>
	</div>
';

$GLOBALS['footer_output_mobile'] = '
<p class="text-center quiet" >Made by and <br />
Copyright &copy; <a href="http://www.jamesjnadeau.com/" >James J Nadeau</a> '.date('Y').'</p>

'.<<<END
<!-- Google Analytics -->
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
  
  ga('create', 'UA-43523405-1', 'explorevermontfood.com');
  ga('send', 'pageview');
  
  function ga_roam_track_page()
  {
    ga('send', 'pageview');
    console.log('ga pageview tracked');
  }
  
  $(document).on('pageshow', function ()
  {
    ga_roam_track_page();
  });
  
</script>
END;

$GLOBALS['panel_right_mobile']['panel_right'] = '
<a href="/" ><img src="/images/logo.jpg" style="max-width: 90%; margin: 5px;" alt="Explore VT Food" id="menu_logo" /></a>
<ul class="" data-role="listview" data-theme="a" data-inset="true" data-corners="false"  >
		<!-- <li class=""><a href="/all_options.php">All Options</a></li> -->
		<li data-iconshadow="false" ><a href="/?location_current=44.4758%2C-73.2125">Burlington</a></li>
		<li data-iconshadow="false" ><a href="/?location_current=43.623570%2C-72.517303">Woodstock</a></li>
		<li data-iconshadow="false" ><a href="/?location_current=44.2600%2C-72.5758">Montpelier</a></li>
		<li data-iconshadow="false" ><a href="/?location_current=44.0153%2C-73.1678">Middlebury</a></li>
		<li data-iconshadow="false" ><a href="/?location_current=42.8783%2C-73.1906">Bennington</a></li>
		<li data-iconshadow="false" ><a href="/?location_current=42.8508%2C-72.5583">Brattleboro</a></li>
		<li data-iconshadow="false" ><a href="/?location_current=43.5359%2C-72.7215">Plymouth</a></li>
		<li data-iconshadow="false" ><a href="/?location_current=44.8099%2C-73.0845">St Albans</a></li>
		<li data-iconshadow="false" ><a href="/sources.php">Data Sources</a></li>
	</ul>
';
