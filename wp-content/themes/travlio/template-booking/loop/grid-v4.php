<?php
global $post;

$thumbsize = !isset($thumbsize) ? 'travlio-grid-thumbnail' : $thumbsize;
$image_html = travlio_get_attachment_thumbnail( get_post_thumbnail_id( $post['ID'] ), $thumbsize );
	
$placeholder_url = apply_filters( 'batours_image_url', null, 'placeholder_img.png' );

$item_url = BABE_Functions::get_page_url_with_args($post['ID'], $_GET);

$image = $image_html ? '<a href="' . esc_url($item_url) . '">' . $image_html . '</a>' : '<a href="' . $item_url . '"><img src="' . $placeholder_url . '"></a>';


$price_old = $post['discount_price_from'] < $post['price_from'] ? '<span class="tour_info_price_old">' . BABE_Currency::get_currency_price( $post['price_from'] ) . '</span>' : '';

$discount = $post['discount'] ? '<div class="tour_info_price_discount">'.esc_html__('Discount ','travlio') . $post['discount'] . '%</div>' : '';

$cat_slug = $unit = '';
$terms = wp_get_post_terms( $post['ID'], 'categories');
if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
	$cat_slug = $terms[0]->slug;

	$rules = BABE_Booking_Rules::get_rule_by_cat_slug($cat_slug);
	if ( !empty($rules) ){
		$units_arr = BABE_Prices::get_rate_units($rules);
	    $unit = $units_arr['unit'];
	}
}
?>

<div class="tour-grid-v4 tour-item-style">
	
	<div class="inner p-relative">
		<?php if( $price_old ){ ?>
			<div class="wrapper-discount">
				<div class="text"><?php echo trim($discount); ?></div>
			</div>
		<?php } ?>
		<div class="tour-image">
			<?php echo trim($image); ?>
		</div>
		<div class="tour-content">
			<h3 class="title"><a href="<?php echo esc_url( $item_url ); ?>"><?php echo trim($post['post_title']); ?></a></h3>
			<div class="tour_info_price">
				<span class="tour_info_price_new"><?php echo trim(BABE_Currency::get_currency_price( $post['discount_price_from'] )); ?></span>
				<span><?php echo esc_html($unit); ?></span>
			</div>
		</div>

	</div>
</div>