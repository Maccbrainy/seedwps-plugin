<?php
/**
 * AdminManagerCallbacks 
 * 
 * @package SeedwpsPlugin
 */
namespace Inc\Api\Callbacks;

use \Inc\Controllers\BaseController;

class AdminManagerCallbacks extends BaseController
{
	
	public function checkboxSanitize($input)
	{
		
		// return filter_var($input, FILTER_SANITIZE_NUMBER_INT);
		// return (isset($input) ? true : false);
		$output = array();

		foreach ( $this->manager_settings as $key => $value ) {
			$output[$key] = isset( $input[$key] ) ? true : false;
		}

		return $output;
	}

	public function adminSectionManager()
	{
		echo 'Manage the sections and features of this plugin by activating the checkboxes from the following list.';
	}

	public function checkboxField($args)
	{
		$name = $args['label_for'];
		$classes = $args['class'];
		$option_name = $args['option_name'];
		// $checkbox = get_option( $name );
		$checkbox = get_option( $option_name );
		

		$checked = isset($checkbox[$name]) ? ($checkbox[$name] ? true : false) : false;


		echo '<div class="' . $classes . '"><input type="checkbox" id="' . $name . '" name="' . $option_name . '[' . $name . ']" value="1" class="" ' . ( $checked ? 'checked' : '') . '><label for="' . $name . '"><div></div></label></div>';

		// echo '<div class="' . $classes . '"><input type="checkbox" id="' . $name . '" name="' .$name.'" value="1" class="'.$classes.'" ' . ($checkbox ? 'checked' : '') . '><label for="' . $name . '"><div></div></label></div>';
	}

}
