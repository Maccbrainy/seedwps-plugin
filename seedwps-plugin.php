<?php
/*
Plugin Name: Seedwps Plugin for WordPress
Plugin URI: "https://github.com/maccbrainy/seedwps-plugin"
Description: WordPress Custom Post Type and Taxonomy creator and Ajax signup/Login Manager
version: 1.0.0
Author: Iketaku 'maccbrainy' Michael C
Author URI: "https://maccbrainy.com"
License: GPLv3
*/
/**
 * if this file is called directly, abort!!!
 */
defined('ABSPATH') or die('Hey, you cannot access this file you silly human!');

/**
 * Require once for the composer autoload
 */
if ( file_exists(dirname(__FILE__) . '/vendor/autoload.php')) :

	require_once dirname(__FILE__). '/vendor/autoload.php';

endif;

/**
 * The code that runs during plugin activation
 * @return [function] [plugin activation]
 */
function activate_Seedwps_Plugin()
{
	inc\Base\Activate::activate();
}
register_activation_hook(__FILE__, 'activate_Seedwps_Plugin');

/**
 * The code that runs during plugin deactivation
 * @return [function] [Plugin deactivation]
 */
function deactivate_Seedwps_Plugin()
{
	Inc\Base\Deactivate::deactivate();
}
register_activation_hook(__FILE__, 'deactivate_Seedwps_Plugin');


/**
 * Initialize all the core classes of the plugin
 */

if (class_exists('Inc\\Init')):
	
	Inc\Init::registerServices();

endif;


