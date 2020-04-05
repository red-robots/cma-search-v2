<?php 
if( is_front_page() ) { 
	$hero_type = get_field("hero_type");

	if($hero_type=='video') { 

		$video = get_field("video");
		$video_mp4 = ( isset($video['mp4']) && $video['mp4'] ) ? $video['mp4'] : '';
		$video_ogg = ( isset($video['ogg']) && $video['ogg'] ) ? $video['ogg'] : '';
		$video_webm = ( isset($video['webm']) && $video['webm'] ) ? $video['webm'] : '';
		$overlayType = ( isset($video['overlay_type']) && $video['overlay_type'] ) ? $video['overlay_type'] : '';
		$imagesvg = '';
		$imageType = '';
		if($overlayType=='svg') {
			$imagesvg = ( isset($video['overlay_image_svg']) && $video['overlay_image_svg'] ) ? $video['overlay_image_svg']:'';
		} else {
			$imageType = ( isset($video['overlay_image_png']) && $video['overlay_image_png'] ) ? $video['overlay_image_png']:'';
		}


		if($video_mp4) { ?>
			<div class="video-wrapper pageHero">
				<video id="videoHero" width="800" muted autoplay playsinline loop>
					<source src="<?php echo $video_mp4 ?>" type="video/mp4">
					<?php if ($video_webm) { ?>
					<source src="<?php echo $video_webm ?>" type="video/webm" />
					<?php } ?>
					<?php if ($video_ogg) { ?>
					<source src="<?php echo $video_ogg ?>" type="video/ogg">
					<?php } ?>
					Your browser does not support HTML5 video.
				</video>
				<div id="video-controls" style="display:none;">
				    <button type="button" id="play-pause" class="pause">Play</button>
				</div>
				<?php if ($imagesvg) { ?>
					<?php if (strpos($imagesvg, '<svg') !== false) { ?>
						<div class="image-overlay svg"><div class="ov"><?php echo $imagesvg; ?></div></div>
					<?php } ?>
				<?php } else if($imageType) { ?>
				<div class="image-overlay img"><div class="ov"><img src="<?php echo $imageType['url'] ?>" alt="" aria-hidden="true"></div></div>
				<?php } ?>
			</div>	
		<?php } ?>

	<?php } else { ?>
		
		<?php if( $slides = get_field("image_slides") ) { 
			$count = ($slides) ? count($slides) : 0; 
			$slidesId = ($count>1) ? 'slideshow':'static-banner';
			$placeholder = get_bloginfo("template_url") . "/images/rectangle.png";
			?>

			<div id="<?php echo $slidesId ?>" class="swiper-container banner-wrap cf homepage pageHero">
				<div class="swiper-wrapper">

					<?php foreach ($slides as $img) {
						$caption = $img['caption'];
						$imgSrc = ($img['image']) ? $img['image']['url']:'';
						if($imgSrc) { ?>
	    				<div class="swiper-slide slideItem" style="background-image:url('<?php echo $imgSrc ?>');">
	    					<?php if ($caption) { ?>
	    					<div class="slideCaption">
		    					<div class="slideInside animated">
		    						<div class="slideMid">
			    						<?php if ($caption) { ?>
			    						<h2 class="slideText"><?php echo $caption; ?></h2>	
			    						<?php } ?>
		    						</div>
	    						</div>
	    					</div>
	    					<?php } ?>
	    					<img src="<?php echo $placeholder ?>" alt="" aria-hidden="true" />
	    				</div>
	    				<?php } ?>
	    			<?php } ?>

				</div>

				<?php if ($count>1) { ?>
				    <div class="swiper-pagination"></div>
				    <div class="swiper-button-next"></div>
				    <div class="swiper-button-prev"></div>
				    <div class="customSlideNav">
				    	<a id="slidePrev"><span></span></a>
				    	<a id="slideNext"><span></span></a>
				    </div>
				<?php } ?>
			</div>

		<?php } ?>

	<?php } ?>


<?php } else { 

	$staticBannerImg = get_field("staticBanner");
	$staticBannerText = get_field("staticBannerText");
	$banner_image = get_field("temp_banner_image");
	$banner_text = get_field("temp_banner_text");
	if($banner_image && !$staticBanner) { ?>
	<div class="hero-wrapper">
		<div class="hero-image" style="background-image:url('<?php echo $banner_image['url']; ?>');"></div>
		<?php if ($banner_text) { ?>
		<div class="hero-caption animated fadeIn">
			<div class="caption"><?php echo $banner_text ?></div>
		</div>
		<?php } ?>
	</div>
	<?php } else { ?>
		
		<?php if ($staticBannerImg) { ?>
		<div class="hero-wrapper">
			<div class="hero-image" style="background-image:url('<?php echo $staticBannerImg['url']; ?>');"></div>
			<?php if ($staticBannerText) { ?>
			<div class="hero-caption animated fadeIn">
				<div class="caption"><?php echo $staticBannerText ?></div>
			</div>
			<?php } ?>
		</div>
		<?php } ?>


	<?php } ?>

<?php } ?>