<?php
/**
 * Triggers this file on plugin deactivation 
 * 
 * @package SeedwpsPlugin
 */
namespace Inc\Base;

class Deactivate
{
	/**
	 * Register default hooks and actions for Wordpress
	 * @return
	 */

	public static function deactivate()
	{
		//flush rewrite rules
		flush_rewrite_rules();
	}
}