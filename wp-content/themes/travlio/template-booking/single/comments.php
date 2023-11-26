<?php
/**
 * Comments area template file.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 */


if ( post_password_required() ) {
	
	return;
}

?>
<div id="comments" class="comments-area">

	<?php
	if ( have_comments() ) :
		?>
		<h2 class="comments-title">
			<?php
			$comment_count = get_comments_number();
			if ( '1' === $comment_count ) {
				
				printf(
					esc_html__( 'One review', 'travlio' )
				);
				
			} else {
				
				printf( // WPCS: XSS OK.
					esc_html( _nx( '%1$s review', '%1$s reviews', $comment_count, 'multiple_comments_title', 'travlio' ) ),
					number_format_i18n( $comment_count )
				);
			}
			?>
		</h2><!-- .comments-title -->

		<?php
		the_comments_navigation( array(
			'prev_text'          => esc_html__( 'Older reviews', 'travlio' ),
			'next_text'          => esc_html__( 'Newer reviews', 'travlio' ),
			'screen_reader_text' => esc_html__( 'Continue reading', 'travlio' ),
		) );
		?>

		<ul class="comment-list">
			<?php
			wp_list_comments( array(
				'short_ping' => true,
                'callback' => 'travlio_tour_comments',
                'avatar_size' => 96,
			) );
			?>
		</ul><!-- .comment-list -->

		<?php
		the_comments_navigation( array(
			'prev_text'          => esc_html__( 'Older reviews', 'travlio' ),
			'next_text'          => esc_html__( 'Newer reviews', 'travlio' ),
			'screen_reader_text' => esc_html__( 'Continue reading', 'travlio' ),
		) );

		if ( ! comments_open() ) :
			?>
			<p class="no-comments"><?php esc_html_e( 'Reviews are closed.', 'travlio' ); ?></p>
			<?php
		endif;

	endif;

	$aria_req = ( $req ? " aria-required='true'" : '' );
	$comment_args = array(
        'title_reply'       => esc_html__( 'Leave a Review', 'travlio' ),
  		'title_reply_to'    => esc_html__( 'Leave a Review', 'travlio' ),
  		'cancel_reply_link' => esc_html__( 'Cancel Review', 'travlio' ),
  		'label_submit'      => esc_html__( 'Submit Review', 'travlio' ),

        'comment_field' => '<div class="form-group space-comment">
                                <textarea rows="7" placeholder="'.esc_attr__('Your Review', 'travlio').'" id="comment" class="form-control"  name="comment"'.$aria_req.'></textarea>
                            </div>',
        'fields' => apply_filters(
        	'comment_form_default_fields',
        		array(
                    'author' => '<div class="row"><div class="col-sm-6 col-xs-12"><div class="form-group ">
                                <input type="text" name="author" placeholder="'.esc_attr__('Name*', 'travlio').'" class="form-control" id="author" value="' . esc_attr( $commenter['comment_author'] ) . '" ' . $aria_req . ' />
                                </div></div>',
                    'email' => ' <div class="col-sm-6 col-xs-12"><div class="form-group ">
                                <input id="email"  name="email" placeholder="'.esc_attr__('Email*', 'travlio').'" class="form-control" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" ' . $aria_req . ' />
                                </div></div></div>',
                )
			),
			'comment_notes_before' => '<div class="form-group h-info">'.esc_html__('Your email address will not be published.','travlio').'</div>',
			'comment_notes_after' => '',
        );


	travlio_comment_form($comment_args);
	?>

</div><!-- #comments -->