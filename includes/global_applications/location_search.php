<?php 

include_once($GLOBALS['includes_root']."/classes/location.class.php");

function location_search($radius = 10)
{
	$display_form = location_search_process($radius);
	
	if($display_form)
	{
		location_search_form();
		$location = new Location();
		$options = $location->get_all_options();
		
		echo '<h3>Tags</h3>';
		echo '<ul data-role="listview" >';
			foreach($options as $option)
			{
				echo '<li>';
					echo '<a href="options.php?option_id='.$option['option_id'].'" ><h3>'.$option['name'].'</h3></a> ';
				echo '</li>';
			}
		echo '</ul>';
	}
	
}

function location_search_form()
{
	$GLOBALS['site_js_footer']['geolocate'] = "/global_js/location.js";
	echo '<div class="error hidden geolocate_notification" ></div>';
	
	echo '<hr class="clear space" />';
	
	echo '<form class="location_form"  action="/" >';
		
		echo '<div class="">';
			echo '<input type="submit" class="green button large" name="change_milage" value="Search Around Me"  />';
		echo '</div>';
		
		echo '<input type="hidden" name="description" value="" />';
		echo '<input type="hidden" class="location_current_form" name="location_current" value="" />';
		echo '<input type="hidden" class="location_accuracy_form" name="location_accuracy" value="" />';
	echo '</form>';
	echo '<hr class="clear space" />';
	
	echo <<<END
<script>
$(document).one('pageshow', function()
{
	if (navigator.geolocation) 
	{
		console.log("navigator enabled");
		//show loading
		$.mobile.loading( 'show', 
		{
			text: 'Getting Your Location',
			textVisible: true
		});
		
		getAccurateCurrentPosition
		(
			location_accepted, 
			location_declined, 
			{desiredAccuracy:30000, maxWait:15000}
		);
		console.log("geolocation called");
	}
	else
	{
		$('#geolocate_notification').html(gps_missing_message);
	}
});
</script>
END;
}


function location_search_process($radius)
{
	if(isset($_REQUEST['location_current']))
	{
		$_SESSION['last_location'] = $_REQUEST['location_current'];
		$location = new Location();
		list($latitude, $longitude) = explode(',', $_REQUEST['location_current']);
		$info = $location->search($latitude, $longitude, $radius);
		
		foreach($info as $value)
		{
			/*$output[] = array(
				'Name'=> '<a href="location_view.php?id='.$value['id'].'" >'.$value['name'].'</a>',
				'Distance' => number_format($value['distance'], 2).' miles',
				'Description'=>substr($value['description'], 0,300).'<a href="location_view.php?id='.$value['id'].'" > view more...</a>',
				'Hours' => $value['hours'],
				'Address' => '<a href="https://maps.google.com/?q='.urlencode($value['address']).'" >'.$value['address'].'</a>',
				'URL' => '<a href="'.$value['url'].'" >'.$value['url'].'</a>'
				);*/
			
			ob_start();
				echo '<li>';
					echo '<a href="location_view.php?id='.$value['id'].'" >';
						echo '<h3>'.$value['name'].'</h3>';
						echo '<p>';
							if($value['hours'] != NULL)
								echo '<strong>Hours: </strong>'.$value['hours'].'<br/>';
							echo $value['address'];
						echo '</p>';
						echo '<p class="ui-li-aside">';
							echo number_format($value['distance'], 2).' miles';
						echo '</p>';
					echo '</a>';
					echo '<a href="https://maps.google.com/?q='.urlencode($value['name'].' '.$value['address']).'" target="_blank" data-icon="search" data-theme="g">'.$value['address'].'</a>';
				echo '</li>';
			$list_items .= ob_get_clean();
			$url = 'location_view.php?id='.$value['id'];
			$locations[] = array( 'info' => "<a href='".$url."' >".$value['name']."</a><br/>".
										"<a class='button blue' href='tel:".$value['phone']."' >".$value['phone'].'</a>',
								'lat' => $value['latitude'],
								'long' => $value['longitude'],
							);
		}
		//
		echo '<div class="content-primary" >';
			echo '<div class="mobile_map" class="span-23">';
				show_map_mobile($locations, $latitude.', '.$longitude, 'map_', '100%', '400px', 'true', false, 12);
				//include_once($GLOBALS['includes_root']."/global_applications/google_maps.php");
				//app_google_my_location_map($locations, $_REQUEST['location_current'], 'map', '100%', '400px', 'true', true, 14);
				//show_map($locations, $_REQUEST['location_current'], 'map', '100%', '400px', 'true', true, 14);
			echo '</div>';
			echo '<hr/>';
		echo '</div>';
		//echo '<hr class="space" />';
		echo '<div class="content-secondary" >';
			//html_table($output);
			echo '<ul data-role="listview" >';
				echo $list_items;
			echo '</ul>';
		echo '</div>';
		return false;
	}
	return true;
}
