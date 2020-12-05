<?php
/**
 * Dashboard
 * 
 * @package SeedwpsPlugin
 */
namespace Inc\Controllers;


use Inc\Api\AdminSettingsApi;
use \Inc\Controllers\BaseController;
use Inc\Api\Callbacks\AdminCallbacks;
use Inc\Api\Callbacks\AdminManagerCallbacks;


class DashboardController extends BaseController
{
	/**
	 * Stores a new instance of the AdminSettingsApi
	 * @var Class instance
	 */
	public $admin_settings_api;

	/**
	 * Stores a new instance of the AdminManagerCallbacks
	 * @var Class instance
	 */
	public $admin_manager_callbacks;

	/**
	 * Stores a new instance of the AdminCallbacks
	 * @var Class instance
	 */
	public $admin_callbacks;

	/**
	 * Admin Pages array
	 * @var array
	 */
	public $pages = array();


	public function register()
	{
		$this->admin_settings_api = new AdminSettingsApi();

		$this->admin_callbacks = new AdminCallbacks();

		$this->admin_manager_callbacks = new AdminManagerCallbacks();

		$this->setPages();
 
		$this->activateRegisterSetting();

		$this->activateSettingsSection();

		$this->activateSettingsField();

		//Method chaining
		$this->admin_settings_api->AddAdminPages($this->pages)->withSubPage('Dashboard')->register();
	}


	/*=========Admin Page==========*/
	
	public function setPages()
	{
		/**
		 * Admin Pages array
		 * @var array
		 */
		$this->pages = array(

			array(

				'page_title' => 'Seedwps Plugin Options',
				'menu_title' => 'Seedwps Plugin',
				'capability' => 'manage_options',
				'menu_slug' => 'seedwps_plugin',
				'callback' => array($this->admin_callbacks, 'dashboard_Index'),
				'icon_url' => 'dashicons-plugins-checked',
				'position' => 120
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
		 * Seedwps plugin Manager Settings array
		 * @var array
		 */
		$args = array(

			array(
				
				'option_group' => 'seedwps_plugin_settings',
				'option_name' => 'seedwps_plugin',
				'sanitize_callback' => array($this->admin_manager_callbacks,'checkboxSanitize')
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
		 *  Manager Settings Section array
		 * @var array
		 */
		$args = array(
			array(
				'id' =>'seedwps_managers_index',
				'title' =>'Settings Manager',
				'callback' => array($this->admin_manager_callbacks,'adminSectionManager'),
				'page' => 'seedwps_plugin'
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
		 *  Manager Settings field array
		 *  $manager_settings defined in the BaseController
		 * @var array
		 */
		$args = array();

		foreach ($this->manager_settings as $key => $value) {
			
			$args[] = array(
			
				'id' =>$key,
				'title' =>$value,
				'callback' => array($this->admin_manager_callbacks,'checkboxField'),
				'page' => 'seedwps_plugin',
				'section' => 'seedwps_managers_index',
				'args' => array(
					'option_name'	=> 'seedwps_plugin',
					'label_for' 	=>$key,
	 				'class' 		=>'ui-toggle'
	 			)
			);
		}

		$this->admin_settings_api->addfields($args);
	}

}