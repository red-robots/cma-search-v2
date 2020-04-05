<?php
/**
 * Enqueue scripts and styles.
 */
function bellaworks_scripts() {
	wp_register_style( 'cma_bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css', array(), '4.1.3', false);
    wp_enqueue_style( 'cma_bootstrap');
    
	wp_enqueue_style( 'bellaworks-style', get_stylesheet_uri() );

	//wp_register_style( 'cma_style', get_template_directory_uri() . '/css/cma.css', array(), '', false);
    //wp_enqueue_style( 'cma_style');

	wp_deregister_script('jquery');
		wp_register_script('jquery', get_template_directory_uri() .'/assets/js/jquery-3.4.1.min.js', false, '3.4.1', false);
		wp_enqueue_script('jquery');

	wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/assets/js/bootstrap.min.js', array( 'jquery' ), '4.1.3', true );

	wp_enqueue_script( 
			'bellaworks-blocks', 
			get_template_directory_uri() . '/assets/js/vendors.js', 
			array(), '20120206', 
			true 
		);

	// wp_enqueue_script('youtube-api','https://www.youtube.com/iframe_api','',true);

	wp_enqueue_script( 
			'jquery-confirm', 
			get_template_directory_uri() . '/assets/js/jquery-confirm.min.js', 
			array(), '20190101', 
			true 
		);

	wp_enqueue_script( 
			'bellaworks-custom', 
			get_template_directory_uri() . '/assets/js/custom.js', 
			array('jquery'), '20120206', 
			true 
		);

	wp_localize_script( 'bellaworks-custom', 'frontajax', array(
		'ajaxurl' => admin_url( 'admin-ajax.php' )
	));

	/*wp_enqueue_script( 
		'font-awesome', 
		get_template_directory_uri() . '/assets/svg-with-js/js/fontawesome-all.js', 
		array(), '20180424', 
		true 
	);
	*/



	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	
}
add_action( 'wp_enqueue_scripts', 'bellaworks_scripts' );


