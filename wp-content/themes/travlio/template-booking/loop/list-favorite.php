<?php
global $post;

$thumbsize = !isset($thumbsize) ? 'ba-thumbnail-sq' : $thumbsize;
$image_html = travlio_get_attachment_thumbnail( get_post_thumbnail_id( $post['ID'] ), $thumbsize );
	
$placeholder_url = apply_filters( 'batours_image_url', null, 'placeholder_img.png' );

$item_url = BABE_Functions::get_page_url_with_args($post['ID'], $_GET);

$image = $image_html ? '<a href="' . esc_url($item_url) . '">' . $image_html . '</a>' : '<a href="' . $item_url . '"><img src="' . $placeholder_url . '"></a>';


?>

<div id="favorite-listing-<?php echo esc_attr($post['ID']); ?>" class="tour-list-v2 tour-item-style my-favorite-item-wrapper">
	
	<div class="inner flex-middle">
		<div class="tour-image">
			<?php echo trim($image); ?>
			<a href="javascript:void(0);" class="apus-favorite-remove btn-action" data-id="<?php echo esc_attr($post['ID']); ?>"><i class="ti-close"></i></a>
		</div>
		<div class="tour-content">
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