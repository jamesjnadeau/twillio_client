<?php

require $_SERVER['DOCUMENT_ROOT'].'/secret.php';
require $_SERVER['DOCUMENT_ROOT'].'/twilio/Twilio.php';
 
$capability = new Services_Twilio_Capability($accountSid, $authToken);
$capability->allowClientOutgoing($appSid);
$capability->allowClientIncoming('jenny');
$token = $capability->generateToken();
echo $token;