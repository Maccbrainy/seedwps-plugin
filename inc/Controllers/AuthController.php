<?php
/**
 * Authentication Controller
 * 
 * @package SeedwpsPlugin
 */
namespace Inc\Controllers;

use Inc\Api\AdminSettingsApi;
use \Inc\Controllers\BaseController;
use Inc\Api\Callbacks\AdminCallbacks;

class AuthController extends BaseController
{


	public function register()
	{
		//$this->activated() defined in the BaseController
		if ( ! $this->activated('login_manager')) {

			return;
		}
			
	}
	
}