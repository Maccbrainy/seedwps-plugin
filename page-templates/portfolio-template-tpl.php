<?php
/**
 * Template Name: Portfolio Page Template
 * 
 * @package SeedwpsPlugin
 */
use Inc\Api\CustomSettingsApi;
 
 get_header();


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

                  //Portfolio Post type
                  $portfolio = isset($wp_post_types['portfolio'])? $wp_post_types['portfolio']: $wp_post_types['post'];

                  //Portfolio Post type description
                  $portfolio_description = isset($portfolio->description)? $portfolio->description:'';

                  echo'<div class="portfolio-page-header mt-8 mb-8">';
                    echo'<h1 class="portfolio-page-decription font-semibold"><span>'.$portfolio_description.'</span><h1>';
                  echo'</div>';


                  /*==================================================
                    PORTFOLIO FILTER
                   ===================================================*/


                  echo'<ul class="portfolio-filter justify-center flex">';

                    echo'<li class="portfolio-filter-list list-none mr-7 is-active" data-filter="all">All</li>';


                  // $portfolio_options = ! get_option('seedwps_plugin_portfolio') ? array(): get_option('seedwps_plugin_portfolio');

                  // $portfolio_taxonomy = $portfolio_options['taxonomies'];
                  // OR
                  

                  //One of the many Portfolio Post type taxonomies
                  $portfolio_taxonomy = isset($portfolio->taxonomies[2]) ? $portfolio->taxonomies[2]: '';
                  
                  
                   $portfolio_taxonomy_args = array (
                       'taxonomy' => $portfolio_taxonomy,
                           'orderby' => 'name',
                           'order'   => 'ASC'
                   );

                    $portfolio_taxonomies = get_categories($portfolio_taxonomy_args);

                      // echo'<div class="portfolio-filter text-center">';

                    foreach($portfolio_taxonomies as $portfolio_taxonomy) {

                    echo '<li class="portfolio-filter-list list-none mr-7" data-filter="'.$portfolio_taxonomy->slug.'">
                             '.$portfolio_taxonomy->name.'
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