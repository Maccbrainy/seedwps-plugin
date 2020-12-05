<?php
/**
 * SettingsLinks
 * 
 * @package SeedwpsPlugin
 */
namespace Inc\Base;

use \Inc\Controllers\BaseController;

class SettingsLinks extends BaseController
{

	/**
	 * Register default hooks and actions for Wordpress
	 * @return
	 */
	public function register()
	{
		add_filter( 'plugin_action_links_' . $this->plugin, array($this, 'settingsLinks' ));
	}

	public function settingsLinks($links)
	{
		$admin_url = admin_url( 'admin.php?page=seedwps_plugin' );

		$settings_link = '<a href="' . $admin_url . '">Settings</a>';

		array_push( $links, $settings_link);

		return $links;
	}

}