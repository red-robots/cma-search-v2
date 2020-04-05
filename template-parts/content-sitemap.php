<?php
/**
 * Template part for displaying sitemap content in 404.php.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package bellaworks
 */

?>

<article>

	<div class="entry-content" style="color: #333">
		<?php wp_nav_menu( array( 
                                'menu'      => 'Top Menu',
                                'container' => 'ul',                                
                                'menu_class'     => 'sitemap404',
                            )); ?>
	</div><!-- .entry-content -->
	
</article><!-- #post-## -->
