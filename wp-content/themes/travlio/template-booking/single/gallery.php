<?php

global $post;

$babe_post = BABE_Post_types::get_post($post->ID);

$files = isset($babe_post['images']) ? (array)$babe_post['images'] : array();

if ( !BABE_Settings::$settings['unitegallery_remove'] && !empty($files) ) {

	$thumbnail = apply_filters('babe_slider_img_thumbnail', 'travlio-gallery-rectangle');
	$full = apply_filters('babe_slider_img_full', 'full');
	?>

	<div class="property-detail-gallery v1">
	    <div class="slick-carousel" data-carousel="slick" data-items="2" data-smallmedium="2" data-extrasmall="1" data-pagination="false" data-nav="true" data-autoplay="true">
	        
	        <?php
            foreach ( $files as $file ) {
            	$image_full_arr = wp_get_attachment_image_src( $file['image_id'], $full );
        	?>
	        	<div class="item">
	                <a href="<?php echo esc_url( $image_full_arr[0] ); ?>" data-elementor-lightbox-slideshow="travlio-gallery" class="p-popup-image v1">
	                    <?php echo travlio_get_attachment_thumbnail( $file['image_id'], $thumbnail );?>
	                </a>
                </div>
            <?php } ?>
	    </div>
	</div>

	<?php
	
}
