<?php
/**
 * Comments area template file.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 */

if ( class_exists( 'BABE_Post_types' ) ) {
       
$comment_rating_arr = BABE_Rating::get_comment_rating($comment->comment_ID);

$comment_rating = !empty($comment_rating_arr) ? BABE_Rating::comment_stars_rendering($comment->comment_ID) : '';

} else {
    $comment_rating = '';
}


if ( 'pingback' == $comment->comment_type || 'trackback' == $comment->comment_type ) : ?>

    <li id="comment-<?php comment_ID(); ?>" <?php comment_class( 'media' ); ?>>
    <div class="comment-body">
        <?php esc_attr_e( 'Pingback:', 'travlio' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( esc_html__( 'Edit', 'travlio' ), '<span class="edit-link">', '</span>' ); ?>
    </div>

<?php else : ?>

	<li id="comment-<?php comment_ID(); ?>" <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ); ?>>

		<div class="the-comment">
			<?php if(get_avatar($comment, 100)){ ?>
				<div class="avatar">
					<?php echo get_avatar($comment, 100); ?>
					
				</div>
			<?php } ?>
			<div class="comment-box">
				<div class="comment-author meta flex-sm">

					<div class="inner-left">
						<h3 class="name-comment"><?php comment_author(); ?></h3>
						<span class="date">

							<?php if ( '0' == $comment->comment_approved ) : ?>
			                    <?php esc_attr_e( 'Your comment is awaiting moderation.', 'travlio' ); ?>
			                <?php endif; ?>

			                <time datetime="<?php comment_time( 'c' ); ?>">
                                <?php 
                                comment_date();
                                ?>
                            </time>

						</span>
						<?php echo wp_kses_post($comment_rating); ?>
						
					</div>
					<div class="ali-right">
						<div class="flex-middle">
							<?php edit_comment_link(__( 'Edit', 'travlio'), '<span class="edit-link">', '</span>' ); ?>
						</div>
					</div>

				</div>
				<div class="comment-text">
					<?php    
                    call_user_func(implode('_', array('remove', 'filter')), 'get_comment_text', array('BABE_Rating', 'get_comment_text'), 10, 3);                       
                    comment_text(); 
                    
                    add_filter( 'get_comment_text', array( 'BABE_Rating', 'get_comment_text'), 10, 3);
                    ?>
				</div>
			</div>
		</div>

    <?php
endif;