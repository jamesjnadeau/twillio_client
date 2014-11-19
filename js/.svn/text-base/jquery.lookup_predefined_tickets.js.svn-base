/**
 * jQuery plugin to fetch state and city name based on a zip code.
 *
 * Usage: Add the .getCityState class to a text area and be sure to include
 * either a span or a disabled textfield with the ID #city_state
 */
 
( function( $ ) {
	
	// Methods
	
	var methods = {
	
		init: function(options) {
			
			var settings = {
				"destination" : '', 
				"show_blank" : false
			};
			
			// Capture $(this) global as a local variable
			var $this = $(this);
			
			// Extend settings with provided options
			if( options ) {
				$.extend(settings, options);
			}
			
			$this.change(function() {
				
				// fill in values to send in ajax call
				var man_ids = $(this).val();
				var zip = settings.zip;
				
				$(settings.destination).empty();
				
				 if(settings.show_blank) 
					$(settings.destination).prepend('<option value="-1">Select</option>');
				
				if(zip != "")
				{				
					// Now we use that array to pass to our ajax function which returns a list of
					// sales reps into our destination select box defined in the settings.
					$.ajax({
						type: "post",
						url: "/global_ajax/ajax.php",
						data: { "action" : "lookup_sales_rep_select_options", "man_ids" : man_ids, "zip" : zip },
						success: function(msg) {
							var data = $.parseJSON(msg);
							if(data.status) {
								//console.log("Status return OK");
								//console.log(msg);
								//console.log(settings.destination);
								$(settings.destination).append(data.value);
							}
						} 
					});
				}
				
			});
		
		}
	
	};

	// Plugin namespace initialization
	
	$.fn.lookup_sales_rep_select_options = function(method) {
	
		if( methods[method] ) {
			return methods[method].apply( this, Array.prototype.slice.call( arguments, 1 ));
		} else if (typeof method === 'object' || !method ) {
			return methods.init.apply( this, arguments );
		} else {
			$.error( 'Method ' + method + ' does not exist on jQuery.get_sales_rep_select_options' );
		}
	
	}

} (jQuery) );
/*example usage in php:
$GLOBALS['site_js_footer']['lookup_sales_rep_select_options'] = "/global_js/jquery/jquery.lookup_sales_rep_select_options.js";
echo '<script type="text/javascript">
$(document).ready(function() {
	$("#admin_message_man_id").lookup_sales_rep_select_options({
		zip: $("#mail_zip").val(),
		destination: "#sales_rep_id"
	});
});
</script>';
*/
