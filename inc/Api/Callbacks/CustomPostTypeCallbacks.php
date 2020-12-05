<?php
/**
 * Custom Post Type Callbacks 
 * 
 * @package SeedwpsPlugin
 */
namespace Inc\Api\Callbacks;


class CustomPostTypeCallbacks
{
	
	public function cptSanitize($input)
	{

		$output = get_option('seedwps_plugin_cpt');

		if(isset($_POST['remove'])){
			unset($output[$_POST['remove']]);

			return $output;		
		}

		if (count($output) == 0) {

			$output[ $input['post_type'] ] = $input;

			return $output;
		}

		foreach ($output as $key => $value) {

			if ($input['post_type'] === $key) {
				$output[$key] = $input;
			}else
			{
				$output[ $input['post_type'] ] = $input;
			}
		}

		return $output;
		
	}
 
	public function cptSectionManager()
	{
		$edit_cpt = 'Edit your custom post type to your desire';
		$create_cpt = 'Create your custom post type(s) as many as you want.';

		echo isset($_POST['edit_post']) ? $edit_cpt : $create_cpt;
	}

	public function textField($args)
	{
		$name = $args['label_for'];
		$option_name = $args['option_name'];
		$input = get_option( $option_name );
		$class = $args['class'];
		$value = '';
		// $value2 = $input[$name];
		
		if(isset($_POST['edit_post'])){

			$input = get_option( $option_name );

			$value = $input[ $_POST['edit_post'] ] [$name];

		}

		echo '<input type="text" class="'.$class.'" id="' . $name . '" name="' . $option_name . '[' . $name . ']" value="'.$value.'" placeholder="'.$args['placeholder'].'" required><label for="' . $name . '"><div></div></label>';
	}


	public function checkboxField($args)
	{
		$name = $args['label_for'];
		$classes = $args['class'];
		$option_name = $args['option_name'];
		
		$checked = false;
		
		if(isset($_POST['edit_post'])){

			$checkbox = get_option( $option_name );

			$checked = isset($checkbox[$_POST['edit_post']][$name]) ?: false;
		}

		echo '<div class="' . $classes . '"><input type="checkbox" id="' . $name . '" name="' . $option_name . '[' . $name . ']" value="1" class="" ' . ( $checked ? 'checked' : '') . '><label for="' . $name . '"><div></div></label></div>';

	}

}
