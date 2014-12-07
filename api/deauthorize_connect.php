<?php

require $_SERVER['DOCUMENT_ROOT'].'/secret.php';
require $_SERVER['DOCUMENT_ROOT'].'/firebase/firebaseLib.php';

//https://www.twilio.com/docs/connect
//add to list of authorized ids
//$_REQUEST['AccountSid'];
file_put_contents('log', print_r($_REQUEST, true));

$firebase = new Firebase($GLOBALS['firebase']['url'], $GLOBALS['firebase']['secret']);

$firebase.delete('/twilioConnect/'.urlencode($_REQUEST['AccountSid']));