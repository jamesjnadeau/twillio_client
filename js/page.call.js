$(document).ready(function() {
	
	
	/******************************************
	** STEP 1
	*/
	
	
	// The first page is just two simple text buttons
	// which slide in the next content based on which
	// one the user clicks on. Nothing fancy.

	$("#step1_employee").click(function() {
	
		$("#step1").fadeOut('fast', function() { $("#step2_employee").fadeIn('fast'); });
	
	});
	
	$("#step1_customer").click(function() {
	
		$("#step1").fadeOut('fast', function() {
			
			$("#step2_enduser").fadeIn('fast', function() {
			
				// As soon as the new area has come in,
				// we need to get the list of manufacturers
				// from the data. Then append them.
			
				$.ajax({
					type: "POST",
					url: "includes/inc.call.php",
					data: { "action" : "get_manufacturers" },
					success: function(msg) {
						
						var data = $.parseJSON(msg);
						
						for(var key in data) {
							
							$("#consumer_manu").append('<option value="' + data[key].id + '">' + data[key].name + '</option>');
						
						}
						
					}
				});
		
			});
		
		});
		
	});
	
	
	
	
	/******************************************
	** STEP 2
	*/
	
	
	
	/********************/
	/* EMPLOYEE ACTIONS */
	/********************/
	
	
	
	// DEFINES CLICK ACTIONS FOR SEARCHING FOR A REP
	// OR A DEALER BASED ON NAME OR ZIP CODE
	
	$("#search_zip, #search_name").keyup(function(e) { 
		if(e.keyCode == '13') $("#search_submit").click();
	});
	
	$("#search_submit").live("click", function() { 
	
		var error = 0;
		
		if($("#search_type").val() == "") {
			
			$("#search_type").siblings(".field-icon").fadeIn('fast');
			error++;
		
		} else {
			
			$("#search_type").siblings(".field-icon").fadeOut('fast');
		
			if($("#search_zip").val() == "" && $("#search_name").val() == "") {
				error++;
				$("#search_zip").siblings(".field-icon").fadeIn('fast');
				$("#search_name").siblings(".field-icon").fadeIn('fast');
			
			} else {
				error = 0;
				$("#search_zip").siblings(".field-icon").fadeOut('fast');
				$("#search_name").siblings(".field-icon").fadeOut('fast');
			}
		
		}
		
		if(!error) {
			
			$("#step2_employee .results ol").fadeOut('fast', function() {
				
				$("#step2_employee .ajax-loader").fadeIn('fast');
				
				var zip = $("#search_zip").val();
				var company = $("#search_name").val();
				var type = $("#search_type").val();
				
				$.ajax({
				
					type: "POST",
					url: "includes/inc.call.php",
					data: { "action" : "company_search", "zip" : zip, "company" : company, "type" : type },
					
					success: function(msg) {
						//console.log(msg)
						
						var data = $.parseJSON(msg);
						
						if(data.results == 0) {
							$("#step2_employee .results ol").empty().append('<li class="results-row">No results</li>').fadeIn('fast');
						}
						
						if(data.status) {
							
							$("#step2_employee .results ol").empty();
							
							if(data.dealers) {
								$.each(data.dealers, function(key, dealer) {
									
									if(dealer.is_mpn) var mpn = "(MyPoint Dealer)";
									else var mpn = "";
								
									$("#step2_employee .results ol").append('<li class="results-row" id="' + dealer.id + '"><span class="results-row-name">' + dealer.company + ' <i>' + mpn + '</i></span><span class="results-row-location">' + dealer.city + ', ' + dealer.state + '</li>').fadeIn('fast'); 
								});
							}
							
							if(data.reps) {
								$.each(data.reps, function(key, rep) {
								
									$("#step2_employee .results ol").append('<li class="results-row" id="' + rep.id + '"><span class="results-row-name">' + rep.company + '</span><span class="results-row-location">' + rep.city + ', ' + rep.state + '</li>').fadeIn('fast'); 
								});
							}
							
							if(data.wholesalers) {
								$.each(data.wholesalers, function(key, wholesalers) {
								
									$("#step2_employee .results ol").append('<li class="results-row" id="' + wholesalers.id + '"><span class="results-row-name">' + wholesalers.company + '</span><span class="results-row-location">' + wholesalers.city + ', ' + wholesalers.state + '</li>').fadeIn('fast'); 
								});
							}
						}
											
						$("#step2_employee .ajax-loader").fadeOut('fast');
						
					}
				
				});
				
			});
	
		}
	
	});
	
	
	
	// WHEN YOU CHOOSE A DEALER/REP FROM THE LIST
	// OF RESULTS, HIGHLIGHT THE SELECT BY ADDING
	// A CLASS, AND ALSO SHOW A 'NEXT' BUTTON TO
	// MOVE ON TO STEP 3
	
	$("#step2_employee .results ol li.results-row").live("click", function() {
		
		$("#step2_setDealer").fadeIn();
		
		var dealer_id = $(this).attr("id");
		
		$("#step2_employee .results ol li").each(function() {
			$(this).removeClass("results-row-selected");	
		});
		
		$(this).addClass("results-row-selected");
				
	});
	
	
	
	
	
	// CLICK ACTION FOR 'NEXT' BUTTON THAT PUSHES THE 
	// USER TO STEP 3. WE SET SOME HIDDEN VARIABLES TO
	// USE LATER AND ALSO SET A SESSION VAR VIA AJAX.
	// 
	// FINALLY, WE ALSO FETCH THE LIST OF EMPLOYEES
	// FOR THE COMPANY THE USER JUST CHOSE AND DISPLAY
	// THAT ON THE NEXT PAGE FOR THE USER TO CHOOSE FROM
	
	$("#step2_setDealer").live("click", function() {
	
		var company_id = $("#step2_employee .results ol li.results-row-selected").attr("id");
		var company_type = $("#search_type").val();
		var man_id = $("#man_id option:selected").val();
		if(man_id == "") man_id = -1;
		
		$("#company_type").val( company_type );
		$("#company_id").val( company_id );
				
		if(company_id && company_id > 0) {
			
			$.ajax({
				
				type: "POST",
				url: "includes/inc.call.php",
				data: { "action" : "set_company", "company_id" : company_id, "company_type" : company_type, "man_id" : man_id },
				success: function(msg) {
					// alert(msg);
				}
				
			});
		
			$("#step2_employee").fadeOut('fast', function() {
				
				$("#step3_employee").fadeIn('fast');
				
				var company_type = $("#company_type").val();
				var company_id = $("#company_id").val();
				
				$.ajax({
				
					type: "POST",
					url: "includes/inc.call.php",
					data: { "action" : "employee_search", "company_id" : company_id, "company_type" : company_type },
					success: function(msg) {
						console.log(msg);
						var data = $.parseJSON(msg);
						
						if(data[0].id != 0 && data[0].id != null) {
						
							$.each(data, function(key, emp) {
							
								if(emp.id != "" && emp.fname != "") {
								
									$("#step3_employee .results ol").append('<li class="results-row" id="' + emp.id + '"><span>' + emp.fname + ' ' + emp.lname + ' (' + emp.email + ')</span></li>');
							
								}
							
							});
						
						} else {
						
							$("#step3_employee .results ol").append('<li id="0"><span>No results</span></li>');
						
						}
						
						
					}
				
				});				
				
			});
			
		}
	
	});
	
	
	
	
	
	
	
	
	
	
	/********************/
	/* CONSUMER ACTIONS */
	/********************/
	
	
	
	
	
	
	// CLICK ACTION FOR THE BUTTON TO LOOK UP A
	// DEALER BASED ON NAME ALONE. ONCE THE USER
	// FINDS THE DEALER IN THE LIST AND CLICKS ON
	// IT, WE SET A READ-ONLY FIELD TO THE DEALER ID
	// SO THAT WE CAN USE IT LATER
	
	$("#consumer_dealer").keyup(function(e) { 
		if(e.keyCode == '13') $("#consumer_dealer_lookup").click();
	});
	
	$("#consumer_dealer_lookup").click(function() {
		
		$("#add-consumer-form-wrapper").fadeOut('fast');
		
		$("#step2_enduser #consumer_dealer_loading").fadeIn('fast');
		$("#step2_enduser .results").animate({ "opacity" : "0" }, 500, function() {
		
			var dealer_name = $("#consumer_dealer").val();
			
			$.ajax({
			
				type: "POST",
				url: "includes/inc.call.php",
				data: { "action" : "company_search", "company" : dealer_name, "type" : "dealers" },
				success: function(msg) {
					
					var data = $.parseJSON(msg);
						
					if(data.results == 0) {
						$("#step2_enduser .results ol").empty().append('<li class="results-row">No results</li>').fadeIn('fast');
					}
					
					if(data.status) {
						
						$("#step2_enduser .results ol").empty();
						
						if(data.dealers) {
							$.each(data.dealers, function(key, dealer) {
								
								if(dealer.is_mpn) var mpn = "(MyPoint Dealer)";
								else var mpn = "";
							
								$("#step2_enduser .results ol").append('<li class="results-row results-row-dealer" id="' + dealer.id + '"><span class="results-row-name">' + dealer.company + ' <i>' + mpn + '</i></span><span class="results-row-location">' + dealer.city + ', ' + dealer.state + '</li>').fadeIn('fast'); 
							});
						}
						
					}
										
					$("#step2_enduser .ajax-loader").fadeOut('fast');
					$("#step2_enduser .results").animate({ "opacity" : "1" }, 500);
				
				} 
			
			});
		
		});
		
	});
	
	$("#step2_enduser .results ol li.results-row-dealer").live("click", function() {
		
		var dealer_id = $(this).attr("id");
		var dealer_name = $(this).find('.results-row-name').text();
		
		$("#consumer_dealer").val( $.trim(dealer_name) );
		$("#consumer_dealer_id").val( dealer_id );
		
		$("#step2_enduser .results").animate({ "opacity" : "0"}, 1000, function() {
			$("#step2_enduser .results ol").empty();
		});
				
	});
	
	
	
	
	
	
	
	// CLICK FUNCTION FOR THE BUTTON WHICH WILL LOOK
	// FOR A CONSUMER BASED ON EMAIL AND ZIP CODE. WHEN
	// THE USER SELECTS A RESULT IN THE LIST IT FILLS
	// A READ-ONLY FIELD WITH THE CONSUMER ID
	
	$("#consumer_email, #consumer_zip").keyup(function(e) {
		if(e.keyCode == '13') $("#consumer_person_lookup").click();
	});
	
	$("#consumer_person_lookup").click(function() {
		
		$("#add-consumer-form-wrapper").fadeOut('fast');
		
		var email = $("#consumer_email").val();
		var zip = $("#consumer_zip").val();
		
		if(email == "" && zip == "") { } 
		
		else {
		
			$("#step2_enduser .results").animate({ "opacity" : "0"}, 500, function() {
			
				$("#consumer_person_loading").fadeIn('fast');
				
				$.ajax({
				
					type: "POST",
					url: "includes/inc.call.php",
					data: { "action" : "search_consumers", "zip" : zip, "email" : email },
					success: function(msg) {
						
						var data = $.parseJSON(msg);
						
						$("#step2_enduser .results ol").empty();
						
						$.each(data, function(key, consumer) {
						
							$("#step2_enduser .results ol").append('<li class="results-row results-row-person" id="' + consumer.id + '"><span class="results-row-name">' + consumer.fname + ' ' + consumer.lname + '</span> (<span class="results-row-email">' + consumer.email + '</span>) (<span class="results-row-zip">' + consumer.zip + '</span>)</li>');
						
						});
						
						$("#step2_enduser .results").animate({ "opacity" : "1"}, 500);
						
						$("#consumer_person_loading").fadeOut('fast');
						
					}, 
					error: function(request, status, error) {
						alert("Request: " + request + "\nStatus: " + status + "\nError: " + error);
						$("#consumer_person_loading").fadeOut('fast');
					}
				
				});
				
			});
		
		}
	
	});
	
	$("#step2_enduser .results ol li.results-row-person").live("click", function() {
	
		var consumer_id = $.trim( $(this).attr("id") );
		var consumer_email = $.trim( $(this).find('.results-row-email').text() );
		var consumer_zip = $.trim( $(this).find('.results-row-zip').text() );
		
		$("#consumer_id").val( consumer_id );
		$("#consumer_zip").val( consumer_zip );
		
		$("#step2_enduser .results").animate({ "opacity" : "0"}, 1000, function() {
			$("#step2_enduser .results ol").empty();
		});
	
	});
	
	
	
	
	
	
	
	// DISPLAYS THE FORM FOR ADDING A CONSUMER IF THEY'RE
	// NOT ALREADY IN THE DATABASE
	
	$("#step2_enduser #consumer_person_add").click(function() {
	
		$("#add-consumer-form").resetForm();
		
		$("#consumer_email").val('');
		$("#consumer_zip").val('');
		$("#consumer_id").val('');
	
		$("#step2_enduser .results").animate({ "opacity" : "0" }, 500, function() {
			
			$(this).find('ol').empty();
			
			$("#add-consumer-form-wrapper").fadeIn('slow');	
		
		});
	});
	
	
	
	// HANDLES ERROR CHECKING AND SUBMISSION OF THE
	// ADD CONSUMER FORM
	
	$("#con_new_submit").click(function() {
	
		$("#consumer_new_loading").fadeIn('fast');
	
		if($("#add-consumer-form").validate().form()) {
		
			$("#add-consumer-form").ajaxSubmit({
				target: "#submit-success",
				data: { "action" : "add_consumer" },
				dataType: "json",
				success: function(response, status, msg, element) {
				
					if(response.success) {
						
						$("#consumer_id").val( response.id );
						$("#consumer_email").val( response.email );
						$("#consumer_zip").val( response.zip );
						
						$("#add-consumer-submit-success").text('Successfully Added.').slideDown('fast', function() {
							setTimeout(function() {
								$("#add-consumer-form-wrapper").fadeOut('slow');
							}, 2000);
						});
						
					} else {
					
						//alert("something went wrong");
					
					}
					
					$("#consumer_new_loading").fadeOut('fast');
					
				},
				error: function(request, status, error) {
					
					alert(request + "\n" + status + "\n" + error);
					
				}
			});
		
		} else {
			$("#consumer_new_loading").fadeOut('fast');
		}
		
		return false;
	
	});
	
	
	
	
	// SETS UP VALIDATION FOR THE ADD CONSUMER FORM
	// THE VALIDATE METHOD IS CALLED ABOVE AND ONCE
	// ALL FIELDS ARE VALID IT IS SUBMITTED VIA AJAX
	
	$("#add-consumer-form").validate({
		wrapper: "li",
		errorContainer: "#add-consumer-errors",
		errorLabelContainer: "#add-consumer-errors ul",
		errorElement: 'em',
		errorClass: 'field_error',
		validClass: 'field_valid',
		rules: {
			con_new_fname: "required",
		    con_new_lname: "required",
		    con_new_address: "required",
		    con_new_city: "required",
		    con_new_state: "required",
		    con_new_zip: {
		    	required: true,
		    	number: true
		    },
		    con_new_phone: "required",
		    con_new_email: {
		    	required: true,
		    	email: true
		    }
		},
		
		messages: {
			con_new_fname: "Enter the consumer's first name",
			con_new_lname: "Enter the consumer's last name",
			con_new_address: "Enter the consumer's address",
			con_new_city: "Enter the consumer's city",
			con_new_state: "Choose the consumer's state",
			con_new_zip: {
				required: "Enter the consumer's zip code",
				number: "Enter a valid zip code"
			},
			con_new_phone: "Enter the consumer's phone number",
			con_new_email: {
				required: "Enter the consumer's email address",
				email: "Enter a valid email address"
			}
		},
		
		submitHandler: function() {
						
		}
			
	});
	
	
	
	
	
	
	
	$("#step2_enduser_next").click(function() {
	
		if($("#step2_enduser_form").validate().form()) {
		
			var company_id = $("#consumer_dealer_id").val();
			var consumer_id = $("#consumer_id").val();
			var man_id = $("#consumer_manu").val();
			
			if(company_id == "") company_id = "-1";
			if(man_id == "") man_id = "-1";
		
			// Set session vars and redirect
			$.ajax({
			
				type: "POST",
				url: "includes/inc.call.php",
				data: { "action" : "set_ticket_type", "type" : "consumer", "company_id" : company_id, "company_type" : "dealers", "man_id" : man_id, "consumer_id" : consumer_id },
				success: function(msg) {
					self.location = "add";
				}
			
			});
		
		}
	
	});
	
	$("#step2_enduser_form").validate({
	
		wrapper: "li",
		errorContainer: "#step2_enduser_errors",
		errorLabelContainer: "#step2_enduser_errors ul",
		errorElement: 'em',
		errorClass: 'field_error',
		validClass: 'field_valid',
		rules: {
			consumer_dealer_id: {
				required: function(element) {
					
					if( $("#consumer_newcontact").is(":checked") )
						return false;
					else
						return true
				
				}
			},
			consumer_id: {
				required: true
			},
			consumer_manu: { 
				required: function(element) {
					
					if( $("#consumer_newcontact").is(":checked") )
						return false;
					else
						return true
					
				}
			}
		},
		
		messages: {
			consumer_dealer_id: {
				required: "Associate this consumer with a dealer"
			},
			consumer_id: {
				required: "Either look up the consumer or add them"
			},
			consumer_manu: {
				required: "Associate this consumer with a manufacturer"
			}
		},
		
		submitHandler: function() {
						
		}
	
	});
	
	
	
	
	/******************************************
	** STEP 3
	*/
	
	
	
	
	
	
	
	
	// HANDLES THE CLICK ACTION FOR SELECTING A
	// COMPANY EMPLOYEE. THIS SETS A SESSION VAR
	// VIA AJAX AND THEN REDIRECTS THE USER TO THE
	// ADD TICKET PAGE
	
	$("#step3_employee .results ol li.results-row").live("click", function() {
		
		$("#step3_setEmployee").fadeIn();
		
		var user_id = $(this).attr("id");
		
		$("#step3_employee .results ol li").each(function() {
			$(this).removeClass("results-row-selected");	
		});
		
		$(this).addClass("results-row-selected");
				
	});
	
	$("#step3_setEmployee").live("click", function() {
	
		var emp_id = $("#step3_employee .results ol li.results-row-selected").attr("id");
		
		if(emp_id && emp_id > 0) {
			
			$.ajax({
					
				type: "POST",
				url: "includes/inc.call.php",
				data: { "action" : "set_employee", "emp_id" : emp_id },
				success: function(msg) {
					
					$("#step3_employee").fadeOut('fast');
					self.location = "add";
					
				}
				
			});
		
		}
	
	});
	
	
	
	
	
});
