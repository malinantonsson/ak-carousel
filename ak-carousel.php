<?php
/*
Plugin Name: Carousel for ak Creative
Description: Used to dislay a carousel without archive (e.g testimonials). Shortcode: [akCarousel-posts post_type="posttype_name"].
*/

// Enqueue styles and scripts
add_action( 'wp_enqueue_scripts', 'add_ak_carousel_script' );
function add_ak_carousel_script() { 
	wp_enqueue_script( 'ak-carousel-script', plugins_url('ak-carousel/js/ak-carousel-script.js'), array ( 'jquery' ), 1.1, true); 
}

// Create the post shortcode
add_shortcode("akCarousel-posts", "akCarousel_sc");

function ak_carousel_content( $more_link_text = null, $strip_teaser = false) {
    $content = get_the_content( $more_link_text, $strip_teaser );
    $content = apply_filters( 'the_content', $content );
    $content = str_replace( ']]>', ']]&gt;', $content );
    return $content;
}

function akCarousel_sc($atts) {
	extract(shortcode_atts(array( "post_type" => ''), $atts));
    global $post;

    $args = array(
    	'post_type' => $post_type, 
    	'posts_per_page' => 10, 
    	'order'=> 'DSC', 
    	'orderby' => 'date');

    $custom_posts = get_posts($args);
    $output = '';

	$index = 0;
    $output .= 	'
    	<div class="ak-post-wrapper ak-carousel-wrapper">
	    	<div class="ak-posts ak-carousel">'; 
		    
		    foreach($custom_posts as $post) : setup_postdata($post);
		    	$slug = basename(get_permalink());
		    	$title = get_the_title();
		    	$content = ak_carousel_content();
		    	$output .= 	'
		    	<div class="ak-post ak-carousel-post" id="'.$slug.'"
		    		data-index="'.$index.'">
					<h3 class="ak-post__headline ak-carousel-post__headline">
			        	'.$title.'</h3>
 
			        <div class="ak-post__content ak-carousel-post__content">'
			        	.$content.
			        '</div>
			    </div>';

			$index++;
		    endforeach; wp_reset_postdata();
	    	$output .= 	'</div>
		    <div class="ak-post-nav">
		    	<div class="ak-post-nav__inner">
			    	<button class="ak-post-nav__button ak-carousel__button--prev">
			    	 	<svg class="ak-icon ak-post-nav__icon"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/wp-content/plugins/wp-svg-spritemap-master/defs.svg#:scroll-left"></use></svg>
			    	</button>

			    	<button class="ak-post-nav__button ak-carousel__button--next">
			    	 	<svg class="ak-icon ak-post-nav__icon"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/wp-content/plugins/wp-svg-spritemap-master/defs.svg#:scroll-right"></use></svg>
			    	</button>
			    </div>
		    </div>';
	    
		$output .= 	'</div>';
	return $output;
	}
?>
