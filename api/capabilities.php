<?php

require $_SERVER['DOCUMENT_ROOT'].'/secret.php';
require $_SERVER['DOCUMENT_ROOT'].'/twilio/Twilio.php';
//file_put_contents('log', print_r($_REQUEST, true));
$capability = new Services_Twilio_Capability($GLOBALS['accountSid'], $GLOBALS['authToken']);
$capability->allowClientOutgoing($GLOBALS['appSid']);
$capability->allowClientIncoming(str_replace(':', '', $_REQUEST['clientName']));
$token = $capability->generateToken();
echo $token;