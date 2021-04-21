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

		return $input;
		
	}
 
	public function portfolioSectionManager()
	{
		echo 'Configure your portfolio to your desired behaviour.';
	}

	public function textField($args)
	{
		$name = $args['label_for'];
		$option_name = $args['option_name'];
		$input = get_option( $option_name );
		$class = $args['class'];
		$value = isset($input[$name])? $input[$name]:'';


		echo '<input type="text" class="'.$class.'" id="' . $name . '" name="' . $option_name . '[' . $name . ']" value="'.$value.'" placeholder="'.$args['placeholder'].'"><label for="' . $name . '"><div></div></label>';

	}

	public function optionsSelect($args)
	{
		$name =$args['label_for'];
		$option_name = $args['option_name'];
		

		//Get the portfolio option name
      	$portfolio_option_name = get_option($option_name);
      	//Get the taxonomy selected for this portfolio
      	$selected_taxonomy = $portfolio_option_name['taxonomies'];


              echo '<select name="'.$option_name . '['.$name.']" id="'.$name.'">';

					//Get the custom taxonomies created
					$options = ! get_option('seedwps_plugin_taxonomy') ? array(): get_option('seedwps_plugin_taxonomy');

	              		foreach ($options as $option) {

	              			$taxonomy = $option['taxonomy'];
	              			$taxonomy_name = $option['singular_name'];

	              			if ($selected_taxonomy == $taxonomy) {
							       $selected = 'selected';
							   } else {
							       $selected = '';
							   }

	              			echo'<option value="'.$taxonomy.'" '.$selected.'>'.$taxonomy_name.'</option>';
	              		}

              echo'</select>';
               
	}

	public function checkboxField($args)
	{

		$name = $args['label_for'];
		$classes = $args['class'];
		$option_name = $args['option_name'];
		$checkbox = get_option( $option_name );
		

		$checked = isset($checkbox[$name]) ? ($checkbox[$name] ? true : false) : false;


		echo '<div class="' . $classes . '"><input type="checkbox" id="' . $name . '" name="' . $option_name . '[' . $name . ']" value="1" class="" ' . ( $checked ? 'checked' : '') . '><label for="' . $name . '"><div></div></label></div>';

	}


}
