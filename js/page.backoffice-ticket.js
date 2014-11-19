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
	    postData: { 'last_file' : 0, "user_id" : $("#update_mpn_user").val() },
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
		
		if($("#add-response-form").validate().form()) {
			
			$("#add-response-loading").fadeIn('fast', function() {
			    
			    $("#add-response-form").ajaxSubmit({
			    	data: { "action" : "update_ticket" },
				    success: function(response, status, msg, element) {
				    
					    $("#add-response-loading").fadeOut('fast');
					    $("#submit-success").html("Ticket submitted successfully. Page will refresh momentarily.").show(500, function() {
					    	setTimeout(function() { self.location = location.href }, 2000);
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
	$("#add-response-form").validate({
		wrapper: "li",
		errorContainer: "#errors",
		errorLabelContainer: "#errors ul",
		errorElement: 'em',
		errorClass: 'field_error',
		validClass: 'field_valid',
		rules: {
			update_comment: "required"
		},
		
		messages: {
			update_comment: "Enter a comment to update the ticket"
		},
		
		submitHandler: function() {
						
		}
			
	});
	
	
});