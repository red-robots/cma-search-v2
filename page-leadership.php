<?php
/**
 * Template Name: Leadership
 */
get_header(); ?>
<div id="primary" class="content-area-full cf">
  <?php while ( have_posts() ) : the_post(); ?>

    <?php  
    $row1_title = get_field("row1_title");
    $row1_text = get_field("row1_text");
    $row1Images = get_field("row1_images");
    if ($row1_title || $row1_text || $row1Images) { ?>
    <section class="temp-row1 cf">
      <div class="wrapper">
        <?php if ($row1_title) { ?>
        <h1 class="cma-title-red fadeInUp wow" data-wow-delay="0.5s"><?php echo $row1_title ?></h1>
        <?php } ?>
        
        <?php if ($row1_text) { ?>
        <div class="row-text fadeInUp wow" data-wow-delay="0.7s"><?php echo $row1_text ?></div>
        <?php } ?>
        
        <?php if ($row1Images) { ?>
        <div class="row1Images">
          <?php foreach ($row1Images as $img) { 
            $imageId = $img['ID'];
            $beforeLink = '';
            $afterLink = '';
            $pageLink = get_field("attachmentPagelink",$imageId);
            if($pageLink) {
              $beforeLink = '<a href="'.$pageLink.'" target="_blank">';
              $afterLink = '</a>';
            }
          ?>
            <span class="rowImg">
            <?php echo $beforeLink ?><img src="<?php echo $img['url'] ?>" alt="<?php echo $img['title'] ?>"><?php echo $afterLink ?>
            </span>
          <?php } ?>
        </div>
        <?php } ?>

      </div>
    </section>
    <?php } ?>


    <?php  
    $row2_title = get_field("row2_title");
    $row2_text = get_field("row2_text");
    if ($row2_title || $row2_text ) { ?>
    <section class="temp-row2 cma-main-body cf">
      <div class="container text-center">
        <div class="col-md-12 cma-center">
        
        <?php if ($row2_title) { ?>
          <h1 class="text-center"><?php echo $row2_title ?></h1>
        <?php } ?>

        <?php if ($row2_text) { ?>
          <div class="row-text"><?php echo $row2_text ?></div>
        <?php } ?>

        </div>
      </div>
    </section>
    <?php } ?>


    <?php  
    $row3Image = get_field("row3Image");
    $row3ImageCaption = get_field("row3ImageCaption");
    if($row3Image) { ?>
    <div class="text-center header_image_section fadeIn wow animated" data-wow-delay="0.5s">    
        <div class="featured_image " style="background-image: url('<?php echo $row3Image['url'] ?>');">       
        </div>     
        <div class="header_image_text">
          <h1 class=" align-middle"><?php echo $row3ImageCaption ?></h1> 
        </div>      
    </div>
    <?php } ?>


  <?php endwhile; ?>
  
  <!-- TEAM -->
  <?php  
    $args = array(
      'posts_per_page'   => -1,
      'post_type'        => 'teams',
      'post_status'      => 'publish',
      'tax_query' => array(
          array(
              'taxonomy' => 'leadershiptax',
              'terms' => 5, /*  Executive Leadership */
              'include_children' => false 
          ),
      ),
    );
    $teams = new WP_Query($args);
    $total = $teams->found_posts;
    $placeholder = THEMEURI . 'images/photo-coming-soon.png';
    $numcols = array(6,9);

  if ( $teams->have_posts() ) {  ?>
  <div id="leadership" class="cf"></div>
  <div class="cma-main-body teampage total-items-<?php echo $total; ?>" id="team_cma">
    <div class="container text-center">
      <div class="col-md-10 cma-center">
        
        <div class="row  mb-4 fadeIn wow" data-wow-delay="0.5s">
          <?php while ( $teams->have_posts() ) : $teams->the_post();  
            $photo = get_field("team_photo",$id);
            $jobTitle = get_field("team_title",$id);
            $grid = ( in_array($total,$numcols) ) ? 'col-md-4':'col-md-3';
          ?>
          <div class="team-info <?php echo $grid ?>">
            <div class="text-center mb-3">
              <div class="text-center mb-3 teamPhoto">
                <a href="<?php echo get_permalink(); ?>">
                <?php if ($photo) { ?>
                  <img src="<?php echo $photo['url']; ?>" alt="<?php echo $photo['title']; ?>" class="img-circle">
                <?php } else { ?>
                  <img src="<?php echo $placeholder; ?>" alt="Photo Coming Soon" class="img-circle">
                <?php } ?>
                </a>
              </div>
               <div class="text-bold teamName">
                <div class="name"><?php echo get_the_title(); ?></div> 
                <?php if ($jobTitle) { ?>
                <div class="jobtitle"><?php echo $jobTitle ?></div> 
                <?php } ?>
              </div>
               <div class="moreinfo"><a href="<?php echo get_permalink(); ?>">Read Bio</a></div>
            </div>
          </div>
          <?php endwhile; wp_reset_postdata(); ?>
        </div>

      </div>
    </div>
  </div>
  <?php } ?>


   <!--  Request Information -->
    <?php
        $rp_title     = get_field('rp_title');
        $rp_text      = get_field('rp_text'); 
        $final_content =  email_obfuscator($rp_text);
        $rpButtonName = get_field("rp_button_name");           
        $rpButtonLink = get_field("rp_button_link");  
    if($rp_title || $rp_text ) { ?>
    <section class="temp-bottom text-center multicolored cf">
      <div class="wrapper">
        <?php if ($rp_title) { ?>
          <h1 class="cma-title-white fadeInUp wow" data-wow-delay="0.5s"><?php echo $rp_title ?></h1>
        <?php }  ?>
      
        <?php if ($rp_text) { ?>
          <div class="text-white fadeInUp wow" data-wow-delay="0.6s"><?php echo $final_content ?></div>
        <?php } ?>

        <?php if ($rpButtonName && $rpButtonLink) { ?>
        <div class="btndiv fadeIn wow" data-wow-delay="0.65s">
          <a href="<?php echo $tempButtonLink ?>" class="link-white"><?php echo $rpButtonName ?></a>
        </div>  
        <?php } ?>

      </div>
    </section>
    <?php } ?>


</div>
<?php
get_footer();