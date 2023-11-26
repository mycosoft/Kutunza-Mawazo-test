<?php
/**
 * Page template file.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 */

get_header();

travlio_render_breadcrumbs();
?>
<section id="main-container" class="main-content inner">
	
	<div id="main-content">
		<div id="primary" class="content-area">
			<div id="content" class="site-content detail-tour " role="main">
				<?php
					// Start the Loop.
					while ( have_posts() ) : the_post();
						global $post;
						?>

						<div class="header-detail-tour">
							<?php
								get_template_part( 'template-booking/single/gallery');
							?>

							<header class="tour-entry-header justify-content-center flex-middle-sm clearfix">
								<?php
									get_template_part( 'template-booking/single/header');
								?>
							</header><!-- .entry-header -->

						</div>

						<div class="clearfix <?php echo apply_filters( 'travlio_tour_content_class', 'container' ); ?>">
							<div class="row content-tour-detail">
								<div class="col-xs-12 col-md-8">
									<?php
										get_template_part( 'template-booking/single-tour');

										if ( comments_open() || get_comments_number() ) :
											comments_template('/template-booking/single/comments.php');
										endif;
									?>
								</div>
								<div class="col-xs-12 col-md-4 sidebar-single-tour">
									
									<?php get_template_part( 'template-booking/single/booking-form'); ?>

									<?php if ( is_active_sidebar( 'booking-single-sidebar' ) ): ?>
							   			<?php dynamic_sidebar( 'booking-single-sidebar' ); ?>
							   		<?php endif; ?>
							   	</div>
							   	
							</div>
						</div>

						<?php
						
						
					// End the loop.
					endwhile;
				?>
			</div><!-- #content -->
		</div><!-- #primary -->
	</div>	
		
</section>
<?php get_footer();