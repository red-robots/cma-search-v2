<?php 
/*
 * Custom Post Types 
 * DASH ICONS = https://developer.wordpress.org/resource/dashicons/
 * Example: 'menu_icon' => 'dashicons-admin-users'
*/

add_action('init', 'js_custom_init', 1);
function js_custom_init() {
    $post_types = array(
        array(
            'post_type' => 'services',
            'menu_name' => 'Services',
            'plural'    => 'Services',
            'single'    => 'Service',
            'menu_icon' => 'dashicons-list-view',
            'supports'  => array('title','editor')
        ),
        array(
            'post_type' => 'teams',
            'menu_name' => 'Teams',
            'plural'    => 'Teams',
            'single'    => 'Team',
            'menu_icon' => 'dashicons-groups',
            'supports'  => array('title','editor')
        ),
        array(
            'post_type' => 'location',
            'menu_name' => 'Locations',
            'plural'    => 'Locations',
            'single'    => 'Location',
            'menu_icon' => 'dashicons-location',
            'supports'  => array('title','editor')
        ),
        array(
            'post_type' => 'vendors-type',
            'menu_name' => 'Vendors',
            'plural'    => 'Vendors',
            'single'    => 'Vendor',
            'menu_icon' => 'dashicons-category',
            'supports'  => array('title','editor')
        )
    );
    
    if($post_types) {
        foreach ($post_types as $p) {
            $p_type = ( isset($p['post_type']) && $p['post_type'] ) ? $p['post_type'] : ""; 
            $single_name = ( isset($p['single']) && $p['single'] ) ? $p['single'] : "Custom Post"; 
            $plural_name = ( isset($p['plural']) && $p['plural'] ) ? $p['plural'] : "Custom Post"; 
            $menu_name = ( isset($p['menu_name']) && $p['menu_name'] ) ? $p['menu_name'] : $p['plural']; 
            $menu_icon = ( isset($p['menu_icon']) && $p['menu_icon'] ) ? $p['menu_icon'] : "dashicons-admin-post"; 
            $supports = ( isset($p['supports']) && $p['supports'] ) ? $p['supports'] : array('title','editor','custom-fields','thumbnail'); 
            $taxonomies = ( isset($p['taxonomies']) && $p['taxonomies'] ) ? $p['taxonomies'] : array(); 
            $parent_item_colon = ( isset($p['parent_item_colon']) && $p['parent_item_colon'] ) ? $p['parent_item_colon'] : ""; 
            $menu_position = ( isset($p['menu_position']) && $p['menu_position'] ) ? $p['menu_position'] : 20; 
            
            if($p_type) {
                
                $labels = array(
                    'name' => _x($plural_name, 'post type general name'),
                    'singular_name' => _x($single_name, 'post type singular name'),
                    'add_new' => _x('Add New', $single_name),
                    'add_new_item' => __('Add New ' . $single_name),
                    'edit_item' => __('Edit ' . $single_name),
                    'new_item' => __('New ' . $single_name),
                    'view_item' => __('View ' . $single_name),
                    'search_items' => __('Search ' . $plural_name),
                    'not_found' =>  __('No ' . $plural_name . ' found'),
                    'not_found_in_trash' => __('No ' . $plural_name . ' found in Trash'), 
                    'parent_item_colon' => $parent_item_colon,
                    'menu_name' => $menu_name
                );
            
            
                $args = array(
                    'labels' => $labels,
                    'public' => true,
                    'publicly_queryable' => true,
                    'show_ui' => true, 
                    'show_in_menu' => true, 
                    'show_in_rest' => true,
                    'query_var' => true,
                    'rewrite' => true,
                    'capability_type' => 'post',
                    'has_archive' => false, 
                    'hierarchical' => false, // 'false' acts like posts 'true' acts like pages
                    'menu_position' => $menu_position,
                    'menu_icon'=> $menu_icon,
                    'supports' => $supports
                ); 
                
                register_post_type($p_type,$args); // name used in query
                
            }
            
        }
    }
}

