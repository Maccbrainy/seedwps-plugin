<?php
/**
 * Template part for displaying Custom Taxonomies Admin Area
 *
 * @link https://developer.wordpress.org/reference/functions/add_menu_page/
 *
 * @package seedwps
 */

?>

<div class="wrap">
	<h1> Custom Taxonomy Manager</h1>
	<?php settings_errors();?>

	<ul class="nav nav-tabs">
		<li class="<?php echo !isset($_POST['edit_taxonomy']) ? 'active' : ''; ?>"><a href="#tab-1">Your Custom Taxonomy</a></li>
		<li class="<?php echo isset($_POST['edit_taxonomy']) ? 'active' : ''; ?>">
			<a href="#tab-2">
				<?php echo isset($_POST['edit_taxonomy']) ? 'Edit' : 'Add'; ?> Your Custom Taxonomy
			</a>
		</li>
		<li><a href="#tab-3">Export</a></li>
	</ul>
	
	<div class="tab-content">
		<div id="tab-1" class="tab-pane <?php echo !isset($_POST['edit_taxonomy']) ? 'active' : ''; ?>">

			<h3>Manage your Custom Taxonomy</h3>
			
				<?php
				/*if the seedwps_plugin_taxonomy is empty in the database, return an empty array() otherwise proceed, use any of the below $options code*/

				// 	$options = get_option('seedwps_plugin_taxonomy') ?: array();	
				// or
				
				$options = ! get_option('seedwps_plugin_taxonomy') ? array(): get_option('seedwps_plugin_taxonomy');

				echo '<table id="table-ui">
						<tr>
							<th>ID</th>
							<th>Singular Name</th>
							<th class="text-center">Hierarchical</th>
							<th class="text-center">Activated for Post Type</th>
							<th class="text-center">Actions</th>
						</tr>';

					foreach ($options as $option ) {


						$hierarchical = isset($option['hierarchical']) ? "TRUE": "FALSE";

						$objecttypes = isset($option['objecttypes'])? ($option['objecttypes'] ? $option['objecttypes'] :'None'): null;


						echo '<tr>';
								echo "<td>{$option['taxonomy']}</td>";
								echo "<td>{$option['singular_name']}</td>";
								echo "<td class=\"text-center\">{$hierarchical}</td>";

								echo "<td class=\"text-center capitalize\"><strong>";

									foreach ($objecttypes as $key => $value):

										echo "{$key}"."</br> ";

									endforeach;

								echo "</strong></td>";

								echo "<td class=\"text-center\">";
							/**
							 * A form and a button (utilizing the WordPress submit_button() function) for Editing a custom post type
							 * NB:For editing a CPT, the action="" is made empty meaning the form
							 * is pointing to itself.
							 * And as a result, the settings_fields() function is not needed.
							 **/
							 
							echo '<form method="post" action="" class="inline-block">';

								echo '<input type="hidden" name="edit_taxonomy" value="'.$option['taxonomy'].'">';

								submit_button('Edit', 'primary small', 'submit', false);

							echo '</form> ';


							/**
							 * A form and a button (utilizing the WordPress submit_button() function) for
							 * deleting a Taxonomy 
							 */
									echo '<form method="post" action="options.php" class="inline-block">';

										settings_fields('seedwps_plugin_taxonomy_settings');

										echo '<input type="hidden" name="remove" value="'.$option['taxonomy'].'">';
										//utilizing the WordPress submit button to delete a Taxonomy
										submit_button('Delete', 'delete small', 'submit', false, array(
											'onclick'=> 'return confirm("Are you sure you want to delete this Custom Taxonomy? The data associated with this data will not be deleted!");'
										));

									echo '</form>';
								echo '</td>';
							echo '</tr>';
					}

					echo '</table>';
				?>
		</div>  
		<div id="tab-2" class="tab-pane <?php echo isset($_POST['edit_taxonomy']) ? 'active' : ''; ?>">
			<form method="post" action="options.php">
				<?php 
					settings_fields('seedwps_plugin_taxonomy_settings');//option_group
					do_settings_sections('seedwps_taxonomy_manager');//section page
					submit_button();
				?>		
			</form>
		</div>
		<div id="tab-3" class="tab-pane">
			<h3>Export Your Custom Taxonomies</h3>
		</div>
	</div><!-- .tab-content -->
</div>