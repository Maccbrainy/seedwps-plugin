<?php
/**
 * Template part for displaying Custom portfolio
 *
 * @link https://developer.wordpress.org/reference/functions/add_menu_page/
 *
 * @package SeedwpsPlugin
 */

?>

<div class="wrap">
	<h1> Tab Slider Manager</h1>
	<?php settings_errors();?>

	<ul class="nav nav-tabs">
		<li class="active"><a href="#tab-1">Your portfolios and ShortCodes</a></li>
		<li><a href="#tab-2">Your portfolio</a></li>
	</ul>
	
	<div class="tab-content">
		<div id="tab-1" class="tab-pane active">

			<h3>Manage your portfolios</h3>
			
				<?php
				/*if the seedwps_plugin_cpt is empty in the database, return an empty array() otherwise proceed, use any of the below $options code*/

				// 	$options = get_option('seedwps_plugin_cpt') ?: array();	
				// or
				
				// $options = ! get_option('seedwps_plugin_cpt') ? array(): get_option('seedwps_plugin_cpt');

					echo '<table id="table-ui">
							<tr>
								<th>Post Type ID</th><th>Post Type Name</th><th class="text-center">Short Code Generated</th><th class="text-center"> Actions</th>
							</tr>';

					// foreach ($options as $option) {

					// 	$public = isset($option['public']) ? "TRUE": "FALSE";
					// 	$has_archive = isset($option['has_archive']) ? "TRUE": "FALSE";

					// 	echo "<tr>
					// 			<td>{$option['post_type']}</td><td>{$option['singular_name']}</td><td>{$option['plural_name']}</td><td class=\"text-center\">{$public}</td><td class=\"text-center\">{$has_archive}</td><td class=\"text-center\">";
							/**
							 * A form and a button (utilizing the WordPress submit_button() function) for Editing a custom post type
							 * NB:For editing a CPT, the action="" is made empty meaning the form
							 * is pointing to itself.
							 * And as a result, the settings_fields() function is not needed.
							 *
							 */
							// echo '<form method="post" action="" class="inline-block">';

							// 	echo '<input type="hidden" name="edit_post" value="'.$option['post_type'].'">';

							// 	submit_button('Edit', 'primary small', 'submit', false);

							// echo '</form> ';


							/**
							 * A form and a button (utilizing the WordPress submit_button() function) for
							 * deleting a custom post type 
							 */
					// 		echo '<form method="post" action="options.php" class="inline-block">';

					// 			settings_fields('seedwps_plugin_cpt_settings');

					// 			echo '<input type="hidden" name="remove" value="'.$option['post_type'].'">';
					// 			//utilizing the WordPress submit button to delete a CPT
					// 			submit_button('Delete', 'delete small', 'submit', false, array(
					// 				'onclick'=> 'return confirm("Are you sure you want to delete this Custom Post Type? The data associated with this data will not be deleted!");'
					// 			));

					// 		echo '</form></td></tr>';
					// }

					echo '</table>';
				?>
		</div>  
		<div id="tab-2" class="tab-pane">
			<form method="post" action="options.php">
				<?php 
					settings_fields('seedwps_plugin_portfolio_settings');//option_group
					do_settings_sections('seedwps_portfolio_manager');//section page
					submit_button();
				?>		
			</form>
		</div>
	</div><!-- .tab-content -->
</div>