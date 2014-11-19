<?php 

include('../settings.php');
include_once($GLOBALS['includes_root']."/classes/location.class.php");
$location = new Location();

$base_url = 'http://nofavt.org/find-organic-food/farmers-market-listing';
$html = curl_load($base_url);

require 'QueryPath/QueryPath.php';

$root = htmlqp($html);

$root = $root->find('.content')->children();

//$count = 0;
foreach($root as $value)
{
	//check to make sure there are no styles
	if(!$value->hasAttr('style'))
	{
		//echo $value->tag()."\r\n";
		if($value->tag() == 'h4')
		{
			$title = $value->text();
			echo $title."\r\n";
			$description = $value->next('ul')->html();
			$value->find('li');
			$description = '';
			foreach($value as $temp)
			{
				$description .= $temp->text().'|';
			}
			echo $description."\r\n";
			$temp = explode('|', $description);
			$description = $temp[1];
			$hours = $temp[4];
			$address = $temp[0];
			$phone = $temp[2];
			$url = $temp[3];
			 
			$id = $location->add($title, $description, $address, $hours, $url, $phone);
			echo 'adding location with id '.$id."\r\n";
			$location->add_option($id, 'Farmers Market');
			$count++;
			//if($count > 5)
				//exit;
		}
		
	}
	

}

