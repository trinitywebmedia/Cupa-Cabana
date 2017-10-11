<?php
// Start the engine
require_once( get_template_directory() . '/lib/init.php' );

// Localization
load_child_theme_textdomain(  'start', apply_filters(  'child_theme_textdomain', get_stylesheet_directory(  ) . '/languages', 'start'  )  );

// include bootstrap inclusion function
include( get_stylesheet_directory() . '/include/bootstrap_class_inclusion.php' );

// Add Custom Post Types
require_once(  get_stylesheet_directory(  ) . '/include/cpt/super-cpt.php'   );
require_once(  get_stylesheet_directory(  ) . '/include/cpt/zp_cpt.php'   );

// Include Shortcodes
require_once(  get_stylesheet_directory(  ) . '/include/shortcode/shortcodes_init.php' );

// Include Theme Settings
require_once (  get_stylesheet_directory(  ) . '/include/theme_settings.php'   );

// Supports HTML5
add_theme_support( 'html5' );

// Child theme (do not remove)
define( 'CHILD_THEME_NAME', 'Start' );
define( 'CHILD_THEME_URL', 'http://www.zigzagpress.com/start' );

// Add Viewport meta tag for mobile browsers
add_action( 'genesis_meta', 'zp_viewport_meta_tag' );
function zp_viewport_meta_tag() {
	echo '<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />';
}

// Add support for custom background
add_theme_support( 'custom-background' );

// Reposition Primary Navigation
remove_action( 'genesis_after_header', 'genesis_do_nav' );
add_action( 'genesis_header', 'genesis_do_nav', 11 );

// Reposition Secondary Navigation
remove_action( 'genesis_after_header', 'genesis_do_subnav' );
add_action( 'genesis_header', 'genesis_do_subnav', 11 );

// Add support for structural wraps
add_theme_support( 'genesis-structural-wraps', array () );

// Unregister Sidebar
unregister_sidebar(  'header-right'  );

/** Unregister Layout */
genesis_unregister_layout( 'content-sidebar-sidebar' );
genesis_unregister_layout( 'sidebar-sidebar-content' );
genesis_unregister_layout( 'sidebar-content-sidebar' );


// Additional Stylesheets
add_action( 'wp_enqueue_scripts', 'zp_print_styles'  );
function zp_print_styles( ) {

	wp_register_style( 'bootstrap', get_stylesheet_directory_uri( ).'/css/bootstrap.css' );
	wp_register_style( 'main', get_stylesheet_directory_uri( ).'/css/main.css' );
	wp_register_style( 'magnific-popup', get_stylesheet_directory_uri( ).'/css/magnific-popup.css' );
	wp_register_style( 'font-awesome', get_stylesheet_directory_uri( ).'/css/font-awesome.min.css' );
	wp_enqueue_style( 'bootstrap' );
	wp_enqueue_style( 'main'  );
	wp_enqueue_style( 'magnific-popup'  );
	wp_enqueue_style( 'font-awesome'  );

	wp_register_style( 'mobile', get_stylesheet_directory_uri( ).'/css/mobile.css' );
	wp_enqueue_style( 'mobile'  );
	wp_register_style( 'custom_css', get_stylesheet_directory_uri( ).'/custom.css' );
	wp_enqueue_style( 'custom_css'  );
	
}

// Theme Scripts
add_action( 'wp_enqueue_scripts', 'zp_theme_js' );

function zp_theme_js( ) {
	
	wp_enqueue_script( 'jquery' );
	wp_enqueue_script('jquery-ui-1.10.3.custom.min', get_stylesheet_directory_uri() . '/js/jquery-ui-1.10.3.custom.min.js', '', '1.10.3' , true );
	wp_enqueue_script('jquery.ui.touch-punch.min', get_stylesheet_directory_uri() . '/js/jquery.ui.touch-punch.min.js', '','0.2.2', true );
	wp_enqueue_script('bootstrap.min', get_stylesheet_directory_uri().'/js/bootstrap.min.js','', '3.0', true );
	wp_enqueue_script('jquery.isotope.min', get_stylesheet_directory_uri().'/js/jquery.isotope.min.js', '', '1.5.25', true  );
	wp_enqueue_script('jquery.magnific-popup', get_stylesheet_directory_uri() . '/js/jquery.magnific-popup.js', '', '0.9.7', true );
	wp_enqueue_script('jquery.fitvids.min', get_stylesheet_directory_uri() . '/js/jquery.fitvids.min.js','','', true );
	wp_enqueue_script('bootstrap-select', get_stylesheet_directory_uri() . '/js/bootstrap-select.js', '','', true );
	wp_enqueue_script('jquery.nav', get_stylesheet_directory_uri() . '/js/jquery.nav.js','','', true);
	wp_enqueue_script('custom.js', get_stylesheet_directory_uri() . '/js/custom.js','','', true);
}

