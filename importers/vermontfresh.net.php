<?php 

include('../settings.php');
include_once($GLOBALS['includes_root']."/classes/location.class.php");
$location = new Location();

$base_url = 'http://www.vermontfresh.net';
$html = curl_load($base_url.'/member-search/member-list/');

require 'QueryPath/QueryPath.php';

$root = htmlqp($html);

$root = $root->find('ul.members li');
$count = 0;
foreach($root as $value)
{
	echo $value->html()."\r\n";
	$url = $value->find('a')->attr('href');
	$title = $value->text();
	$html = curl_load($base_url.$url);
	//echo $html."\r\n";
	$temp = htmlqp($html, '.member-details')->children();
	$p_count = 0;
	foreach($temp as $info)
	{
		if($info->hasClass('member-address'))
		{//address
			$info = $info->find('p')->innerhtml();
			$address = trim(preg_replace("/\s+/", " ", str_replace('<br/>', ' ', $info)));
			echo $address."\r\n";
		}
		elseif($info->hasClass('contact-info'))
		{
			$info = $info->find('ul li');
			$phone = $info->innerhtml();
			$phone = explode('</span>', $phone);
			$phone = $phone[1];
			echo $phone."\r\n";
			$info->next();
			//email
			$info->next();
			$website = $info->find('a')->attr('href');
			echo $website."\r\n";
			$p_count = 1;
		}
		elseif($p_count)
		{
			if($info->tag() == 'p')
			{
				switch($p_count)
				{
					case 1;
						//description
						$description = $info->text();
						echo $description."\r\n";
						break;
					case 2;
						//options
						$options = $info->text();
						
						break;
					//case 3;
						//atmosphere, don't care
						//break;
					case 4;
						//hours
						$hours = $info->text();
						echo $hours."\r\n";
						break;
					case 5;
						//more otpions
						$options .= ', '.$info->text();
						$p_count = -1;
						break;
				}
				$p_count++;
			}
		}
		elseif($info->hasClass('member-product-list'))
		{
			$options .= ', '.$info->find('p')->text();
			echo $options."\r\n";
			
		}

	}
	$id = $location->add($title, $description, $address, $hours, $website, $phone);
	echo 'adding location with id '.$id."\r\n";
	$options = explode(',', $options);
	foreach($options as $option)
	{
		$location->add_option($id, trim($option));
	}
	$count++;
	//if($count > 5)
			//exit;
}
echo "\r\n\r\n".$count;
