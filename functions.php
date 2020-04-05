<?php
/**
 * bellaworks functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package bellaworks
 */

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/theme-setup.php';

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/scripts.php';

/**
 * Custom Post Types.
 */
require get_template_directory() . '/inc/post-types.php';

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Post Pagination
 */
require get_template_directory() . '/inc/pagination.php';


/**
 * Theme Specific additions.
 */
require get_template_directory() . '/inc/theme.php';

/**
 * Block & Disable All New User Registrations & Comments Completely.
 * Description:  This simple plugin blocks all users from being able to register no matter what, 
 *				 this also blocks comments from being able to be inserted into the database.
 */
require get_template_directory() . '/inc/block-all-registration-and-comments.php';

/**
 * Customizer additions.
 */
// require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

if( function_exists('acf_add_options_page') ) {
    
    // acf_add_options_page(array(
    //     'page_title'    => 'Theme General Settings',
    //     'menu_title'    => 'Theme Settings',
    //     'menu_slug'     => 'theme-general-settings',
    //     'capability'    => 'edit_posts',
    //     'redirect'      => false
    // ));
    
    // acf_add_options_sub_page(array(
    //     'page_title'    => 'Theme Header Settings',
    //     'menu_title'    => 'Header',
    //     'parent_slug'   => 'theme-general-settings',
    //     'menu_slug'     => 'theme-options-header',
    //     'capability'    => 'edit_posts',
    // ));
    
    // acf_add_options_sub_page(array(
    //     'page_title'    => 'Theme Footer Settings',
    //     'menu_title'    => 'Footer',
    //     'parent_slug'   => 'theme-general-settings',
    //     'menu_slug'     => 'theme-options-footer',
    //     'capability'    => 'edit_posts',
    // ));
    
}

function custom_login_logo() { 
?> 
<style type="text/css"> 
    body.login div#login h1 a {
        background-image: url(<?php echo get_template_directory_uri(). '/images/section6_logo.png'; ?>);  
        padding-bottom: 10px; 
        background-size: contain;
        width: 100%;
        height: 80px;
}
    } 
</style>
 <?php 
} add_action( 'login_enqueue_scripts', 'custom_login_logo' );
