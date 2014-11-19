<?php


function app_html_page_header($title)
{

$GLOBALS['site_css']['animate'] = array('media' => 'all', 'source' => '/css/animate.css');
//metrics by james
//system_log_metric(array('start' => microtime(true)), 'html_page_load_time');

global $keywords, $description, $author;

echo "<!doctype html>
<!--[if lt IE 7]> <html class='no-js ie6 oldie' lang='en'> <![endif]-->
<!--[if IE 7]>    <html class='no-js ie7 oldie' lang='en'> <![endif]-->
<!--[if IE 8]>    <html class='no-js ie8 oldie' lang='en'> <![endif]-->
<!--[if gt IE 8]><!--> <html class='no-js' lang='en'> <!--<![endif]-->
<head>
    
	<meta charset='utf-8'>
    
	<meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1'>
    
	<title>$title</title>";
    
	if(isset($description))
	echo "<meta name='description' content='$description'>";

	if(isset($author)) 
	echo "<meta name='author' content='$author'>";
	
	if(isset($keywords))
	echo "<meta name='keywords'content='$keywords'>";
	
	/*
	if(is_mobile())
		echo "<meta name='viewport' content='width=device-width, user-scalable=no, initial-scale=1, maximum-scale=1'>";
	else
		echo "<meta name='viewport' content='width=device-width, user-scalable=no, initial-scale=1'>";
	
	echo "<meta name='HandheldFriendly' content='True' />
	<meta name='apple-mobile-web-app-capable' content='yes' />
	<link type='text/plain' rel='author' href='/humans.txt' />
	<link rel='shortcut icon' href='/favicon.ico'>
	<link rel='apple-touch-icon' href='/apple-touch-icon.png'>
	";
	*/
	//echo "<script src='//ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js'></script><script src='/global_js/jquery/jquery.ui.min.js'></script>";
	//<link rel=\"stylesheet\" href=\"http://code.jquery.com/ui/1.8.18/themes/base/jquery-ui.css\" type=\"text/css\" media=\"all\" />
	//<link rel=\"stylesheet\" href=\"http://static.jquery.com/ui/css/demo-docs-theme/ui.theme.css\" type=\"text/css\" media=\"all\" />
	
	app_html_page_js('header');
	
	app_html_page_css();

	$classes = '';
	
	echo '</head>';
	echo '<body class="'.$classes.'">';
	echo '<div id="wrapper">';
	echo '<div class="container">';
}

function app_html_page_css()
{
	//cases for different css files
	//step through global css array
	foreach($GLOBALS['site_css'] as $key => $value)
	{
		
		//check to see if the file exists
		if(file_exists($_SERVER['DOCUMENT_ROOT'] . $value['source'] ))
		{
			//it exists, link to it
			echo "<link rel='stylesheet' href='" . $value['source'] . "' media='" . $value['media'] . "' type='text/css' />";
		}
		
	}
	/*
	if($GLOBALS['site_id'] == NULL)
	{
		if (is_tablet())
			echo "<link rel='stylesheet' href='/global_css/tablet.css' type='text/css' />";
		elseif (is_mobile())
			echo "<link rel='stylesheet' href='/global_css/mobile.css' type='text/css' />";
	}*/
	
	//custom css included from scripts run directory
	//check to see if the file exists
	if(file_exists($_SERVER['DOCUMENT_ROOT']."/css/site.css") && !isset($GLOBALS['no_site_css_file']))
	{
		echo "<link rel='stylesheet' href='/css/site.css' type='text/css' />";
	}

}

function app_html_page_js( $location )
{
	
	switch($location) {
	
		case "header":
			
			/**
			 * Loop through external JS files first, since this
			 * contains jQuery, which other files will rely upon
			 */
			if(is_array($GLOBALS['site_js_external']))
			{
				foreach($GLOBALS['site_js_external'] as $value) 
				{
					echo "<script src='$value'></script>\r\n";
				}
			}
			
			/**
			 * For the most part the only JS output
			 * here is Modernizr, but if needed, just add an
			 * additional key to the $GLOBALS['site_js_header'] array
			 */
			
			foreach($GLOBALS['site_js_header'] as $value)
			{
				/* Only output script if the file exists on the server */
				if(file_exists($_SERVER['DOCUMENT_ROOT']."$value"))
				{
					echo "<script src='$value'></script>\r\n";
				}
				else
					debug('file not found '.$value);
				
			}
			
			
			break;
			
			
		case "footer":
			
			
			/**
			 * Now loop through our local JS files
			 */
			 
			foreach($GLOBALS['site_js_footer'] as $value)
			{
				/* Only output script if the file exists on the server */
				if(file_exists($_SERVER['DOCUMENT_ROOT']."$value"))
				{
					echo "<script src='$value'></script>";
				}
				else
					debug('file not found '.$value);
				
			}
			
			
			break;
	
		default:
			break;
					
	}
	
}


function app_html_page_footer($show_support = true)
{

	/**
	 * HTML markup for the footer
	 */
	
	if(isset($GLOBALS['footer_output']))
		echo $GLOBALS['footer_output'];
	/**
	 * Close the .container
	 */
	echo '</div>';
	
	/**
	 * Output of JS comes after everything else 
	 */

	app_html_page_js('footer');
	
	//if(is_mypoint_employee() && !is_mobile())
	{
		//echo "<script src='/support/debug.php'></script>";
		include($_SERVER['DOCUMENT_ROOT'].'/support/debug.php');
	}
	//else
		//unset($_SESSION['debug']);
	
	echo "</div>";
	echo "</body>";
	echo "</html>";
	
	//system_log_metric(array('end' => microtime(true)), 'html_page_load_time');
	//system_log_save_metrics();
}

/*
 * outputs an html table
 * 
 * 
 * $values = array(['values key'] => $values)
 * $header_order = array('#' => 'values key');
 * $header_names = array('#' => 'display name');
 */

function html_table($values, $header_order = NULL, $header_names = NULL, $use_datatables = true, $table_layout = 'fixed')
{
	if($values && is_array($values))
	{
		if($header_order == NULL)
		{// set up defaults
			$header_names = $header_order = array_keys($values[0]);
		}
		
		if($use_datatables)
		{
			$GLOBALS['site_js_footer']['jquery.dataTables.min.js'] = '/global_js/jquery/jquery.dataTables.min.js';
			echo '<table class="dataTable" style=" word-wrap:break-word; table-layout:'.$table_layout.'" width="100%" cellpadding="0" cellspacing="0" border="0" >';
		}
		else
			echo '<table class="" style=" word-wrap:break-word; table-layout:'.$table_layout.'" width="100%" cellpadding="0" cellspacing="0" border="0" >';
			
		echo '<thead><tr>';
		for($i = 0; $i < count($header_names); $i++)
		{// display headers
			echo '<th class="table_column_'.$i.'" >'.$header_names[$i].'</th>';
		}
		echo '</tr></thead>';
		
		
		echo '<tdata>';
			foreach($values as $value)
			{//display values
				echo '<tr>';
				for($i = 0; $i < count($header_order); $i++)
				{
					echo '<td>'.$value[$header_order[$i]].'</td>';
				}
				echo '</tr>';
			}
		echo '</tdata>';
		echo '</table>';
	}
}

