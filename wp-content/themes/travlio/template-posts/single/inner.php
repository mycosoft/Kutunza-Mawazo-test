<?php
$post_format = get_post_format();
global $post;
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="inner post-layout">

        <?php if(has_post_thumbnail()) { ?>
            <div class="top-image image-detail">
                <?php
                    $thumb = travlio_post_thumbnail();
                    echo trim($thumb);
                ?>
            </div>
        <?php } ?>

    	<div class="entry-content-detail <?php echo esc_attr( (has_post_thumbnail())?'':'no-thumbnail' ); ?>">

            <div class="meta">
                <div>
                    <a href="<?php the_permalink(); ?>">
                        <div class="flex-middle meta-author">
                            <?php echo get_avatar( get_the_author_meta( 'user_email' ),50 ); ?>
                            <div class="inner-right">
                                <?php echo esc_html__('By','travlio') ?>
                                <span class="text-theme"><?php echo get_the_author(); ?></span>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="comments"><i class="far fa-comment-dots"></i><?php comments_number( esc_html__('0 Comments', 'travlio'), esc_html__('1 Comment', 'travlio'), esc_html__('% Comments', 'travlio') ); ?>
                </div>
                <div class="date">
                    <i class="far fa-calendar-check"></i><?php the_time( get_option('date_format', 'd M, Y') ); ?>
                </div>
            </div>

            <?php if (get_the_title()) { ?>
                <h1 class="entry-title">
                    <?php the_title(); ?>
                </h1>
            <?php } ?>

        	<div class="single-info">
                <div class="entry-description">
                    <?php
                        the_content();
                    ?>
                </div><!-- /entry-content -->
        		<?php
        		wp_link_pages( array(
        			'before'      => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'travlio' ) . '</span>',
        			'after'       => '</div>',
        			'link_before' => '<span>',
        			'link_after'  => '</span>',
        			'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', 'travlio' ) . ' </span>%',
        			'separator'   => '',
        		) );
        		?>
                <?php  
                    $posttags = get_the_tags();
                ?>
                <?php if( !empty($posttags) || travlio_get_config('show_blog_social_share', false) ){ ?>
            		<div class="tag-social flex-middle-sm">
                        
            			<?php if( !empty($posttags) ) {
                            travlio_post_tags();
            			} ?>
                        
                        <?php if( travlio_get_config('show_blog_social_share', false) ){ ?>
                            <div class="ali-right">
                                <?php get_template_part( 'template-parts/sharebox' ); ?>
                            </div>
                        <?php } ?>
                        
            		</div>
                <?php } ?>
        	</div>
            
            <?php
                //Previous/next post navigation.
                the_post_navigation( array(
                    'next_text' => '<span class="meta-nav"><i class="flaticon-next-1"></i></span> ' .
                        '<div class="inner">'.
                        '<div class="navi">' . esc_html__( 'Next', 'travlio' ) . '</div>'.
                        '<span class="title-direct">%title</span></div>',
                    'prev_text' => '<span class="meta-nav"><i class="flaticon-left-arrow-2"></i></span> ' .
                        '<div class="inner">'.
                        '<div class="navi"> ' . esc_html__( 'Prev', 'travlio' ) . '</div>'.
                        '<span class="title-direct">%title</span></div>',
                ) );
            ?>

        </div>
    </div>

</article>