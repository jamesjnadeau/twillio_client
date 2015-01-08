<?php

require $_SERVER['DOCUMENT_ROOT'].'/secret.php';
require $_SERVER['DOCUMENT_ROOT'].'/Purl/Purl.php';
require $_SERVER['DOCUMENT_ROOT'].'/firebase/firebaseLib.php';

//https://www.twilio.com/docs/connect
//add to list of authorized ids
//$_REQUEST['AccountSid'];
//$_REQUEST['state'];
//file_put_contents('log', print_r($_REQUEST, true));

$firebase = new Firebase($GLOBALS['firebase']['url'], $GLOBALS['firebase']['secret']);

$firebase->set('/twilioConnect/'.urlencode($_REQUEST['AccountSid']).'/user_id', $_REQUEST['state']);

header('Location: /');