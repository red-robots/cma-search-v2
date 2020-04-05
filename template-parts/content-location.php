<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="entry-content">

    <?php
    $header_image       = get_field('row_1_header_image');
    $header_image_text  = get_field('row_1_header_title');
    ?>

    <?php if ($header_image) { ?>
    <div class="hero-wrapper m80">
      <div class="hero-image" style="background-image:url('<?php echo $header_image; ?>');"></div>
      <?php if ($header_image_text) { ?>
      <div class="hero-caption animated fadeIn">
        <div class="caption"><?php echo $header_image_text ?></div>
      </div>
      <?php } ?>
    </div>
    <?php } ?>

   
    <!-- 2nd row -->
    <?php
    $row_2_title    = get_field('row_2_title');
    $row_2_text     = get_field('row_2_text');
    if($row_2_title || $row_2_text) { ?>
    <div class=" mb-5 justify-content-center">
      <div class="col-md-10 text-center" style="margin: 0 auto;">
        <?php if ($row_2_title) { ?>
        <div class="fadeInUp wow" data-wow-delay="0.5s">
            <h1 class="cma-title-red"><?php echo $row_2_title; ?></h1>
        </div> 
        <?php } ?>      

        <?php if ($row_2_text) { ?> 
        <div class="text-center fadeInUp wow" data-wow-delay="0.7s">
          <p class="cma-paragraph-normal"><?php echo $row_2_text; ?></p>
        </div>
        <?php } ?>      
      </div>      
    </div>
    <?php } ?>

    <!-- 3rd row -->
    <?php
    $row_3_background_image = get_field('row_3_background_image');
    $row_3_title            = get_field('row_3_title');
    if($row_3_background_image || $row_3_title) { ?>  
    <div class="">
      <div class=" text-center">
        <div class="header_image_section fadeIn wow" data-wow-delay="0.6s">

            <?php if ($row_3_background_image) { ?>
            <div class="featured_image " style="background-image: url('<?php echo $row_3_background_image;  ?>');" >       
            </div>
            <?php } ?>

            <?php if ($row_3_title) { ?>
            <div class="header_image_text fadeIn wow" data-wow-delay="0.9s">
                <h1 class="align-middle " >
                  <?php echo $row_3_title;  ?>                
                </h1>
            </div>
            <?php } ?>

          </div>
      </div>
    </div>
    <?php } ?>

    <!-- 4th row -->
    <?php if( $row4theTeam = get_field('row4theTeam') ) { ?>
    <div id="teams"></div>
    <div class="cma-main-body " id="team_cma">
      <div class="container text-center">
        <div class="col-md-8 cma-center">
          <div class="row contactFlexcols fadeIn wow" data-wow-delay="0.5s">

            <?php foreach($row4theTeam as $e) {
              if( $m = $e['teamName'] ) {
                  $id = $m->ID;
                  $name = $m->post_title; 
                  $nameTrim = preg_replace('/\s+/',' ',$name);
                  $nameArrs = ($nameTrim) ? explode(' ',$nameTrim) : '';
                  $altText = $e['altText'];
                  $altTextTrim = preg_replace('/\s+/','', $altText);
                  $photo = get_field("team_photo",$id);
                  $placeholder = THEMEURI . 'images/photo-coming-soon.png';
                  $email = get_field("team_email",$id);
                  $showBioLink = (isset($e['showbio']) && $e['showbio']=='yes') ? true : false;
                  $teamFname = ( isset($nameArrs[0]) && $nameArrs[0] ) ? $nameArrs[0]:'';
                  $teamLname = ( isset($nameArrs[1]) && $nameArrs[1] ) ? $nameArrs[1]:'';
                  $pagelink = get_permalink($id);
                  $teamContactLink = $pagelink . '?contact=yes&ref='.get_the_ID();
                  $linktoContactForm = (isset($e['linktocontactform']) && $e['linktocontactform']=='yes') ? true : false;
                  if($altTextTrim) {
                    $altText = email_obfuscator($altText,true);
                    if (!$showBioLink) {

                    }
                    /* check if name exist from alt text */
                    $team_fname = strtolower( preg_replace('/\s+/',' ', $teamFname) ) . ' ' . strtolower( preg_replace('/\s+/',' ', $teamLname) );
                    $alt_str = strtolower($altTextTrim);
                    $check_strings = array($team_fname,$email);
                    $altText = '';
                    $hasTopInfo = array();

                    /* check firstname */
                    if (strpos($alt_str, $team_fname) !== false) {
                      // do nothing...
                    } else {
                      $hasTopInfo[] = $nameTrim;
                      $altText .= '<div class="t-name">'.$nameTrim.'</div>';
                    }

                    /* check email */
                    // if($email) {
                    //   if (strpos($alt_str, $email) !== false) {
                    //     // do nothing...
                    //   } else {
                    //     $hasTopInfo[] = $email;
                    //     $altText .= '<div class="t-email"><a href="mailto:'.antispambot($email,1).'">'.antispambot($email).'</a></div>';
                    //   }
                    // }

                    if($hasTopInfo) {
                      $altText .= '<div class="alttxtwrap">'.$e['altText'].'</div>';
                    } else {
                      $altText = $e['altText'];
                    }

                  } 
                  $teamInfo = ($altTextTrim) ? $altText : $name;
              ?>
              <div class="col-md-6 cflexcol">
                <div class="text-center">
                  
                  <div class="text-center teamPhoto">
                  <?php if ($photo) { ?>
                    <img src="<?php echo $photo['url']; ?>" alt="<?php echo $photo['title']; ?>" class="img-circle">
                  <?php } else { ?>
                    <img src="<?php echo $placeholder; ?>" alt="Photo Coming Soon" class="img-circle">
                  <?php } ?>
                  </div>
                  
                  <div class="text-bold teamName"><?php echo $teamInfo ?></div>

                  <?php if ( empty($altTextTrim) ) { ?>

                    <?php if ($email) { ?>

                      <?php if ($linktoContactForm) { ?>
                      <div class="moreInfo text-bold mt-2 linktocontactform ">
                        <a href="<?php echo $teamContactLink; ?>" class="team_cma_link redlinkcolor">Contact <?php echo $teamFname; ?></a>
                      </div>
                      <?php } else { ?>
                      <div class="teamEmail text-bold">
                        <a href="mailto:<?php echo antispambot($email,1) ?>"><?php echo antispambot($email); ?></a>
                      </div>
                      <?php } ?>

                    <?php } ?>

                  <?php } ?>

                  <?php if ($altTextTrim) { ?>

                    <?php if ($linktoContactForm && $showBioLink==false) { ?>
                      <div class="moreInfo text-bold mt-2 linktocontactform ">
                        <a href="<?php echo $teamContactLink; ?>" class="team_cma_link redlinkcolor">Contact <?php echo $teamFname; ?></a>
                      </div>
                    <?php } ?>

                  <?php } ?>

                  <?php if ($showBioLink && $linktoContactForm==false) { ?>

                    <div class="moreInfo text-bold mt-2">
                      <a href="<?php echo $pagelink ?>" class="team_cma_link redlinkcolor">More About <?php echo $teamFname; ?></a>
                    </div>

                  <?php } ?>

                  <?php if ($showBioLink && $linktoContactForm) { ?>

                    <div class="moreInfo text-bold mt-2 grouplinks">
                      <a href="<?php echo $pagelink ?>" class="team_cma_link redlinkcolor">More About <?php echo $teamFname; ?></a>
                      <a href="<?php echo $teamContactLink; ?>" class="team_cma_link linktocontactform redlinkcolor">Contact <?php echo $teamFname; ?></a>
                    </div>

                  <?php } ?>
                  
                </div>
              </div>
              <?php } ?>
            <?php } ?>

          </div>
        </div>
      </div>
    </div>
    <?php } ?>

    <!-- 5th row -->
    <?php
    $row_5_title        = get_field('row_5_title');
    $row_5_locations    = get_field('row_5_locations');
    if($row_5_title || $row_5_locations) { ?>
    <div class="pt-5 mb-5 justify-content-center">
      <div class="col-md-6 text-center fadeIn wow" data-wow-delay="0.5s" style="margin: 0 auto;">
        <div class="titleDiv">
          <h1 class="cma-title-red"><?php echo ($row_5_title) ? $row_5_title : ''; ?></h1>
        </div>            
        <div class="row mt-5">
            <?php if($row_5_locations): ?>
                <?php foreach($row_5_locations as $location): ?>
                    <div class="col">
                      <div class="text-bold">
                        <?php echo ($location['location_name']) ?  $location['location_name'] : ''; ?>
                      </div>
                      <div>
                        P: <?php echo ($location['location_phone']) ?  $location['location_phone'] : ''; ?>
                      </div>
                      <div>
                        F: <?php echo ($location['location_fax']) ?  $location['location_fax'] : ''; ?>
                      </div>
                      <div>
                        <?php echo ($location['location_address']) ?  $location['location_address'] : ''; ?>
                      </div>
                    </div>
                <?php endforeach; ?>
        <?php endif; ?>
        </div>
      </div>      
    </div>
    <?php } ?>

    <!-- 6th row -->
    <?php
    $row_6_title        = get_field('row_6_title');
    $row_6_text         = get_field('row_6_text');
    $row_6_link_text    = get_field('row_6_link_text');
    $row_6_link_url     = get_field('row_6_link_url');
    if ($row_6_title || $row_6_text) { ?>
    <div class="cma-bg-red multicolorBg">
      <div class="innerpad cf">

        <?php if ($row_6_title) { ?>
        <div class="justify-content-center">
          <div class="col-md-8 mt-4" style="margin: 0 auto">
              <div class="fadeInUp wow" data-wow-delay="0.8s">
                  <h1  class="text-center"><?php echo $row_6_title; ?></h1>
              </div>
          </div>
        </div>
        <?php } ?>
        
        <?php if ($row_6_text) { ?>
        <div class="container">
          <div class="mb-4">
            <div class="col-md-9 cma-center text-center ">
                <div class="fadeInUp wow" data-wow-delay="0.9s">
                  <div class="cma-paragraph-normal text-white">
                    <?php echo $row_6_text; ?>
                  </div>
                </div>
                
                <?php if ($row_6_link_text && $row_6_link_url) { ?>
                <div class="fadeInUp wow" data-wow-delay="1s">
                  <a href="<?php echo $row_6_link_url; ?>" class="cma-solid-bottom-white"><?php echo $row_6_link_text; ?></a>
                </div>
                <?php } ?>
            </div>
          </div> 
        </div><!-- container -->
        <?php } ?>

      </div>
    </div>
    <?php } ?>


	</div><!-- .entry-content -->
	
</article><!-- #post-## -->
