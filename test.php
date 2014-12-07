<?php

require 'secret.php';
require 'Purl/Purl.php';
require 'firebase/firebaseLib.php';

//https://www.twilio.com/docs/connect
//add to list of authorized ids
//$_REQUEST['AccountSid'];
//$_REQUEST['state'];
//file_put_contents('log', print_r($_REQUEST, true));

$firebase = new Firebase($GLOBALS['firebase']['url'], $GLOBALS['firebase']['secret']);

$firebase->set('test/testing', array('this_is'=>'testing this'));