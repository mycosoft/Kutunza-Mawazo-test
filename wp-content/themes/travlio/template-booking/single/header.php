<?php

global $post;

$babe_post = BABE_Post_types::get_post($post->ID);


if ( isset($babe_post['code']) && $babe_post['code'] ) {
	?>
	<div class="singles_item">
		<div class="icon">
			<i class="icofont-qr-code"></i>
		</div>
		<div class="info">
			<h4 class="name"><?php esc_html_e( 'Tour Code', 'travlio' ); ?></h4>
			<div class="value"><?php echo trim($babe_post['code']); ?></div>
		</div>
	</div>
	<?php
}

$times_arr = BABE_Post_types::get_post_av_times($babe_post);
if (!empty($times_arr)){
    ?>
    <div class="singles_item">
		<div class="icon">
			<i class="icofont-stopwatch"></i>
		</div>
		<div class="info">
			<h4 class="name"><?php esc_html_e( 'Start time', 'travlio' ); ?></h4>
			<div class="value"><?php echo implode(', ', $times_arr); ?></div>
		</div>
	</div>
    <?php
}

$duration = BABE_Post_types::get_post_duration($babe_post);
if ( !empty($duration) ) {
?>
	<div class="singles_item">
		<div class="icon">
			<i class="icofont-sand-clock"></i>
		</div>
		<div class="info">
			<h4 class="name"><?php esc_html_e( 'Duration', 'travlio' ); ?></h4>
			<div class="value"><?php echo BABE_Post_types::get_post_duration($babe_post); ?></div>
		</div>
	</div>
<?php
}

if (isset($babe_post['age_restriction']) && $babe_post['age_restriction']){
	?>
	<div class="singles_item">
		<div class="icon">
			<i class="icofont-user-alt-3"></i>
		</div>
		<div class="info">
			<h4 class="name"><?php esc_html_e( 'Age', 'travlio' ); ?></h4>
			<div class="value"><?php echo apply_filters('translate_text', $babe_post['age_restriction']); ?></div>
		</div>
	</div>
	<?php
}

if (isset($babe_post['address']['address']) && $babe_post['address']['address']){
	
	?>
	<div class="singles_item">
		<div class="icon">
			<i class="icofont-island"></i>
		</div>
		<div class="info">
			<h4 class="name"><?php esc_html_e( 'Address', 'travlio' ); ?></h4>
			<div class="value"><a href="<?php echo esc_url( '//maps.google.com/maps?q=' . urlencode( strip_tags( $babe_post['address']['address'] ) ) . '&zoom=14&size=512x512&maptype=roadmap&sensor=false' ); ?>" target="_blank"><?php echo trim($babe_post['address']['address']); ?></a></div>
		</div>
	</div>
	<?php
}

$prices = BABE_Post_types::get_post_price_from($post->ID);   

$price_old = $prices['discount_price_from'] < $prices['price_from'] ? '<span class="tour_info_price_old">' . BABE_Currency::get_currency_price( $prices['price_from'] ) . '</span>' : '';
	
$discount = $prices['discount'] ? '<div class="tour_info_price_discount">-' . $prices['discount'] . '%</div>' : '';

?>
<div class="singles_item">
	<div class="icon">
		<i class="icofont-money-bag"></i>
	</div>
	<div class="info">
		<h4 class="name"><?php esc_html_e( 'Price', 'travlio' ); ?></h4>
		<div class="value">
			<label class="content-light"><?php esc_html_e( 'from', 'travlio' ); ?></label>
			<?php echo trim($price_old); ?>
			<span class="tour_info_price_new"><?php echo trim(BABE_Currency::get_currency_price( $prices['discount_price_from'] )); ?></span>
		   <?php echo trim($discount); ?>
		</div>
	</div>
</div>