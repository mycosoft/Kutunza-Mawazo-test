<?php
global $post;

$thumbsize = !isset($thumbsize) ? 'ba-thumbnail-sq' : $thumbsize;
$image_html = travlio_get_attachment_thumbnail( get_post_thumbnail_id( $post['ID'] ), $thumbsize );
	
$placeholder_url = apply_filters( 'batours_image_url', null, 'placeholder_img.png' );

$item_url = BABE_Functions::get_page_url_with_args($post['ID'], $_GET);

$image = $image_html ? '<a href="' . esc_url($item_url) . '">' . $image_html . '</a>' : '<a href="' . $item_url . '"><img src="' . $placeholder_url . '"></a>';

$babe_post = BABE_Post_types::get_post( $post['ID'] );

$rules_cat = BABE_Booking_Rules::get_rule_by_obj_id($post['ID']);
if ($rules_cat['rules']['basic_booking_period'] == 'single_custom'){
	$date_from_obj = new DateTime( BABE_Calendar_functions::date_to_sql($babe_post['start_date']).' '.$babe_post['start_time']);
	$dates = $date_from_obj->format(get_option('date_format'));
}
?>

<div class="tour-list-v2 tour-item-style">
	
	<div class="inner flex-middle">
		<div class="tour-image">
			<?php echo trim($image); ?>
		</div>
		<div class="tour-content">
			<?php if(!empty($dates)){ ?>
				<div class="date"><i class="ti-calendar"></i><?php echo trim($dates); ?></div>
			<?php } ?>

			<h3 class="title"><a href="<?php echo esc_url( $item_url ); ?>"><?php echo trim($post['post_title']); ?></a></h3>
			<div class="des">
				<?php echo BABE_Post_types::get_post_excerpt( $post,7 ); ?>
			</div>
			<div class="flex-middle bottom-inner">
				<a class="link-check" href="<?php echo esc_url( $item_url ); ?>"><?php esc_html_e('Get Detail','travlio') ?></a>
				<div class="tour_info_price">
					<span class="tour_info_price_new"><?php echo trim(BABE_Currency::get_currency_price( $post['discount_price_from'] )); ?></span>
				</div>
			</div>
		</div>
	</div>

</div>