<?php 


include('../settings.php');
include_once($GLOBALS['includes_root']."/classes/location.class.php");
$location = new Location();

$fields = array(
	'searchcat' =>  'towns',
	'Town' => 'px',
	'ProdID' => 'px',
	'filter' => 'px',
	'submit' => urlencode(' search for producers ')
);

$base_url = 'http://vermontmaple.org/open-year-round.php?county=';
$html = curl_load($base_url);

require 'QueryPath/QueryPath.php';

$root = htmlqp($html);

$root = $root->find('.basebody form')->children();
$count = 0;
foreach($root as $value)
{
	//echo $value->tag()."\r\n";
	if($value->tag() == 'p')
	{//could be a title or options
		if($value->has('b'))
		{//title
			$title = $value->text();
			echo $title."\r\n";
		}
		else
		{//options
			$options = $value->text();
			echo $options."\r\n";
		}
		
	}
	elseif($value->tag() == 'blockquote')
	{//more info
		//echo $value->html()."\r\n";	
		$info = strip_tags(str_replace('<br/>', '|', $value->html()));
		echo $info."\r\n";
		$info = explode('|', $info);
		
		$address = $info[0].' '.$info[1];
		$phone = $info[2];
		$url = $info[4];
		
		$id = $location->add($title, $description, $address, $hours, $url, $phone);
		echo 'adding location with id '.$id."\r\n";
		$count++;
		//if($count > 5)
			//exit;
	}
}

