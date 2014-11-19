<?php 


function app_google_my_location_map($locations, $map_center, $map_canvas = 'map', $width = '100%', $height = '300px', $draggable = 'false', $show_script = true, $zoom = 8) 
{
	$location_string = '';
	
	if (is_array($locations)) 
	{
		$location_string .= '[';
		foreach($locations as $location) 
		{
			$location_string .= '[new google.maps.LatLng('.$location['lat'].','.$location['long'].'), "'.$location['info'].'" ],'."\r\n";
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
		echo '<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key='.$GLOBALS['google_api_key'].'&sensor=true"></script>';
		
		echo '
<script type="text/javascript">
	
var map_center_'.$map_canvas.' = new google.maps.LatLng('.$map_center.');

var data_points_'.$map_canvas.' = '.$location_string.';

var iterator_'.$map_canvas.' = 0;

var '.$map_canvas.';

var current_window_'.$map_canvas.';

function drop_'.$map_canvas.'() 
{
	//my location marker
	var  marker_'.$map_canvas.' = new google.maps.Marker({
			position: map_center_'.$map_canvas.',
			map: '.$map_canvas.',
			draggable: false,
			animation: google.maps.Animation.DROP,
			icon: "/global_images/icons/silk/flag_blue.png"
	});
	
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
