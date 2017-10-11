<?php
/**
* Home Template
*/

// Force homepage to full width
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

// add custom css in the head

add_action( 'wp_head', 'zp_custom_section_style' );

function zp_custom_section_style(){
	global $post;
	
	$recent = new WP_Query(array('post_type'=> 'section', 'showposts' => '-1','order'=>'DESC' ));
	
	$section_style = '';
	$section_style .= '<style type="text/css">';
	
	while($recent->have_posts()) : $recent->the_post();
	
	$include_header_label= '';
	$text_color = '';
	$section_css = '';
	
	$title = get_the_title();
	$nav_anchor = get_post_meta( $post->ID, 'navigation_anchor', true  );
	$section_intro = get_post_meta( $post->ID, 'section_intro', true  );
	$background_image_id = get_post_meta( $post->ID, 'section_background_image', true  );
	$background_image = wp_get_attachment_url( $background_image_id );
	$background_color = get_post_meta( $post->ID, 'section_background_color', true  );
	$section_text_color = get_post_meta( $post->ID, 'section_text_color', true  );
	$include_header_label = get_post_meta( $post->ID, 'include_header_label', true  );
	$content = get_the_content();
	
	$background_style = '';
	if( $background_image ){
		$background_style = 'background-image: url( '.$background_image.' ); background-attachment: fixed; background-repeat: no-repeat; background-size:cover; position: relative; height: 100%; ';
	}elseif( $background_color ){
		$background_style = 'background-color: '.$background_color.'; ';
	}
	
	if( $section_text_color ){
		$text_color = 'color:'.$section_text_color.'; ';
	}

	
	if( $background_style || $text_color ){
    		$section_style .= '#'.$nav_anchor.'{ '.$background_style.$text_color. '} #'.$nav_anchor.' p.lead{ '.$text_color. '} #'.$nav_anchor.' small{ '.$text_color. '} #'.$nav_anchor.' header p.lead:after{ background-color:'.$section_text_color. '} ';
		}
	if( $include_header_label == 'yes'){ 
			if( !$content ){
				$section_style .= ' #'.$nav_anchor.' header{ padding-bottom: 72px; margin-bottom: 0; }';
		}
	}

	endwhile; wp_reset_query();
	
	$section_style .= '</style>';
	
	echo $section_style;
}

// custom loop
remove_action(	'genesis_loop', 'genesis_do_loop' );
add_action(	'genesis_loop', 'zp_homepage_template' );
function zp_homepage_template() {
	global $post;
	
	
	$recent = new WP_Query(array('post_type'=> 'section', 'showposts' => '-1','order'=>'DESC' ));
	
	while($recent->have_posts()) : $recent->the_post();
	
	$include_header_label= '';
	$text_color = '';
	$section_css = '';
	
	$title = get_the_title();
	$nav_anchor = get_post_meta( $post->ID, 'navigation_anchor', true  );
	$section_intro = get_post_meta( $post->ID, 'section_intro', true  );
	$background_image_id = get_post_meta( $post->ID, 'section_background_image', true  );
	$background_image = wp_get_attachment_url( $background_image_id );
	$background_color = get_post_meta( $post->ID, 'section_background_color', true  );
	$section_text_color = get_post_meta( $post->ID, 'section_text_color', true  );
	$include_header_label = get_post_meta( $post->ID, 'include_header_label', true  );
	$content = get_the_content();
	
	$background_style = '';
	if( $background_image ){
		$background_style = 'background-image: url( '.$background_image.' ); background-attachment: fixed; background-repeat: no-repeat; background-size:cover; position: relative; height: 100%; ';
	}elseif( $background_color ){
		$background_style = 'background-color: '.$background_color.'; ';
	}
	
	if( $section_text_color ){
		$text_color = 'color:'.$section_text_color.'; ';
	}
	
	// check if there is background image
	if( $background_image ){
		$background_data = 'data-speed="30" data-type="background"';	
	}else{
		$background_data = '';	
	}
	
?>
	<section id="<?php echo $nav_anchor; ?>" class="section_wrapper" <?php echo $background_data; ?> >
	<?php


		if( $include_header_label == 'yes'){ 
		
		// add section overlay if there is background-image
		if( $background_image ){
			echo '<div class="slider_overlay"></div>';
		}
	
		?>
        	<header>
		<?php
        	if( $title ){
				echo '<h1>'.$title.'</h1>';
			}
			
			if( $section_intro ){
				echo '<p class="lead">'.$section_intro.'</p>';
			}
		?>
    	</header>
		<?php } ?>
		
		<?php echo do_shortcode( the_content() );?>

    </section>
<?php

endwhile; wp_reset_query();
}

genesis();