var username = $("#username");
var password = $("#password");
var loader = $("#loading");

$(document).ready(function() {
	
	$("html.js body").fadeIn('fast');
	
	$(username).focus();
	
	$(password).keyup(function(e) {
		
		if(e.keyCode == 13) {
			$(loader).show();
			$(this).blur();
			checkFields();
		}
	
	});
	
	
	
});

function checkFields() {

	if($(username) != "" && $(password) != "") {
		
		
		$.ajax({
		
			type: "POST",
			url: "includes/inc.login.php",
			data: { "action" : "check_login", "username" : $(username).val(), "password" : $(password).val() },
			success: function(msg) {
				
				var data = $.parseJSON(msg);
				
				$(loader).hide();
				
				if(data.status) {
				
					$("#login_form .error").slideUp('fast', function() {
						$("#login_form .success").html(data.message).slideDown('fast', function() {
							setTimeout(loginSuccess, 3000);
						});
					});
					
				} else {
					
					$("#login_form .error").html(data.message).slideDown('fast', function() {
						$(this).delay(4000).slideUp('fast');
					});
					
				}
				
			},
			error: function(request, status, error) {
				//alert(status);
			}
		
		});
		
		
	}

}


function loginSuccess() {
	
	clearTimeout();
	$("body").fadeOut('fast');
	location.href = "dashboard";
	
}