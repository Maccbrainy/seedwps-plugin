<?php
/**
 * Custom Taxonomy Controller
 * 
 * @package SeedwpsPlugin
 */
namespace Inc\Controllers;

use Inc\Api\AdminSettingsApi;
use \Inc\Controllers\BaseController;
use Inc\Api\Callbacks\AdminCallbacks;
use Inc\Api\Callbacks\TaxonomyCallbacks;

class CustomTaxonomyController extends BaseController
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

	/**
	 * Stores the custom taxonomy  array
	 * @var array
	 */
	public $taxonomies = array();

	/**
	 * Stores a new instance of the TaxonomyCallbacks
	 * @var Class instance
	 */
	public $taxonomy_callbacks;


	public function register()
	{
		//$this->activated() defined in the BaseController
		if ( ! $this->activated('taxonomy_manager')) {

			return;
		}
		
		$this->admin_settings_api = new AdminSettingsApi();

		$this->admin_callbacks = new AdminCallbacks();

		$this->taxonomy_callbacks = new TaxonomyCallbacks();

		// add_action('init', array($this, 'activate'));

		$this->setSubpages();

		$this->activateRegisterSetting();

		$this->activateSettingsSection();

		$this->activateSettingsField();

		//Method chaining
		$this->admin_settings_api->AddAdminSubPages($this->subpages)->register();

		$this->storesCustomTaxonomies();

		if ( ! empty($this->taxonomies)) {

			add_action('init', array($this, 'registerCustomTaxonomy'));
		}

		add_action('admin_enqueue_scripts', array($this,'load_taxonomy_post_checked_noneditable_scripts'));
	}

	/*=========Admin SubPages==========*/

	public function setSubpages()
	{
		/**
		 * Admin Taxonomy Subpage array
		 * @var array
		 */
		$this->subpages = array(

			array(

				'parent_slug' => 'seedwps_plugin',
				'page_title' => 'Taxonomy Settings',
				'menu_title' => 'Taxonomy Manager',
				'capability' => 'manage_options',
				'menu_slug' => 'seedwps_taxonomy_manager',
				'callback' => array($this->admin_callbacks, 'taxonomy_Index')
			)
		);
	}

	/*==================================
		Register settings
	====================================
	*/
	public function activateRegisterSetting()
	{
		/**
		 * Seedwps plugin Custom taxonomy Settings array
		 * @var array
		 */
		$args = array(

			array(
				
				'option_group' => 'seedwps_plugin_taxonomy_settings',
				'option_name' => 'seedwps_plugin_taxonomy',
				'sanitize_callback' => array($this->taxonomy_callbacks,'taxonomySanitize')
			)
		);

		$this->admin_settings_api->addSettings($args);
	}

	/*==================================
		settings sections
	====================================
	*/
	public function activateSettingsSection()
	{
		/**
		 *  Custom taxonomy Settings Section array
		 * @var array
		 */
		$args = array(
			array(
				'id' =>'seedwps_taxonomy_index',
				'title' =>'Custom Taxonomy Manager',
				'callback' => array($this->taxonomy_callbacks,'taxonomySectionManager'),
				'page' => 'seedwps_taxonomy_manager'
			)
		);

		$this->admin_settings_api->addSections($args);
	}

	/*==================================
		settings field
	====================================
	*/
	public function activateSettingsField()
	{
		/**
		 *  Custom Taxonomy Settings field array
		 * 
		 * @var array
		 */
		$args = array(

			array(
			
				'id' => 'taxonomy',
				'title' =>'Custom Taxonomy ID',
				'callback' => array($this->taxonomy_callbacks,'textField'),
				'page' => 'seedwps_taxonomy_manager',
				'section' => 'seedwps_taxonomy_index',
				'args' => array(
					'option_name'	=> 'seedwps_plugin_taxonomy',
					'label_for' 	=>'taxonomy',
					'placeholder'	=>'eg. genre',
					'class' 		=> isset($_POST['edit_taxonomy']) ? 'noneditable': 'regular-text',
					'array'			=>'taxonomy'
	 				
	 			)
			),
			array(
			
				'id' =>'singular_name',
				'title' =>'Singular Name',
				'callback' => array($this->taxonomy_callbacks,'textField'),
				'page' => 'seedwps_taxonomy_manager',
				'section' => 'seedwps_taxonomy_index',
				'args' => array(
					'option_name'	=> 'seedwps_plugin_taxonomy',
					'label_for' 	=>'singular_name',
					'placeholder'	=>'eg. Genre',
					'class' 		=>'regular-text',
					'array'			=>'taxonomy'			
	 			)
			),
			
			array(
			
				'id' =>'hierarchical',
				'title' =>'Hierarchical',
				'callback' => array($this->taxonomy_callbacks,'checkboxField'),
				'page' => 'seedwps_taxonomy_manager',
				'section' => 'seedwps_taxonomy_index',
				'args' => array(
					'option_name'	=> 'seedwps_plugin_taxonomy',
					'label_for' 	=>'hierarchical',
					'class' 		=>'ui-toggle',
					'array'			=>'taxonomy'	
	 			)
			),
			array(
			
				'id' =>'objecttypes',
				'title' =>'Post Types',
				'callback' => array($this->taxonomy_callbacks,'checkboxPostTypesField'),
				'page' => 'seedwps_taxonomy_manager',
				'section' => 'seedwps_taxonomy_index',
				'args' => array(
					'option_name'	=> 'seedwps_plugin_taxonomy',
					'label_for' 	=>'objecttypes',
					'class' 		=>'ui-toggle',
					'array'			=>'taxonomy'	
	 			)
			)

		);

		$this->admin_settings_api->addfields($args);
	}
	public function storesCustomTaxonomies()
	{
		/*if the seedwps_plugin_taxonomy is empty in the database, return an empty array() otherwise proceed and get the taxonomy array*/
		$options = ! get_option('seedwps_plugin_taxonomy') ? array(): get_option('seedwps_plugin_taxonomy');


		//store the info into an array
		foreach ($options as $option) {

			$labels = array(
				'name'  			=> $option['singular_name'],
				'singular_name'     => $option['singular_name'],
				'search_items'      => 'Search '. $option['singular_name'],
				'all_items'         => 'All '. $option['singular_name'],
				'parent_item'       => 'Parent '. $option['singular_name'],
				'parent_item_colon' => 'Parent '. $option['singular_name'],
				'edit_item'         => 'Edit '. $option['singular_name'],
				'update_item'       => 'Update '. $option['singular_name'],
				'add_new_item'      => 'Add New '. $option['singular_name'],
				'new_item_name'     => 'New '. $option['singular_name']. ' name',
				'menu_name'         => $option['singular_name']
			);
				$this->taxonomies[] = array(
					'hierarchical'      => isset($option['hierarchical'])? true: false,
					'labels'            => $labels,
					'show_ui'           => true,
					'show_admin_column' => true,
					'query_var'         => true,
					'rewrite'           => array('slug' => $option['taxonomy']),
					'objecttypes'		=> isset($option['objecttypes'])? $option['objecttypes']: null
				);
		}


	}
	public function registerCustomTaxonomy()
	{
		foreach ($this->taxonomies as $taxonomy) {
			//checking if the objecttypes of the post types is set
			$objecttypes = isset($taxonomy['objecttypes'])? array_keys($taxonomy['objecttypes']): null;

			register_taxonomy( $taxonomy['rewrite']['slug'], $objecttypes, $taxonomy);
				
		}
	}

	public function load_taxonomy_post_checked_noneditable_scripts($hook)
	{

		$post_array = array('seedwps-plugin_page_seedwps_taxonomy_manager');
			
			if ( ! in_array($hook, $post_array) ) return;

	    	if ('seedwps-plugin_page_seedwps_taxonomy_manager' == $hook) {
	    		
	    	wp_enqueue_script('checkpostboxbydefault', $this->plugin_url .'assets/dist/js/checkpostboxbydefault.js');
	    	}
	}
}