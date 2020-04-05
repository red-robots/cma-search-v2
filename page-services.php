<?php
/**
 * Template Name: Services
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package ACStarter
 */

get_header(); ?>

	<div id="primary" class="content-area mt-5 mb-4">
		<main id="main" class="site-main container" role="main">

			<?php
			$wp_query = null;
			//while ( have_posts() ) : the_post();

				get_template_part( 'template-parts/content', 'services' );

				// If comments are open or we have at least one comment, load up the comment template.
				/*if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;
				*/

			//endwhile; // End of the loop.
			?>

		

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();