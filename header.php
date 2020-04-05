<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<?php if( is_singular() && pings_open( get_queried_object() )) { ?><link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>"><?php }  ?>	
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0/css/all.min.css">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i|Playfair+Display:400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&display=swap" rel="stylesheet">	
	<?php if( $mapAPI = gmap_api_key() ) { ?><script src="https://maps.googleapis.com/maps/api/js?key=<?php echo $mapAPI ?>"></script><?php } ?>
	<?php wp_head(); ?>
	<script src="https://www.youtube.com/iframe_api"></script>
	<script>var currentURL = '<?php echo get_permalink() ?>';</script>
<?php if( $customScripts = get_field("header_custom_scripts","option") ) { echo $customScripts; } ?>
</head>
<?php
$hero_type = get_field("hero_type");
$custom_class = '';
if($hero_type=='video') {
	$video = get_field("video");
	$custom_class = (isset($video['mp4']) && $video['mp4']) ? 'hasvideo' : '';
}  
?>
<body <?php body_class($custom_class); ?>>
	<div id="page" class="site cf">
		<a class="skip-link sr" href="#content"><?php esc_html_e( 'Skip to content', 'bellaworks' ); ?></a>


		<header id="masthead" class="site-header" role="banner">
		 	<div id="right-full-screen-menu-container" class="custom-top-wrap">
		 		<div class="custom-top">
		 			<div class="wrapper main_menu_top">

		 				<?php if(is_home()) { ?>
		 					<h1 class="logo">
		 						<a href="<?php bloginfo('url'); ?>">
		 							<img src="<?php bloginfo('stylesheet_directory'); ?>/images/logo.png" alt="<?php bloginfo('name'); ?>">
		 						</a>
		 					</h1>
		 				<?php } else { ?>
		 					<div class="logo">
		 						<a href="<?php bloginfo('url'); ?>">
		 							<img src="<?php bloginfo('stylesheet_directory'); ?>/images/logo.png" alt="<?php bloginfo('name'); ?>">
		 						</a>
		 					</div>
		 				<?php } ?>
	
						<div>
							
						</div>
		 				<div class="burger">
		 					<div class="burger_label">Menu</div>
		 					<span></span>
		 				</div>

		 				



		 			</div><!-- wrapper -->
	 				<div class="mobilemenu">		 					
	 					<?php 
	 					wp_nav_menu( array( 
	 						'menu'		=> 'Top Menu',
	 						'container' => 'ul',		 						
	 						'menu_class'     => 'mobilemain',
	 					)); ?>
	 				</div>
		 		</div>

		 		

		 	</div>
		</header><!-- #masthead -->

		<?php get_template_part('template-parts/banner'); ?>

		<div id="content" class="site-content cf">
