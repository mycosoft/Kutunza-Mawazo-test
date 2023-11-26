<?php
global $post;

$thumbsize = !isset($thumbsize) ? 'travlio-grid-thumbnail' : $thumbsize;

$image_html = travlio_get_attachment_thumbnail( get_post_thumbnail_id( $post['ID'] ), $thumbsize );
	
$placeholder_url = apply_filters( 'batours_image_url', null, 'placeholder_img.png' );

$item_url = BABE_Functions::get_page_url_with_args($post['ID'], $_GET);

$image = $image_html ? '<a href="' . esc_url($item_url) . '">' . $image_html . '</a>' : '<a href="' . $item_url . '"><img src="' . $placeholder_url . '"></a>';


$price_old = $post['discount_price_from'] < $post['price_from'] ? '<span class="tour_info_price_old">' . BABE_Currency::get_currency_price( $post['price_from'] ) . '</span>' : '';

$discount = $post['discount'] ? '<div class="tour_info_price_discount">'.esc_html__('Save ','travlio') . $post['discount'] . '%</div>' : '';

$babe_post = BABE_Post_types::get_post( $post['ID'] );
$tour_duration = '';
$duration = BABE_Post_types::get_post_duration( $babe_post );
if ( !empty($duration) ) {
	$tour_duration = '<div class="tour-duration"><i class="ti-timer"></i>' . $duration .'</div>';
}

$address = !empty($babe_post['address']['address']) ? $babe_post['address']['address'] : '';
?>

<div class="tour-grid tour-item-style">
	<?php echo trim($discount); ?>
	<div class="inner">
		<div class="tour-image">
			<?php echo trim($image); ?>
		</div>
		<div class="tour-content">
            <div class="tour-title-wrapper">
            	<div class="flex">
	            	<div class="tour-title-inner">
		            	<?php
		            	if ( $address ) {
		            		?>
		            		<div class="tour-address"><i class="ti-location-pin"></i><?php echo esc_attr($address); ?></div>
		            		<?php
		            	}
		            	?>
		               	<h3 class="title"><a href="<?php echo esc_url( $item_url ); ?>"><?php echo trim($post['post_title']); ?></a></h3>
		               	<?php echo trim(BABE_Rating::post_stars_rendering( $post['ID'] )); ?>
	               	</div>

	               	<div class="tour-favorite ali-right">
	               		<?php Travlio_Favorite::display_favorite_btn($post['ID']); ?>
	               	</div>
               	</div>
            </div>
			
			<div class="tour-tags-wrapper flex-middle">
                
				<?php echo trim($tour_duration); ?>
				

				<div class="tour_info_price ali-right">
					<i class="ti-bolt"></i><span class="price-label"><?php esc_html_e( 'From', 'travlio' ); ?></span>
					<?php echo trim($price_old); ?>
					<span class="tour_info_price_new"><?php echo trim(BABE_Currency::get_currency_price( $post['discount_price_from'] )); ?></span>
				</div>
			</div>
		</div>
	</div>
</div>