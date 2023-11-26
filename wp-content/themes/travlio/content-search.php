<?php 
global $post;
$thumbsize = 'full';
$thumb = travlio_display_post_thumb($thumbsize);
?>
<article <?php post_class('post post-layout post-list-item'); ?>>
    <div class="list-inner">
        <?php
            if ( !empty($thumb) ) {
                ?>
                <div class="top-image">
                    <div class="date">
                        <?php the_time( get_option('date_format', 'd M, Y') ); ?>
                    </div>
                    <?php
                        echo trim($thumb);
                    ?>
                 </div>
                <?php
            }
        ?>
        <div class="col-content">
            <div class="meta">
                <div class="author">
                    <a href="<?php the_permalink(); ?>">
                        <?php echo get_the_author(); ?>
                    </a>
                </div>
                <div class="comments">
                    <?php comments_number( esc_html__('0 Comments', 'travlio'), esc_html__('1 Comment', 'travlio'), esc_html__('% Comments', 'travlio') ); ?>
                </div>
                <?php travlio_post_categories_first($post); ?>
            </div>
            
            <?php if (get_the_title()) { ?>
                <h4 class="entry-title">
                    <?php if ( is_sticky() && is_home() && ! is_paged() ) : ?>
                        <div class="stick-icon text-theme"><i class="ti-pin2"></i></div>
                    <?php endif; ?>
                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                </h4>
            <?php } ?>
            <div class="description"><?php echo travlio_substring( get_the_excerpt(),35, '...' ); ?></div>
        </div>
    </div>
</article>