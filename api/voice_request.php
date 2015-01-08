<?php
header('Content-type: text/xml');
 
// put a phone number you've verified with Twilio to use as a caller ID number
$callerId = "+18023471430";
 
// put your default Twilio Client name here, for when a phone number isn't given
//$number   = "jenny";
$number = $_REQUEST['From'];
 
// get the phone number from the page request parameters, if given
if (isset($_REQUEST['ClientName'])) {
    $number = htmlspecialchars($_REQUEST['ClientName']);
}
 
// wrap the phone number or client name in the appropriate TwiML verb
// by checking if the number given has only digits and format symbols
if (preg_match("/^[\d\+\-\(\) ]+$/", $number)) {
    $numberOrClient = "<Number>" . $number . "</Number>";
} else {
    $numberOrClient = "<Client>" . $number . "</Client>";
}
file_put_contents('log', print_r($_REQUEST, true));
?>
 
<Response>
	<?/*
	<Say>Calling <?php echo $number; ?></Say>
	<Pause length="2"/>
	<Say>Calling <?php echo $number; ?></Say>
	*/?>
    <Dial callerId="<?php echo $callerId ?>">
          <?php echo $numberOrClient ?>
    </Dial>
</Response>
