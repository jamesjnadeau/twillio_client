/*
    @package Fieldset Collapse
    @desc Creates a fieldset that can be expanded or collapsed
    @author Mike Fowler
    @version 1.0
    
*/
       
jQuery.fn.fieldsetCollapse = function(options) {
    
    var defaults = { }
    
    settings = jQuery.extend({}, defaults, options);
    
    return this.each(function() {
	
	var obj = jQuery(this);
	var height = obj.height();
	
	obj.find("legend").addClass('collapsible').click(function() {
	    
	    if (obj.hasClass('collapsed')) {
		
		obj.removeClass('collapsed');
		obj.animate({ "height" : height + "px" }, 300);
		obj.children().not('legend').animate({ "opacity" : "1" }, 500);
		    
	    } else {
		
		obj.addClass('collapsed');
		obj.animate({ "height" : "4px" }, 300);
		obj.children().not('legend').animate({ "opacity" : "0" }, 500);
		
	    }
		
	});
	
    });
    
};