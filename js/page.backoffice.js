$(document).ready(function() {

	$('#file_upload').uploadify({
		
		swf: 'service/includes/inc.uploadify.swf',
	    uploader: 'service/includes/inc.uploadify.php',
	    cancelImage: 'service/images/uploadify-cancel.png',
	    checkExisting: 'service/includes/inc.uploadify-check-exists.php',
	    auto: true,
	    fileObjName: 'file_upload',
	    buttonClass: "button large green",
	    buttonText: "Select Files",
	    multi: true,
	    queueID: "file-list",
	    queueSizeLimit: 10,
	    removeCompleted: false,
	    requeueErrors   : false,
	    postData: { 'last_file' : 0, "user_id" : $("#mpn_user").val() },
	    onUploadSuccess: function(file,data,response) {
	    	
	    	var data = $.parseJSON(data);
	    	
	    	if($("#file_id").val() == "") {
	    		$("#file_id").val( data.id );
	    	}
	    	
	    	$("#last_file_id").val( data.last );
	    	
	    	$("#file_upload").uploadifySettings('postData', { 'last_file' : data.last, 'user_id' : $("#mpn_user").val() });
	    	
	    	
	    	/*
	    	Debug Vars:
	    	alert("Child: " + data.child + "\n");
	    	alert("File ID: " + data.id + "\n");
	    	alert("User ID: " + data.user_id + "\n");
	    	alert("Last: " + data.last + "\n");
	    	alert("Old Last: " + data.last_old + "\n");
	    	*/
	    	
	    }
	    
	
	});
	
	
	
	$("#submit-form").click(function() {
		
		if($("#add-form").validate().form()) {
			
			$("#add-ticket-loading").fadeIn('fast', function() {
			    
			    $("#add-form").ajaxSubmit({
			    	data: { "action" : "add_ticket" },
				    success: function(response, status, msg, element) {
				    
					    $("#add-ticket-loading").fadeOut('fast');
					    $("#submit-success").html("Ticket submitted successfully. Page will refresh momentarily.").show(500, function() {
					    	setTimeout(function() { self.location = "support.php" }, 2000);
					    });
					    
				    },
				    error: function() {
						alert("something went wrong");
				    }
			    });
			    
			    
			
			});

		}
	
	});
	
	
	// Set up form validation
	$("#add-form").validate({
		wrapper: "li",
		errorContainer: "#errors",
		errorLabelContainer: "#errors ul",
		errorElement: 'em',
		errorClass: 'field_error',
		validClass: 'field_valid',
		rules: {
			subject: "required",
			description: "required",
			type: "required"
		},
		
		messages: {
			subject: "Enter a short descriptive subject for your support ticket",
			description: "Describe the issue in detail",
			type: "Choose a support ticket type"
		},
		
		submitHandler: function() {
						
		}
			
	});
	
	
});