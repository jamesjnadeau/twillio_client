<?php

//include default settings for this location
include_once($_SERVER['DOCUMENT_ROOT']."/settings.php");


//start displaying an html page
include_once($GLOBALS['includes_root']."/global_applications/html_page.php");
app_html_page_header_mobile("Explore all the Great Food VT has to offer");

ob_start();

	include_once($GLOBALS['includes_root']."/global_applications/location_search.php");
	location_search();
	
jqm_page('index', ob_get_clean(), array('data-cache="false"'));

//end the html page
app_html_page_footer();
