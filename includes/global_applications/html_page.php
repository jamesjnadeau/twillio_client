<?php


function app_html_page_header($title)
{

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
	
	if($GLOBALS['site_id'] == NULL
		&& is_mobile())
		echo "<meta name='viewport' content='width=device-width, initial-scale=1, user-scalable=no' >";
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
	
	if (is_tablet())
		$classes = 'tablet';
	elseif (is_mobile())
		$classes = 'mobile';
	else
		$classes = '';
	
	echo '<link type="text/plain" rel="author" href="/humans.txt" />';
	
	echo '</head>';
	echo '<body class="'.$classes.'">';
	echo  '<!--[if lte IE 7]>';
	echo '<div style="border: 1px solid #F7941D; background: #FEEFDA; text-align: center; clear: both; height: 75px; position: relative;">   <div style="width: 640px; margin: 0 auto; text-align: left; padding: 0; overflow: hidden; color: black;">      <div style="width: 75px; float: left;"><img src="/global_images/ie6nomore-warning.jpg" alt="Warning!"/></div>      <div style="width: 275px; float: left; font-family: Arial, sans-serif;">        <div style="font-size: 14px; font-weight: bold; margin-top: 12px;">You are using an outdated browser</div>        <div style="font-size: 12px; margin-top: 6px; line-height: 12px;">For a better experience using this site, please upgrade to a modern web browser.</div>      </div>      <div style="width: 75px; float: left;"><a href="http://www.firefox.com" target="_blank"><img src="/global_images/ff.png" style="border: none;" alt="Get Firefox 6"/></a></div>      <div style="width: 75px; float: left;"><a href="http://www.browserforthebetter.com/download.html" target="_blank"><img src="/global_images/ie.png" style="border: none;" alt="Get Internet Explorer "/></a></div>           <div style="float: left;"><a href="http://www.google.com/chrome" target="_blank"><img src="/global_images/chrome.png" style="border: none;" alt="Get Google Chrome"/></a></div>    </div>  </div>';
	echo '<![endif]-->';
	echo '<div id="wrapper">';
	echo '<div class="container">';
}

function app_html_page_header_mobile($title)
{
	
	global $keywords, $description, $author;
echo "<!doctype html>
<head>
	
	<meta charset='utf-8'>
	
	<meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1'>
	
	<link rel='author' href='https://plus.google.com/107468556120112635472?rel=author'/>
	
	<title>$title</title>";
	echo '<link rel="shortcut icon" href="/sites/drupal.mypointnow.com/files/mypointnow_favicon.png" type="image/x-icon" />';
	echo "<meta name='viewport' content='width=device-width, initial-scale=1, user-scalable=no' >";
	
	app_html_page_js('header_mobile');
	//app_html_page_basket_js();
	
	app_html_page_css();
	
	$classes = 'mobile';
	
	echo '<link type="text/plain" rel="author" href="/humans.txt" />';
	echo '</head>';
	echo '<body class="'.$classes.'">';
}

