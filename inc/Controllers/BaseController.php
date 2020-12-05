<?php
/**
 * BaseController 
 * 
 * @package SeedwpsPlugin
 */
namespace Inc\Controllers;

class BaseController
{
	/**
	 * Stores the plugin directory path
	 * @var
	 */
	public $plugin_path;

	/**
	 * Stores the plugin directory url
	 * @var
	 */
	public $plugin_url;

	public $plugin_url2;

	/**
	 * Stores the plugin name
	 * @var
	 */
	public $plugin;

	/**
	 * Register constants used in the plugin
	 * @return
	 */
	
	/**
	 * Stores the plugin manager settings array
	 * @var array
	 */
	public $manager_settings = array();


	public function __construct()
	{
		$this->plugin_path = plugin_dir_path( dirname(__FILE__, 2) );

		$this->plugin_url = plugin_dir_url( dirname(__FILE__, 2) );

		$this->plugin_url2 = plugin_dir_url( dirname(__FILE__, 2) );

		$this->plugin = plugin_basename( dirname(__FILE__, 3) ).'/seedwps-plugin.php';

		$this->manager_settings = array(

			'cpt_manager' 			=>'Activate CPT Manager',
			'taxonomy_manager' 		=> 'Activate Taxonomy Manager',
			'testimonial_manager'	=> 'Activate Testimonial Manager',
			'portfolio_manager'		=> 'Activate portfolio Manager',
			'template_manager'		=> 'Activate custom templates',
			'login_manager'			=>'Activate Login Manager'

		);
	}

	public function activated(string $key)
	{
		/**
		 * Stores the option name of the Manager Settings array
		 * @var 
		 */
		$option_name = get_option( 'seedwps_plugin' );

		/**
		 * Stores the Manager Settings activation option value
		 * $key stores the manager_settings field "id"
		 * It returns true if the CPT option name is activated and false if not. 
		 * @var
		 */
		$activated = isset( $option_name[$key]) ? $option_name[$key] : false;

		return $activated;
	}
		
}