<?php
function curl_load($url, $type = 'GET', $fields = NULL)
{
	echo 'curl get '.$url."\r\n";
	$curl = curl_init($url);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US) AppleWebKit/534.10 (KHTML, like Gecko) Chrome/8.0.552.224 Safari/534.10');
	if($type == 'POST')
		curl_setopt($curl, CURLOPT_POSTFIELDS, $fields);
	$html = curl_exec($curl);
	curl_close($curl);
	 return $html;
}

function calculate_distance($lat1, $lon1, $lat2, $lon2, $unit="M") { 
	$theta = $lon1 - $lon2; 
	$dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta)); 
	$dist = acos($dist); 
	$dist = rad2deg($dist); 
	$miles = $dist * 60 * 1.1515;
	$unit = strtoupper($unit);

	if ($unit == "K") 
		return ($miles * 1.609344); 
	else if ($unit == "N")
		return ($miles * 0.8684);
	else
		return $miles;
}
        
// Create a map using Google Maps API
function show_map($locations, $map_center, $map_canvas = 'map', $width = '100%', $height = '300px', $draggable = 'false', $show_script = true, $zoom = 8) 
{
	if(isset($GLOBALS['is_mobile']))
	{
		show_map_mobile($locations, $map_center, $map_canvas, $width, $height, $draggable, $show_script, $zoom) ;
		return;
	}
	
	if ($draggable == TRUE)
		$draggable = 'true';
	elseif ($draggable == FALSE)
		$draggable = 'false';
		
	$location_string = '';
	
	if (is_array($locations)) 
	{
		$location_string .= '[';
		foreach($locations as $location) 
		{
			$location_string .= '[new google.maps.LatLng('.$location['lat'].','.$location['long'].'), "'.$location['info'].'" ],';
		}
		$location_string .= ']';
	}
	else 
	{
		$location_string .= '['.$locations.']';
	}
	$location_string = str_replace(',]', ']', $location_string);
	
	echo '
	<div id="'.$map_canvas.'" class="mobile_map" style="width:'.$width.'; height:'.$height.'; border: 1px solid #ccc;"></div>';
	
	if ($show_script == true)
		echo '<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key='.$GLOBALS['google_api_key'].'&sensor=false"></script>';
		
		echo '
<script type="text/javascript">
	
var map_center_'.$map_canvas.' = new google.maps.LatLng('.$map_center.');

var data_points_'.$map_canvas.' = '.$location_string.';

var iterator_'.$map_canvas.' = 0;

var '.$map_canvas.';

var current_window_'.$map_canvas.';

function drop_'.$map_canvas.'() 
{
	/* this makes the markers appear one by one */
	for (var i = 0; i < data_points_'.$map_canvas.'.length; i++) 
	{
		setTimeout(function() 
		{
			addMarker_'.$map_canvas.'();
		}, i * 20);
	}
}

function addMarker_'.$map_canvas.'() 
{
	/* Main function to add markers on page */  
 	var  marker_'.$map_canvas.' = new google.maps.Marker({
			position: data_points_'.$map_canvas.'[iterator_'.$map_canvas.'][0],
			map: '.$map_canvas.',
			draggable: false,
			animation: google.maps.Animation.DROP
	});
/* Creates the info windows for hte marker this sets the content */  
	var infowindow_'.$map_canvas.' = new google.maps.InfoWindow(
	{
		content: data_points_'.$map_canvas.'[iterator_'.$map_canvas.'][1],
		size: new google.maps.Size(50,50)
	});
/* Adds click function to the markers */  

	google.maps.event.addListener(marker_'.$map_canvas.', \'click\', function() 
	{
	
	/* This checks the current windows open we need this to close the windows  */
		if(current_window_'.$map_canvas.')
		{
			current_window_'.$map_canvas.'.close();
		}
		
		current_window_'.$map_canvas.' = infowindow_'.$map_canvas.';
		
		current_window_'.$map_canvas.'.open('.$map_canvas.',marker_'.$map_canvas.');
	});
	iterator_'.$map_canvas.'++;
}
/*starts off the map*/
google.maps.event.addDomListener(window, \'load\', initialize_'.$map_canvas.');

function initialize_'.$map_canvas.'() 
{
	var mapOptions_'.$map_canvas.' = 
	{
		zoom: '.$zoom.',
		mapTypeId: google.maps.MapTypeId.ROADMAP,
		draggable: '.$draggable.',
		center: map_center_'.$map_canvas.'
	};
	'.$map_canvas.' = new google.maps.Map(document.getElementById("'.$map_canvas.'"), mapOptions_'.$map_canvas.');
	drop_'.$map_canvas.'();
}
</script>';
}

function show_map_mobile($locations, $map_center, $map_canvas = 'map', $width = '100%', $height = '300px', $draggable = 'false', $show_script = false, $zoom = 8) 
{
	if ($draggable == TRUE)
		$draggable = 'true';
	elseif ($draggable == FALSE)
		$draggable = 'false';
		
	$location_string = '';
	
	if (is_array($locations)) 
	{
		$location_string .= '[';
		foreach($locations as $location) 
		{
			$location_string .= '[new google.maps.LatLng('.$location['lat'].','.$location['long'].'), "'.$location['info'].'" ],';
		}
		$location_string .= ']';
	}
	else 
	{
		$location_string .= '['.$locations.']';
	}
	$location_string = str_replace(',]', ']', $location_string);
	
	$map_center = str_replace('-0', '-', $map_center);
	
	echo '
	<div id="'.$map_canvas.'" class="mobile_map" style="width:'.$width.'; height:'.$height.'; border: 1px solid #ccc;"></div>';
	
	//if ($show_script == true)
		//echo '<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>';
		
		echo '
<script type="text/javascript">
	
var map_center_'.$map_canvas.' = new google.maps.LatLng('.$map_center.');

var data_points_'.$map_canvas.' = '.$location_string.';

var iterator_'.$map_canvas.' = 0;

var '.$map_canvas.';

var current_window_'.$map_canvas.';
';

	//solution to this problem found here:
	//http://stackoverflow.com/questions/9221259/jquery-mobile-not-loading-google-map-except-on-refresh
	echo '
	jQuery("div:jqmData(role=\'page\'):last").bind("pageinit", function()
	{
		//console.log("map pagecreate event triggered");
		initialize_'.$map_canvas.'(); 
		
		
	});
	
	
	jQuery("div:jqmData(role=\'page\'):last").bind("pageshow",function()
	{
			//console.log("map pageshow event triggered");
			google.maps.event.trigger('.$map_canvas.', "resize");
			'.$map_canvas.'.setCenter(map_center_'.$map_canvas.');
	});';
	
echo '
function initialize_'.$map_canvas.'() 
{
	var mapOptions_'.$map_canvas.' = 
	{
		zoom: '.$zoom.',
		mapTypeId: google.maps.MapTypeId.ROADMAP,
		draggable: '.$draggable.',
		center: map_center_'.$map_canvas.'
	};
	'.$map_canvas.' = new google.maps.Map(document.getElementById("'.$map_canvas.'"), mapOptions_'.$map_canvas.');
	//drop_'.$map_canvas.'();
	
	'.$map_canvas.'_markers = [];
	'.$map_canvas.'_info = [];
	for (var i = 0; i < data_points_'.$map_canvas.'.length; i++) 
	{
		/* Creates the info windows for the marker*/  
		var infowindow = new google.maps.InfoWindow(
		{
			content: data_points_'.$map_canvas.'[i][1],
			size: new google.maps.Size(50,50)
		});
		
		var marker = new google.maps.Marker({
			position: data_points_'.$map_canvas.'[i][0],
			//animation: google.maps.Animation.DROP,
			map: '.$map_canvas.'
		});
		
		marker.my_infowindow = infowindow;
		
		/* Adds click function to the markers */  
		google.maps.event.addListener(marker, \'click\', function() 
		{
			this.my_infowindow.open('.$map_canvas.', this);
		});
		
		'.$map_canvas.'_markers.push(marker);
		'.$map_canvas.'_info.push(infowindow);
	}
	console.log('.$map_canvas.'_info);
}
</script>';
}

function geocode($address) 
{
	/* This has been removed as Google limites the amount of queries per key
	 * 
	 * 
	define("MAPS_HOST", "maps.google.com");
	define("KEY", "ABQIAAAA5jPz0kY-MxEBFEnGwF61lBRQU9eQ2vBzPXpZCmL743tQNzOcxRRqX-PhwGBVCa6qua5cA-PhcUoMCQ");
	
	$base_url = "http://" . MAPS_HOST . "/maps/geo?output=csv&key=" . KEY;
	if ($address != null)
		$markers["address"] = $address.", ".$city.", ".$state;
	else
		$markers["address"] = $state;
	$request_url = $base_url . "&q=" . urlencode($markers["address"]);
	$csv = file_get_contents($request_url) or die("url not loading");
	$csvSplit = explode(",", $csv);
	$status = $csvSplit[0];
	$lat = $csvSplit[2];
	$long = $csvSplit[3];
	*/
	
    $_url = sprintf('http://maps.google.com/maps?output=js&q=%s',rawurlencode($address));
    $_result = false;
    if($_result = file_get_contents($_url)) {
        if(strpos($_result,'errortips') > 1 || strpos($_result,'Did you mean:') !== false)
        {
			 debug('geocode error');
			 //debug_print($_result);
			 //return false;
		}
        preg_match('!center:\s*{lat:\s*(-?\d+\.\d+),lng:\s*(-?\d+\.\d+)}!U', $_result, $_match);
        $lat = $_match[1];
        $long = $_match[2];
    }
	return array($lat, $long);
}

function geocode_reverse($lat, $long)
{
	$url = 'http://maps.googleapis.com/maps/api/geocode/json?latlng='.$lat.','.$long.'&sensor=true';
	//debug($url);
	$result = file_get_contents($url);
	//debug("geocode_reverse result = $result");
	return json_decode($result, true);

}

function get_state_option($selected = NULL, $states=array(), $provinces=array(), $show_us=true, $show_ca=true){
	//Creates option list for state select 
	$html= '<select name="state" id="state" >';
	
	$html.=	'<option value="-1">Choose one</option>';

	
	if($show_us){
		$html.='<optgroup  Label= "United States">';

		if(count($states)==0){
	
			$states =  get_us_states_list();
	
		}
		for($i=0;$i<count($states);$i++){
			
			$html.= '<option value='.$states[$i];
			if($selected == $states[$i]){
				$html.= ' selected ';	
			}
			
			$html .= '>'.$states[$i].'</option>';
		}
					$html.='</optgroup>';

	}
	if($show_ca){
	
		$html.='<optgroup  label= "Canada">';

		if(count($provinces)==0){
	
			$provinces= get_canada_list();
	
		}
		for($i=0;$i<count($provinces);$i++){
		
			$html.= '<option value='.$provinces[$i];
		
			if($selected == $provinces[$i]){
		
				echo ' selected ';	
		
			}
			
			$html .= '/>'.$provinces[$i].'</option>';
		}
			$html.='</optgroup>';

	}
	$html .= '</select>';
	return $html;
}

function convert_phone($Number='5555555555')
{
	$GoodNumbers = array(0,1,2,3,4,5,6,7,8,9);
	$CheckNumbers = str_split($Number);
	$NewNumber = '';
	while(list($k, $num) = each($CheckNumbers))
	{
		if(in_array($num,$GoodNumbers) && preg_match("/^[0-9]$/i", $num))
		{
			$NewNumber .= $num;
		}
	}
	//$NewNumber = substr($NewNumber,0,3).substr($NewNumber,3);
	return $NewNumber;
}

//include this function to allow calls to be made
function phone_call()
{
	//require 'Services/Twilio.php';
	if(is_mypoint_employee() && isset($_REQUEST['vbx_call']))
	{
		
		include_once($GLOBALS['includes_root']."/classes/users.class.php");
		$user = new Users();
		$info = $user->get_vbx_info($_SESSION['user_info']['email']);
		
		$key = $info['key'];
		$to = $_REQUEST['to'];
		$user_id = $info['user_id'];
		$caller_id = $info['phonenumber'];
		
		include_once($GLOBALS['includes_root']."/twilio/Services/Twilio/Capability.php");
// @start snippet from http://www.twilio.com/docs/howto/twilio-client-click-to-call
$capability = new Services_Twilio_Capability($info['twilio_sid'], $info['twilio_token']);
$capability->allowClientOutgoing($info['application_sid']);
$token = $capability->generateToken();

//<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>
echo <<<END

<script type="text/javascript" src="https://static.twilio.com/libs/twiliojs/1.0/twilio.js"></script>

<script type="text/javascript">
$(document).ready(function(){

	Twilio.Device.setup("$token");

	$("#call").click(function() {
		params = { "to" : '$to', 'rest_access': '$key', 'client': $user_id, 'caller_id': '$caller_id'};
		Twilio.Device.connect(params);
	});
	$("#hangup").click(function() {
		Twilio.Device.disconnectAll();
	});

	Twilio.Device.ready(function (device) {
		$('#status').text('Ready to start call');
	});

	Twilio.Device.offline(function (device) {
		$('#status').text('Offline');
	});

	Twilio.Device.error(function (error) {
		$('#status').text(error);
	});

	Twilio.Device.connect(function (conn) {
		$('#status').text("Successfully established call");
		toggleCallStatus();
	});

	Twilio.Device.disconnect(function (conn) {
		$('#status').text("Call ended");
		$('#hangup').toggle();
		//toggleCallStatus();
	});

	function toggleCallStatus(){
		$('#call').toggle();
		//$('#hangup').toggle();
	}

});
</script>
<!-- @start snippet -->
<div class="span-24">
	<div class="span-8 info">
	<font size="45"  color="blue" >&#9990;</font>
	Use the buttons to the right<br/>
	You must have a VBX account and registered phone number
	</div>
	<div class="span-12">
		<input class="span-8 button large green" type="button" id="call" value="Start Call to $to"/>
		<input class="span-4 button large notred" type="button" id="hangup" value="Disconnect Call" />
		<div class="span-12 large notice last" id="status">
			Offline
		</div>
	</div>
</div>
<hr class="space">
<!-- @end snippet -->
END;
	}
}

//takes a messy number, converts it for use in pbx and makes a form call
function phone_call_form($number, $country_code ="+1" )
{
	echo '<form action="" method="POST" >';
	echo '<input type="hidden" name="to" value="'.$country_code.convert_phone($number).'" />';
	echo '<input class="button blue large" type="submit" name="vbx_call" value="&#9990; Call" /> '.$number;
	echo '</form>';
}

function paginate_query($main_query, $start, $limit = 10) {
	$total_num_rows = mysql_num_rows(mysql_query($main_query));
		if ($total_num_rows > 10) {
			$total_pages = ceil($total_num_rows / $limit);
			echo '<p class="paginate"><strong>Page: </strong>';
			
			if ($_GET['page'] > 1) {
				$current_page = $_GET['page'];
				echo '<a href="?page='.($current_page-1).'" class="button">< Previous</a>';
			}
			else {
				$current_page = 1;
			}
			
			if ($total_pages > 20) {
				
				// If the page is 1-5, don't show pages before it
				if ($current_page > 5) {
					for($i=1; $i < 6; $i++) {
						echo '<a href="?page='.$i.'" class="button">'.$i.'</a>';
					}
					
				}
				echo '<a href="?page='.$current_page.'" class="button selected">'.$current_page.'</a>';
				
				for($i=($current_page+1); $i < ($current_page+5); $i++) {
					echo '<a href="?page='.$i.'" class="button">'.$i.'</a>';
				}
				
				
				if ($current_page > ($total_pages - 5)) {
					echo ' ... ';
					
					
					for($i=$total_pages-5; $i < $total_pages; $i++) {
						echo '<a href="?page='.$i.'" class="button">'.$i.'</a>';
					}
				}
			}
			else {
				for($i=0; $i < $total_pages; $i++) {
					echo '<a href="?page='.$i.'" class="button">'.$i.'</a>';
				}
			}
			
			if ($_GET['page'] != $total_pages)
				echo '<a href="?page='.($current_page+1).'" class="button">Next ></a>';
				
			echo '</p>';
		}
		
		echo 'Showing records '.number_format($start).' - '.number_format($start+$limit).' out of '.number_format($total_num_rows).' total';
	
}

function get_states($abbreviation = null, $full_name = null, $get_all = null) 
{
	$states = array(
	'AL' => 'Alabama',
	'AK' => 'Alaska',
	'AZ' => 'Arizona',
	'AR' => 'Arkansas',
	'CA' => 'California',
	'CO' => 'Colorado',
	'CT' => 'Connecticut',
	'DE' => 'Delaware',
	'FL' => 'Florida',
	'GA' => 'Georgia',
	'HI' => 'Hawaii',
	'ID' => 'Idaho',
	'IL' => 'Illinois',
	'IN' => 'Indiana',
	'IA' => 'Iowa',
	'KS' => 'Kansas',
	'KY' => 'Kentucky',
	'LA' => 'Louisiana',
	'ME' => 'Maine',
	'MD' => 'Maryland',
	'MA' => 'Massachusetts',
	'MI' => 'Michigan',
	'MN' => 'Minnesota',
	'MS' => 'Mississippi',
	'MO' => 'Missouri',
	'MT' => 'Montana',
	'NE' => 'Nebraska',
	'NV' => 'Nevada',
	'NH' => 'New Hampshire',
	'NJ' => 'New Jersey',
	'NM' => 'New Mexico',
	'NY' => 'New York',
	'NC' => 'North Carolina',
	'ND' => 'North Dakota',
	'OH' => 'Ohio',
	'OK' => 'Oklahoma',
	'OR' => 'Oregon',
	'PA' => 'Pennsylvania',
	'RI' => 'Rhode Island',
	'SC' => 'South Carolina',
	'SD' => 'South Dakota',
	'TN' => 'Tennessee',
	'TX' => 'Texas',
	'UT' => 'Utah',
	'VT' => 'Vermont',
	'VA' => 'Virginia',
	'WA' => 'Washington',
	'WV' => 'West Virginia',
	'WI' => 'Wisconsin',
	'WY' => 'Wyoming',
	);
	
	
	if($abbreviation == null AND $full_name == null AND $get_all == null)
		return $states;
	elseif ($full_name == null AND strlen($abbreviation) == 2)	
		return $states[$abbreviation];
	elseif ($full_name != null OR strlen($abbreviation) > 2)
		return array_search($abbreviation, $states);
	else
		return 1;
}

// These are used all over Drupal to encode links - DO NOT DELETE!!
function seoencode($text)
{
	$text = str_replace(' - ', '-', $text);
	$text = str_replace(' ', '-', $text);
	$text = str_replace('/', '', $text);
	$text = rawurlencode($text);
	return $text;
}

function seodecode($text)
{
	$text = str_replace('%26', 'AND', $text);
	$text = str_replace('-', ' ', $text);
	$text = rawurldecode($text);
	return $text;
}

function translate($source)
{
	//debug("translating");
	if(isset($GLOBALS['language']))
	{
		$query = "SELECT result
			FROM translate t 
			JOIN translate_result tr on t.translate_id = tr.translate_id
			WHERE source = '$source' AND language = '".$GLOBALS['language']."' and needed = 0";
		$result = mysql_query($query);
		if(mysql_num_rows($result))
		{
			$temp = mysql_fetch_assoc($result);
			//return utf8_encode($temp['result']);
			return $temp['result'];
		}
		else
		{
			debug("error translating source = '$source'");
			//check to see if source is already in db
			$query = "INSERT IGNORE INTO translate(source) VALUES ('$source')";
			//debug("translate insert query = $query");
			$result = mysql_query($query);
			
			$query = "SELECT translate_id
				FROM translate t WHERE source = '$source' ";
			debug("translate_id query = $query");
			$result = mysql_query($query);
			
			$temp = mysql_fetch_assoc($result);
			$id = $temp['translate_id'];
			unset($temp);
			
			$query = "INSERT INTO translate_result(translate_id, language, needed) VALUES ($id, '".$GLOBALS['language']."', 1)";
			debug("translate_result insert query = $query");
			$result = mysql_query($query);
			
			return $source;
		}
	}
	else
		return $source;
}

//Returns true if the email is valid
function CheckValidEmail($to_email)
{
	return preg_match_all("/^(?:[A-Za-z0-9!#$%&'*+=?^_`{|}~-]+(?:\.[A-Za-z0-9!#$%&'*+=?^_`{|}~-]+)*|\"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*\")@(?:(?:[A-Za-z0-9](?:[A-Za-z0-9-]*[A-Za-z0-9])?\.)+[A-Za-z0-9](?:[A-Za-z0-9-]*[A-Za-z0-9])?|\[(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?|[A-Za-z0-9-]*[A-Za-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])$/", $to_email, $arr, PREG_PATTERN_ORDER);
}

function getBrowser()
{
	$u_agent = $_SERVER['HTTP_USER_AGENT'];
	$ub = '';
	if(preg_match('/MSIE/i',$u_agent))
	{
		$ub = "Internet Explorer";
	}
	elseif(preg_match('/Firefox/i',$u_agent))
	{
		$ub = "Mozilla Firefox";
	}
	elseif(preg_match('/Safari/i',$u_agent))
	{
		$ub = "Apple Safari";
	}
	elseif(preg_match('/Chrome/i',$u_agent))
	{
		$ub = "Google Chrome";
	}
	elseif(preg_match('/Flock/i',$u_agent))
	 {
		$ub = "Flock";
	}
	elseif(preg_match('/Opera/i',$u_agent))
	{
		$ub = "Opera";
	}
	elseif(preg_match('/Netscape/i',$u_agent))
	{
		$ub = "Netscape";
	} 
	return $ub;
}

//james made this
//from: http://www.fliquidstudios.com/2009/05/07/resizing-images-in-php-with-gd-and-imagick/
function resize_image($file, $w, $h, $crop=FALSE) 
{
	$img = new Imagick($file);
	if ($crop) 
	{
		$img->cropThumbnailImage($w, $h);
	} 
	else 
	{
		$img->thumbnailImage($w, $h, TRUE);
	}
	
	$img->writeImage($file);
}

function upload_image_form($type, $max_width = 1024, $max_height = 1024, $user_id = null)
{
	if ((is_android() AND is_android() >= 3.0) OR (is_ios() and is_ios() >= 6.0) OR !is_mobile())
	{
		$GLOBALS['site_js_footer']['image_upload'] = "/global_js/image_upload.js";
		echo '<input type="file" capture="camera" style="display:none" name="image_for_upload" id="image_for_upload">';
		echo '<input type="hidden" name="image_type" id="image_type" value="'.$type.'" />';
		echo '<input type="hidden" name="image_max_height" id="image_max_height" value="'.$max_height.'" />';
		echo '<input type="hidden" name="image_max_width" id="image_max_width" value="'.$max_width.'" />';
		if ($user_id != null)
			echo '<input type="hidden" name="image_user_id" id="image_user_id" value="'.$user_id.'" />';
		echo '<button id="upload_image">Select Image...</button>';
	}
	elseif (!is_ios())
	{
		echo '<input type="file" capture="camera" name="image_for_upload" id="image_for_upload">';
	}
}

function is_mobile()
{
	if(isset($_SESSION['is_mobile']))
	{
		if ($_SESSION['is_mobile'] == true)
			return $_SESSION['is_mobile'];
		else
			return false;
	}
	else
	{
		include_once($GLOBALS['includes_root']."/classes/mobile_detect.class.php");
		$detect = new Mobile_Detect;
		if($detect->isMobile()) 
		{
			$_SESSION['is_mobile'] = true;
			$_SESSION['jquery.mobile'] = true;
			return true;
		}
		else
		{
			$_SESSION['is_mobile'] = false;
			return false;
		}
	}
}

function is_tablet()
{
	if(isset($_SESSION['is_tablet']))
	{
		return $_SESSION['is_tablet'];
	}
	else
	{
		include_once($GLOBALS['includes_root']."/classes/mobile_detect.class.php");
		$detect = new Mobile_Detect;
		
		if($detect->isTablet()) 
		{
			$_SESSION['is_tablet'] = true;
			return true;
		}
		else
		{
			$_SESSION['is_tablet'] = false;
			return false;
		}
	}
}

function is_app()
{
	if(isset($_SESSION['is_app']))
		return $_SESSION['is_app'];
	else
	{
		if(preg_match_all("/phonegap-roam/", $_SERVER['HTTP_USER_AGENT'], $matches))
		{
			$_SESSION['is_app'] = true;
			return true;
		}
		else
		{
			$_SESSION['is_app'] = false;
			return false;
		}
	}
}

function is_ios()
{
	
	if(isset($_SESSION['is_app']))
		return $_SESSION['is_app'];
	else
	{
		include_once($GLOBALS['includes_root']."/classes/mobile_detect.class.php");
		$detect = new Mobile_Detect;
		if($detect->isiOS())
		{
			$_SESSION['is_ios'] = true;
		}
		else
		{
			$_SESSION['is_ios'] = false;
		}
	}
	return $_SESSION['is_ios'];
	/*
	if(preg_match_all("/iPhone OS (\d+)_(\d+)\s+/", $_SERVER['HTTP_USER_AGENT'], $matches)){
		$version = $matches[1][0].'.'.$matches[2][0];
		return $version;
	}
	else
		return false;
	*/
}

function is_android()
{
	if(isset($_SESSION['is_android']))
		return $_SESSION['is_android'];
	else
	{
		include_once($GLOBALS['includes_root']."/classes/mobile_detect.class.php");
		$detect = new Mobile_Detect;
		if($detect->isAndroidOS())
		{
			$_SESSION['is_android'] = true;
		}
		else
		{
			$_SESSION['is_android'] = false;
		}
	}
	return $_SESSION['is_android'];
	/*if(preg_match_all("/Android (\d+(?:\.\d+)+);/i", $_SERVER['HTTP_USER_AGENT'], $matches)){
		$version = $matches[1][0];
		return $version;
	}
	else
		return false;
	*/
}
