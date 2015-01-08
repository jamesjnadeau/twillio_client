<?php

require $_SERVER['DOCUMENT_ROOT'].'/secret.php';
require $_SERVER['DOCUMENT_ROOT'].'/twilio/Twilio.php';
$client = new Services_Twilio($GLOBALS['accountSid'], $GLOBALS['authToken']);


foreach ($client->accounts as $account) {
    echo '<pre>'.$account->friendly_name.'
	'.$account->uri.'
	'.$account->auth_token.'
	'.$account->OwnerAccountSid.'
	</pre>';
}