function app_html_page_basket_js()
{
	echo "<script type='text/javascript' src='/global_js/basket.full.min.js' ></script>";
	if(is_array($GLOBALS['site_js_external']))
	{
		foreach($GLOBALS['site_js_external'] as $value) 
		{
			echo "<script src='$value'></script>\r\n";
		}
	}
	if(!is_mobile())
	{
		echo '<!--[if lt IE 9 ]>
			<script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
			<script>window.attachEvent(\'onload\',function(){CFInstall.check({mode:\'overlay\'})})</script>
			<script src="/global_js/applications/ie6bar.js"></script>
		<![endif]--> ';
	}
	
	echo '<script>';
		echo 'try
			{';
				echo 'basket.require('."\r\n";
					$require = '';
					foreach($GLOBALS['site_js_header_mobile'] as $key=>$value)
					{
						$require .= '{ url: "'.$value.'", key: "'.$key.'", expire: 72, unique: "'.$GLOBALS['site_js_version'].'" }, ';
					}
					echo rtrim($require, ', ').');';
		echo '}
			catch(err) { location.reload(true); }';
	echo '</script>';
	echo "\r\n";
}

function app_html_page_css()
{
	if(isset($GLOBALS['is_mobile']))
	{
		//check for mobile styles
		foreach($GLOBALS['site_css_mobile'] as $key => $value)
		{
			
			//check to see if the file exists
			if(file_exists($_SERVER['DOCUMENT_ROOT'] . $value['source'] ))
			{
				//it exists, link to it
				echo "<link rel='stylesheet' href='" . $value['source'] . "' media='" . $value['media'] . "' type='text/css' />";
			}
			
		}
	}
	else
	{
		foreach($GLOBALS['site_css'] as $key => $value)
		{
			
			//check to see if the file exists
			if(file_exists($_SERVER['DOCUMENT_ROOT'] . $value['source'] ))
			{
				//it exists, link to it
				echo "<link rel='stylesheet' href='" . $value['source'] . "' media='" . $value['media'] . "' type='text/css' />";
			}
			
		}
		if(($GLOBALS['site_id'] == NULL && !isset($GLOBALS['service'])))
		{
			if (is_tablet())
				echo "<link rel='stylesheet' href='/global_css/tablet.css' type='text/css' />";
			//elseif (is_mobile())
				//echo "<link rel='stylesheet' href='/global_css/mobile.css' type='text/css' />";
		}
		
		//custom css included from scripts run directory
		//check to see if the file exists
		if(file_exists($_SERVER['DOCUMENT_ROOT']."/css/site.css") && !isset($GLOBALS['no_site_css_file']))
		{
			echo "<link rel='stylesheet' href='/css/site.css' type='text/css' />";
		}
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
		case "header_mobile":
			
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
			
			if(isset($_SESSION['mobile_disable_ajax']))
			{
				echo '<script type="text/javascript">'
					.'$(document).bind("mobileinit", function () {'
						.'$.mobile.ajaxEnabled = false;'
						.'console.log("disableing jquery mobile ajax requests");'
					.'});'
				.'</script>';
			}
			
			/**
			 * Prompt IE 6 users to install Chrome Frame
			 */
			if(!is_mobile())
			{
				echo '<!--[if lt IE 9 ]>
					<script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
					<script>window.attachEvent(\'onload\',function(){CFInstall.check({mode:\'overlay\'})})</script>
					<script src="/global_js/applications/ie6bar.js"></script>
				<![endif]--> ';
			}
			
			/**
			 * For the most part the only JS output
			 * here is Modernizr, but if needed, just add an
			 * additional key to the $GLOBALS['site_js_header'] array
			 */
			
			foreach($GLOBALS['site_js_header_mobile'] as $value)
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
			 * If jQuery has not been loaded from the Google CDN, we fall back onto our local copy
			 * This must be called in between loading the external scripts and the local scripts
			 * to ENSURE that jQuery has been loaded, whether from remote or local copy
			 */
			echo '<script>window.jQuery || document.write("<script src=\'/js/jquery.js\'>\x3C/script>")</script>';
			
			
			
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
			
			
			/**
			 * Prompt IE 6 users to install Chrome Frame
			 */
			 
			echo '<!--[if lt IE 7 ]>
				<script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
				<script>window.attachEvent(\'onload\',function(){CFInstall.check({mode:\'overlay\'})})</script>
				<script src="/global_js/applications/ie6bar.js"></script>
			<![endif]--> ';
			
			
			break;
	
		default:
			break;
					
	}
	
}


function app_html_page_footer($show_support = true)
{
	
	if(isset($GLOBALS['is_mobile']))
	{
		app_html_page_footer_mobile();
		return;
	}
	
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
	
	if (is_mobile())
		$show_support = false;
		
	/**
	 * Support script 
	 */
	if($show_support && !is_mobile())
	{	 
		//if(isset($GLOBALS['sales_reps_site']))
		//	include($_SERVER['DOCUMENT_ROOT'].'/support/form-inline-mobile.php');
		//else
			include($_SERVER['DOCUMENT_ROOT'].'/support/form-inline.php');
	}
	
	if(is_mypoint_employee() && !is_mobile())
	{
		if(!isset($GLOBALS['site_js_footer']['jquery.ui']) || !isset($GLOBALS['site_js_header']['jquery.ui']))
		{
			//jquery ui not on this page, add it so datepicker does not fail
			echo "<script src='/global_js/jquery/jquery.ui.min.js'></script>";
		}
		//echo "<script src='/support/debug.php'></script>";
		include($_SERVER['DOCUMENT_ROOT'].'/support/debug.php');
	}
	else
	{
		unset($_SESSION['debug']);
		unset($_SESSION['debug_db']);
		unset($_SESSION['debug_query']);
		unset($_SESSION['debug_error']);
	}
	echo "</div>";
	echo "</body>";
	echo "</html>";
	
	//system_log_metric(array('end' => microtime(true)), 'html_page_load_time');
	//system_log_save_metrics();
}

function app_html_page_footer_mobile($show_support = true)
{
	//if(isset($_REQUEST['ajax']))
		//return;
	/**
	 * Output of JS comes after everything else 
	
	foreach($GLOBALS['site_js_footer'] as $key=>$value)
	{
		if(file_exists($_SERVER['DOCUMENT_ROOT']."$value"))
		{
			echo "<script src='$value'></script>";
		}
		else
			debug('file not found '.$value);
	} 
	*/
	unset($GLOBALS['site_js_footer']);
	
	/**
	 * Support script 
	 */
	if($show_support)
	{	 
		//if(isset($GLOBALS['sales_reps_site']))
		//	include($_SERVER['DOCUMENT_ROOT'].'/support/form-inline-mobile.php');
		//else
		//support page 
		include($_SERVER['DOCUMENT_ROOT'].'/support/form-inline-mobile.php');
	}
	
	if(isset($GLOBALS['footer_output']))
		echo $GLOBALS['footer_output'];
	
	/*
	 * Debug
	 */
	if(is_mypoint_employee())
	{
		/*if (isset($GLOBALS['xhprof']) && extension_loaded('xhprof')) 
		{
			$xhprof_data = xhprof_disable();
			
			$xhprof_runs = new XHProfRuns_Default();
			$run_id = $xhprof_runs->save_run($xhprof_data, "xhprof_testing");
			
			$profiler_url = sprintf('/support/xhprof/index.php?run=%s&source=%s', $run_id, $profiler_namespace);
			debug( ini_get('xhprof.output_dir').'<br/><a href="'. $profiler_url .'" target="_blank">Profiler output</a>');
		}*/
		
		include($_SERVER['DOCUMENT_ROOT'].'/support/debug_mobile.php');
	}
	else
	{
		unset($_SESSION['debug']);
		unset($_SESSION['debug_db']);
		unset($_SESSION['debug_query']);
		unset($_SESSION['debug_error']);
	}
	echo "</body>";
	echo "</html>";
	
	//system_log_metric(array('end' => microtime(true)), 'html_page_load_time');
	//system_log_save_metrics();
	exit;
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
			echo '<table data-role="table" data-mode="columntoggle" class="ui-responsive table-stroke dataTable" style=" word-wrap:break-word; table-layout:'.$table_layout.'" width="100%" cellpadding="0" cellspacing="0" border="0" >';
		}
		else
			echo '<table data-role="table" data-mode="columntoggle" class="ui-responsive table-stroke " style=" word-wrap:break-word; table-layout:'.$table_layout.'" width="100%" cellpadding="0" cellspacing="0" border="0" >';
			
		echo '<thead><tr class="ui-bar-d" >';
		for($i = 0; $i < count($header_names); $i++)
		{// display headers
			echo '<th class="table_column_'.$i.'" data-priority="'.($i + 1).'" >'.$header_names[$i].'</th>';
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

function jqm_page($id, &$output, $attributes = NULL)
{
	app_html_page_jquery_mobile($id, $output, $attributes);
}

function app_html_page_jquery_mobile($id, &$output, $attributes = array())
{
	echo '<div data-role="page" data-position="fixed" id="'.$id.'" class="ui-responsive-panel" '; 
			foreach($attributes as $attribute)
				echo $attribute.' ';
		echo '>';
		
		if(isset($GLOBALS['panel_script']))
			echo '<script>'.$GLOBALS['panel_script'].'</script>';
		
		if(isset($GLOBALS['panel_left_mobile']))
		{
			foreach($GLOBALS['panel_left_mobile'] as $panel_id => $content)
			{
				echo '<div class="panel_butons panel_left_mobile" data-role="panel" id="'.$panel_id.'" data-theme="a"'
					.'data-display="push" ';
				if(!is_mobile())
					echo ' data-animate="false" ';
				echo ' >';
					echo $content;
				echo '</div>';
			}
		}
		if(isset($GLOBALS['panel_right_mobile']))
		{
			foreach($GLOBALS['panel_right_mobile'] as $panel_id => $content)
			{
				echo '<div class="panel_butons panel_right_mobile" data-role="panel" id="'.$panel_id.'" data-theme="a" '
					//.'data-display="overlay" '
					.'data-display="push" '
					.'data-position="right" data-position-fixed="true">';
					echo $content;
				echo '</div>';
			}
		}
		echo '<div data-role="header" ';
			if(isset($GLOBALS['header_attributes']))
				foreach($GLOBALS['header_attributes'] as $key => $value)
					echo $key.'="'.$value.'" ';
			echo '>';
			echo $GLOBALS['header_output_mobile'];
			
			if(isset($GLOBALS['header_title']))
			{
				echo $GLOBALS['header_title'];
			}
			
			if(isset($GLOBALS['nav']))
			{
				echo '<div data-role="navbar" class="ui-body-b" data-iconpos="left">';
					echo '<ul>';
						foreach($GLOBALS['nav'] as $value)
							echo '<li>'.$value.'</li>';
						
					echo '</ul>';
				echo '</div>';
			}
		echo '</div>';
		echo '<div data-role="content">	';
			echo $output;
		echo '</div>';
		if(isset($GLOBALS['footer_output_mobile']))
		{
			echo '<div data-role="footer" data-position="fixed" data-tap-toggle="false" >'; //data-position="fixed"
				if(isset($GLOBALS['nav_footer']))
				{
					echo '<div data-role="navbar" class="ui-body-b" >';
						echo '<ul>';
							foreach($GLOBALS['nav_footer'] as $value)
								echo '<li>'.$value.'</li>';
						echo '</ul>';
					echo '</div>';
				}
				echo $GLOBALS['footer_output_mobile'];
			echo '</div>';
		}
		if(isset($GLOBALS['help_bubble_tours']))
		{
			foreach($GLOBALS['help_bubble_tours'] as $tour_class => $tour_start_selector)
			{
				echo "<script>$(document).one('pageshow', function() { console.log('page_tour $tour_class'); $('.$tour_class').smallipop('tour'); });</script>";
			}
			
			echo $GLOBALS['help_bubble_output'];
			
			unset($GLOBALS['help_bubble_tours']);
			unset($GLOBALS['help_bubble_output']);
		}
	echo '</div>'."\r\n";
}

function jqm_toolbar_company_connection($company_type, $company_id, $item_type=NULL, $item_id=NULL, $change = true)
{
	if($item_type == NULL)
		$change = false;
	
	if($company_type != NULL)
	{
		//debug_print(array($company_type, $company_id, $item_type, $item_id));
		switch($company_type)
		{
			case "dealer":
				$url = 'dealer_edit.php?dealer_id=';
				include_once($GLOBALS['includes_root']."/classes/dealers.class.php");
				$company_object = new Dealer($company_id);
				$company_info = $company_object->get();
				break;
			case "wholesaler";
				$url = 'wholesaler_edit.php?wholesaler_id=';
				include_once($GLOBALS['includes_root']."/classes/wholesalers.class.php");
				$company_object = new Wholesaler($company_id);
				$company_info = $company_object->get();
				break;
			case "sales_rep":
				$url = 'sales_rep_edit.php?agency_id=';
				include_once($GLOBALS['includes_root']."/classes/sales_reps.class.php");
				$company_object = new Sales_rep($company_id);
				$company_info = $company_object->get();
				break;
			case "consumer";
				include_once($GLOBALS['includes_root']."/classes/users.class.php");
				$company_object = new Users($company_id);
				$user_info = $company_object->get($company_id);
				$url = 'customers.php?user_id=';
				$company_info['company_name'] = $user_info['name_f'].' '.$user_info['name_l'];
				break;
			case 'user';
				include_once($GLOBALS['includes_root']."/classes/users.class.php");
				$company_object = new Users();
				$role_ids = $company_object->get_role_ids($company_id);
				$user_company_type = get_company_type_from_role_ids($role_ids);
				switch($user_company_type)
				{
					case 'sales_rep';
						$url = 'edit_rep_users.php?agency_id='.$user_info['company_id'].'&user_id=';
						break;
					case 'wholesaler';
						$url = 'wholesaler_edit_users.php?wholesaler_id=='.$user_info['company_id'].'&user_id=';
						break;
					case 'dealer';
						$url = 'edit_user_info.php?&user_id=';
						break;
				}
				$user_info = $company_object->get($company_id);
				
				
				
				$company_info['company_name'] = $user_info['name_f'].' '.$user_info['name_l'];
				break;
		}
		
		if(isset($company_object))
		{
			$GLOBALS['nav'][] = '<a data-ajax="true" data-icon="back" data-iconpos="left"
				href="'.get_site_user_type_folder().$url.$company_id.'" >'.$company_info['company_name'].'</a>';
			if($change)
				$GLOBALS['nav'][] = '<a data-ajax="true" ' 
					.'href="'.get_site_user_type_folder().'organization_connect.php?connect_type='.$item_type.'&connect_id='.$item_id.'" >Change Connection</a>';
		}
		else
		{
			$GLOBALS['nav'][] = '<a data-ajax="true" data-icon="plus" ' 
				.'href="'.get_site_user_type_folder().'organization_connect.php?connect_type='.$item_type.'&connect_id='.$item_id.'" >Connect to Company</a>';
		}
	}
}

function help_bubble_tour($tour_class, $tour_start_selector)
{
	$GLOBALS['help_bubble_tours'][$tour_class] = $tour_start_selector;
}

function help_bubble($tour_class, $tour_index, $content, $attributes = NULL )
{
	if(!isset($GLOBALS['help_bubble_output']))
		$GLOBALS['help_bubble_output'] = '';
	
	
	
	$GLOBALS['help_bubble_output'] .= '<span class="'.$tour_class.'" id="'.$tour_class.'_'.$tour_index.'" data-smallipop-tour-index="'.$tour_index.'" ';
	if($attributes == NULL)
	{
		$attributes = array
			(
				//'data-smallipop-tourIndex' => 1,
				'data-smallipop-preferredPosition' => 'right',
				
			);
		/*$GLOBALS['help_bubble_output'] .=  ' data-smallipop=\'
			{
				"tourIndex": 1,
				"tourTitle": "Tutorial",
				"preferredPosition": "top",
				"tourHighlight": true
			}\' ';
		*/
	}
	
	foreach($attributes as $key => $value)
	{
		$GLOBALS['help_bubble_output'] .=  ' '.$key.'="'.$value.'" ';
	}
	
	$GLOBALS['help_bubble_output'] .= '>'.$content.'</span>';
}
