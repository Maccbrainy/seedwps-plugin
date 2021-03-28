<?php
/**
 * Template Name: Portfolio Page Template
 * 
 * @package SeedwpsPlugin
 */
use Inc\Api\CustomSettingsApi;
 
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
      

         echo'<div class="container portfolio--case-study-container">';

                  /*==================================================
                    PORTFOLIO DESCRIPTION
                   ===================================================*/
                   
                  //WordPress list all post types;
                  global $wp_post_types;

                  // var_dump($wp_post_types['portfolio']->taxonomies[2]);
                  // die;
                  
                  $portfolio = isset($wp_post_types['portfolio'])? $wp_post_types['portfolio']:'';

                  $portfolio_description = isset($portfolio->description)? $portfolio->description:'';

                  echo'<div class="portfolio-page-header mt-8 mb-8">';
                    echo'<h1 class="portfolio-page-decription font-semibold"><span>'.$portfolio_description.'</span><h1>';
                  echo'</div>';


                  /*==================================================
                    PORTFOLIO FILTER
                   ===================================================*/


                  echo'<ul class="portfolio-filter justify-center flex">';

                    echo'<li class="portfolio-filter-list list-none mr-7 is-active" data-filter="all">All</li>';


                  $options = ! get_option('seedwps_plugin_taxonomy') ? array(): get_option('seedwps_plugin_taxonomy');

                  foreach ($options as $option ) {

                      $taxonomy = $option['taxonomy'];
                 
                  }

                       $portfolioCategoriesArgs = array (
                           'taxonomy' => $taxonomy,
                               'orderby' => 'name',
                               'order'   => 'ASC'
                       );

                       $portfolioCategories = get_categories($portfolioCategoriesArgs);

                      // echo'<div class="portfolio-filter text-center">';

                    foreach($portfolioCategories as $portfolioCategory) {

                    echo '<li class="portfolio-filter-list list-none mr-7" data-filter="'.$portfolioCategory->slug.'">
                             '.$portfolioCategory->name.'
                                 </li>';

                         }
                       // echo'</div>';

                  echo'</ul>';

                   /*==================================================
                    PORTFOLIO CONTENT
                   ===================================================*/
                   
                  echo'<div class="flex flex-wrap portfolio--content">';

    
                   if($query-> have_posts()) : 
                      while($query->have_posts()) :$query->the_post();
                      //Getting the Featured Image of the post
                      $thumbnaildata = wp_get_attachment_url(get_post_thumbnail_id(get_the_ID()));
                      //featured image of the post
                      $featuredimage = '<img class="carousel__image" src="' . $thumbnaildata. '"/>'; 
                      //Title of the post
                      $title = get_the_title();
                      //subtitle of the post type
                      $subtitle = get_post_meta( get_the_ID(), '_seedwps_portfolio_key', true )['subtitle'];
                      //Excerpt of the post
                      $excerpt = get_the_excerpt();
                      //permalink of the post
                      $permalink = get_the_permalink();

                      //tags of the posts in the post type
                      $get_the_tags = get_the_tags();
                      $tags = $get_the_tags;  

                      //Retrieves the custom taxonomies of the post
                      $get_the_terms = CustomSettingsApi::seedwps_get_the_taxonomies();

                echo'<div class="portfolio--filter_data '.$get_the_terms.' w-full flex flex-col p-6 sm:w-1/2 lg:w-1/2">';

                        echo'<div class="portfolio-data-content">
                           <div class="portfolio--image"><a href="'.$permalink.'">'.$featuredimage.'</a></div>
                           <p class="portfolio--title uppercase font-medium mt-8 mb-4">'.$title.'</p>
                           <h2 class="portfolio--excerpt pt-0 font-semibold"><a href="'.$permalink.'">'.$excerpt.'</a></h2>';

                       
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