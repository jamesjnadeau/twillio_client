<?php
/*
 * 
 * 
 * @author James Nadeau
 * @version 1.0 2012-10-20
 * @documentation non
 * 
 * Description
*/
class Location
{

	function __construct()
	{
		
	}
	
	function add($name, $description, $address, $hours, $url, $phone)
	{
		$name = mysql_real_escape_string($name);
		$description = mysql_real_escape_string($description);
		$address = mysql_real_escape_string($address);
		$url = mysql_real_escape_string($url);
		$phone = mysql_real_escape_string($phone);
		$hours = mysql_real_escape_string($hours);
		
		if($address != NULL)
		{//geocode
			list($latitude, $longitude) = geocode($address);
			sleep(2);
		}
		
		$query = "INSERT INTO `location` (`name`, `description`, `address`, `hours`, `latitude`, `longitude`, `url`, `phone`)
					VALUES ('$name', '$description', '$address', '$hours', '$latitude', '$longitude', '$url', '$phone')";
		$result = mysql_query($query) or debug($query);
		return mysql_insert_id();
	}
	
	function add_option($id, $name)
	{
		$id = mysql_real_escape_string($id);
		$name = mysql_real_escape_string(trim(htmlentities($name)));
		//check for $name already
		$query = "SELECT option_id FROM options WHERE name LIKE '$name'";
		$result = mysql_query($query) or debug($query);
		
		if(mysql_num_rows($result))
		{
			//debug("found pre-existing");
			$temp = mysql_fetch_assoc($result);
			$option_id = $temp['option_id'];
		}
		else
		{
			debug('creating option');
			$query = "INSERT INTO `options` (`name`)
				VALUES ('$name');";
			mysql_query($query) or debug($query);
			$option_id = mysql_insert_id();
		}
		
		$query = "INSERT INTO `location_options` (`location_id`, `option_id`)
				VALUES ('$id', '$option_id')";
		$result = mysql_query($query) or debug($query);
	}
	
	function update($id, $name, $description, $address, $latitude, $longitude)
	{
		
	}
	
	function delete()
	{
		
	}
	
	function get($id)
	{
		$id = mysql_real_escape_string($id);
		$query = "SELECT * from location where id = $id";
		debug($query);
		$result = mysql_query($query);
		return mysql_fetch_assoc($result);
	}
	
	function get_options($id)
	{
		$id = mysql_real_escape_string($id);
		$query = "SELECT o.* from location_options lo JOIN options o on o.option_id = lo.option_id where location_id = $id";
		debug($query);
		$info = false;
		$result = mysql_query($query) or debug($query);
		
		while($temp = mysql_fetch_assoc($result))
		{
			$info[] = $temp;
		}
		return $info;
	}
	
	function get_all_options()
	{
		$query = "SELECT * from options ORDER BY name";
		debug($query);
		$info = false;
		$result = mysql_query($query) or debug($query);
		
		while($temp = mysql_fetch_assoc($result))
		{
			$info[] = $temp;
		}
		return $info;
	}
	
	function get_by_options($latitude, $longitude, $option_id, $radius = 10)
	{
		$latitude = mysql_real_escape_string($latitude);
		$longitude = mysql_real_escape_string($longitude);
		$option_id = mysql_real_escape_string($option_id);
		$query = "SELECT location.*, 
						((ACOS(SIN('".$latitude."' * PI() / 180) 
						* SIN(latitude * PI() / 180) + COS('".$latitude."' * PI() / 180) * COS(latitude * PI() / 180) 
						* COS(('".$longitude."' - longitude) * PI() / 180)) * 180 / PI()) * 60 * 1.1515) AS `distance` 
					FROM `location` 
					JOIN location_options on (location_options.location_id = location.id AND option_id = $option_id)
					JOIN options on options.option_id = location_options.option_id
					HAVING `distance` <= '$radius' 
					ORDER BY `distance` ASC
					LIMIT 20
					#GROUP BY location.id";
		$info = false;
		$result = mysql_query($query) or debug($query);
		
		while($temp = mysql_fetch_assoc($result))
		{
			$info[] = $temp;
		}
		return $info;
	}
	
	function search($latitude, $longitude, $radius)
	{
		$latitude = mysql_real_escape_string($latitude);
		$longitude = mysql_real_escape_string($longitude);
		
		$query = "SELECT location.*, 
			#GROUP_CONCAT(options.names), 
						((ACOS(SIN('".$latitude."' * PI() / 180) 
						* SIN(latitude * PI() / 180) + COS('".$latitude."' * PI() / 180) * COS(latitude * PI() / 180) 
						* COS(('".$longitude."' - longitude) * PI() / 180)) * 180 / PI()) * 60 * 1.1515) AS `distance` 
					FROM `location` 
					#LEFT JOIN location_options on location_options.location_id = location.id
					#LEFT JOIN options on options.options_id = location_options.options_id
					HAVING `distance` <= '$radius' 
					ORDER BY `distance` ASC
					LIMIT 20
					#GROUP BY location.id";
		
		$info = false;
		$result = mysql_query($query) or debug($query);
		
		while($temp = mysql_fetch_assoc($result))
		{
			$info[] = $temp;
		}
		return $info;
	}
	
	function geocode_fix($id, $address)
	{
		$id = mysql_real_escape_string($id);
		list($latitude, $longitude) = geocode($address);
		sleep(2);
		$query = "UPDATE location set latitude = '$latitude', longitude = '$longitude' WHERE id = ".$id;
		debug($query);
		mysql_query($query);
	}
}


