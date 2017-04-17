<?php
/*
Plugin Name: Carousel for ak Creative
Description: Used to dislay a carousel without archive (e.g testimonials)
*/

// Enqueue styles and scripts
add_action( 'wp_enqueue_scripts', 'add_ak_carousel_script' );
function add_ak_carousel_script() { 
	wp_enqueue_script( 'ak-carousel-script', plugins_url('ak-carousel/js/ak-carousel-script.js'), array ( 'jquery' ), 1.1, true); 
}

// Create the post shortcode
add_shortcode("akCarousel-posts", "akCarousel_sc");

function ak_the_content( $more_link_text = null, $strip_teaser = false) {
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
    	<div class="ak-carousel-wrapper">
	    	<div class="ak-carousel">'; 
		    
		    foreach($custom_posts as $post) : setup_postdata($post);
		    	$slug = basename(get_permalink());
		    	$title = get_the_title();
		    	$content = ak_the_content();
		    	$output .= 	'
		    	<div class="ak-carousel-post" id="'.$slug.'"
		    		data-index="'.$index.'" 
		    		data-behaviour="ak-carousel-post">
			        <h3 class="ak-carousel-post__headline">
			        	'.$title.'</h3>
			        
			        <div class="ak-carousel-post__content">'
			        	.$content.
			        '</div>
			    </div>';

			$index++;
		    endforeach; wp_reset_postdata();
	    	$output .= 	'</div>
		    <div class="ak-carousel__bottom">
		    	<button class="ak-carousel__button ak-carousel__button--prev">
		    	 	<svg class="ak-icon ak-carousel__icon"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/wp-content/plugins/wp-svg-spritemap-master/defs.svg#:scroll-left"></use></svg>
		    	</button>

		    	<div class="ak-carousel__social"> 
		    		<button class="ak-carousel__button ak-carousel__button--linkedin">
		    			<svg class="ak-icon ak-carousel__icon"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/wp-content/plugins/wp-svg-spritemap-master/defs.svg#:linkedin"></use></svg>
		    		</button>

		    		<button class="ak-carousel__button ak-carousel__button--twitter">
		    			<svg class="ak-icon ak-carousel__icon"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/wp-content/plugins/wp-svg-spritemap-master/defs.svg#:twitter"></use></svg>
		    		</button>

		    		<button class="ak-carousel__button ak-carousel__button--facebook">
		    			<svg class="ak-icon ak-carousel__icon"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/wp-content/plugins/wp-svg-spritemap-master/defs.svg#:facebook"></use></svg>
		    		</button>
		    	</div>

		    	<button class="ak-carousel__button ak-carousel__button--next">
		    	 	<svg class="ak-icon ak-carousel__icon"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/wp-content/plugins/wp-svg-spritemap-master/defs.svg#:scroll-right"></use></svg>
		    	</button>
		    </div>';
	    
		$output .= 	'</div>';
	return $output;
	}
?>
