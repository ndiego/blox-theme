jQuery(document).on( 'submit', '#search_container form', function() {
    var $form = jQuery(this);
    var $input = $form.find('input[name="s"]');
    var query = $input.val().trim();
    var $content = jQuery('#search_results')
    
    if ( query != "" ) {
		jQuery.ajax({
			type : 'post',
			url : SearchDocumentation.ajaxurl,
			data : {
				action : 'blox_load_search_results',
				query : query
			},
			beforeSend: function() {
				$input.prop('disabled', true);
				$content.addClass('loading');
			},
			success : function( response ) {
				$input.prop('disabled', false);
				$content.removeClass('loading');
				$content.html( response );
			}
		});
    }
    
    return false;
})