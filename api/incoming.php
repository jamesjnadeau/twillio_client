<?php

require $_SERVER['DOCUMENT_ROOT'].'/secret.php';
require $_SERVER['DOCUMENT_ROOT'].'/twilio/Twilio.php';

$response = new Services_Twilio_Twiml();

require $_SERVER['DOCUMENT_ROOT'].'/secret.php';
require $_SERVER['DOCUMENT_ROOT'].'/Purl/Purl.php';
require $_SERVER['DOCUMENT_ROOT'].'/firebase/firebaseLib.php';

//https://www.twilio.com/docs/connect
//add to list of authorized ids
//$_REQUEST['AccountSid'];
//$_REQUEST['state'];
//file_put_contents('log', print_r($_REQUEST, true));
/*
Array
(
    [AccountSid] => AC8ab92c1b24144865af6472525fe87203
    [ToZip] => 05450
    [FromState] => VT
    [Called] => +18023471430
    [FromCountry] => US
    [CallerCountry] => US
    [CalledZip] => 05450
    [Direction] => inbound
    [FromCity] => BURLINGTON
    [CalledCountry] => US
    [CallerState] => VT
    [CallSid] => CA769fc3e19af379cbe7a66fe503fe1714
    [CalledState] => VT
    [From] => +18027771834
    [CallerZip] => 05468
    [FromZip] => 05468
    [CallStatus] => ringing
    [ToCity] => ENOSBURG FALLS
    [ToState] => VT
    [To] => +18023471430
    [ToCountry] => US
    [CallerCity] => BURLINGTON
    [ApiVersion] => 2010-04-01
    [Caller] => +18027771834
    [CalledCity] => ENOSBURG FALLS
)

 */

$firebase = new Firebase($GLOBALS['firebase']['url'], $GLOBALS['firebase']['secret']);

//$firebase->set('/call/'.urlencode($_REQUEST['AccountSid']).'/user_id', $_REQUEST['state']);


//use phone number 
//$_REQUEST['From']
//to get flow
//
//flow action switch
	//say
		//$response->say('Hello');
		//text
		//recording
		//$response->play('https://api.twilio.com/cowbell.mp3', array("loop" => 5));
	//menu
		//text
		//recording
	//forward(dial)
		//fail option, see https://www.twilio.com/docs/quickstart/php/twiml/connect-call-to-second-person
	//conference
	//pause - allows rings before pickup.
	//hangup

	//redirect
	//reject

	//queue
	//enqueue
	//leave


//set up call to next flow action


//all done
print $response;