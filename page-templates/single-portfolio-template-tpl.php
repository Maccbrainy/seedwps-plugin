<?php
/**
 * @package SeedwpsPlugin
 */

 get_header();?>

    <div id="primary" class="content-area">
		<main id="main" class="site-area" role="main">

			<div class="container">
				<div class="row">
					<div class="col-xs-12 col-md-10 col-lg-8 col-lg-offset-2 col-md-offset-1">
						<?php
							if (have_posts()): 
		
								while (have_posts()): the_post();?>

								<article id="post-<?php the_ID();?>"<?php post_class();?>>
									
								 	<header class="entry-header text-center">
								 		<?php the_title( '<h1 class="entry-title">','</h1>'); ?>
									</header>

									<div class="entry-content">

										<?php the_content();?>
									 	
									</div><!-- .entry-content -->
									
								</article>
		
									<?php 

							 	endwhile;
		
							endif;
		
						?>
							
					</div><!-- .col-lg-8 -->
							
				</div><!-- .row -->		

			</div><!-- .container -->
		</main>
	</div><!-- #primary -->

 <?php get_footer();