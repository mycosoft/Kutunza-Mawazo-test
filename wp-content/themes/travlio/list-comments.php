<?php

$GLOBALS['comment'] = $comment;
$add_below = '';

?>
<li <?php comment_class(); ?> id="comment-<?php comment_ID() ?>">

	<div class="the-comment">
		<?php if(get_avatar($comment, 100)){ ?>
			<div class="avatar">
				<?php echo get_avatar($comment, 100); ?>
			</div>
		<?php } ?>
		<div class="comment-box">
			<div class="comment-author meta flex-sm">
				<div class="inner-left">
					<h3 class="name-comment"><?php echo get_comment_author_link() ?></h3>
					<span class="date"><?php printf(esc_html__('%1$s', 'travlio'), get_comment_date()) ?></span>
				</div>

				<div class="ali-right">
					<?php edit_comment_link(esc_html__('Edit', 'travlio'),'  ','') ?>
					<?php comment_reply_link(array_merge( $args, array( 'reply_text' => esc_html__(' Reply', 'travlio'), 'add_below' => 'comment', 'depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
				</div>
			</div>
			<div class="comment-text">
				<?php if ($comment->comment_approved == '0') : ?>
				<em><?php esc_html_e('Your comment is awaiting moderation.', 'travlio') ?></em>
				<br />
				<?php endif; ?>
				<?php comment_text() ?>
			</div>
		</div>
	</div>
</li>