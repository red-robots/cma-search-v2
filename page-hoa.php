<?php
/**
 * Template Name: HOAs
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package ACStarter
 */

get_header(); ?>

	<div class="mb-5 top-header-image">
      <?php if(has_post_thumbnail()) {
        $featured_image     = wp_get_attachment_url( get_post_thumbnail_id( get_the_ID() ) );
        $header_image_text  = get_field('row_1_image_header_text');
        ?>

        <?php if ($featured_image) { ?>
        <div class="hero-wrapper m80">
          <div class="hero-image" style="background-image:url('<?php echo $featured_image; ?>');"></div>
          <?php if ($header_image_text) { ?>
          <div class="hero-caption animated fadeIn">
            <div class="caption"><?php echo $header_image_text ?></div>
          </div>
          <?php } ?>
        </div>
        <?php } ?>

      <?php } ?>
  </div>

    <!-- 1st row -->
    <?php
    $row1_title     = get_field('row_1_title');
    $row1_text      = get_field('row_1_text');  
    if($row1_title || $row1_text) { ?>
    <div class="row-1 mb-5 justify-content-center">
      <div class="col-md-7 text-center" style="margin: 0 auto;">

        <?php if ($row1_title) { ?>
      	<div class="fadeIn wow" data-wow-delay="0.5s">
      		<h1 class="cma-title-red"><?php echo $row1_title; ?></h1>
      	</div>
        <?php } ?>

        <?php if ($row1_text) { ?>
          <div class="fadeInUp wow" data-wow-delay="0.7s">
            <?php echo $row1_text; ?>
          </div>
        <?php } ?>
        
      </div>      
    </div>
    <?php } ?>


  <!-- 2nd row -->
  <?php
    $row_2_title     = get_field('row_2_title');
    $row_2_text      = get_field('row_2_text');        
  ?>
  <?php if ($row_2_title || $row_2_text) { ?>
  <div class="row-two-section row-2 cf">
    <div class=" cma-main-body">

      <?php if ($row_2_title) { ?>
      <div class="justify-content-center">
        <div class="mb-2 mt-4 col-md-7" style="margin: 0 auto;" >
          <div class="fadeIn wow" data-wow-delay=".8s">
            <h1  class="text-center">
              <?php echo $row_2_title; ?>
            </h1>
          </div>
        </div>
      </div>
      <?php } ?>
      
      <div class="container">
        <div class="row">
          <div class="col-md-7 cma-center text-center">
              <div class="fadeInUp wow" data-wow-delay=".8s">
                  <?php echo ($row_2_text) ? $row_2_text : '';  ?>
              </div>
          </div>
        </div> <!-- row -->
      </div> <!-- container -->

    </div>
  </div>
  <?php } ?>

  <!-- 3rd row -->
  <?php  
  	$row_3_image_text = get_field('row_3_image_header_text');
    $row_3_image     = get_field('row_3_image');
  	$row_3_text      = get_field('row_3_text');
  	$row_3_offers    = get_field('row_3_offers');
  ?>
  
  <?php if ($row_3_image_text || $row_3_image) { ?>
  <div class="text-center header_image_section fadeIn wow" data-wow-delay="0.5s">    
      <div class="featured_image " style="background-image: url('<?php echo $row_3_image['url'];  ?>');" >       
      </div>     
      <div class="header_image_text fadeIn wow" data-wow-delay="0.7s">
        <h1 class=" align-middle">
          <?php echo ($row_3_image_text) ? $row_3_image_text : '';  ?>
        </h1> 
      </div>      
  </div>
  <?php } ?>

  
  <?php if ($row_3_text || $row_3_offers) { ?>
  <div class=" mb-5">
    <div class="container text-center">
      <div class="justify-content-center">
        
        <div class="col-md-8 cma-center pt-5">          
          <div class="cma-paragraph-normal fadeInUp wow" data-wow-delay="0.5s">
            <?php echo ($row_3_text) ? $row_3_text : '';  ?> 
          </div>
          <div class="row pt-4 ">
			<?php if($row_3_offers): $x = 0; ?>
				<?php foreach($row_3_offers as $offers): ?>
					<?php
						$x++;
						$offer_icon 	= $offers['offer_image'];
						$offer_title 	= $offers['offer_title'];
						$offer_text 	= $offers['offer_text'];
					?>
			          <div class="col-sm-4 fadeInUp wow" data-wow-delay="<?php echo ($x / 5) . 's'; ?>">
			            <div class="cma-icon-holder">
			            	<?php if($offer_icon): ?>
			              		<img src="<?php echo $offer_icon['url']; ?>" alt="">
			          		<?php endif; ?>
			            </div>
			            <div class="cma-sub-title ">
			              <?php echo ($offer_title) ? $offer_title : ''; ?>
			            </div>
			            <p class="cma-paragraph-normal">
			              <?php echo ($offer_text) ? $offer_text : ''; ?>
			            </p>
			          </div>
	          	<?php endforeach; ?>
	      	<?php endif; ?>

			

        </div>

          

        </div>



      </div>
      
    </div>
  </div>
  <?php } ?>

  <!-- 4th row -->
  <?php
  	$row_4_title 		= get_field('row_4_title');
  	$row_4_text 		= get_field('row_4_text');
  	$row_4_services 	= get_field('row_4_services');
  ?>

  <?php if ($row_4_title || $row_4_text || $row_4_services) { ?>
  <div class="cma-bg-red">
    <div class=" cma-bg-red ">

      <?php if ($row_4_title) { ?>
      <div class="justify-content-center">
        <div class="col-md-8 mb-4 mt-4" style="margin: 0 auto">
        	<div class="fadeIn wow" data-wow-delay="0.7s">
        		<h1  class="text-center"><?php echo $row_4_title ?></h1>
        	</div>
        </div>
      </div>
      <?php } ?>
      
      <div class="container">
        <div class="contentInner cf">
        
          <?php if ($row_4_text) { ?>
          <div class="col-md-10 cma-center text-center ">
              <div class="fadeInUp wow" data-wow-delay="1s">
                <?php echo $row_4_text ?>
              </div>
          </div>
          <?php } ?>
        
          <?php if($row_4_services) { ?> 
          <div class="row_images  mt-4 col-md-10 " style="margin: 0 auto;">
            <div class="row">
					   <?php $x = 0; foreach($row_4_services as $service) { ?>
  						<?php
  							$x++;
  							$service_icon 	= $service['service_image'];
  							$service_title 	= $service['service_title'];
  						?>
              <div class="col-md-3 mb-5 col-6 fadeInUp wow" data-wow-delay="<?php echo ($x / 5) . 's'; ?>">
                <div class="text-center">
                	<?php if($service_icon): ?>
                  		<img src="<?php echo $service_icon['url']; ?>" alt="" class="img-circle">
                  	<?php endif; ?>
                  <div class="mt-2">
                    <span class="font-weight-bold service-title"><?php echo ($service_title) ? $service_title : ''; ?></span>
                  </div>
                </div>
              </div> <!-- col-md-3 -->
		          <?php } ?>
            </div>
          </div> <!-- row -->
          <?php } ?>

        </div> 
      </div> <!-- container -->
      


    </div>
  </div>
  <?php } ?>

  <!-- 5th row -->
  <?php
  	$row_5_title 		= get_field('row_5_title');
  	$row_5_text 		= get_field('row_5_text');
  	$row_5_monitoring 	= get_field('row_5_monitoring');
  ?>

  <?php if ($row_5_title || $row_5_text) { ?>
  <div class="row-5" id="why_cma">
    <div class="container text-center">
      <div class="col-md-8 cma-center">
      	
        <?php if ($row_5_title) { ?>
        <div class="fadeIn wow" data-wow-delay="0.7s">
          <h1 class="cma-title-red"><?php echo $row_5_title ?></h1>
        </div>
        <?php } ?>

        <?php if ($row_5_text) { ?>
        <div class="mt-4 mb-4 fadeInUp wow" data-wow-delay="0.8s">
          <p class="cma-paragraph-why"><?php echo $row_5_text ?></p>
        </div>
        <?php } ?>
        
      </div>

		<?php if($row_5_monitoring):  $x = 0; ?>
			<?php foreach($row_5_monitoring as $monitor): ?>
				<?php
					$x++;
					$monitor_icon = $monitor['monitoring_image'];
					$monitor_title = $monitor['monitoring_title'];
				?>
		      <div class="cma-center cma-why-container fadeInUp wow" data-wow-delay="<?php echo ($x / 5) . 's'; ?>">
		        <div class="cma-icon-black">
		        	<?php if($monitor_icon): ?>
		          		<img src="<?php echo $monitor_icon['url'];  ?>" alt="">
		          	<?php endif; ?>
		        </div>
		        <div class="cma-title-dark">
		          <?php echo ($monitor_title) ? $monitor_title : '';  ?>
		        </div>        
		      </div>
	  		<?php endforeach; ?>
      	<?php endif; ?>

    </div>
  </div>
  <?php } ?>

  <!-- 6th row -->
  <?php
	$row_6_title 		= get_field('row_6_title');
	$row_6_text 		= get_field('row_6_text');
	$row_6_certificates = get_field('row_6_certificates');
	$row_6_button_title = get_field('row_6_button_title');
	$row_6_button_link 	= get_field('row_6_button_link');
  $row6Contents = array($row_6_title,$row_6_text,$row_6_certificates);
  $isMulticolored = ($row6Contents && array_filter($row6Contents)) ? 'whiteBg':'multicolored';
  ?>

  <?php if ($row_6_title || $row_6_text || $row_6_certificates) { ?>
  <div class=" cma-bg-mixed">
    <div class="container text-center pb-5">
      <div class="col-md-8 cma-center  pt-5">

        <?php if($row_6_title) { ?>
      	<div class="cma-title-wrap fadeIn wow" data-wow-delay=".8s">
      		<h1 class="cma-title-white pb-4"><?php echo $row_6_title ?></h1>
      	</div>
        <?php } ?>

        <div class="textWrap fadeInUp wow" data-wow-delay=".9s">
        
          <?php if($row_6_text) { ?>
          <div class="cma-paragraph-white text-white"><?php echo $row_6_text ?></div>
          <?php } ?>
          
          <?php if($row_6_certificates) { ?>
          <div class="text-center text-white cert_lists mt-3">
  	          <ul class="list-group">
  	          	<?php foreach($row_6_certificates as $x=>$certificate) { ?>
  	            <li class="list-group-item"><?php echo ($certificate['certificate_title']) ? $certificate['certificate_title'] : ''; ?></li>
  	            <?php } ?>	            
  	          </ul>
          </div>
          <?php } ?>
          
          <?php if ($row_6_button_link && $row_6_button_title) { ?>
          <div class="mt-4">
            <a href="<?php echo $row_6_button_link; ?>" class="btn-gray"><?php echo $row_6_button_title; ?></a>
          </div>
          <?php } ?>

        </div>
        

      </div>

    </div>
  </div>
  <?php } ?>

  
  <!-- 7th row -->
  <?php
  	$row_7_title 		= get_field('row_7_title');
  	$row_7_text 		= get_field('row_7_text');
  	$row_7_button_text 	= get_field('row_7_button_title');
  	$row_7_button_link 	= get_field('row_7_button_link');
  ?>

  <?php if ($row_7_title || $row_7_text) { ?>
  <div class="pt-3 pb-5 <?php echo $isMulticolored ?>" id="request_information">
    <div class="container text-center">
      <div class="col-md-8 cma-center">  

        <?php if ($row_7_title) { ?>
        <div class="fadeIn wow" data-wow-delay="0.8s">     
          <h1 class="cma-title-normal"><?php echo $row_7_title; ?></h1>
        </div>
        <?php } ?>
      	
        <?php if ($row_7_text) { ?>
        <div class="cma-paragraph-normal fadeInUp wow" data-wow-delay=".9s">
          <?php echo $row_7_text; ?>
        </div>
        <?php } ?>
        
        <?php if ($row_7_button_text && $row_7_button_link) { ?>
        <div class="btndiv fadeIn wow animated" data-wow-delay="0.8s" >
          <a href="<?php echo $row_7_button_link; ?>" class="link-white"><?php echo $row_7_button_text; ?></a>
        </div>
        <?php } ?>
      </div>
    </div>
  </div>
  <?php } ?>

<?php
get_footer();