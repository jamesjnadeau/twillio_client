$(document).ready(function() {
    
    
    
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

	
	
	
	
	
	
	
	
	// Upon submitting the form, first check it for
	// errors and submit it if there are none, 
	// displaying errors if there are any
	/*
	$("#submit-form").click(function() {
		
			if($("#add-response-form").validate().form()) {
				
				$("#add-response-loading").fadeIn('fast', function() {
				
				// now submit the form
				$("#add-response-form").ajaxSubmit({
					data: { "action" : "add_ticket" },
					success: function(response, status, msg, element) {
					
						var data = $.parseJSON(response);
						
						var row = '<tr style="display:none;">';
						row += '<td class="ticket-child-id">#' + data.id + '</td>';
						row += '<td class="ticket-child-date">' + data.date + '<br />' + data.time + '</td>';
						row += '<td class="ticket-child-user">' + data.name + '</td>';
						row += '<td class="ticket-child-comment">' + data.comment + '</td>';
						row += '<td class="ticket-child-notes">' + data.notes + '</td>';
						row += '<td class="ticket-child-time-logged">' + data.spent + ' (min.)</td>';
						row += '<td class="ticket-child-files">' + data.files + '</td></tr>';
						
						$("#add-response-loading").hide(500, function() {
							$("#update_wrapper").slideUp('fast');
						});
						
						$.scrollTo( $("#update-ticket"), 1000 , {
							onAfter: function() {
								$(row).hide().prependTo('#ticket-children tbody').delay(500).fadeIn(1000);
							}
						});
						
						
						
						
						
					},
					error: function() {
						alert('error');
						$("#add-response-loading").fadeOut('fast');
					}
				});
				
				});
	
			}
			
			return false;
			
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
		    update_type: "required",
		    update_status: "required",
		    update_completion: "required",
		    update_time_spent: "required",
		    update_assignedto: "required",
		    update_duedate: {
		    	required: true
		    },
		    update_time_est_time: "required",
		    update_billable: "required"
		},
		
		messages: {
			update_type: "Ticket type can not be empty",
			update_status: "Ticket status can not be empty",
			update_completion: "Ticket completion can not be empty",
			update_time_spent: "Time spent can not be empty",
			update_assignedto: "Assignee can not be empty",
			update_duedate: {
				required: "Due date can not be blank",
			},
			update_time_est_time: "Estimated time can not be empty",
			update_billable: "Billable can not be blank"
		},
		
		submitHandler: function() {
						
		}
			
	});
	
	
	
	$("#update-ticket").click(function() {
	
		$("#update_time_spent").val('0');
		$("#update_comment").val('');
		$("#update_notes").val('');
		$("#file_id").val('');
		$("#last_file_id").val('');
		
		$("#update_wrapper").show(500, function() {
			$.scrollTo( $("#update_anchor"), 1000 );
		});
	
	});
		
	*/
	
	
	
	
});
