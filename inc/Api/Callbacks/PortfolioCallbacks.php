<?php
/**
 * portfolio Callbacks
 * 
 * @package SeedwpsPlugin
 */
namespace Inc\Api\Callbacks;


class PortfolioCallbacks
{
	
	public function portfolioSanitize($input)
	{
		$output = get_option('seedwps_plugin_portfolio');

		if(isset($_POST['remove'])){
			unset($output[$_POST['remove']]);

			return $output;		
		}

		if (count($output) == 0) {

			$output[ $input['portfolio'] ] = $input;

			return $output;
		}

		foreach ($output as $key => $value) {

			if ($input['portfolio'] === $key) {
				$output[$key] = $input;
			}else
			{
				$output[ $input['portfolio'] ] = $input;
			}
		}

		return $output;
		
	}
 
	public function portfolioSectionManager()
	{
		$create_taxonomy = 'Select a post type(s) to slide in the front end as many as you want.';

		echo $create_taxonomy;
	}

	public function textField($args)
	{
		$output = '';
		$name = $args['label_for'];
		$option_name = $args['option_name'];
		$input = get_option( $option_name );
		$class = $args['class'];
		$value = '';
		


		$post_types = get_post_types( array('show_ui' => true ));


		echo '<label for="' . $name . '"></label>';

			echo '<select id="' . $name . '">';

			foreach ($post_types as $post_type):

				echo '<option name="'.$post_type.'" value="'.$post_type.'">'.$post_type.'</option>';

			endforeach;

		echo '</select>';

		// echo $output;

	}


}