// Add new taxonomy, make it hierarchical (like categories)
add_action( 'init', 'ii_custom_taxonomies', 0 );
function ii_custom_taxonomies() {
        $posts = array(
            array(
                'post_type' => 'teams',
                'menu_name' => 'Leadership',
                'plural'    => 'Leadership',
                'single'    => 'Leadership',
                'taxonomy'  => 'leadershiptax'
            ),
            array(
                'post_type' => 'vendors-type',
                'menu_name' => 'Vendors Types',
                'plural'    => 'Vendors Types',
                'single'    => 'Vendors Type',
                'taxonomy'  => 'vendorscat'
            ),
        );
    
    if($posts) {
        foreach($posts as $p) {
            $p_type = ( isset($p['post_type']) && $p['post_type'] ) ? $p['post_type'] : ""; 
            $single_name = ( isset($p['single']) && $p['single'] ) ? $p['single'] : "Custom Post"; 
            $plural_name = ( isset($p['plural']) && $p['plural'] ) ? $p['plural'] : "Custom Post"; 
            $menu_name = ( isset($p['menu_name']) && $p['menu_name'] ) ? $p['menu_name'] : $p['plural'];
            $taxonomy = ( isset($p['taxonomy']) && $p['taxonomy'] ) ? $p['taxonomy'] : "";
            
            
            if( $taxonomy && $p_type ) {
                $labels = array(
                    'name' => _x( $menu_name, 'taxonomy general name' ),
                    'singular_name' => _x( $single_name, 'taxonomy singular name' ),
                    'search_items' =>  __( 'Search ' . $plural_name ),
                    'popular_items' => __( 'Popular ' . $plural_name ),
                    'all_items' => __( 'All ' . $plural_name ),
                    'parent_item' => __( 'Parent ' .  $single_name),
                    'parent_item_colon' => __( 'Parent ' . $single_name . ':' ),
                    'edit_item' => __( 'Edit ' . $single_name ),
                    'update_item' => __( 'Update ' . $single_name ),
                    'add_new_item' => __( 'Add New ' . $single_name ),
                    'new_item_name' => __( 'New ' . $single_name ),
                  );

              register_taxonomy($taxonomy,array($p_type), array(
                'hierarchical' => true,
                'labels' => $labels,
                'show_ui' => true,
                'show_in_rest' => true,
                'show_admin_column' => true,
                'query_var' => true,
                'rewrite' => array( 'slug' => $taxonomy ),
              ));
            }
            
        }
    }
}

// Add the custom columns to the position post type:
add_filter( 'manage_posts_columns', 'set_custom_cpt_columns' );
function set_custom_cpt_columns($columns) {
    global $wp_query;
    $query = isset($wp_query->query) ? $wp_query->query : '';
    $post_type = ( isset($query['post_type']) ) ? $query['post_type'] : '';
    if($post_type=='teams') {
        unset( $columns['title'] );
        unset( $columns['date'] );
        unset( $columns['taxonomy-leadershiptax'] );
        $columns['title'] = __( 'Team Name', 'bellaworks' );
        $columns['email'] = __( 'Team Email', 'bellaworks' );
        $columns['photo'] = __( 'Team Photo', 'bellaworks' );
        $columns['taxonomy-leadershiptax'] = __( 'Leadership', 'bellaworks' );
    }

    if($post_type=='vendors-type') {
        unset( $columns['title'] );
        unset( $columns['date'] );
        unset( $columns['taxonomy-vendorscat'] );
        $columns['title'] = __( 'Vendor Name', 'bellaworks' );
        $columns['vendor_logo'] = __( 'Team Photo', 'bellaworks' );
        $columns['taxonomy-vendorscat'] = __( 'Type', 'bellaworks' );
    }
    
    return $columns;
}

// Add the data to the custom columns for the book post type:
add_action( 'manage_posts_custom_column' , 'custom_post_column', 10, 2 );
function custom_post_column( $column, $post_id ) {
    global $wp_query;
    $query = isset($wp_query->query) ? $wp_query->query : '';
    $post_type = ( isset($query['post_type']) ) ? $query['post_type'] : '';
    
    if($post_type=='teams') {
        switch ( $column ) {
            case 'photo' :
                $img = get_field('team_photo',$post_id);
                $img_src = ($img) ? $img['sizes']['thumbnail'] : '';
                $the_photo = '<span class="tmphoto" style="display:inline-block;width:50px;height:50px;background:#e2e1e1;text-align:center;">';
                if($img_src) {
                   $the_photo .= '<img src="'.$img_src.'" alt="" style="width:100%;height:auto" />';
                } else {
                    $the_photo .= '<i class="dashicons dashicons-businessman" style="font-size:33px;position:relative;top:8px;left:-6px;opacity:0.3;"></i>';
                }
                $the_photo .= '</span>';
                echo $the_photo;
                break;

            case 'email' :
                $email = get_field("team_email",$post_id);
                echo ($email) ? '<a href="mailto:'.$email.'">'.$email.'</a>' : '&mdash;';
                break;
        }
    }

    if($post_type=='vendors-type') {
        switch ( $column ) {
            case 'vendor_logo' :
                $img = get_field('vendor_logo',$post_id);
                $img_src = ($img) ? $img['sizes']['medium'] : '';
                if($img_src) {
                   $the_photo .= '<img src="'.$img_src.'" alt="" style="width:80px;height:auto" />';
                } else {
                    $the_photo .= '<span class="tmphoto" style="display:inline-block;width:50px;height:50px;background:#e2e1e1;text-align:center;position:relative;"><i class="dashicons dashicons-format-image" style="font-size:25px;position:absolute;top:13px;left:13px;opacity:0.3;"></i></span>';
                }
                echo $the_photo;
                break;
        }
    }
    
}

function bella_post_type_styles() { ?>
    <style>
        td.column-vendor_logo {
            vertical-align: middle;
        }
    </style>
<?php
}
add_action( 'admin_head', 'bella_post_type_styles' );


