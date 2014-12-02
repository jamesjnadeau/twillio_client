<?php

require $_SERVER['DOCUMENT_ROOT'].'/secret.php';
require $_SERVER['DOCUMENT_ROOT'].'/twilio/Twilio.php';

$response = new Services_Twilio_Twiml();

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