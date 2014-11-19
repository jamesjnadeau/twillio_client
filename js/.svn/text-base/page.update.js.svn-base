$(function() {
	
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