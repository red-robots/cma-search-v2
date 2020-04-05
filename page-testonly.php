<?php

get_header(); ?>
	
	<div id="primary" class="content-area default-template">
		<main id="main" class="site-main container" role="main">
			
			<?php
			while ( have_posts() ) : the_post();

				get_template_part( 'template-parts/content', 'page' );


			endwhile; // End of the loop.
			?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
