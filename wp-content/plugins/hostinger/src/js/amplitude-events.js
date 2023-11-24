( function ( $ ) {
	$( document ).on( 'ready', function () {
		const nonce = document.getElementById( 'menu_actions_nonce' ).value;
			$('#adminmenu #toplevel_page_hostinger li a').click(function () {
				let action = $(this).attr("href").split('#').pop();

				$.ajax( {
					url: ajaxurl,
					method: 'POST',
					data: {
						action: 'hostinger_menu_action',
						nonce: nonce,
						location: 'side_bar',
						event_action: action
					},
					success: function ( data ) {
					},
					error: function ( xhr, status, error ) {
						console.log( 'AJAX request failed: ' + error );
					}
				} );
			});

		$('.hsr-wrapper__list .hsr-list__item').click(function () {
			let action = $(this).data('name');

			$.ajax( {
				url: ajaxurl,
				method: 'POST',
				data: {
					action: 'hostinger_menu_action',
					nonce: nonce,
					location: 'home_page',
					event_action: action
				},
				success: function ( data ) {
				},
				error: function ( xhr, status, error ) {
					console.log( 'AJAX request failed: ' + error );
				}
			} );
		});

		function sendAjaxRequest(eventAction) {
			$.ajax({
				url: ajaxurl,
				method: 'POST',
				data: {
					action: 'hostinger_regenerate_website',
					nonce: ajax_var.nonce,
					location: 'wordpress',
					event_action: eventAction
				},
				success: function (data) {
					if( eventAction === 'wordpress.ai_regenerate.beta_signup' ) {
						$('.hts-btn-wrapper .hts-response-msg').show();
						$('#hts-notify').removeClass('hts-disabled button--loading');
					}
				},
				error: function (xhr, status, error) {
					$('#hts-notify').removeClass('hts-disabled button--loading');
					console.log('AJAX request failed: ' + error);
				}
			});
		}

		$('.hsr-wrapper__list .hts-ai-website-tab').click(function () {
			sendAjaxRequest('wordpress.ai_regenerate.enter');
		});

		$('#hts-notify').click(function () {
			$('.hts-btn-wrapper .hts-response-msg').hide();
			$(this).addClass('hts-disabled button--loading');
			sendAjaxRequest('wordpress.ai_regenerate.beta_signup');
		});

	} );

} )( jQuery );
