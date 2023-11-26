jQuery(document).ready(function($){
	"use strict";
	var travlio_upload;
	var travlio_selector;

	function travlio_add_file(event, selector) {

		var upload = $(".uploaded-file"), frame;
		var $el = $(this);
		travlio_selector = selector;

		event.preventDefault();

		// If the media frame already exists, reopen it.
		if ( travlio_upload ) {
			travlio_upload.open();
			return;
		} else {
			// Create the media frame.
			travlio_upload = wp.media.frames.travlio_upload =  wp.media({
				// Set the title of the modal.
				title: "Select Image",

				// Customize the submit button.
				button: {
					// Set the text of the button.
					text: "Selected",
					// Tell the button not to close the modal, since we're
					// going to refresh the page when the image is selected.
					close: false
				}
			});

			// When an image is selected, run a callback.
			travlio_upload.on( 'select', function() {
				// Grab the selected attachment.
				var attachment = travlio_upload.state().get('selection').first();

				travlio_upload.close();
				travlio_selector.find('.upload_image').val(attachment.attributes.url).change();
				if ( attachment.attributes.type == 'image' ) {
					travlio_selector.find('.travlio_screenshot').empty().hide().prepend('<img src="' + attachment.attributes.url + '">').slideDown('fast');
				}
			});

		}
		// Finally, open the modal.
		travlio_upload.open();
	}

	function travlio_remove_file(selector) {
		selector.find('.travlio_screenshot').slideUp('fast').next().val('').trigger('change');
	}
	
	$('body').on('click', '.travlio_upload_image_action .remove-image', function(event) {
		travlio_remove_file( $(this).parent().parent() );
	});

	$('body').on('click', '.travlio_upload_image_action .add-image', function(event) {
		travlio_add_file(event, $(this).parent().parent());
	});

});