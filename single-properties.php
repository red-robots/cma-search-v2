<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package bellaworks
 */

get_header(); 
$latitude = '';
$longitude = '';
$gmap = get_field("google_map");
$latitude = ( isset($gmap['lat']) && $gmap['lat'] ) ? $gmap['lat'] : '';
$longitude = ( isset($gmap['lng']) && $gmap['lng'] ) ? $gmap['lng'] : '';
?>
<div id="primary" class="content-area property-page">
	<main id="main" class="site-main container" role="main">
	<?php while ( have_posts() ) : the_post(); ?>
		<?php 
		$title = get_the_title();
		// $title = strtolower( $title );
		// $title = ucwords($title);
		$coupon_code = get_field("coupon_code");
		$community_name = get_field("community_name");
		$address = get_field("address");
		$manager_name = get_field("manager_name");
		$manager_phone = get_field("manager_phone");
		$manager_email = get_field("manager_email");
		$m_email = ($manager_email) ? '<a href="mailto:'.antispambot($manager_email,1).'">'.antispambot($manager_email).'</a>':'';
		?>
		<header class="entry-header">
			<h1 class="cma-title-red"><?php echo $title; ?></h1>
		</header>
		<div class="entry-content">
			<?php the_content(); ?>

			<div class="property-info">
				<div class="pcol left">
					<div class="group">
						<div class="info"><strong>Coupon Code:</strong> <?php echo $coupon_code ?></div>
						<div class="info"><strong>Address:</strong> <?php echo $address ?></div>
					</div>

					<div class="group">
						<div class="info"><strong>Manager Name:</strong> <?php echo $manager_name ?></div>
						<div class="info"><strong>Manager Email:</strong> <?php echo $m_email ?></div>
						<div class="info"><strong>Manager Phone:</strong> <?php echo $manager_phone ?></div>
					</div>
				</div>
				<div class="pcol right">
					<?php if ($latitude && $longitude) { ?>
					<div class="acf-map" data-zoom="16">
				        <div class="marker" data-lat="<?php echo esc_attr($latitude); ?>" data-lng="<?php echo esc_attr($longitude); ?>"></div>
				    </div>
					<?php } ?>
				</div>
			</div>
		</div>
	<?php endwhile; ?>

	</main><!-- #main -->
</div><!-- #primary -->

<?php
get_footer();
?>

<?php if ($latitude && $longitude) { ?>
<script type="text/javascript">
(function( $ ) {
	
	function initMap( $el ) {

	    // Find marker elements within map.
	    var $markers = $el.find('.marker');

	    // Create gerenic map.
	    var mapArgs = {
	        zoom        : $el.data('zoom') || 16,
	        mapTypeId   : google.maps.MapTypeId.ROADMAP
	    };
	    var map = new google.maps.Map( $el[0], mapArgs );

	    // Add markers.
	    map.markers = [];
	    $markers.each(function(){
	        initMarker( $(this), map );
	    });

	    // Center map based on markers.
	    centerMap( map );

	    // Return map instance.
	    return map;
	}

	function initMarker( $marker, map ) {

	    // Get position from marker.
	    var lat = $marker.data('lat');
	    var lng = $marker.data('lng');
	    var latLng = {
	        lat: parseFloat( lat ),
	        lng: parseFloat( lng )
	    };

	    // Create marker instance.
	    var marker = new google.maps.Marker({
	        position : latLng,
	        map: map
	    });

	    // Append to reference for later use.
	    map.markers.push( marker );

	    // If marker contains HTML, add it to an infoWindow.
	    if( $marker.html() ){

	        // Create info window.
	        var infowindow = new google.maps.InfoWindow({
	            content: $marker.html()
	        });

	        // Show info window when marker is clicked.
	        google.maps.event.addListener(marker, 'click', function() {
	            infowindow.open( map, marker );
	        });
	    }
	}


	function centerMap( map ) {

	    // Create map boundaries from all map markers.
	    var bounds = new google.maps.LatLngBounds();
	    map.markers.forEach(function( marker ){
	        bounds.extend({
	            lat: marker.position.lat(),
	            lng: marker.position.lng()
	        });
	    });

	    // Case: Single marker.
	    if( map.markers.length == 1 ){
	        map.setCenter( bounds.getCenter() );

	    // Case: Multiple markers.
	    } else{
	        map.fitBounds( bounds );
	    }
	}
// Render maps on page load.
$(document).ready(function(){
    $('.acf-map').each(function(){
        var map = initMap( $(this) );
    });
});

})(jQuery);
</script>
<?php } ?>

