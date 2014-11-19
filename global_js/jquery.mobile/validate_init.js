/*
 * jQuery Validate defaults
 */
$(document).ready(function () 
{
	$.validator.setDefaults(
	{
		errorClass: "validate-error",
		errorElement: "div",
		errorPlacement: function(error, element) 
		{
			error.prependTo(element.parent());
		}
	});
});
