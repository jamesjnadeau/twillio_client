<?php
/*
 * 
 * @package MyPointNow
 * @author James Nadeau
 * @version 1.0 2011-0- 
 * @documentation non
 * 
 * Description
*/
class Change
{

	function __construct()
	{
		if (func_num_args() > 0)
		{//check if there is a function argument
			$arg = func_get_args();
			
			if(is_array($arg[0]))
			{//if it's an array, get it's values into the class
				//parse array and assign them as class variables
				foreach($arg[0] as $key => $value)
				{
					$this->{$key} = $value;
				}
			}
			if(count($arg[0]) == 1)
			{//Not NULL ticket id and only one argument supplied			
				//sanitize data
				$this->CHANGE_id = mysql_real_escape_string($this->CHANGE_id);
			}
		}
	}
	
	function add()
	{
		//$this-> = mysql_real_escape_string();
		
	}
	
	function update()
	{
		
	}
	
	function delete()
	{
		
	}
	
	function get()
	{
		
	}

}

?>
