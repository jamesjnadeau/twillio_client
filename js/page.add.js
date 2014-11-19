$(document).ready(function() {


	// On page load, get a list of internal RBMG staff and
	// populate a list with it
    get_internal_staff();
    
    
    
    
    
    
    // Upon selecting what type of company this ticket is for
    // display an appropriate list of companies in that category
    
    $("#ticketfor").change(function() {
	
		$("#companycontact").parent().animate({"opacity":"0"}, 300);
		$("#companyselect").parent().animate({"opacity":"0"}, 300);
		
		var val = $(this).find("option:selected").val();
		
		if(val != "") {
		 
		    var markup = "";
		    
		    $.ajax({
			
			type: "POST",
			url: "includes/inc.add.php",
			data: { "action" : "get_companies", "type" : val },
			success: function(msg) {
			    
			    var data = $.parseJSON(msg);
			    for(key in data) {
					
					if(data[key].id != "" && data[key].company != "")
						markup += '<option value="' + data[key].id + '">' + data[key].company + '</option>' + "\n";
			    
			    }
			
			    if(markup != "")
				$("#companyselect").empty().append('<option value="-1">Choose...</option>' + "\n" + markup);
			    else 
				$("#companyselect").empty().append('<option value="-1">No contacts found</option>' + "\n" + markup);
			    
			    $("#companyselect").parent().animate({"opacity":"1"}, 300);
			    
			}
			
		    });
		    
		}
	
    });
    
    
    
    
    
    // Upon selecting a company, get a list of contacts for specified company
    
    $("#companyselect").change(function() {
	
	
		$("#companycontact").parent().animate({"opacity":"0"}, 300);
		
		var id = $(this).find("option:selected").val();
		var type = $("#ticketfor").find("option:selected").val();
		
		if(id != "" && type != "") {
		 
		    var markup = "";
		    
		    $.ajax({
			
			type: "POST",
			url: "includes/inc.add.php",
			data: { "action" : "get_employees", "type" : type, "company" : id  },
			success: function(msg) {
			    
			    var data = $.parseJSON(msg);
			    for(key in data) {
				markup += '<option value="' + data[key].id + '">' + data[key].name + ' (' + data[key].email + ')</option>';
			    }
			    
			    if(markup != "")
					$("#companycontact").empty().append('<option value="">Choose...</option>' + "\n" + markup);
			    else
					$("#companycontact").empty().append('<option value="">No contacts found</option>');
			    
			    $("#companycontact").parent().animate({"opacity":"1"}, 300);
			    
			}
			
		    });
	    
	}
	
    });
    
    
    // Upon submitting the form, first check it for
    // errors and submit it if there are none, 
    // displaying errors if there are any
    
    $("#submit-form").live('click', function() {
		
		if($("#add-form").validate().form()) {
			
			$("#add-ticket-loading").fadeIn('fast', function() {
			    
			    $("#add-form").ajaxSubmit({
				    data: { "action" : "add_ticket" },
				    success: function(response, status, msg, element) {
				    
					    var data = $.parseJSON(response);
					    
					    $("#add-ticket-loading").fadeOut('fast');
					    
					    $("#submit-success").html("Ticket added successfully. Redirecting...").show(500, function() {
					    	setTimeout(function() {
					    		self.location = "ticket_view.php?ticket_id=" + data.ticket_id;
					    	}, 2000);
					    });
					    
				    },
				    error: function() {
					
				    }
			    });
			    
			});

		}
		
		return false;
		
    });
    
    
    
    // Set up datepicker widget for due date field
    
    $(".datepicker").datepicker({
	
		dateFormat: 'yy-mm-dd',
		changeMonth: true,
		changeYear: true,
		minDate: 0,
		defaultDate: 0,
		showOtherMonths: true,
		selectOtherMonths: true,
		showAnim: "drop"
	
	});
	
	$(".datepicker").datepicker("setDate", '0');

	
	
	
	
	
	
	// Set up form validation
	$("#add-form").validate({
		wrapper: "li",
		errorContainer: "#errors",
		errorLabelContainer: "#errors ul",
		errorElement: 'em',
		errorClass: 'field_error',
		validClass: 'field_valid',
		rules: {
			subject: {
				required: true,
				minlength: 10
			},
		    description: {
		    	required: true,
		    	minlength: 10
		    },
		    est_time: {
		    	required: true
		    },
		    time_spent: {
		    	required:true
		    },
		    due_date: {
		    	required: true
		    },
		    type: "required",
		    status: "required",
		    ticketfor: "required",
		    companyselect: "required",
		    companycontact: "required",
		    billable: "required"
		},
		
		messages: {
			subject: {
				required: "Enter a ticket subject",
				minlength: "Enter a ticket subject, greater than 10 characters"
			},
			description: {
				required: "Enter a ticket description",
				minlength: "Enter a description greater than 10 characters"
			},
			est_time: {
				required: "Choose a time estimate for this ticket"
			},
			time_spent: {
				required: "Choose the amount of time that has been spent so far on this ticket"
			},
			due_date: {
				required: "Choose a due date"
			},
			type: "Choose a ticket type",
			status: "Choose a ticket status",
			ticketfor: "Choose a client category",
			companyselect: "Choose a client company",
			companycontact: "Choose a client contact",
			billable: "Choose the billable status"
		},
		
		submitHandler: function() {
						
		}
			
	});
	
	
	
	
	
	
	file_count = 1;
	$("#add_file").click(function(e) {
		file_count++;
		$("#file_uploads").append('<p><label class="label-top inline" for="file_upload_'+file_count+'">File</label><input id="file_upload_'+file_count+'" name="file_upload[]" type="file"><a class="remove_file" href="#"><img src="/service/images/icons/delete.png" alt="" /></a></p>');
		e.preventDefault();
		e.stopPropagation();
	});
	
	$(".remove_file").live('click', function(e) {
		$(this).parent().remove();
		e.preventDefault();
		e.stopPropagation();
	});
	
	
	
	
	
	
});


// Retrieve a list of internal RMBG Staff

function get_internal_staff() {
 
    $.ajax({
	
	type: "POST",
	url: "includes/inc.add.php",
	data: { "action" : "get_internal_staff" },
	success: function(msg) {
	    
	    var data = $.parseJSON(msg);
	    for(key in data) {
		$("#assigned_to").append('<option value="' + data[key].id + '">' + data[key].name + '</option>');
	    }
	    
	}
	
    });
    
}
