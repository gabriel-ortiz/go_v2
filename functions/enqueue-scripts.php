<?php
function site_scripts() {
  global $wp_styles; // Call global $wp_styles variable to add conditional wrapper around ie stylesheet the WordPress way
  $enqueue_filetime       = 	filemtime(get_template_directory() . '/functions/enqueue-scripts.php');
  
        
    // Adding scripts file in the footer
    wp_enqueue_script( 'main', get_template_directory_uri() . '/assets/scripts/scripts.js', array( 'jquery' ), filemtime(get_template_directory() . '/assets/scripts/js'), true );
    
        wp_localize_script( 'main', 'GO', array(
        'site_url' 	=> site_url('/'),
        'assets' 	=> GO_ASSETS,
        'ajax_url' 	=> admin_url( 'admin-ajax.php' ),
        'nonce'    	=> wp_create_nonce( 'go_nonce' ),
        'is_admin'  => is_admin()   
    ) );
    
    // Register vendor stylesheet
    wp_enqueue_style( 'vendor', get_template_directory_uri() . '/assets/styles/vendor-styles.css', array(), filemtime(get_template_directory() . '/assets/styles/vendor-styles.css'), 'all' );
   
    // Register main stylesheet
    wp_enqueue_style( 'site', get_template_directory_uri() . '/assets/styles/style.css', array(), filemtime(get_template_directory() . '/assets/styles/scss'), 'all' );

    // Comment reply script for threaded comments
    if ( is_singular() AND comments_open() AND (get_option('thread_comments') == 1)) {
      wp_enqueue_script( 'comment-reply' );
    }
    
    //register font awesome CDN
	wp_enqueue_style( 'font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.2/css/all.min.css' , array(), $enqueue_filetime,  'all' );
}
add_action('wp_enqueue_scripts', 'site_scripts', 999);