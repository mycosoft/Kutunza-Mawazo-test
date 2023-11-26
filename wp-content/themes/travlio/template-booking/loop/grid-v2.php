<?php
global $post;

$thumbsize = !isset($thumbsize) ? 'travlio-grid-thumbnail' : $thumbsize;

$image_html = travlio_get_attachment_thumbnail( get_post_thumbnail_id( $post['ID'] ), $thumbsize );
	
$placeholder_url = apply_filters( 'batours_image_url', null, 'placeholder_img.png' );

$item_url = BABE_Functions::get_page_url_with_args($post['ID'], $_GET);

$image = $image_html ? '<a href="' . esc_url($item_url) . '">' . $image_html . '</a>' : '<a href="' . $item_url . '"><img src="' . $placeholder_url . '"></a>';


$price_old = $post['discount_price_from'] < $post['price_from'] ? '<span class="tour_info_price_old">' . BABE_Currency::get_currency_price( $post['price_from'] ) . '</span>' : '';

$discount = $post['discount'] ? '<div class="tour_info_price_discount">'.esc_html__('Save ','travlio') . $post['discount'] . '%</div>' : '';

$discount_number = ( $price_old) ? ( $post['price_from'] - $post['discount_price_from'] ) : 0 ;

?>

<div class="tour-grid-v2 tour-item-style">
	
	<div class="inner">
		<div class="tour-image">
			<?php echo trim($image); ?>
		</div>
		<div class="tour-content">

			<?php if( $price_old ){ ?>
				<div class="wrapper-price">
					<div class="price">
						<?php echo trim( '<span class="symbol">'.BABE_Currency::get_currency_symbol().'</span>'.$discount_number ); ?>
					</div>
					<div class="text"><?php echo esc_html__('Discount','travlio') ?></div>
				</div>
			<?php } ?>

			<h3 class="title"><a href="<?php echo esc_url( $item_url ); ?>"><?php echo trim($post['post_title']); ?></a></h3>
			<div class="des">
				<?php echo BABE_Post_types::get_post_excerpt( $post, 12 ); ?>
			</div>
			<div class="tour_info_price">
				<span class="price-label"><?php esc_html_e( 'From ', 'travlio' ); ?></span>
				<span class="tour_info_price_new"><?php echo trim(BABE_Currency::get_currency_price( $post['discount_price_from'] )); ?></span>
			</div>
			<a class="link-check" href="<?php echo esc_url( $item_url ); ?>"><?php echo esc_html__('Check','travlio') ?><i class="fas fa-long-arrow-alt-right"></i></a>
		</div>

	</div>
</div>