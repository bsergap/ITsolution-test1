(function($) {
	$('body').on('change', '.data-cell', function(e) {
		if($(this).val() != '' && (
			$(this).val() < 1 || $(this).val() > 99999
		)) $(this).addClass('error');
		else $(this).removeClass('error');
	});
	$('#data-form').submit(function(e) {
		if($(this).find('.error').length > 0) {
			alert("Sorry, you have the bad value!");
			return false;
		}
	});
})(jQuery)
