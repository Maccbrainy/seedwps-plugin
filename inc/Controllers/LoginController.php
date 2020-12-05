<?php
/**
 * Login Controller
 * 
 * @package SeedwpsPlugin
 */
namespace Inc\Controllers;

use Inc\Api\AdminSettingsApi;
use \Inc\Controllers\BaseController;
use Inc\Api\Callbacks\AdminCallbacks;

class LoginController extends BaseController
{
	/**
	 * Stores a new instance of the AdminSettingsApi
	 * @var Class instance
	 */
	public $admin_settings_api;

	/**
	 * Stores a new instance of the AdminCallbacks
	 * @var Class instance
	 */
	public $admin_callbacks;

	/**
	 * Admin Custom Post Type Subpage array
	 * @var array
	 */
	public $subpages = array();


	public function register()
	{
		//$this->activated() defined in the BaseController
		if ( ! $this->activated('login_manager')) {

			return;
		}
		
		$this->admin_settings_api = new AdminSettingsApi();

		$this->admin_callbacks = new AdminCallbacks();

		add_action('init', array($this, 'activate'));

		$this->setSubpages();

		//Method chaining
		$this->admin_settings_api->AddAdminSubPages($this->subpages)->register();
	}

	public function activate()
	{

			$labels = array(
	        'name'                  => _x( 'Login', 'Post type general name', 'textdomain' ),
	        'singular_name'         => _x( 'Login', 'Post type singular name', 'textdomain' ),
	        'menu_name'             => _x( 'Login', 'Admin Menu text', 'textdomain' ),
	        'name_admin_bar'        => _x( 'Login', 'Add New on Toolbar', 'textdomain' ),
	        'add_new'               => __( 'Add New', 'textdomain' ),
	        'add_new_item'          => __( 'Add New Login', 'textdomain' ),
	        'new_item'              => __( 'New Login', 'textdomain' ),
	        'edit_item'             => __( 'Edit Login', 'textdomain' ),
	        'view_item'             => __( 'View Login', 'textdomain' ),
	        'all_items'             => __( 'All Login', 'textdomain' ),
	        'search_items'          => __( 'Search Login', 'textdomain' ),
	        'parent_item_colon'     => __( 'Parent Login:', 'textdomain' ),
	    );
	       
	 
	    $args = array(
	        'labels'             => $labels,
	        'public'             => true,
	        'publicly_queryable' => true,
	        'show_ui'            => true,
	        'show_in_menu'       => true,
	        'query_var'          => true,
	        'rewrite'            => array( 'slug' => 'login' ),
	        'capability_type'    => 'post',
	        'has_archive'        => true,
	        'hierarchical'       => false,
	        'menu_position'      => null,
	        'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' )
	    );

	    register_post_type('login', $args);

	}

	/*=========Admin SubPages==========*/

	public function setSubpages()
	{
		/**
		 * Admin Login Subpage array
		 * @var array
		 */
		$this->subpages = array(

			array(

				'parent_slug' => 'seedwps_plugin',
				'page_title' => 'Login Settings',
				'menu_title' => 'Login Manager',
				'capability' => 'manage_options',
				'menu_slug' => 'seedwps_login_manager',
				'callback' => array($this->admin_callbacks, 'signin_Index')
			)
		);
	}
}