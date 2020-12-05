<?php
/**
 * AdminCallbacks 
 * 
 * @package SeedwpsPlugin
 */
namespace Inc\Api\Callbacks;

use \Inc\Controllers\BaseController;

class AdminCallbacks extends BaseController
{

	public function dashboard_Index()
	{
		require_once $this->plugin_path .'inc/Pages/dashboard.php';
	}


	public function cpt_Index()
	{
		require_once $this->plugin_path .'inc/Pages/cpt.php';
	}


	public function taxonomy_Index()
	{
		require_once $this->plugin_path .'inc/Pages/taxonomy.php';
	}


	public function testimonial_Index()
	{
		require_once $this->plugin_path .'inc/Pages/testimonial.php';
	}


	public function portfolio_Index()
	{
		require_once $this->plugin_path .'inc/Pages/portfolio.php';
	}

	public function portfolioShortCode_Index()
	{
		require_once $this->plugin_path .'inc/Pages/portfolioshortcode.php';
	}

	public function signin_Index()
	{
		require_once $this->plugin_path .'inc/Pages/signin.php';
	}

}
