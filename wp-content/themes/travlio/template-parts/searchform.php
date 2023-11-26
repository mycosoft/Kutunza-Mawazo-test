<div class="apus-search-form">
	<form action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get">
		
		<div class="main-search">
	  		<input type="text" placeholder="<?php esc_attr_e( 'What do you need?', 'travlio' ); ?>" name="s" class="apus-search form-control" autocomplete="off"/>
		</div>
		
		<input type="hidden" name="post_type" value="post">

		<button type="submit" class="btn btn-theme radius-0"><?php esc_html_e('Search', 'travlio'); ?></button>
	</form>
</div>