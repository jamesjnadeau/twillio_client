<?php

//include default settings for this location
include_once($_SERVER['DOCUMENT_ROOT']."/settings.php");


//start displaying an html page
include_once($GLOBALS['includes_root']."/global_applications/html_page.php");
app_html_page_header("Welcome");


//start displaying an html page
include_once($GLOBALS['includes_root']."/global_applications/html_page.php");

ob_start();
	include_once($GLOBALS['includes_root']."/global_applications/options.php");
	options($_REQUEST['option_id']);
$output = ob_get_clean();

app_html_page_header_mobile($GLOBALS['title']);

jqm_page('options_'.$_REQUEST['option_id'], $output, array("data-cache='false'"));

//end the html page
app_html_page_footer_mobile();
