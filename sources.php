<?php

//include default settings for this location
include_once($_SERVER['DOCUMENT_ROOT']."/settings.php");


//start displaying an html page
include_once($GLOBALS['includes_root']."/global_applications/html_page.php");
app_html_page_header_mobile("Sources");

ob_start();

	echo '<h2>Data Sources</h2>';
	echo '<div class="span-12" >';
		echo '<ul>';
		echo '<li><h5><a href="nofavt.org" >nofavt.org</a></h5></li>';
		echo '<li><h5><a href="vermontfresh.net" >vermontfresh.net</a></h5></li>';
		echo '<li><h5><a href="vermontgrowerguide.com" >vermontgrowerguide.com</a></h5></li>';
		echo '<li><h5><del><a href="vermontmaple.org" >vermontmaple.org</a></del></h5></li>';
		echo '</ul>';
	echo '</div>';
	
	echo '<div class="span-12 last" >';
		echo '<h2>But they are all html sources?</h2>';
		echo '<h4>Trust me, I know<img src="/images/no.png" width="50px;"/></h4>';
		echo '<p>I spent roughly 10 hours getting them working</p>';
	echo '</div>';
	
	echo '<div class="span-12 " >';
		echo '<h3>You spent all that time and only have <del>4</del> 3 sources?</h3>';
		echo '<h4>I was trying something new! And I learned something.<img src="/images/all.jpg" width="50px;"/></h4>';
		echo '<a class="span-6 first" alt="querypath" href="http://querypath.org/" ><img src="/images/querypath.png" width="200px;"/></a>';
		echo '<h5 class="span-6 last">Differnt than XPath, DOM libraries</h5>';
		echo '<hr class="space" />';
		echo '<p>I also learned that Drupal feeds are confusing and hard to debug under time constraints.</p>';
	echo '</div>';
	
	echo '<div class="span-12 last" >';
		echo '<h3>What else would I have liked to do?</h3>';
		echo '<ul>';
		echo '<li>Images?</li>';
		echo '<li>Port to Drupal Feeds</li>';
		echo '<li>More Sources</li>';
		echo '</ul>';
	echo '</div>';
	
	echo '<h4>Put on Github <a href="https://github.com/jamesjnadeau/hackvt_2012" >https://github.com/jamesjnadeau/hackvt_2012</a></h4>';
jqm_page('sources', ob_get_clean(), array("data-cache='false'"));

//end the html page
app_html_page_footer_mobile();
