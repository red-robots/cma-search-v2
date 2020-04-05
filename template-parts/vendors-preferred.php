<?php  
  $pv1 = array(
    'posts_per_page'   => -1,
    'post_type'        => 'vendors-type',
    'post_status'      => 'publish',
    'tax_query' => array(
        array(
            'taxonomy' => 'vendorscat',
            'field' => 'slug',
            'terms' => 'preferred-vendor'
        ),
    ),
  );
  $partnerVendors = new WP_Query($pv1);
  if ( $partnerVendors->have_posts() ) { 
  $total = $partnerVendors->found_posts;  ?>
  <div class="text-center vendors-information posts-<?php echo $total;?> fadeIn wow" data-wow-delay=".8s">
    <div class="flexbox">
    <?php while ( $partnerVendors->have_posts() ) : $partnerVendors->the_post();  
      $vendorLogo = get_field("vendor_logo");
      $placeholder = get_bloginfo("template_url") .'/images/square.png';
      $vendor_id = get_the_ID();
      ?>
      <div class="fbox <?php echo ($vendorLogo) ? 'haslogo':'nologo'; ?>">
        <div class="inside">
          <a href="#" data-id="<?php echo $vendor_id?>" class="vendorInfoPopUp popupInfo">
            <?php if ($vendorLogo) { ?>
            <span class="spanlogo" style="background-image:url('<?php echo $vendorLogo['url'] ?>');"></span>
            <?php } ?>
            <img src="<?php echo $placeholder ?>" alt="" aria-hidden="true" class="placeholder">
          </a>
        </div>
      </div>
    <?php endwhile; wp_reset_postdata(); ?>
    </div>
  </div>

  <?php } ?>