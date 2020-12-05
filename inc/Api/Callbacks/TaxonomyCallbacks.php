<?php
/**
 * Custom Taxonomy Callbacks
 * 
 * @package SeedwpsPlugin
 */
namespace Inc\Api\Callbacks;


class TaxonomyCallbacks
{
	
	public function taxonomySanitize($input)
	{
		$output = get_option('seedwps_plugin_taxonomy');

		if(isset($_POST['remove'])){
			unset($output[$_POST['remove']]);

			return $output;		
		}

		if (count($output) == 0) {

			$output[ $input['taxonomy'] ] = $input;

			return $output;
		}

		foreach ($output as $key => $value) {

			if ($input['taxonomy'] === $key) {
				$output[$key] = $input;
			}else
			{
				$output[ $input['taxonomy'] ] = $input;
			}
		}

		return $output;
		
	}
 
	public function taxonomySectionManager()
	{
		$edit_taxonomy = 'Edit your custom taxonomy to your desire';
		$create_taxonomy = 'Create your custom taxonomy type(s) as many as you want.';

		echo isset($_POST['edit_taxonomy']) ? $edit_taxonomy : $create_taxonomy;
	}

	public function textField($args)
	{
		$name = $args['label_for'];
		$option_name = $args['option_name'];
		$input = get_option( $option_name );
		$class = $args['class'];
		$value = '';
		
		if(isset($_POST['edit_taxonomy'])){

			$input = get_option( $option_name );

			$value = $input[ $_POST['edit_taxonomy'] ] [$name];

		}

		echo '<input type="text" class="'.$class.'" id="' . $name . '" name="' . $option_name . '[' . $name . ']" value="'.$value.'" placeholder="'.$args['placeholder'].'" required><label for="' . $name . '"><div></div></label>';
	}


	public function checkboxField($args)
	{
		$name = $args['label_for'];
		$classes = $args['class'];
		$option_name = $args['option_name'];
		
		$checked = false;
		
		if(isset($_POST['edit_taxonomy'])){

			$checkbox = get_option( $option_name );

			$checked = isset($checkbox[$_POST['edit_taxonomy']][$name]) ?: false;
		}

		echo '<div class="' . $classes . '"><input type="checkbox" id="' . $name . '" name="' . $option_name . '[' . $name . ']" value="1" class="" ' . ( $checked ? 'checked' : '') . '><label for="' . $name . '"><div></div></label></div>';

	}

	public function checkboxPostTypesField($args)
	{
		$output = '';
		$name = $args['label_for'];
		$classes = $args['class'];
		$option_name = $args['option_name'];
		
		$checked = false;
		$selected='';
		
		if(isset($_POST['edit_taxonomy'])){

			$checkbox = get_option( $option_name );

		}

		$post_types = get_post_types( array('show_ui' => true));

		foreach ($post_types as $post_type) {


			if(isset($_POST['edit_taxonomy'])){

				$checked = isset($checkbox[$_POST['edit_taxonomy']][$name][$post_type]) ?: false;
			}

			// $output.=$post_type . '</br>';
			$output.='<div class="' . $classes . ' mb-12 flex full-width"><input type="checkbox" id="' . $post_type . '" name="' . $option_name . '[' . $name . ']['.$post_type.']" value="1" class="" ' . ( $checked ? 'checked' : '') . '><label for="' . $post_type . '"><div></div></label><strong class="mt--6">'.$post_type.'</strong></div>';
		}

		echo $output;

	}


}
