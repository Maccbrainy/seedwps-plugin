<?php
/**
 * Template Name: Portfolio Page Template
 * 
 * @package SeedwpsPlugin
 */

 get_header();

    
            // $taxonomy = 'development_categories';
            // $terms = get_terms($taxonomy); // Get all terms of a taxonomy

            // if ( $terms && !is_wp_error( $terms ) ) :
                
            //     echo'<ul>';
            //         foreach ( $terms as $term ) { 
            //             echo'<li><a href="'.get_term_link($term->slug, $taxonomy).'">'.$term->name.'</a></li>';
            //         }
            //     echo'</ul>';
            // endif;

         $args = array (
            'post_type' => 'portfolio',
            'post_status' => 'publish',
            'post_per_page' => -1,
            'meta_query' => array(
               array(
                  'key' =>'_seedwps_portfolio_key',
                  'value' => 's:16:"projectcompleted";b:1;',
                  'compare' =>'LIKE'
               )
            )
         );

         $query = new WP_Query($args);
      

         echo'<div class="portfolio--case-study-container">';

                  global $wp_post_types;

                  $portfolio = $wp_post_types['portfolio'];

                  echo'<div class="portfolio-page-header mt-12 mb-12">';
                    echo'<h1 class="portfolio-page-decription"><span>'.$portfolio->description.'</span><h1>';
                  echo'</div>';



                   $portfolioCategoriesArgs = array (
                       'taxonomy' => 'development_categories',
                           'orderby' => 'name',
                           'order'   => 'ASC'
                   );

                   $portfolioCategories = get_categories($portfolioCategoriesArgs);

                  echo'<div class="portfolio-filter text-center ">';

                     foreach($portfolioCategories as $portfolioCategory) {

                       echo '<a href="'.get_category_link( $portfolioCategory->term_id ).'">
                         '.$portfolioCategory->name.'
                             </a>';

                     }
                   echo'</div>';


                  echo'<div class="flex flex-wrap portfolio--content">';
    
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
                        <div class="portfolio-data-content">
                           <div class="portfolio--image"><a href="'.$permalink.'">'.$featuredimage.'</a></div>
                           <p class="portfolio--title uppercase font-medium mt-10">'.$title.'</p>
                           <h2 class="portfolio--excerpt"><a href="'.$permalink.'">'.$excerpt.'</a></h2>';

                       
                           if(!empty($tags)):
                            echo'<div class="flex flex-wrap flex-row">';
                           foreach ($tags as $tag)
                                  echo'<p class="portfolio--tags tracking-wide">'.$tag->name.'</p>';
                            echo'</div>';
                          endif;
                  echo'</div>'; 
               echo'</div>'; 

            endwhile;  
            endif;

              echo'</div>';
            echo'</div>';        
 wp_reset_postdata();
               
 get_footer();