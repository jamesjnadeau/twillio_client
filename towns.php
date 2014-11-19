<?php

//include default settings for this location
include_once($_SERVER['DOCUMENT_ROOT']."/settings.php");


//start displaying an html page
include_once($GLOBALS['includes_root']."/global_applications/html_page.php");
app_html_page_header_mobile("Explore all the Great Food VT has to offer");

ob_start();

	echo '<ul data-role="listview" >
		<li class=""><a href="/all_options.php">All Options</a></li>
		<li class=""><a href="/?location_current=44.4758%2C-73.2125">Burlington</a></li>
		<li class=""><a href="/?location_current=43.623570%2C-72.517303">Woodstock</a></li>
		<li class=""><a href="/?location_current=44.2600%2C-72.5758">Montpelier</a></li>
		<li class=""><a href="/?location_current=44.0153%2C-73.1678">Middlebury</a></li>
		<li class=""><a href="/?location_current=42.8783%2C-73.1906">Bennington</a></li>
		<li class=""><a href="/?location_current=42.8508%2C-72.5583">Brattleboro</a></li>
		<li class=""><a href="/?location_current=43.5359%2C-72.7215">Plymouth</a></li>
		<li class=""><a href="/?location_current=44.8099%2C-73.0845">St Albans</a></li>
		<li class=""><a href="/sources.php">Data Sources</a></li>
	</ul>';
	
jqm_page('index', ob_get_clean(), array('data-cache="false"'));

//end the html page
app_html_page_footer();



	

