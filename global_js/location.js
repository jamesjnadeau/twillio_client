
gps_disabled_message = 'You have denied us access to your location. Please change your device settings to use this feature. If you need assistance please use the "Help" button in the menu.';
gps_missing_message = 'Your browser does not support geolocation services. Please Upgrade your browser to use this feature.';
//from https://github.com/gwilson/getAccurateCurrentPosition/blob/master/geo.js
//with modification
getAccurateCurrentPosition = function (geolocationSuccess, geolocationError, options) 
{
	var lastCheckedPosition;
	var locationEventCount = 0;
	
	var location_semaphore = true;
	
	options = options || {};
	
	var checkLocation = function (position) 
	{
		console.log('checking position');
		lastCheckedPosition = position;
		++locationEventCount;
		// We ignore the first event unless it's the only one received because some devices seem to send a cached
		// location even when maxaimumAge is set to zero
		if ((position.coords.accuracy <= options.desiredAccuracy) && (locationEventCount > 0)) 
		{
			clearTimeout(timerID);
			navigator.geolocation.clearWatch(watchID);
			foundPosition(position);
		} 
		else 
		{
			//geoprogress(position);
			console.log(JSON.stringify(position));
		}
	}
	
	var stopTrying = function () 
	{
		navigator.geolocation.clearWatch(watchID);
		foundPosition(lastCheckedPosition);
	}

	var onError = function (error) 
	{
		clearTimeout(timerID);
		navigator.geolocation.clearWatch(watchID);
		geolocationError(error);
	}
	
	var foundPosition = function (position) 
	{
		if(location_semaphore)
		{
			location_semaphore = false;
			geolocationSuccess(position);
		}
	}
	
	if (!options.maxWait)
		options.maxWait = 3; // Default 10 seconds
	if (!options.desiredAccuracy)    
		options.desiredAccuracy = 20; // Default 20 meters
	if (!options.timeout)
		options.timeout = options.maxWait; // Default to maxWait
	
	options.maximumAge = 0; // Force current locations only
	options.enableHighAccuracy = true; // Force high accuracy (otherwise, why are you using this function?)
	
	var watchID = navigator.geolocation.watchPosition(checkLocation, onError, options);
	var timerID = setTimeout(stopTrying, options.maxWait); // Set a timeout that will abandon the location loop
}

position_accuracy_fails = 0;
position_required_accuracy = 100000;
position_request_time = 0;
position_timeout = 2000;

// this is called when the browser has shown support of navigator.geolocation
function location_accepted(position) 
{
	my_lat_long =  position.coords.latitude + ',' + position.coords.longitude;
	
	console.log(position);
	
	$.mobile.loading( 'hide');
	
	$.mobile.changePage('/', 
	{
		type: "get",
		data: {location_current: my_lat_long, location_accuracy: position.coords.accuracy},
		//dataUrl: redirect_url
	});
	
	/*
	if(position_accuracy_fails > 20)
	{
		$('.loading').hide();
		$('.geolocate_notification').html(
			'GPS accuracy only '  + position.coords.accuracy + ' meters'
			);
		$('.geolocate_notification').removeClass('hidden');
		$('.location_form :submit').removeAttr("disabled");
		//take lat and long and inject in form
		position_request_time = position.timestamp;
		$('.location_current_form').val(my_lat_long);
		$('.location_accuracy_form').val(position.coords.accuracy);
		$('#location_current_link').attr('href', 'http://maps.google.com/?q='+my_lat_long);
		console.log('geolocaiton failed too many times');
	}
	else if(position.coords.accuracy > position_required_accuracy)
	{
		position_accuracy_fails++;
		$('.geolocate_notification').html(
			'Unable to get geolocation accurracy within ' 
			+ position_required_accuracy + ' Meters<br/>'
			+ 'Actual ' + position.coords.accuracy + ', Try' + position_accuracy_fails
			//+ my_lat_long + '<br/>' + position.coords.accuracy
			);
		$('.geolocate_notification').removeClass('hidden');
		setTimeout(mypoint_location_get_position(), position_timeout);
	}
	else
	{
		position_request_time = position.timestamp;
		//take lat and long and inject in form
		$('.location_current_form').val(my_lat_long);
		$('.location_accuracy_form').val(position.coords.accuracy);
		
		//create google maps link
		$('#location_current_link').attr('href', 'http://maps.google.com/?q='+my_lat_long);
		$('.geolocate_notification').hide();
		$('.loading').hide();
		$('.location_form :submit').removeAttr("disabled");
	}
	* */
}

position_declined_error_count = 1;
function location_declined(error) 
{
	$.mobile.loading( 'hide');
	
	console.log(JSON.stringify(error));
	
	if(error.code != 3)
		alert(gps_disabled_message);
}

function mypoint_location_get_position()
{
	navigator.geolocation.getCurrentPosition(location_accepted, location_declined, {enableHighAccuracy:true, maximumAge:1000, timeout:10000});
}

//$(document).ready(function() 
$(document).on('pageshow', function()
{
	console.log('pageshow');
});
