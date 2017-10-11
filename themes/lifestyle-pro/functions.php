<?php
//* Start the engine
include_once( get_template_directory() . '/lib/init.php' );

//* Set Localization (do not remove)
load_child_theme_textdomain( 'lifestyle', apply_filters( 'child_theme_textdomain', get_stylesheet_directory() . '/languages', 'lifestyle' ) );


//* Child theme (do not remove)
define( 'CHILD_THEME_NAME', __( 'Lifestyle Pro Theme', 'lifestyle' ) );
define( 'CHILD_THEME_URL', 'http://my.studiopress.com/themes/lifestyle/' );
define( 'CHILD_THEME_VERSION', '3.0.0' );

//* Add HTML5 markup structure
add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list' ) );

//* Add viewport meta tag for mobile browsers
add_theme_support( 'genesis-responsive-viewport' );

//* Enqueue Droid Sans and Roboto Slab Google fonts
add_action( 'wp_enqueue_scripts', 'lifestyle_google_fonts' );
function lifestyle_google_fonts() {

	wp_enqueue_style( 'google-fonts', '//fonts.googleapis.com/css?family=Droid+Sans:400,700|Roboto+Slab:400,300,700', array(), CHILD_THEME_VERSION );
	
}

//* Add new image sizes
add_image_size( 'home-large', 634, 360, TRUE );
add_image_size( 'home-small', 266, 160, TRUE );

//* Add support for custom background
add_theme_support( 'custom-background', array(
	'default-image' => get_stylesheet_directory_uri() . '/images/bg.png',
	'default-color' => 'efefe9',
) );

//* Add support for custom header
add_theme_support( 'custom-header', array(
	'header_image'    => '',
	'header-selector' => '.site-title a',
	'header-text'     => false,
	'height'          => 150,
	'width'           => 320,
) );

//* Add support for additional color style options
add_theme_support( 'genesis-style-selector', array(
	'lifestyle-pro-blue'    => __( 'Lifestyle Pro Blue', 'lifestyle' ),
	'lifestyle-pro-green'   => __( 'Lifestyle Pro Green', 'lifestyle' ),
	'lifestyle-pro-mustard' => __( 'Lifestyle Pro Mustard', 'lifestyle' ),
	'lifestyle-pro-purple'  => __( 'Lifestyle Pro Purple', 'lifestyle' ),
	'lifestyle-pro-red'     => __( 'Lifestyle Pro Red', 'lifestyle' ),
) );

//* Add support for 3-column footer widgets
add_theme_support( 'genesis-footer-widgets', 3 );

//* Reposition the primary navigation
remove_action( 'genesis_after_header', 'genesis_do_nav' );
add_action( 'genesis_before_header', 'genesis_do_nav' );

//* Hook after post widget after the entry content
add_action( 'genesis_after_entry', 'lifestyle_after_entry', 5 );
function lifestyle_after_entry() {

	if ( is_singular( 'post' ) )
		genesis_widget_area( 'after-entry', array(
			'before' => '<div class="after-entry widget-area">',
			'after'  => '</div>',
		) );

}

//* Modify the size of the Gravatar in the author box
add_filter( 'genesis_author_box_gravatar_size', 'lifestyle_author_box_gravatar' );
function lifestyle_author_box_gravatar( $size ) {

	return 96;
		
}

//* Modify the size of the Gravatar in the entry comments
add_filter( 'genesis_comment_list_args', 'lifestyle_comments_gravatar' );
function lifestyle_comments_gravatar( $args ) {

	$args['avatar_size'] = 60;
	return $args;
	
}

//* Remove comment form allowed tags
add_filter( 'comment_form_defaults', 'lifestyle_remove_comment_form_allowed_tags' );
function lifestyle_remove_comment_form_allowed_tags( $defaults ) {
	
	$defaults['comment_notes_after'] = '';
	return $defaults;

}

//* Register widget areas
genesis_register_sidebar( array(
	'id'          => 'home-top',
	'name'        => __( 'Home - Top', 'lifestyle' ),
	'description' => __( 'This is the top section of the homepage.', 'lifestyle' ),
) );
genesis_register_sidebar( array(
	'id'          => 'home-middle',
	'name'        => __( 'Home - Middle', 'lifestyle' ),
	'description' => __( 'This is the middle section of the homepage.', 'lifestyle' ),
) );
genesis_register_sidebar( array(
	'id'          => 'home-bottom-left',
	'name'        => __( 'Home - Bottom Left', 'lifestyle' ),
	'description' => __( 'This is the bottom left section of the homepage.', 'lifestyle' ),
) );
genesis_register_sidebar( array(
	'id'          => 'home-bottom-right',
	'name'        => __( 'Home - Bottom Right', 'lifestyle' ),
	'description' => __( 'This is the bottom right section of the homepage.', 'lifestyle' ),
) );
genesis_register_sidebar( array(
	'id'          => 'after-entry',
	'name'        => __( 'After Entry', 'lifestyle' ),
	'description' => __( 'This is the after entry widget area.', 'lifestyle' ),
) );

//* Change the footer text
add_filter('genesis_footer_creds_text', 'sp_footer_creds_filter');
function sp_footer_creds_filter( $creds ) {
	$creds = '[footer_copyright] &middot; <a href="http://mydomain.com">CUPA CABANA | BRIDGEWATER, NJ | 908.722.2877</a> &middot; Developed by <a href="http://www.marketingpress.com" title="Marketing Press">Marketing Press</a>';
	return $creds;
}

// Register responsive menu script
add_action( 'wp_enqueue_scripts', 'prefix_enqueue_scripts' );

/**
 * Enqueue responsive javascript
 * @author Ozzy Rodriguez
 * @todo Change 'prefix' to your theme's prefix
 */
function prefix_enqueue_scripts() {

	wp_enqueue_script( 'prefix-responsive-menu', get_stylesheet_directory_uri() . '/lib/js/responsive-menu.js', array( 'jquery' ), '1.0.0', true ); // Change 'prefix' to your theme's prefix

}