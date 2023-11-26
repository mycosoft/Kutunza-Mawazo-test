<?php

$post_args = !empty($post_args) ? $post_args : array();

$output = '';
$results = array();

if (!empty($post_args) && isset($post_args['related_items']) && !empty($post_args['related_items'])) {
    
  	$related_arr = BABE_Post_types::get_post_related($post_args);
  
  	?>
  	<div class="tour-detail-related">
        <h2 class="title"><?php esc_html_e('You may like', 'travlio'); ?></h2>
        <div class="inner">
		  	<div class="slick-carousel" data-carousel="slick" data-items="2" data-smallmedium="2" data-extrasmall="1" data-pagination="true" data-nav="false">
		        <?php
		        $i = 1;
		        foreach( $related_arr as $related_post ) {
		            setup_postdata( $GLOBALS['post'] =& $related_post );
		        ?>
		        	<div class="item">
		                <?php get_template_part( 'template-booking/loop/grid' ); ?>
		            </div>    
		        <?php $i++; }
		        wp_reset_postdata();
		        ?>
		    </div>
		</div>
    </div>
  	<?php
}