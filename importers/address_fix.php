<?php 

include('../settings.php');
include_once($GLOBALS['includes_root']."/classes/location.class.php");
$location = new Location();


$query = "SELECT * from location where street = 0 OR street is NULL LIMIT 3";
debug($query);
$result = mysql_query($query);

while($temp = mysql_fetch_assoc($result))
{
	if($temp['address'] != NULL)
	{
		list($latitude, $longitude) = geocode_parse($temp['address']);
		sleep(2);
		
		/*
		$query = "UPDATE location set latitude = '$latitude', longitude = '$longitude' WHERE id = ".$temp['id'];
		//echo $query."\r\n";
		mysql_query($query);
		*/
		echo "\r\n";
	}
	else
		echo "address = ".$temp['address']."\r\n";
}


function geocode_parse($address) 
{
	$maps_host = "maps.googleapis.com";
	//$maps_key =  "ABQIAAAA5jPz0kY-MxEBFEnGwF61lBRQU9eQ2vBzPXpZCmL743tQNzOcxRRqX-PhwGBVCa6qua5cA-PhcUoMCQ";
	
	$base_url = "http://".$maps_host."/maps/api/geocode/json?&sensor=false";
	if ($address != null)
	{
		$markers["address"] = $address;
	
		$request_url = $base_url . "&address=" . urlencode($markers["address"]);
		$_result = file_get_contents($request_url) or debug_print("url not loading");
		echo $request_url."\r\n";
		echo print_r($_result, true)."\r\n";
	}
	/*
	$_url = sprintf('http://maps.google.com/maps?output=json&q=%s',rawurlencode($address));
	$_result = false;
	if($_result = file_get_contents($_url)) 
	{
		echo substr($_result, 9)."\r\n";
		$_result = json_decode(substr($_result, 9));
		echo print_r($_result, true)."\r\n";
		
		switch (json_last_error()) 
		{
			case JSON_ERROR_NONE:
				echo ' - No errors';
			break;
			case JSON_ERROR_DEPTH:
				echo ' - Maximum stack depth exceeded';
			break;
			case JSON_ERROR_STATE_MISMATCH:
				echo ' - Underflow or the modes mismatch';
			break;
			case JSON_ERROR_CTRL_CHAR:
				echo ' - Unexpected control character found';
			break;
			case JSON_ERROR_SYNTAX:
				echo ' - Syntax error, malformed JSON';
			break;
			case JSON_ERROR_UTF8:
				echo ' - Malformed UTF-8 characters, possibly incorrectly encoded';
			break;
			default:
				echo ' - Unknown error';
			break;
		}
	}
	return array($lat, $long);
	*/
}
