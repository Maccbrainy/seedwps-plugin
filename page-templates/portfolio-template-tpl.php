<?php
/**
 * Template Name: Portfolio Page Template
 * 
 * @package SeedwpsPlugin
 */

 get_header();

    

         $args = array (
            'post_type' => 'portfolio',
            'post_status' => 'publish',
            'post_per_page' => -1
         );

         $query = new WP_Query($args);
      

         echo'<div class="portfolio--case-study-container">
                  <div class="flex flex-wrap portfolio--content">';

               
               if($query-> have_posts()) : 
                  while($query->have_posts()) :$query->the_post();
                  //Getting the Featured Image of the post type
                  $thumbnaildata = wp_get_attachment_url(get_post_thumbnail_id(get_the_ID()));
                  //featured image of the post type
                  $featuredimage = '<img class="carousel__image" src="' . $thumbnaildata. '"/>'; 
                  //Title of the post type
                  $title = get_the_title();
                  //subtitle of the post type
                  $subtitle = get_post_meta( get_the_ID(), '_seedwps_portfolio_key', true )['subtitle'];
                  //Excerpt of the post type
                  $excerpt = get_the_excerpt();
                  //permalink of the post type
                  $permalink = get_the_permalink();

                  //tags of the posts in the post type
                  $get_the_tags = get_the_tags();
                  $tags = $get_the_tags;
               

               echo'<div class="portfolio--page_data w-full flex flex-col p-10 sm:w-1/2 lg:w-1/2">
                       <div class="portfolio--image"><a href="'.$permalink.'">'.$featuredimage.'</a></div>
                       <p class="portfolio--title">'.$title.'</p>
                       <h2 class="portfolio--excerpt">'.$excerpt.'</h2>';

                       
                       if(!empty($tags)):
                        echo'<div class="portfolio--tags">';
                       foreach ($tags as $tag)
                        
                                 echo'<p class="-bottom-4">#'.$tag->name.'</p></div>';
                  endif; 
               echo'</div>'; 

            endwhile;  
            endif;

            echo'</div></div>';        
 wp_reset_postdata();
               
 get_footer();