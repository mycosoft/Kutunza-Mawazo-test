<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package WordPress
 * @subpackage Travlio
 * @since Travlio 1.0
 */
/*
*Template Name: 404 Page
*/
get_header();
$style = '';
$bg_image = travlio_get_config('404_bg_image');
$top_image = travlio_get_config('404_image');
if( isset($bg_image['url']) && !empty($bg_image['url']) ) {
    $style = 'style="background-image:url('. $bg_image['url'] .');"';
}
?>

<section class="page-404" <?php echo trim($style); ?>>
	<div id="main-container" class="inner">
		<div id="main-content" class="main-page">
			<section class="error-404 not-found text-center">
				<div class="inner-page-404">

					<?php if( isset($top_image['url']) && !empty($top_image['url']) ) { ?>
						<div class="img-top">
							<img src="<?php echo esc_url($top_image['url']); ?>" alt="<?php esc_attr_e('Image', 'travlio'); ?>">
						</div>
					<?php } else { ?>
						<div class="img-top">
							<img src="<?php echo esc_url( get_template_directory_uri().'/images/404.png'); ?>" alt="<?php esc_attr_e('Image', 'travlio'); ?>">
						</div>
					<?php } ?>

					<?php
					$title_404 = travlio_get_config('404_title');
					$description_404 = travlio_get_config('404_description');

					if( !empty($description_404) ) { ?>
						<div class="description">
							<?php echo esc_html($description_404); ?>	
						</div>
					<?php } else { ?>
						<div class="description">
							<?php esc_html_e('It looks like nothing was found at this location. Maybe try again?', 'travlio'); ?>	
						</div>
					<?php } ?>

					<a class="btn btn-theme" href="<?php echo esc_url(home_url('/')); ?>"><?php echo esc_html__('Back to Home','travlio') ?></a>

				</div>
			</section><!-- .error-404 -->
		</div><!-- .content-area -->
	</div>
</section>
<?php get_footer(); ?>