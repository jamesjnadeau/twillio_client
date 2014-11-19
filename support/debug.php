<?php 
//unset($_SESSION['debug']);

//header("Content-Type: application/javascript"); 
include_once($_SERVER['DOCUMENT_ROOT']."/settings.php");
//include_once $GLOBALS['includes_root']."/global_applications/tickets/add_nested_debug.php";


//<form method="post" action="/support/post.php"> 
?>

<div id="mpn_debug_overlay"></div> 
	
<div id="mpn_debug_form" style="display:none;" class="span-21 last">
	
	<div id="mpn_debug_form_close"  ></div> 
	
	<h1> Debug</h1> 
	<div class="info">
	<a href="/support/db.php" target="_blank" >DB</a>&nbsp;|&nbsp;  
	</div> <hr class="clear"/>
	<div style="overflow:scroll; height:700px"> 
	<?php
	
	
	
	if(isset($_SESSION['debug_db']))
	{
		echo '<h3>debug_db</h3>';
		foreach($_SESSION['debug_db'] as $output)
		{
			echo '<p class="info">'.$output.'</p>';
		}
		unset($_SESSION['debug_db']);
		echo '<hr\>';
	}
	
	if(isset($_SESSION['debug']))
	{
		echo '<h3>debug</h3>';
		$count = 0;
		foreach($_SESSION['debug'] as $output)
		{
			echo '<h4>'.$count.'</h4>';
			$count++;
			/*echo '<p>'.str_replace('
', '
', str_replace("'", "\'", $output)).'</p>';*/
			echo '<p>'.$output.'</p>';
			echo '<hr\>';
		}
		unset($_SESSION['debug']);
	}
	else
		echo '<p class="error" >no debug output</p>';
		
		?> </div>
	</div>
	<hr class="space bottom" />
	<div class="span-21 last">
	</div>

</div>


<script>

$(function() {
	
	//mpn_debug_form();
	mpn_debug_button();
	
	function mpn_debug_check_hide()
	{
		$("#mpn_debug_button").positionForm('vertical-top');
    	$("#mpn_debug_form").positionForm('');
    	if($("#wrapper .container").offset().right <= 57 && $("#mpn_debug_button").css('right') == '-5px')
    	{
    		//$("#mpn_debug_button").animate({ "right" : "+38px"}, 100);
    		$("#mpn_debug_button").hide();
    	}
    	else if($("#wrapper .container").offset().right > 57 && $("#mpn_debug_button").css('right') == '-38px')
    	{
		    $("#mpn_debug_button").show();
    	}
	}
	
	$(document).ready(function() 
	{
		mpn_debug_check_hide();
	});
	
	$(window).resize(function(e)
	{
    	mpn_debug_check_hide();
    });
    $("#mpn_debug_form_close, #mpn_debug_overlay").live('click', function() {
    	var $form = $("#mpn_debug_form");
    	$form.fadeOut('fast', function() {
			$("#mpn_debug_overlay").fadeOut('fast', function() {
				
				$("#mpn_debug_form_subject").val('');
				$("#mpn_debug_form_type option:first").attr('selected', 'selected');
				$("#mpn_debug_errors").empty().hide();
				$("#mpn_debug_form_comments").empty();
				$("#mpn_debug_form_fname").val('');
				$("#mpn_debug_form_lname").val('');
				$("#mpn_debug_form_company").val('');
				$("#mpn_debug_form_email").val('');
				
			});
		});
    });
	
	$("#mpn_debug_submit").live('click', function(e) {
	
		var errors = 0;
		var errorlist = new Array();
		
		if($("#mpn_debug_form_subject").val() == "") 
		{
			errorlist[errors] = "Please enter a subject.";
			errors++;
		}
		
		if($("#mpn_debug_form_fname").val() == "")
		{
			errorlist[errors] = "Please enter your first name.";
			errors++;
		}
		
		if($("#mpn_debug_form_lname").val() == "")
		{
			errorlist[errors] = "Please enter your last name.";
			errors++;
		}
		
		if($("#mpn_debug_form_comments").val() == "")
		{
			errorlist[errors] = "Please describe your issue in the comments area.";
			errors++;
		}
		
		if($("#mpn_debug_form_type option:selected").val() == "")
		{
			errorlist[errors] = "Please select what you are reporting.";
			errors++;
		}
		
		if($("#mpn_debug_form_email").val() == "")
		{
			errorlist[errors] = "Please enter your email address.";
			errors++;
		}
		else
		{
			var pattern = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
			if(pattern.test($("#mpn_debug_form_email").val()) == false)
			{
				errorlist[errors] = "Please enter a valid email address.";
				errors++;
			}
		}
		
		if(errors)
		{
			var $errors = $("#mpn_debug_errors");
			$errors.empty().append('<ul></ul>');
			for(i in errorlist)
			{
				$errors.find("ul").append('<li>'+errorlist[i]+'</li>');
			}
			if($errors.is(":hidden")) 
			{
				$errors.slideDown(function() {
					$("#mpn_debug_form").positionForm('vertical', true);
				});
			}
			else
				$("#mpn_debug_form").positionForm('vertical', true);
			
			e.preventDefault();
			e.stopPropagation();
		
		}
		else
		{
			var $errors = $("#mpn_debug_errors");
			$errors.slideUp(function() {
				$("#mpn_debug_form").positionForm('vertical', true);
			});
		}
		
		
	
	});
	
});

function mpn_debug_button() {

	$('body').append('<div style="display:none" id="mpn_debug_button" class="error">Debug</div>');
	$("#mpn_debug_button").positionForm('vertical-top').css("right", "-5px").fadeIn('slow').live('click', function(e) {
		$("#mpn_debug_overlay").fadeIn('slow');
		
		$("#mpn_debug_form").css('opacity', '0').show().positionForm('').animate({'opacity' : '1'}, 500);
		
	});
	
}

jQuery.fn.positionForm = function (direction, animate) {
	this.css("position","fixed");
    if(direction == "vertical" || direction == "") 
    {
    	if(animate) this.animate({"top": ( $(window).height() - this.height() ) / 2 + "px"}, 200);
    	else this.css("top", ( $(window).height() - this.height() ) / 2 + "px");
    }
    
    if(direction == "vertical-top") 
    {
   		if(animate) this.animate({"top": ( $(window).height() - this.height() ) / 4 + "px"}, 200);
   		else this.css("top", ( $(window).height() - this.height() ) / 4 + "px");
    }
    
    if(direction == "horizontal" || direction == "")
    {
    	if(animate) this.animate({"left": ( $(window).width() - this.width() ) / 2 + "px"}, 200);
    	else this.css("left", ( $(window).width() - this.width() ) / 2 + "px");
    }
    
    return this;
}
</script>
