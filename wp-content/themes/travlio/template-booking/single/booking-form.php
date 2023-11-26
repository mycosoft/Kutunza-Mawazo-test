<?php

global $post;

?>
<div class="widget tour-detail-booking_form">
    <h2 class="widget-title"><?php esc_html_e( 'Book this tour', 'travlio' ); ?></h2>
    <div class="front_top_inner">
        <?php echo BABE_html::booking_form($post->ID); ?>
    </div>
</div>