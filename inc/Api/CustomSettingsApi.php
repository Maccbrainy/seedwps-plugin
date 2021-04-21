<?php
/**
 * Custom Settings Api 
 * 
 * @package SeedwpsPlugin
 */
namespace Inc\Api;

class CustomSettingsApi
{

	/**
	 * Retrieve post custom categories/taxonomies
	 * @return returns results from the custom taxonomies defined
	 */
	public static function seedwps_get_the_taxonomies(){

		global $wp_post_types;

		//Portfolio Post type
        $portfolio = isset($wp_post_types['portfolio'])? $wp_post_types['portfolio']: $wp_post_types['post'];

        //One of the many Portfolio Post type taxonomies
		$portfolio_taxonomy = isset($portfolio->taxonomies[2]) ? $portfolio->taxonomies[2]: '';


        $taxonomy = $portfolio_taxonomy;
        $terms = get_the_terms(get_the_ID(), $taxonomy);

	    $separator = ' ';
	    $output = '';
	    $i = 1;

	    if (!empty($terms)):
	        foreach ($terms as $term):
	            if ($i > 1): 
	            $output .= $separator;
	    endif;

	    $output .= esc_html($term->slug);
	    ++$i;
	    endforeach;
	    endif;

	    return $output;
	}

	public static function portfolio_logo_uploader_field( $name, $value='')
	{

	    $image = ' button">Upload Project Logo';
	    $image_size = 'full'; // it would be better to use thumbnail size here (150x150 or so)
	    $display = 'none'; // display state of the "Remove image" button

	    if( $image_attributes = wp_get_attachment_image_src( $value, $image_size ) ) {

	        // $image_attributes[0] - image URL
	        // $image_attributes[1] - image width
	        // $image_attributes[2] - image height

	        $image = '"><img src="' . $image_attributes[0] . '" style="max-width:50%;display:block;" />';

	    } 

	    return '
	    <div>
	        <a href="#" class="portfolio_upload_image_button' . $image . '</a>

	        <input type="hidden" name="' . $name . '" id="' . $name . '" value="' . $value. '" />
	        <a href="#" class="portfolio_remove_image_button" style="display:inline-block">Remove image</a>
	    </div>'; 

	}

	public static function portfolio_project_logo_display( $name, $value='')
	{

	    $image = '">No project logo';
	    $image_size = 'full'; // it would be better to use thumbnail size here (150x150 or so)
	    $display = 'none'; // display state ot the "Remove image" button

	    if( $image_attributes = wp_get_attachment_image_src( $value, $image_size ) ) {

	        $image = '"><img src="' . $image_attributes[0] . '" style="max-width:70%;display:inline-block;" />';
	    } 

	    return '
	    <div class="img-thumb">
	        <span class="portfolio_upload_image_button' . $image . '</span>
	    </div>';
	}

}