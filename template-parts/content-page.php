<?php
/**
 * Template part for displaying page content in page.php.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package bellaworks
 */

?>
	
<?php 
	$customTitle = get_field("custom_page_title"); 
	$pagetitle = ($customTitle) ? $customTitle : get_the_title();
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<h1 class="entry-title cma-title-red"><?php echo $pagetitle ?></h1>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php
			the_content();
		?>
	</div><!-- .entry-content -->
	
</article><!-- #post-## -->