//Enqueue Admins style and scripts
add_action(  'admin_enqueue_scripts', 'zp_admin_scripts_styles'  );
function zp_admin_scripts_styles(){
}

// Register Widget Area
genesis_register_sidebar( array(
	'id'			=> 'bottom-widget',
	'name'			=> __( 'Bottom Widget', 'start' ),
	'description'	=> __( 'This is the bottom widget right of footer credits', 'start' ),
) );

// Footer Credits
add_filter( 'genesis_footer_creds_text', 'zp_footer_creds_text' );
function zp_footer_creds_text(){
	
	$cred_text = '<div class="creds col-md-6"><p>Copyright &copy; '.date('Y').' '.get_bloginfo( 'name' ).' :: '.get_bloginfo(  'description' ).'</p></div>';
	
	if( genesis_get_option( 'zp_footer_text',  ZP_SETTINGS_FIELD ) ){
		echo '<div class="creds col-md-6"><p>'.genesis_get_option( 'zp_footer_text',  ZP_SETTINGS_FIELD ).'</p></div>';
	}else{
		echo $cred_text;
	}
	
	if(is_active_sidebar('bottom-widget')){
		echo '<div class="bottom-widget col-md-6">';
			dynamic_sidebar('bottom-widget');
		echo '</div>';
	}
		
}

// Enable shortcode in Text Widgets
add_filter( 'widget_text', 'do_shortcode' );

// Custom Favivon
add_filter( 'genesis_favicon_url', 'zp_favicon_url' );
function zp_favicon_url(  ) {
	
	$favicon_link = genesis_get_option( 'zp_favicon', ZP_SETTINGS_FIELD );
	
	if (  $favicon_link  ) {
		$favicon = $favicon_link;
		return $favicon;
	}else
	return false;
}

// Custom Logo
add_action(  'wp_head', 'zp_custom_logo'  );
function zp_custom_logo(  ) {
	if (  genesis_get_option( 'zp_logo', ZP_SETTINGS_FIELD )  ) { ?>
		<style type="text/css">
			.header-image .site-header .title-area {
				background-image: url( "<?php echo genesis_get_option( 'zp_logo', ZP_SETTINGS_FIELD ); ?>" );
				background-position: center center;
				background-repeat: no-repeat;
				height: <?php echo genesis_get_option( 'zp_logo_height', ZP_SETTINGS_FIELD );?>px;
				width: <?php echo genesis_get_option( 'zp_logo_width', ZP_SETTINGS_FIELD );?>px;
			}
			
			.header-image .title-area, .header-image .site-title, .header-image .site-title a{
				height: <?php echo genesis_get_option( 'zp_logo_height', ZP_SETTINGS_FIELD );?>px;
				width: <?php echo genesis_get_option( 'zp_logo_width', ZP_SETTINGS_FIELD );?>px;
			}
       </style>
	 <?php }
}

// Add mobile menu

add_action( 'genesis_header', 'zp_mobile_nav' );
function zp_mobile_nav(){
	$output = '';
	
	$output .=  '<div class="mobile_menu navbar-default" role="navigation"><button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">';
	$output .= '<span class="sr-only">Toggle navigation</span>';
	$output .= '<span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span>';
	$output .= '</button></div>';
	
	echo $output;
}

// Modify Read More Text

add_filter(  'excerpt_more', 'zp_read_more_link'  );
add_filter(  'get_the_content_more_link', 'zp_read_more_link'  );
add_filter( 'the_content_more_link', 'zp_read_more_link' );
function zp_read_more_link(  ) {
    return '&hellip; <a class="more-link" href="' . get_permalink(  ) . '"> '.__( 'Read More ','start' ).'<i class="fa fa-angle-double-right"></i></a>';
}

// Add image sizes
add_image_size( '2col_portfolio', 540, 405, true );
add_image_size( '3col_portfolio', 350, 263 , true );
add_image_size( '4col_portfolio', 255, 191, true );

add_image_size( '2col_blog', 547, 362, true );
add_image_size( '3col_blog', 352, 233, true );
add_image_size( '4col_blog', 255, 170, true );

/* Add support for IE8 */
add_action( 'wp_head', 'zp_add_IE8_fixes' );

function zp_add_IE8_fixes(){
	echo '<!--[if lt IE 9]>
	<script src="'.get_stylesheet_directory_uri( ).'/js/respond.js"></script>
	<![endif]-->'."\n";	
}


/**
 * Include Custom Theme Function
 *
 * Write all your custom functions in this file
 */
 
require_once (  get_stylesheet_directory(  ) . '/include/custom_functions.php'   );

genesis_register_sidebar( array(
'id' => 'page-image',
'name' => __( 'Page Image', 'genesis' ),
'description' => __( 'Page Image', 'digital-pro' ),
) );

add_action( 'genesis_after_header', 'add_genesis_widget_area' );
function add_genesis_widget_area() {
                genesis_widget_area( 'page-image', array(
		'before' => '<div class="page-image widget area">',
		'after'  => '</div>',
    ) );

}