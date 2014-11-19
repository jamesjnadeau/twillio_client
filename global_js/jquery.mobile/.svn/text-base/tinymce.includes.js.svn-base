//$(document).live( 'pagebeforecreate',function(event)
$(document).on('pageshow', function (event, ui) 
{
	var settings = {
		// Location of TinyMCE script
		//script_url : '/global_js/tinymce_latest/tiny_mce.js',
		
		mode : "textareas",
		selector : "textarea.tinymce",
		
		// General options
		theme : "modern",
		verify_html : true,
		valid_elements : "a[href|target=_blank],strong/b,em/i,strike,u,img[longdesc|usemap|src|border|alt=|title|hspace|vspace|width|height|align],-ol[type|compact],-ul[type|compact],-li,-h1,-h2,-h3,-h4,-h5,-h6,#p", //Documentation at http://tinymce.moxiecode.com/wiki.php/Configuration:valid_elements
		
		menubar: false,
		
		theme_advanced_resizing : true,
		
		width: '100%'
	};
	tinyMCE.init(settings);
	
});

/*
 * this might not be needed.
 * 
//usually, tinymce saves just fine to the form
//but if you are having an issue, add this to the forms onsubmit attribute/
//ex. <form onsubmit="save_tinymce_textareas();" >
function save_tinymce_textareas()
{
	console.log('save_tinymce_textareas');
	for (var i = 0; i < tinymce.editors.length; i++) 
	{
		console.log(tinymce.editors[i]);
		tinymce.editors[i].save();
	}
}
*/
