<?php
/**
 * Integration of Bootstrap classes to Genesis Framework
 */

	/**
	*  Add bootstrap class to .site-header
	*/
	add_filter( 'genesis_attr_site-header', 'zzp_site_header_id', 10, 2 );
	function zzp_site_header_id( $attributes, $context ){
	 $attributes['id'] = 'header' ;
	 
	 return  $attributes;
	}
	
	/**
	* Add bootstrap class to .nav-primary
	*/
	add_filter( 'genesis_attr_site-header', 'zzp_site_header_class', 10, 2 );
	function zzp_site_header_class( $attributes, $context ){
	 $attributes['class'] = 'site-header navbar navbar-fixed-top' ;
	 
	 return  $attributes;
	}
 
	/**
	* Add bootstrap class to .nav-primary
	*/
	add_filter( 'genesis_attr_nav-primary', 'zzp_nav_primary_class', 10 , 2  );
	function zzp_nav_primary_class( $attributes, $context ){
	 $attributes['class'] = 'nav-primary navbar-collapse pull-right in';
	 
	 return $attributes;
	}
	
	/**
	* Add bootstrap class to .secondary-primary
	*/
	add_filter( 'genesis_attr_nav-secondary', 'zzp_nav_secondary_class', 10 , 2  );
	function zzp_nav_secondary_class( $attributes, $context ){
	 $attributes['class'] = 'nav-secondary navbar-collapse pull-right in';
	 
	 return $attributes;
	}
	
	/**
	* Add bootstrap class to .site-footer
	*/
	add_filter( 'genesis_attr_site-footer', 'zzp_site_footer_class', 10 , 2  );
	function zzp_site_footer_class( $attributes, $context ){
	 $attributes['class'] = 'site-footer bottom-menu-inverse';
	 
	 return $attributes;
	}

	/**
	* Add bootstrap class to .title-area
	*/
	add_filter( 'genesis_attr_title-area', 'zzp_title_area_class', 10 , 2  );
	function zzp_title_area_class( $attributes, $context ){
	 $attributes['class'] = 'title-area navbar-brand';
	 
	 return $attributes;
	}
	
	/**
	* Add bootstrap class to .header-widget-area
	*/
	add_filter( 'genesis_attr_header-widget-area', 'zzp_header_widget_area_class', 10 , 2  );
	function zzp_header_widget_area_class( $attributes, $context ){
	 $attributes['class'] = 'header-widget-area col-md-8 col-sm-8';
	 
	 return $attributes;
	}
	
	/**
	* Add bootstrap class to Main Content
	*/
	
	add_filter( 'genesis_attr_content', 'zzp_genesis_main_content_class', 10, 2 );
	function zzp_genesis_main_content_class( $attributes, $context ){
	 if( !is_home() && !is_front_page() ){
		
		// get site layout
		$layout = genesis_site_layout();
		
		if( 'content-sidebar' == $layout ){
			$attributes['class'] = 'content col-sm-12 col-md-8 col-xs-12 ';
		}
		
		if( 'sidebar-content' == $layout ){
			$attributes['class'] = 'content col-sm-12 col-md-8 col-xs-12';
		}
		
		if( 'full-width-content' == $layout ){
			$attributes['class'] = 'content col-md-12 col-sm-12 col-xs-12';
		}
		
	 }
	
	return $attributes;
	}
 
	/**
	* Add bootstrap class to Primary Sidebar
	*/
	add_filter( 'genesis_attr_sidebar-primary', 'zzp_genesis_primary_sidebar_class', 10, 2 );
	function zzp_genesis_primary_sidebar_class( $attributes, $context ){
	 
	 //get site layout
	 $layout = genesis_site_layout();
	 
	 if( 'content-sidebar' == $layout ){
		 $attributes['class'] = 'sidebar sidebar-primary widget-area col-sm-12  col-md-4 col-xs-12 ';
	 }
	 
	 if( 'sidebar-content' == $layout ){
		 $attributes['class'] = 'sidebar sidebar-primary widget-area col-sm-12 col-md-4 col-xs-12';
	 }
	
	return $attributes;	 
	}
	
	/**
	* Create additional <div> 'container' and 'row' on site header
	*/
	
	add_action( 'genesis_header', 'zzp_header_markup_open', 6 );
	
	function zzp_header_markup_open(){
	 echo '<div class="container">';  
	}
	
	add_action( 'genesis_header', 'zzp_header_markup_close', 14 );
	function zzp_header_markup_close(){
	  echo '</div>';
	}
	
	/**
	* Create additional <div> 'container' and 'row' on site inner
	*
	*/
	
	add_action( 'genesis_before_content', 'zzp_site_inner_markup_open' );
	function zzp_site_inner_markup_open(){
	  if( !is_home() && !is_front_page() ){
		echo '<div class="container"><div class="row">';
	}
	}
	
	add_action( 'genesis_after_content', 'zzp_site_inner_markup_close' );
	function zzp_site_inner_markup_close(){
	  if( !is_home() && !is_front_page() ){
		echo '</div></div>';
	  }
	}
  
	/**
	* Create additional <div> 'container' and 'row' on site footer
	*/
	
	add_action( 'genesis_footer', 'zzp_footer_markup_open', 6 );
	function zzp_footer_markup_open(){
	  echo '<div class="container"><div class="row">';
	}
	
	add_action( 'genesis_footer', 'zzp_footer_markup_close', 14 );
	function zzp_footer_markup_close(){
	 echo '</div></div>'; 
	}
  
	/**
	* Add Classes to Genesis Primary nav
	*/

	add_filter( 'wp_nav_menu_args' , 'zp_custom_primary_nav' );
	function zp_custom_primary_nav( $args ) {
		if ( $args['theme_location'] == 'primary' || $args['theme_location'] == 'secondary' ) {
			$args['walker'] = new ZP_Custom_Genesis_Nav_Menu;
			$args['desc_depth'] = 0;
			$args['thumbnail'] = false;
		}
		return $args;
		
	}

	/**
	* Menu Walker Class
	*/
	
	class ZP_Custom_Genesis_Nav_Menu extends Walker_Nav_Menu {
		function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0  ) {
        global $wp_query;
		
		 $attributes='';

        $class_names = $value = '';
 
        $classes = empty( $item->classes ) ? array() : (array) $item->classes;
 
        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) );
        $class_names = ' class="' . esc_attr( $class_names ) . ' dropdown"';
 
        $output .= '<li id="menu-item-'. $item->ID . '"' . $value . $class_names .'>';


        $atts = array();
		$atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
		$atts['target'] = ! empty( $item->target )     ? $item->target     : '';
		$atts['rel']    = ! empty( $item->xfn )        ? $item->xfn        : '';
		$atts['href']   = ! empty( $item->url )        ? $item->url        : '';
		
		//check if the link is a section or an http link
		$check_link = strpos( $item->url, 'http' );
		if( $check_link === false ){
			$dropdown_class = 'class="dropdown-toggle" data-toggle="dropdown"';	
		}else{
			$dropdown_class = '';	
		}

		$attributes = '';
		foreach ( $atts as $attr => $value ) {
			if ( ! empty( $value ) ) {
				$value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
				$attributes .= ' ' . $attr . '="' . $value . '"';
			}
		}
		
	    $item_output = $args->before;
		
		// menu link output
        $item_output .= '<a'. $attributes .'  '.$dropdown_class.' >';
        $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
			
		// close menu link anchor
        $item_output .= '</a>';
        $item_output .= $args->after;
 
		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
		}
	}

	/**
	* Filter Primary Nav
	*/
	
	add_filter( 'genesis_do_nav', 'zp_filter_genesis_nav', 10, 3 );
	
	function zp_filter_genesis_nav( $nav_output , $nav, $args){
		
		if ( ! genesis_nav_menu_supported( 'primary' ) )
		return;

		if( is_home() || is_front_page() ){
		//* If menu is assigned to theme location, output
		if ( has_nav_menu( 'primary' ) ) {
	
			$class = 'menu genesis-nav-menu menu-primary nav navbar-nav pull-right';
			if ( genesis_superfish_enabled() )
				$class .= ' js-superfish';
	
			$args = array(
				'theme_location' => 'primary',
				'container'      => '',
				'menu_class'     => $class,
				'echo'           => 0,
			);
	
			$nav = wp_nav_menu( $args );
	
			//* Do nothing if there is nothing to show
			if ( ! $nav )
				return;
	
			$nav_markup_open = genesis_markup( array(
				'html5'   => '<nav %s>',
				'xhtml'   => '<div id="nav">',
				'context' => 'nav-primary',
				'echo'    => false,
			) );
			$nav_markup_open .= genesis_structural_wrap( 'menu-primary', 'open', 0 );
	
			$nav_markup_close  = genesis_structural_wrap( 'menu-primary', 'close', 0 );
			$nav_markup_close .= genesis_html5() ? '</nav>' : '</div>';
	
			$nav_output = $nav_markup_open . $nav . $nav_markup_close;
			
			
		 }
		 return $nav_output;
		}
	}

	/**
	* Filter Secondary Nav
	*/
	add_filter( 'genesis_do_subnav', 'zp_filter_genesis_subnav', 10, 3 );
	
	function zp_filter_genesis_subnav( $nav_output , $nav, $args){
		
		if ( ! genesis_nav_menu_supported( 'secondary' ) )
		return;

		if( !is_home() || !is_front_page() ){
		//* If menu is assigned to theme location, output
		if ( has_nav_menu( 'secondary' ) ) {

		$class = 'menu genesis-nav-menu menu-secondary nav navbar-nav pull-right';
		if ( genesis_superfish_enabled() )
			$class .= ' js-superfish';

		$args = array(
			'theme_location' => 'secondary',
			'container'      => '',
			'menu_class'     => $class,
			'echo'           => 0,
		);

		$subnav = wp_nav_menu( $args );

		//* Do nothing if there is nothing to show
		if ( ! $subnav )
			return;

		$subnav_markup_open = genesis_markup( array(
			'html5'   => '<nav %s>',
			'xhtml'   => '<div id="subnav">',
			'context' => 'nav-secondary',
			'echo'    => false,
		) );
		$subnav_markup_open .= genesis_structural_wrap( 'menu-secondary', 'open', 0 );

		$subnav_markup_close  = genesis_structural_wrap( 'menu-secondary', 'close', 0 );
		$subnav_markup_close .= genesis_html5() ? '</nav>' : '</div>';

		$subnav_output = $subnav_markup_open . $subnav . $subnav_markup_close;
			
			
		 }
		 return $subnav_output;
		}
	}
	
	/**
	* Filter the default WP comment form fields to add bootstrap CSS. 
	*/
	
	add_filter( 'comment_form_default_fields', 'zp_filter_comment_fields' );
	
	function zp_filter_comment_fields( $fields ){
		
		$commenter = wp_get_current_commenter();
		$req      = get_option( 'require_name_email' );
		$aria_req = ( $req ? " aria-required='true'" : '' );
		$html5    = 'html5';
		
		$fields   =  array(
		'author' => '<p class="comment-form-author">' . '<label for="author">' . __( 'Name', 'start' ) . ( $req ? ' <span class="required">*</span>' : '' ) . '</label> ' .
					'<input id="author" class="form-control input-hg" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' /></p>',
		'email'  => '<p class="comment-form-email"><label for="email">' . __( 'Email', 'start' ) . ( $req ? ' <span class="required">*</span>' : '' ) . '</label> ' .
					'<input id="email" class="form-control input-hg" name="email" ' . ( $html5 ? 'type="email"' : 'type="text"' ) . ' value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . ' /></p>',
		'url'    => '<p class="comment-form-url"><label for="url">' . __( 'Website', 'start' ) . '</label> ' .
					'<input id="url" class="form-control input-hg" name="url" ' . ( $html5 ? 'type="url"' : 'type="text"' ) . ' value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" /></p>'
		);					
		
		return $fields;
	 
	}
	
	/**
	* Filter the default WP comment form comment field to add bootstrap CSS. 
	*/
	
	add_filter( 'comment_form_field_comment', 'zp_comment_form_field_comment' );
	
	function zp_comment_form_field_comment( $comment_field ) {
	
		$comment_field = str_replace( 'id="comment"', 'id="comment" class="form-control input-hg"', $comment_field);
	
		return $comment_field;
	}

	/**
	* Add Bootstrap class to search form
	*/
	remove_filter( 'get_search_form', 'genesis_search_form' );
	add_filter( 'get_search_form', 'zp_custom_search_form' );
	function zp_custom_search_form() {
		
		$search_text = get_search_query() ? apply_filters( 'the_search_query', get_search_query() ) : apply_filters( 'genesis_search_text', __( 'Search this website', 'start' ) . '&#x02026;' );
	
		$button_text = apply_filters( 'genesis_search_button_text', esc_attr__( 'Search', 'start' ) );
	
		$onfocus = "if ('" . esc_js( $search_text ) . "' === this.value) {this.value = '';}";
		$onblur  = "if ('' === this.value) {this.value = '" . esc_js( $search_text ) . "';}";
	
		//* Empty label, by default. Filterable.
		$label = apply_filters( 'genesis_search_form_label', '' );
	
		if ( genesis_html5() )
			$form = sprintf( '<form method="get" class="search-form control-group large" action="%s" role="search">%s<div class="input-group"><input type="search" class="search-input form-control input-lg" name="s" placeholder="%s" /><span class="search-span input-group-btn"><button class="search-btn btn btn-primary btn-lg" type="submit" name="submit"><i class="fa fa-search"></i></button></span></div></form>', home_url( '/' ), esc_html( $label ), esc_attr( $search_text ), esc_attr( $button_text ) );
		else
			$form = sprintf( '<form method="get" class="searchform search-form" action="%s" role="search" >%s<input type="text" value="%s" name="s" class="s search-input" onfocus="%s" onblur="%s" /><input type="submit" class="searchsubmit search-submit" value="%s" /></form>', home_url( '/' ), esc_html( $label ), esc_attr( $search_text ), esc_attr( $onfocus ), esc_attr( $onblur ), esc_attr( $button_text ) );
	
		return $form;

	}