<?php

//session_start();
//include default settings for this location
include_once($_SERVER['DOCUMENT_ROOT']."/settings.php");

if(isset($_REQUEST['you_shall_not_pass']) 
	&& $_REQUEST['you_shall_not_pass'] == '44'
	&& $_REQUEST['you_shall_not_pass2'] == '84')
	$_SESSION['db_allow'] = true;


if(isset($_SESSION['db_allow']))
{
	include_once($GLOBALS['includes_root']."/global_applications/adminer.php");
}
else
{
	include_once($GLOBALS['includes_root']."/global_applications/html_page.php");
	app_html_page_header("Not Allowed");
	echo '<h2>Should you be here?</h2>';
	echo '<form  action="" >';
		echo '<input type="password" name="you_shall_not_pass" placeholder="good luck guessing this"/>';
		echo '<input type="password" name="you_shall_not_pass2" placeholder="why are there two?"/>';
		echo '<input type="submit" name="db_submit" value="Good Luck" />';
	echo '</form>';
	echo '<img src="/global_images/gtfo.jpg" />';
	
	//end the html page
	app_html_page_footer();
}


//end the html page
//app_html_page_footer();
