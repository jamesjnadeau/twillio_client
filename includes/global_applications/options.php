<?php 

include_once($GLOBALS['includes_root']."/classes/location.class.php");

function options($option_id, $radius = 20)
{
	list($latitude, $longitude) = explode(',', $_SESSION['last_location']);
	$location = new Location();
	$info = $location->get_by_options($latitude, $longitude, $option_id);
	if(!is_array($info))
	{
		if($radius < 60)
			options($option_id, $radius + 5);
		else
		{
			echo '<h3 class="error">Unable to find anything....</h3>';
			include_once($GLOBALS['includes_root']."/global_applications/location_search.php");
			location_search();
		}
		return;
	}
	ob_start();
		echo '<ul data-role="listview" >';
			foreach($info as $value)
			{
				ob_start();
					list($info, $options) = option_location_view($value['id']);
				$output = ob_get_clean();
				echo '<li ';
						foreach($options as $temp) //Restaurant 
							echo ' '.$temp['schema'].' ';
					echo '>';
					echo '<a href="location_view.php?id='.$value['id'].'" >';
						echo $output;
						//echo '<pre>'.print_r($info, true).'</pre>';
						if($info['latitude'] != NULL)
						{
							$locations[] = array( 		'info' => htmlentities($info['name'])."<br/>".
													//'info' => "<a href='".$url."' >".$value['name']."</a><br/>".
													"<a class='button blue' href='tel:".$info['phone']."' >".$info['phone'].'</a>',
													'lat' => $info['latitude'],
													'long' => $info['longitude'],
									);
						}
					echo '</a>';
				echo '</li>';
			}
		echo '</ul>';
	$output = ob_get_clean();
	
	show_map_mobile($locations, $latitude.', '.$longitude, 'map_', '100%', '400px', 'true', false, 12);
	echo '<hr class="clear" />';
	echo $output;
}

function options_list()
{
	$location = new Location();
	$options = $location->get_all_options();
	echo '<ul data-role="listview" >';
		foreach($options as $option)
		{
			echo '<li><a  href="options.php?option_id='.$option['option_id'].'" >'.$option['name'].'</a></li>';
		}
	echo '</ul>';
}

function option_location_view($id)
{
	
	$location = new Location();
	$info = $location->get($id);
	$options = $location->get_options($id);
	
	//foreach($options as $value)
	//	$option_ids[] = $value['option_id'];
	
	echo '<h2 itemprop="name" >'.$info['name'].'</h2>';
	echo '<div class="unbreakable" ';
			foreach($options as $temp) //Restaurant 
				echo ' '.$temp['schema'].' ';
		echo '>';
		echo '<p itemprop="openingHours" >'.$info['hours'].'</p>';
		
		echo '<p  >';
			//echo '<a itemrprop="map" class="" data-role="button" data-inline="true" target="_blank" href="https://maps.google.com/?q='.urlencode($info['address']).'" >Map:<span itemprop="streetAddress" >'.$info['address'].'</span></a>';
			echo '<span itemscope itemtype="http://schema.org/PostalAddress" itemprop="streetAddress" >'.$info['address'].'</span>';
			echo '<br/>';
			//echo '<a itemprop="telephone" href="tel:'.$info['phone'].'" data-role="button" data-inline="true" >'.$info['phone'].'</a>';
			echo '<span itemprop="telephone" >'.$info['phone'].'</span>';
			
		echo '</p>';
		
		//echo '<pre>'.print_r($options, true).'</pre>';
		echo '<p itemprop="description" class="wordwrap">'.$info['description'].'</p>';
		
		
		
	echo '</div>';
	
	return array($info, $options);
}
