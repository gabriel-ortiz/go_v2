<?php
/** 
 * For more info: https://developer.wordpress.org/themes/basics/theme-functions/
 *
 */		

// Useful global constants
define( 'GO_VERSION',      '0.1.0' );
define( 'GO_URL',          get_stylesheet_directory_uri() );
define( 'GO_TEMPLATE_URL', get_template_directory_uri() );
//define( 'GO_PATH',         get_template_directory() . '/' );
define( 'GO_PATH',         dirname( __FILE__ ) . '/' );
define( 'GO_INC',          GO_PATH . 'includes/' );
define( 'GO_ASSETS',       GO_TEMPLATE_URL . '/assets/' );
define( 'GO_PARTS',       GO_PATH . '/parts/' );
define( 'COMPOSER_PATH', GO_PATH .'vendor/' );

if ( ! defined( 'DAY_IN_SECONDS' ) ) {
    define( 'DAY_IN_SECONDS', 24 * 60 * 60 );
}
	
// Theme support options
require_once(get_template_directory().'/functions/theme-support.php'); 

// WP Head and other cleanup functions
require_once(get_template_directory().'/functions/cleanup.php'); 

// Register scripts and stylesheets
require_once(get_template_directory().'/functions/enqueue-scripts.php'); 

// Register custom menus and menu walkers
require_once(get_template_directory().'/functions/menu.php'); 

// Register sidebars/widget areas
require_once(get_template_directory().'/functions/sidebar.php'); 

// Makes WordPress comments suck less
require_once(get_template_directory().'/functions/comments.php'); 

// Replace 'older/newer' post links with numbered navigation
require_once(get_template_directory().'/functions/page-navi.php'); 

// Adds support for multiple languages
require_once(get_template_directory().'/functions/translation/translation.php'); 

// Adds site styles to the WordPress editor
// require_once(get_template_directory().'/functions/editor-styles.php'); 

// Remove Emoji Support
// require_once(get_template_directory().'/functions/disable-emoji.php'); 

// Related post function - no need to rely on plugins
// require_once(get_template_directory().'/functions/related-posts.php'); 

// Use this as a template for custom post types
// require_once(get_template_directory().'/functions/custom-post-type.php');

// Customize the WordPress login menu
// require_once(get_template_directory().'/functions/login.php'); 

// Customize the WordPress admin
// require_once(get_template_directory().'/functions/admin.php'); 

//Inlcude helpers
require_once 	COMPOSER_PATH . 'autoload.php';
require_once 	GO_INC . 'helpers.php';
include 		GO_INC . 'libraries/html.php' ;


//include custom WP Modules
require_once 	GO_INC . 'ajax-cb.php';
require_once 	GO_INC . 'shortcodes.php';

//Run the Setup Functions
GO\Includes\AjaxCB\setup();
GO\Includes\Shortcodes\setup();
