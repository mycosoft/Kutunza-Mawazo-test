<?php
global $post;

$thumbsize = !isset($thumbsize) ? 'travlio-grid-thumbnail' : $thumbsize;
$image_html = travlio_get_attachment_thumbnail( get_post_thumbnail_id( $post['ID'] ), $thumbsize );
	
$placeholder_url = apply_filters( 'batours_image_url', null, 'placeholder_img.png' );

$item_url = BABE_Functions::get_page_url_with_args($post['ID'], $_GET);

$image = $image_html ? '<a href="' . esc_url($item_url) . '">' . $image_html . '</a>' : '<a href="' . $item_url . '"><img src="' . $placeholder_url . '"></a>';

$babe_post = BABE_Post_types::get_post( $post['ID'] );
// echo "<pre>".print_r($babe_post,1); die;

$address = !empty($babe_post['address']['address']) ? $babe_post['address']['address'] : '';

$terms = wp_get_post_terms( $post['ID'], 'categories');
?>

<div class="tour-grid-v5 tour-item-style">
	
	<div class="inner p-relative">
		<div class="tour-image">
			<?php echo trim($image); ?>
		</div>
		<div class="tour-content">
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
		<?php if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){ ?>
			<a class="category btn-theme" href="<?php echo esc_url(get_category_link( $terms[0] )); ?>">
				<?php echo trim($terms[0]->name); ?>
			</a>
		<?php } ?>
	</div>

</div>