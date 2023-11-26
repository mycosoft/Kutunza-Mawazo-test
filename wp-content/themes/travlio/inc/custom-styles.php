<?php
if ( !function_exists ('travlio_custom_styles') ) {
	function travlio_custom_styles() {
		global $post;	
		
		ob_start();	
		?>
		
			<?php
				$main_font = travlio_get_config('main_font');
				$main_font_family = isset($main_font['font-family']) ? $main_font['font-family'] : false;
				$main_font_size = isset($main_font['font-size']) ? $main_font['font-size'] : false;
				$main_font_weight = isset($main_font['font-weight']) ? $main_font['font-weight'] : false;
			?>
			<?php if ( $main_font_family ): ?>
				/* Main Font */
				.btn,
				body
				{
					font-family:  <?php echo '\'' . $main_font_family . '\','; ?> sans-serif;
				}
			<?php endif; ?>
			<?php if ( $main_font_size ): ?>
				/* Main Font Size */
				body
				{
					font-size: <?php echo esc_html($main_font_size); ?>;
				}
			<?php endif; ?>
			<?php if ( $main_font_weight ): ?>
				/* Main Font Weight */
				body
				{
					font-weight: <?php echo esc_html($main_font_weight); ?>;
				}
			<?php endif; ?>


			<?php
				$heading_font = travlio_get_config('heading_font');
				$heading_font_family = isset($heading_font['font-family']) ? $heading_font['font-family'] : false;
				$heading_font_weight = isset($heading_font['font-weight']) ? $heading_font['font-weight'] : false;
			?>
			<?php if ( $heading_font_family ): ?>
				/* Heading Font */
				h1, h2, h3, h4, h5, h6
				{
					font-family:  <?php echo '\'' . $heading_font_family . '\','; ?> sans-serif;
				}			
			<?php endif; ?>

			<?php if ( $heading_font_weight ): ?>
				/* Heading Font Weight */
				h1, h2, h3, h4, h5, h6
				{
					font-weight: <?php echo esc_html($heading_font_weight); ?>;
				}			
			<?php endif; ?>


			<?php if ( travlio_get_config('main_color') != "" ) : ?>
				/* seting background main */
				.widget-team .team-image .team-popup-btn,
				.slick-carousel .slick-arrow:hover, .slick-carousel .slick-arrow:focus,
				.babe_price_slider .ui-slider-range,.slick-carousel .slick-arrow,.tour-detail ul li::before,
				.babe-search-filter-terms input[type="radio"]:checked + label::before, .babe-search-filter-terms input[type="checkbox"]:checked + label::before,.tagcloud a:hover, .tagcloud a:focus, .tagcloud a.active,
				.tour-list-v2 .date i,.tour-grid-v4 .wrapper-discount,.babe-search-filter-terms .term_item:hover label::before,
				.add-fix-top,.video-wrapper-inner .popup-video .inner:hover,
				.pagination > span.current, .pagination > a.current, .babe_pager > span.current, .babe_pager > a.current, .pagination-links > span.current, .pagination-links > a.current, .apus-pagination > span.current, .apus-pagination > a.current,
				.pagination > span:focus, .pagination > span:hover, .pagination > a:focus, .pagination > a:hover, .babe_pager > span:focus, .babe_pager > span:hover, .babe_pager > a:focus, .babe_pager > a:hover, .pagination-links > span:focus, .pagination-links > span:hover, .pagination-links > a:focus, .pagination-links > a:hover, .apus-pagination > span:focus, .apus-pagination > span:hover, .apus-pagination > a:focus, .apus-pagination > a:hover,
				.bg-theme
				{				
					background-color: <?php echo esc_html( travlio_get_config('main_color') ) ?>;
				}

				.bg-theme{
					background-color: <?php echo esc_html( travlio_get_config('main_color') ) ?> !important;
				}
				/* setting color */
				.my_account_nav_item_current > a,
				.widget_pages ul li:hover > a, .widget_pages ul li.current-cat-parent > a, .widget_pages ul li.current-cat > a, .widget_nav_menu ul li:hover > a, .widget_nav_menu ul li.current-cat-parent > a, .widget_nav_menu ul li.current-cat > a, .widget_meta ul li:hover > a, .widget_meta ul li.current-cat-parent > a, .widget_meta ul li.current-cat > a, .widget_archive ul li:hover > a, .widget_archive ul li.current-cat-parent > a, .widget_archive ul li.current-cat > a, .widget_recent_entries ul li:hover > a, .widget_recent_entries ul li.current-cat-parent > a, .widget_recent_entries ul li.current-cat > a, .widget_categories ul li:hover > a, .widget_categories ul li.current-cat-parent > a, .widget_categories ul li.current-cat > a,
				.detail-post .entry-tags-list a:hover, .detail-post .entry-tags-list a:focus,.apus-social-share a:hover, .apus-social-share a:active,
				.wp-block-quote::before, blockquote::before,.wp-block-quote cite, blockquote cite,
				.babe-search-filter-terms input[type="radio"]:checked + label, .babe-search-filter-terms input[type="checkbox"]:checked + label,
				.babe-search-filter-terms .term_item:hover,
				.store-app .app-icon,.widget-features-box .features-box-image,
				a:hover, .video-wrapper-inner .popup-video .inner,
				a:focus
				{
					color: <?php echo esc_html( travlio_get_config('main_color') ) ?>;
				}
				.text-theme{
					color: <?php echo esc_html( travlio_get_config('main_color') ) ?> !important;
				}

				/* setting border color*/	
				.tagcloud a:hover, .tagcloud a:focus, .tagcloud a.active,
				.babe_price_slider .ui-slider-handle,
				.border-theme
				{
					border-color: <?php echo esc_html( travlio_get_config('main_color') ) ?> !important;
				}

			<?php endif; ?>

			<?php if ( travlio_get_config('button_color') != "" ) : ?>
				/* seting background main */
				.tour-list-v2 .link-check,
				#search-box .babe-search-form .input-group > div.submit button,
				.btn-theme
				{
					background-color: <?php echo esc_html( travlio_get_config('button_color') ) ?> ;
					border-color: <?php echo esc_html( travlio_get_config('button_color') ) ?> ;
				}
				form#booking_form .submit_group button,				
				.btn-theme.btn-outline{
					border-color: <?php echo esc_html( travlio_get_config('button_color') ) ?> ;
					color: <?php echo esc_html( travlio_get_config('button_color') ) ?> ;
				}
			<?php endif; ?>
			<?php if ( travlio_get_config('button_hover_color') != "" ) : ?>
				/* seting background main */
				form#booking_form .submit_group button:hover,
				form#booking_form .submit_group button:focus,
				.tour-list-v2 .link-check:hover,
				.tour-list-v2 .link-check:focus,
				#search-box .babe-search-form .input-group > div.submit button:hover,
				#search-box .babe-search-form .input-group > div.submit button:focus,
				.btn-theme:hover,.btn-theme:focus,
				.btn-theme.btn-outline:hover, .btn-theme.btn-outline:focus{
					border-color: <?php echo esc_html( travlio_get_config('button_hover_color') ) ?> ;
					background-color: <?php echo esc_html( travlio_get_config('button_hover_color') ) ?> ;
				}
			<?php endif; ?>
	<?php
		$content = ob_get_clean();
		$content = str_replace(array("\r\n", "\r"), "\n", $content);
		$lines = explode("\n", $content);
		$new_lines = array();
		foreach ($lines as $i => $line) {
			if (!empty($line)) {
				$new_lines[] = trim($line);
			}
		}		
		return implode($new_lines);
	}
}