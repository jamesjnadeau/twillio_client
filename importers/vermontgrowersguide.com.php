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

$base_url = 'http://www.vermontgrowersguide.com';
$html = curl_load($base_url.'/results/', 'POST', $fields);

require 'QueryPath/QueryPath.php';

$root = htmlqp($html);

$root = $root->find('#content_box .results ul')->find('li');

$count = 0;
foreach($root as $value)
{
	$url = $value->find('a')->attr('href');
	
	$html = curl_load($base_url.str_replace('?', '/?', $url));
	//echo $html."\r\n";
	$temp = htmlqp($html, 'div.results');
	//echo $temp->text();
	$title = $temp->find('h2')->text();
	echo "\t".$title."\r\n";
	
	$info = $temp->top()->find('div.results')->find('p')->html();
	$info = explode('<br />', $info);
	//print_r($info);
	//echo "\t".$info."\r\n";
	$address = trim(strip_tags($info[2]." ".$info[3]));
	echo "\t".$address."\r\n";
	
	$info = $temp->next()->html();
	$info = explode('<br />', $info);
	$phone = $info[1];
	$url = strip_tags($info[2]);
	$email = $info[3];
	echo "\t".$phone.' '.$link.' '.$email."\r\n";
	
	$description = $temp->next()->text();
	
	
	$owner = $temp->top()->find('div.results')->find('p strong')->text();
	echo "\t".$owner."\r\n";
	$id = $location->add($title, $description, $address, $hours, $url, $phone);
	echo 'adding location with id '.$id."\r\n";
	$location->add_option($id, 'Maple Syrup');
	$count++;
	//if($count > 5)
		//exit;
	
}

