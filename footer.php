	</div><!-- #content -->

  <?php  
    $company_name       = get_field('company_name', 'option');
    $company_email      = get_field('email_address', 'option');
    $company_phone      = get_field('phone', 'option');
    $company_bldg_name  = get_field('building_name', 'option');
    $company_address    = get_field('building_address', 'option');
    $request_info       = get_field('request_information_text', 'option');
    $request_info_url   = get_field('request_information_url', 'option');
    $contactlink        = get_field('contactlink', 'option');
  ?>

  
	
    <footer class="cma-footer cf" id="colophon" role="contentinfo">
      <div class="container text-left">
        <div class="row">
          <div class="col-md-7 ftcol1">
            <h4 class="cma-title-red text-bold">
              <?php echo ($company_name) ? $company_name : ''; ?>
            </h4>
            <div>
              P: <?php echo ($company_phone) ? $company_phone : ''; ?> | <?php echo ($contactlink) ? '<a href="'.$contactlink.'">Email Us</a>':''; ?> 
            </div>
            <div class="mb-5 officeAddress">
              <div><?php echo ($company_bldg_name) ? $company_bldg_name : ''; ?></div>
              <div class="company_address"><?php echo ($company_address) ? $company_address : ''; ?></div>
            </div>
          </div>

        

        <div class="col-md-5 ftcol2">
          <div class="mb-3 request-info">
            <a href="<?php echo ($request_info_url) ?  $request_info_url : ''; ?>" class="cma-solid-bottom"><?php echo ($request_info) ? $request_info : '';  ?></a>
          </div>
          <div class="row">

            <?php 
            // if(has_nav_menu('footer')) {
            //   $menu_items = wp_get_nav_menu_items('Footer Menu');
              
            //   $menu   = array();
            //   $ar_list   = array();
            //   foreach($menu_items as $key => $value){ 
            //     $menu['url']    = $value->url;
            //     $menu['title']  = $value->title;
            //     $ar_list[] = $menu;               
            //   }
            //   $rows = ceil(count($ar_list) / 2);
            //   $lists  = array_chunk($ar_list, $rows);

            //   foreach ( $lists as $column) {
            //       echo '<div class="col-md-4 col-6"><ul class="list-group">';
            //       foreach ($column as $item) {
            //           echo '<li class="list-group-item"><a href="'. $item['url'] .'">' . $item['title'] . '</a></li>';
            //       }
            //       echo '</ul></div>';
            //   }
            // }

            ?>
          
          <?php 
            $footsearch = get_field("footer_search","option");
            $foot_shortcode_title = get_field("footer_shortcode_title","option");
          ?>

            <div class="col-md-6 searchCol">
              <?php if ($foot_shortcode_title) { ?>
              <div class="mb-2 text-dark"><?php echo $foot_shortcode_title; ?></div>
              <?php } ?>
              <div class="footerSearchForm">
              <?php if($footsearch) { ?>
                <?php echo do_shortcode($footsearch); ?>
              <?php } ?>
              </div>
            </div>

            <div class="col-md-6 locationCol">       
              <div class="footer_locations">
                <div class="mb-2 text-dark">LOCATIONS</div>
                <ul class="list-group">
                <?php
                      $wp_query = null;
                      $post_type = 'location';
                      $args = array(
                          'posts_per_page'   => -1,
                          'orderby'          => 'date',
                          'order'            => 'DESC',
                          'post_type'        => $post_type,
                          'post_status'      => 'publish',
                          //'paged'            => $paged
                      );

                      $wp_query = null;
                      
                      $wp_query = new WP_Query($args);

                      if ( $wp_query->have_posts() ) {
                      while ( $wp_query->have_posts() ) : $wp_query->the_post();  ?>
                        <li class="list-group-item"><a href="<?php echo get_permalink(); ?>"><?php the_title(); ?></a></li>
                      <?php endwhile; wp_reset_postdata();
                      } ?>
                  </ul>
              </div>
            </div>

          </div>
        </div>


        </div> <!-- row -->

        <?php  
        $socialOptions = social_icons();
        $socialMedia = get_field('social_media', 'option');
        ?>
        
        <div class="colophon cf">

          <?php if ($socialMedia) { ?>
          <div class="social-media-links">
            <ul class="smLinks">
              <?php
              foreach( $socialMedia as $s ) { 
                $socialLink = $s['link'];
                $socialIcon = '';
                $socialName = '';
                if($socialLink) {
                  if(strpos($socialLink, 'http') !== false) {
                    $social_link = $socialLink;
                  } else {
                    $social_link = 'https://' . $socialLink;
                  }
                  $parts = parse_url($social_link);
                  $host = $parts['host'];
                  foreach($socialOptions as $k=>$iconClass) {
                    if (strpos($host, $k) !== false) {
                      $socialIcon = $iconClass;
                      $socialName = $k;
                      break;
                    }
                  }
                } ?>

                <?php if ($social_link && $socialIcon) { ?>
                <li class="social-<?php echo $socialName;?>">
                  <a href="<?php echo $social_link; ?>" target="_blank"><i class="social-icon <?php echo $socialIcon ?>" aria-hidden="true"></i><span style="display:none;"><?php echo $socialName ?></span></a>
                </li>
                <?php } ?>
              <?php } ?>
            </ul>
          </div>
          <?php } ?>

          <div class="copyright">
            Copyright <?php echo date('Y'); ?> <?php echo bloginfo('name'); ?>. All Rights Reserved.
          </div>
        </div>

      </div>
  </footer>
</div><!-- #page -->

<div id="spinner">
  <div class="lds-roller"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
</div>
<?php wp_footer(); ?>



<?php if ( is_front_page() || is_home() ) { ?>
<script type="text/javascript">
/* Video Controls */
window.onload = function() {
  if( $("#videoHero").length > 0 ) {

    var video = document.getElementById("videoHero");
    video.play();

    // Buttons
    var playButton = document.getElementById("play-pause");

    // Event listener for the play/pause button
    playButton.addEventListener("click", function() {
      if (video.paused == true) {
        video.play();
        playButton.innerHTML = "Pause";
        playButton.classList.add("pause");
        playButton.classList.remove("play");
      } else {
        video.pause();
        playButton.innerHTML = "Play";
        playButton.classList.add("play");
        playButton.classList.remove("pause");
      }
    });

  }

}
</script> 
<?php } ?>


</body>
</html>
