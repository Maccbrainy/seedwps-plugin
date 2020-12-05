<?php
/**
 * Settings Api for the admin pages 
 * 
 * @package SeedwpsPlugin
 */
namespace Inc\Api;

class AdminSettingsApi
{
	/**
	 * Stores the admin pages array
	 * @var array
	 */
	public $admin_pages = array();

	/**
	 * Stores the admin subpages array
	 * @var array
	 */
	public $admin_subpages = array();

	/**
	 * Stores the register settings array
	 * @var array
	 */
	public $set_registersettings = array();

	/**
	 * Stores the settings sections array
	 * @var array
	 */
	public $set_settings_sections = array();

	/**
	 * Stores the settings field array
	 * @var array
	 */
	public $set_setting_fields = array();

	/**
	 * Register default hooks and actions for Wordpress
	 * @return
	 */
	public function register()
	{
		if (!empty($this->admin_pages) || !empty($this->admin_subpages)) 
		{
			add_action('admin_menu', array($this,'addAdminMenu'));
		}

		if (! empty($this->set_registersettings)) {

			add_action('admin_init', array($this,'registerSettingsSectionsFields'));
		}
			
	}

	/**
	 * Injects user's defined pages array into $admin_pages array
	 *
	 * @param  var $pages      array of user's defined pages
	 */
	public function AddAdminPages($pages)
	{
		$this->admin_pages = $pages;

		return $this;
	}

	public function withSubPage( $title = null)
	{
		if( empty($this->admin_pages)) {

			return $this;
		}

		$admin_page = $this->admin_pages[0];

		$subpage = array(

			array(
				'parent_slug' => $admin_page['menu_slug'],
				'page_title'  => $admin_page['page_title'],
				'menu_title'  => ($title) ? $title : $admin_page['menu_title'],
				'capability'  => $admin_page['capability'],
				'menu_slug'   => $admin_page['menu_slug'],
				'callback'    => $admin_page['callback']
			)
		);

		$this->admin_subpages = $subpage;

		return $this;
	}

	/**
	 * Injects user's defined pages array into $admin_subpages array
	 *
	 * @param  var $subpages      array of user's defined pages
	 */
	public function AddAdminSubPages($subpages)
	{
		$this->admin_subpages = array_merge($this->admin_subpages, $subpages);

		return $this;
	}

	public function addAdminMenu()
	{
		//Generate Seedwps plugin Admin Pages
		foreach ($this->admin_pages as $page) {
			add_menu_page ($page['page_title'],$page['menu_title'],$page['capability'],$page['menu_slug'],$page['callback'],$page['icon_url'],$page['position']);
		}
		//Generate Seedwps plugin Admin SubPages
		foreach ($this->admin_subpages as $subpage) {
			add_submenu_page( $subpage['parent_slug'], $subpage['page_title'], $subpage['menu_title'], $subpage['capability'], $subpage['menu_slug'], $subpage ['callback']);
		}
	}


	/**
	 * Creating methods to populate the setting Api of wordpress
	 * @param var $args      array of user's defined settings
	 */
	public function addSettings($args)
	{
		$this->set_registersettings = $args;

		return $this;
	}

	/**
	 * Creating methods to populate the setting Api of wordpress
	 * @param var $args      array of user's defined settings section
	 */
	public function addSections($args)
	{
		$this->set_settings_sections = $args;

		return $this;
	}

	/**
	 * Creating methods to populate the setting Api of wordpress
	 * @param var $args      array of user's defined settings field
	 */
	public function addfields($args)
	{
		$this->set_setting_fields = $args;

		return $this;
	}

	/**
	 * Call WordPress methods to register settings, sections, and fields
	 */
	public function registerSettingsSectionsFields()
	{
		// Register Setting
		foreach ($this->set_registersettings as $setting) {
			register_setting($setting['option_group'], $setting['option_name'], (isset($setting['sanitize_callback']) ? $setting['sanitize_callback'] : ''));
		}

		//Settings Section
		foreach ($this->set_settings_sections as $section) {
			add_settings_section($section['id'], $section['title'], (isset($section['callback']) ? $section['callback'] : ''),$section['page']);
		}

		// Settings Fields
		foreach ($this->set_setting_fields as $field) {
			add_settings_field($field['id'], $field['title'], (isset($field['callback']) ? $field['callback'] :''), $field['page'], $field['section'], (isset($field['args']) ? $field['args'] : ''));
		}
	}
}
