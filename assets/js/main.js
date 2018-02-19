jQuery( document ).ready(function() {
    /** Filtro de postagens */
	jQuery('#filter-form-submit').click(function(){
		var filter = jQuery('#filter-form [name=filter]').val();
		
		var filter_query = [];
		jQuery('#filter-form :checked').each(function(index, obj){
			filter_query.push(jQuery(obj).val());
		});
		
		jQuery('#filter-form [name='+ filter +']').val(filter_query.join(','));
		jQuery('#filter-form').submit();
	});
	
	/** Remoção do botão de download do WP Advanced PDF */
	if(jQuery('div a[title="Download PDF"]').length > 0) {
		jQuery('div a[title="Download PDF"]').parent().hide();
	}
});


