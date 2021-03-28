<?php

use Inc\Api\CustomSettingsApi;

$args = array(

	'post_type' => 'portfolio',
	'post_status' => 'publish',
	'post_per_page' => -1,
	'meta_query' => array(
		array(
			'key' =>'_seedwps_portfolio_key',
			'value' =>'s:8:"featured";b:1;',
			'compare' =>'LIKE'
		)
	)
);

$query = new WP_Query($args);



echo'<div class="carousel">
		<button class="carousel_button"><span class="carousel__button--left">&#10094;</span></button>';

		echo '<div class="carousel__logo_navigation">';
	// $i = 1;
// $is_active = ($i === 1 ? ' is-active' : '' );
		if ($query->have_posts()) :
		while($query->have_posts()): $query->the_post();

			//tabimage of the post
			$meta_logo_key = '_seedwps_portfolio_tabimage_key';
			$tabimage = CustomSettingsApi::portfolio_project_logo_display( $meta_logo_key, get_post_meta(get_the_ID(), $meta_logo_key, true) );

				echo'<figure class="carousel__logo__indicator">'.$tabimage.'</figure>';
		// $i++;
	endwhile;
	endif;
		echo'</div>';

	// $i= 1;
	//<----Container for the Thumbnail gallery---->
	echo '<div class="carousel__track-container">
				<ul class="carousel__track">';

		while($query->have_posts()) : $query->the_post();

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


			echo '<li class="carousel__slide">
					<div class="case-study-content">
						<div class="case-study case-study-featuredimage">'.$featuredimage.'
						</div>
						<div class="case-study case-study-detail">
							<h4 class="case-study-title">'.$title.'</h4>
							<h2 class="case-study-subtitle">'.$subtitle.'</h2>
							<p class="case-study-description">'.$excerpt.'</p>
							<a href="'.$permalink.'" class="btn1">View Portfolio</a>
							<a href="#" class="btn2">Contact Us</a>
						</div>
					</div>
				  </li>';
		// $i++;
		endwhile;

		echo '</ul>
			</div>
				<button class="carousel_button"><span class="carousel__button--right">&#10095;</span></button>';

			echo'<div class="carousel_dots">';
				// $i = 1;

			if ($query->have_posts()) :
			while($query->have_posts()): $query->the_post();

			$carouselindicator = isset($title)?'carousel_indicator':'carousel_indicator';

			
				echo '<figure class="'.$carouselindicator.'"></figure>';
			// $i++;
		endwhile;
		endif;
			echo'</div>';

		echo '</div>';

wp_reset_postdata(); 