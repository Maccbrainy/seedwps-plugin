<?php
/**
 * Enqueue scripts
 * 
 * @package SeedwpsPlugin
 */
namespace Inc\Base;

use \Inc\Controllers\BaseController;

class Enqueue extends BaseController
{
	/**
	 * Register default hooks and actions for Wordpress
	 * @return
	 */
	
	public function register()
	{
		add_action('admin_enqueue_scripts', array($this, 'enqueue'));
	}

	public function enqueue()
	{
		//Enqueue css style
		// wp_enqueue_style('seedwps_css', mix('css/seedwpsplugin.css'), array(),'1.0.0', 'all');
		wp_enqueue_style('seedwpsplugin_css', $this->plugin_url .'assets/dist/css/seedwpsplugin.css');

		//Enqueue script
		// wp_enqueue_script('seedwps_js', mix('js/seedwpsplugin.js'), array(), '1.0.0', true);
		wp_enqueue_script('seedwpsplugin_js', $this->plugin_url .'assets/dist/js/seedwpsplugin.js');
	}
}