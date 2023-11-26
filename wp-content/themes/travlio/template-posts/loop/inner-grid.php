<?php 
global $post;
$thumbsize = !isset($thumbsize) ? travlio_get_config( 'blog_item_thumbsize', 'full' ) : $thumbsize;
$thumb = travlio_display_post_thumb($thumbsize);
?>
<article <?php post_class('post post-layout post-grid'); ?>>
    <div class="list-inner">
        <?php
            if ( !empty($thumb) ) {
                ?>
                <div class="top-image">
                    <?php
                        echo trim($thumb);
                    ?>
                    <?php travlio_post_categories_first($post); ?>
                 </div>
                <?php
            }
        ?>
        <div class="col-content">
            <div class="top-inner">
                <?php if (get_the_title()) { ?>
                    <h4 class="entry-title">
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </h4>
                <?php } ?>
                <div class="description"><?php echo travlio_substring( get_the_excerpt(),12, '' ); ?></div>
            </div>
            <div class="meta-bottom flex-middle">
                <div class="meta-author">
                    <i class="far fa-user"></i>
                    <a href="<?php the_permalink(); ?>">
                        <?php echo get_the_author(); ?>
                    </a>
                </div>
                <div class="comments ali-right"><i class="far fa-comment-dots"></i><?php comments_number( esc_html__('0 Comments', 'travlio'), esc_html__('1 Comment', 'travlio'), esc_html__('% Comments', 'travlio') ); ?>
                </div>
            </div>
        </div>
    </div>
</article>