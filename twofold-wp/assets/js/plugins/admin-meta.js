jQuery(document).ready(function($){
	
	// Activate Product Key
	$('.thb-register:not(.disabled)').on("click", function(e){
		var _this = $(this),
				key = $('#thb_product_key').val();
		$.ajax({
			method: 'GET',
			url: _this.data('verify'),
			data: {
				'product_key': key,
				'domain': _this.data('domain')
			},
			beforeSend: function() {
				_this.addClass('disabled');
			},
			error: function(data) {
				_this.removeClass('disabled');
				if (data) {
					var response = $.parseJSON(data.responseText);
					if (response.error_message) {
						$('#thb_error_messages').html('<p>'+response.error_message+'</p>');	
					}
				}
			},
			success: function(data) {
				$.ajax( ajaxurl, {
					method : 'POST',
					data : {
						action: 'thb_update_options',
						key: key,
						expired: 0
					},
					success:function() {
						location.reload();
					}
				});
				
			},
		});
		return false;
	});
	// Remove Product Key
	$('.thb-delete-key').on("click", function(e){
		var _this = $(this);
		$.ajax( ajaxurl, {
			method : 'POST',
			data : {
				action: 'thb_update_options',
				key: '',
				expired: 0
			},
			success:function() {
				location.reload();
			}
		});
		return false;
	});
	// Demo Content Import
	var thb_data = new FormData(),
			thb_once = false;
		
	thb_data.append( 'action', 'ocdi_import_demo_data' );
	thb_data.append( 'security', ocdi.ajax_nonce );
	
	function thb_ajaxCall(thb_data) {
		
		// AJAX call.
		$.ajax({
			method:     'POST',
			url:        ocdi.ajax_url,
			data:       thb_data,
			contentType: false,
			processData: false
		})
		.done( function( response ) {
			if ( 'undefined' !== typeof response.status && 'newAJAX' === response.status ) {
				thb_ajaxCall( thb_data );
			} else if ( 'undefined' !== typeof response.status && 'afterAllImportAJAX' === response.status ) {
				// Fix for data.set and data.delete, which they are not supported in some browsers.
				var newData = new FormData();
				newData.append( 'action', 'ocdi_after_import_data' );
				newData.append( 'security', ocdi.ajax_nonce );
				thb_ajaxCall( newData );
			} else {
				location.reload();
			}
		});
	}
	
	$('.thb-load-demo:not(.disabled)').on("click", function(e){
		var _this = $(this),
				parent = _this.parents('.theme'),
				demo = _this.data('demo');

		parent.addClass('loading');
		$('.thb-load-demo').addClass('disabled').attr('disabled', 'disabled').unbind('click');
		
		thb_data.append( 'selected', demo );
		
		thb_ajaxCall(thb_data);
		
		e.preventDefault();
	});
});