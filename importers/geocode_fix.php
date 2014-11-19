<?php 

include('../settings.php');
include_once($GLOBALS['includes_root']."/classes/location.class.php");
$location = new Location();


$query = "SELECT * from location where latitude = 0 or latitude is NULL";
debug($query);
$result = mysql_query($query);

while($temp = mysql_fetch_assoc($result))
{
	if($temp['address'] != NULL)
	{
		list($latitude, $longitude) = geocode($temp['address']);
				sleep(2);
		$query = "UPDATE location set latitude = '$latitude', longitude = '$longitude' WHERE id = ".$temp['id'];
		echo $query."\r\n";
		mysql_query($query);
	}
	else
		echo "address = ".$temp['address']."\r\n";
}
