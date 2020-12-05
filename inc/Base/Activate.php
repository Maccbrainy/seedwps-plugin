<?php
/**
 * Triggers this file on plugin activation 
 * 
 * @package SeedwpsPlugin
 */
namespace Inc\Base;

class Activate
{
	/**
	 * Register default hooks and actions for Wordpress
	 * @return
	 */

	public static function activate()
	{
		//flush rewrite rules
		flush_rewrite_rules();

		$default = array();

		if ( ! get_option('seedwps_plugin')) {

			update_option('seedwps_plugin', $default);
			
		}

		if ( ! get_option('seedwps_plugin_cpt')) {

			update_option('seedwps_plugin_cpt', $default);
			
		}
		if ( ! get_option('seedwps_plugin_taxonomy')) {

			update_option('seedwps_plugin_taxonomy', $default);
			
		}
		
		// if ( ! get_option('seedwps_plugin_portfolio')) {

		// 	update_option('seedwps_plugin_portfolio', $default);
			
		// }

	
	}
}