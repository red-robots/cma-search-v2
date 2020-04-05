<?php
/**
 * Template Name: Template 1
 */

get_header(); ?>

	<div id="primary" class="content-area-full cf">
		<?php while ( have_posts() ) : the_post(); ?>

			<h1 class="page-title" style="display:none;"><?php the_title(); ?></h1>
		
			<?php  
			$row1_title = get_field("temp_row1_title");
			$row1_text = get_field("temp_row1_text");
			?>
			<?php if ($row1_title || $row1_text) { ?>
			<section class="temp-row1 cf">
				<div class="wrapper">
					<?php if ($row1_title) { ?>
					<h1 class="cma-title-red fadeInUp wow" data-wow-delay="0.5s"><?php echo $row1_title ?></h1>
					<?php } ?>
					<?php if ($row1_text) { ?>
					<div class="row-text fadeInUp wow" data-wow-delay="0.7s"><?php echo $row1_text ?></div>
					<?php } ?>
				</div>
			</section>
			<?php } ?>

			<?php  
			$temp_rp_title = get_field("temp_rp_title");
			$temp_rp_text = get_field("temp_rp_text");
			$tempButtonName = get_field("temp_rp_ButtonName");
			$tempButtonLink = get_field("temp_rp_ButtonLink");
			?>

			<?php if ($temp_rp_title || $temp_rp_text) { ?>
			<section class="temp-bottom text-center multicolored cf">
				<div class="wrapper">
					<?php if ($temp_rp_title) { ?>
					<h1 class="cma-title-white fadeInUp wow" data-wow-delay="0.5s"><?php echo $temp_rp_title ?></h1>
					<?php } ?>
					<?php if ($temp_rp_text) { ?>
					<div class="text-white fadeInUp wow" data-wow-delay="0.6s"><?php echo $temp_rp_text ?></div>
					<?php } ?>

					<?php if ($tempButtonName && $tempButtonLink) { ?>
					<div class="btndiv fadeIn wow" data-wow-delay="0.65s">
						<a href="<?php echo $tempButtonLink ?>" class="link-white"><?php echo $tempButtonName ?></a>
					</div>
					<?php } ?>
				</div>
			</section>
			<?php } ?>

		<?php endwhile; ?>
	</div><!-- #primary -->
	 
<?php
get_footer();
