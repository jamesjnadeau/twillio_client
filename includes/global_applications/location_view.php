<?php 

include_once($GLOBALS['includes_root']."/classes/location.class.php");

function location_view($id)
{
	
	$location = new Location();
	$info = $location->get($id);
	$options = $location->get_options($id);
	
	//foreach($options as $value)
	//	$option_ids[] = $value['option_id'];
	
	
	
	$GLOBALS['title'] = $info['name'];
	echo '<div ';
		foreach($options as $value) //Restaurant 
			echo ' '.$value['schema'].' ';
	echo '>';
		echo '<div class="content-primary" >';
			
		
			//echo '<a href="location_view.php?id='.$id.'" ><h2>'.$info['name'].'</h2></a>';
			
			echo '<h2 itemprop="name" >'.$info['name'].'</h2>';
			
			echo '<h4 itemprop="openingHours" content="'.$info['hours'].'">'.$info['hours'].'</h4>';
			
			if($info['url'] != NULL)
			{
				if(strstr($info['url'], '@'))//if it's an email address
					echo '<a data-role="button" target="_blank" href="mailto:'.$info['url'].'" itemprop="email" >'.$info['url'].'</a>';
				else
				{
					$url_info = parse_url($info['url']);
					echo '<a data-role="button" target="_blank" href="'.$info['url'].'" itemprop="url" >'.$url_info['host'].'</a>';
				}
			}
			echo '<div itemscope itemtype="http://schema.org/PostalAddress">';
				echo '<a itemrprop="map" class="" data-role="button" target="_blank" href="https://maps.google.com/?q='.urlencode($info['name'].' '.$info['address']).'" >Map:<span itemprop="streetAddress" >'.$info['address'].'</span></a>';
			echo '</div>';
			
			echo '<p ><a itemprop="telephone" href="tel:'.$info['phone'].'" data-role="button" data-inline="true" >'.$info['phone'].'</a></p>';
			
			
			echo '<p itemprop="description" >'.$info['description'].'</p>';
		echo '</div>';
		echo '<div class="content-secondary" >';
			if($info['latitude'] == NULL || $info['latitude'] == 0)
			{
				$location->geocode_fix($id, $info['address']);
				$info = $location->get($id);
			}
			
			if($info['latitude'] != NULL)
			{
				$locations[] = array( 'info' => $info['name']."<br/>".
											"<a class='button blue' href='tel:".$info['phone']."' >".$info['phone'].'</a>',
									'lat' => $info['latitude'],
									'long' => $info['longitude'],
								);
				show_map_mobile($locations, $info['latitude'].','.$info['longitude'], 'map_'.$id, '100%', '300px', 'false', false, 14) ;
				echo '<p itemprop="geo" itemscope itemtype="http://schema.org/GeoCoordinates" >';
					echo $info['latitude'].','.$info['longitude'];
					echo ' <meta itemprop="latitude" content="'.$info['latitude'].'" /><meta itemprop="longitude" content="'.$info['longitude'].'" />';
				echo '</p>';
				
			}
			else
				echo '<h3 class="error" >Unable to find coordinates</h3>';
		
			echo '<div class="right" >';
				echo '<h3>Tags</h3>';
				echo '<p>';
					foreach($options as $option)
						echo '<a data-role="button" data-mini="true" data-inline="true" href="options.php?option_id='.$option['option_id'].'" >'.$option['name'].'</a> ';
				echo '</p>';
			echo '</div>';
		
		echo '</div>';
		echo '<hr class="clear" />';
		
	echo '</div>';
	//echo '<p class="span-12  last"></p>';
	
}
