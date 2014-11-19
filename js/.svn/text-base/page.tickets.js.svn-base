$(document).ready(function() {

	/* jQuery Tablesorter Plugin: http://tablesorter.com/docs/ */
	$(".table-sortable").tablesorter({
		
		headers: { 0 : {sorter:false}, 1 : {sorter:false} }		

	});

	$("fieldset.collapsible").fieldsetCollapse();
	
	/* jQuery UI Datepickers */
	
	$(".datepicker").datepicker({
	
		changeMonth: true,
		changeYear: true,
		beforeShow: getDateRange,
		showOtherMonths: true,
		selectOtherMonths: true,
		showAnim: "drop",
		dateFormat: 'yy-mm-dd'
	
	});
	
	$("#filter-reset").click(function(event) {
	
		$("#filter-status").val('!CLOSED');
		$("#filter-type").val('');
		$("#filter-date-start").val('');
		$("#filter-date-end").val('');
		$("#filter-display-count").val('10');
		
		event.preventDefault();	
		
		$("#submit-filters").click();
	
	});
	
	$("#filter-company-type").change(function() {
	
		$("#filter-company-name").parent().animate({"opacity":"0"}, 300);
		
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
				$("#filter-company-name").empty().append('<option value="-1">Choose...</option>' + "\n" + markup);
			    else 
				$("#filter-company-name").empty().append('<option value="-1">No contacts found</option>' + "\n" + markup);
			    
			    $("#filter-company-name").parent().animate({"opacity":"1"}, 300);
			    
			}
			
		    });
		    
		}
	
	});
	
	
	
		
	

});

function getDateRange(input) {

	var min = new Date(2010, 1, 1);
	var dateMin = min;
	var dateMax = new Date(2020, 1, 1);
		
	if(input.id === "filter-date-start") {
	
		if($("#filter-date-end").datepicker("getDate") != null) {
		
			dateMax = $("#filter-date-end").datepicker("getDate"); 
		
		}
	
	} else if(input.id === "filter-date-end") {
	
		if($("#filter-date-start").datepicker("getDate") != null) {	
		
			dateMin = $("#filter-date-start").datepicker("getDate");
		
		}
	
	}
	
	return {
		minDate: dateMin,
		maxDate: dateMax
	};

}