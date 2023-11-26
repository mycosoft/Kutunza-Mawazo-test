<?php
global $post;

$thumbsize = !isset($thumbsize) ? 'travlio-grid-thumbnail' : $thumbsize;

$image_html = travlio_get_attachment_thumbnail( get_post_thumbnail_id( $post['ID'] ), $thumbsize );
	
$placeholder_url = apply_filters( 'batours_image_url', null, 'placeholder_img.png' );

$item_url = BABE_Functions::get_page_url_with_args($post['ID'], $_GET);

$image = $image_html ? '<a href="' . esc_url($item_url) . '">' . $image_html . '</a>' : '<a href="' . $item_url . '"><img src="' . $placeholder_url . '"></a>';


$price_old = $post['discount_price_from'] < $post['price_from'] ? '<span class="tour_info_price_old">' . BABE_Currency::get_currency_price( $post['price_from'] ) . '</span>' : '';

$discount = $post['discount'] ? '<div class="tour_info_price_discount">'. $post['discount'] . '% '.esc_html__('Off','travlio').'</div>' : '';


$babe_post = BABE_Post_types::get_post( $post['ID'] );
// echo "<pre>".print_r($babe_post,1); die;

$address = !empty($babe_post['address']['address']) ? $babe_post['address']['address'] : '';
?>

<div class="tour-grid-v3 tour-item-style">
	
	<div class="inner">
		<div class="tour-image">
			<?php echo trim($image); ?>
		</div>
		<div class="tour-content">
			<?php echo trim($discount); ?>
			<div class="flex-middle">
	            <div class="tour-title-wrapper">
	        		<?php echo trim(BABE_Rating::post_stars_rendering( $post['ID'] )); ?>
	               	<h3 class="title"><a href="<?php echo esc_url( $item_url ); ?>"><?php echo trim($post['post_title']); ?></a></h3>
	            	<?php
	            	if ( $address ) {
	            		?>
	            		<div class="tour-address"><i class="ti-location-pin"></i><?php echo esc_attr($address); ?></div>
	            		<?php
	            	}
	            	?>
	            </div>
				
				<div class="ali-right wrapper-price">
					<div class="tour_info_price">
						<?php echo trim($price_old); ?>
						<span class="tour_info_price_new"><?php echo trim(BABE_Currency::get_currency_price( $post['discount_price_from'] )); ?></span>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>