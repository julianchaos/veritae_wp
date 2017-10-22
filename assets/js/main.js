jQuery( document ).ready(function() {
    /** Filtro de postagens */
	jQuery('#tipo-submit').click(function(){
		var tipo = [];
		jQuery('#tipo-form :checked').each(function(index, obj){
			tipo.push(jQuery(obj).val());
		});
		
		jQuery('#tipo-form [name=tipo]').val(tipo.join(','));
		jQuery('#tipo-form').submit();
	});
	
	/** Remoção do botão de download do WP Advanced PDF */
	if(jQuery('div a[title="Download PDF"]').length > 0) {
		jQuery('div a[title="Download PDF"]').parent().hide();
	}
});


