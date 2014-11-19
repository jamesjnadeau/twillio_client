<?php 

function debug($output, $backtrace_level = 1)
{
	if(php_sapi_name() == 'cli' && empty($_SERVER['REMOTE_ADDR'])) 
	{
		echo "\r\n".'*******';
		echo $output;
		echo "\r\n".'*******';
	}
	else
	{
		if(is_array($output))
			$output = print_r($output, true);
		$backtrace = debug_backtrace();
		
		if(!isset($backtrace[$backtrace_level]))
			$backtrace_level--;
		
		$final_output = 'File: <a target="_blank" href="/support/editor.php?file_name='.$backtrace[$backtrace_level]["file"].'" >'.$backtrace[$backtrace_level]["file"].'</a><br/>';
		
		if($backtrace[$backtrace_level]["function"] != 'mypointnow_error_handler')
		{
			$final_output .= 'Function: '.$backtrace[$backtrace_level]["function"].'<br/>';
			$final_output .= 'Call Line: '.$backtrace[$backtrace_level]["line"].'<br/>';
			$final_output .= 'Args: '.print_r($backtrace[$backtrace_level]["args"], true).'<br/>';
		}
		$final_output .= '<pre class="notice">'.nl2br($output).'</pre>';
		$_SESSION['debug'][] = $final_output;
	}
}

function debug_print($output)
{
	//if(is_mypoint_employee())
	{
		echo '<pre>'.print_r($output, true).'</pre>';
	}
}

function debug_css_print()
{
	foreach($GLOBALS['site_css'] as $key => $value)
	{
		if($value['media'] == 'print')
			$GLOBALS['site_css'][$key]['media'] = 'all';
	}
}

function debug_db($url, $backtrace_level = 0)
{
	$backtrace = debug_backtrace();
	//if(is_mypoint_employee())
	{
		$_SESSION['debug_db'][] = '<a href="'.$url.'" target="_blank">'.basename($backtrace[$backtrace_level]["file"]).' -> '.$backtrace[$backtrace_level+1]["function"].'</a>';
	}
}


class PhpConsole {
	
	public static function start()
	{
		return true;
	}
}

// error handler function
function mypointnow_error_handler($errno, $errstr, $errfile, $errline)
{
    if (!(error_reporting() & $errno)) {
        // This error code is not included in error_reporting
        return;
    }

    switch ($errno) {
    case E_USER_ERROR:
        $output = "<b style='color:red;'>PHP ERROR</b> [$errno] $errstr<br />\n";
        $output .= "  Fatal error on line $errline in file $errfile";
        $output .= ", PHP " . PHP_VERSION . " (" . PHP_OS . ")<br />\n";
        $output .= "Aborting...<br />\n";
        debug($output, 2);
        //system_log($output, 'php error');
        exit(1);
        break;

    case E_USER_WARNING:
        $output = "<b style='color:red;'>PHP user WARNING</b> [$errno] $errstr<br />\n";
        $output .= "on line $errline in file $errfile";
        debug($output, 2);
        //system_log($output, 'php error');
        break;

    case E_USER_NOTICE:
        $output = "<b style='color:red;'>PHP user NOTICE</b> [$errno] $errstr<br />\n";
        $output .= "on line $errline in file $errfile";
        debug($output, 2);
       //system_log($output, 'php error');
        break;
        
    case E_NOTICE:
        $output = "<b style='color:red;'>PHP NOTICE</b> [$errno] $errstr<br />\n";
        $output .= "on line $errline in file $errfile";
        debug($output, 2);
        //system_log($output, 'php error');
        break;
    
    default:
        $output = "<b style='color:red;'>PHP error type:</b> [$errno] $errstr<br />\n";
        $output .= "on line $errline in file $errfile";
        debug($output, 2);
        //system_log($output, 'php error');
        break;
    }
    
	
	
    /* Execute PHP internal error handler */
    return NULL;
}

//set up our error handler

