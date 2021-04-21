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

		add_action('wp_head', array($this, 'add_auth_template'));

		add_action('wp_enqueue_scripts',array($this,'enqueue_auth_template_styles_and_scripts') );
		add_action('wp_ajax_nopriv_seedwps_login', array($this, 'login'));
			
	}

	public function enqueue_auth_template_styles_and_scripts()
	{
		if (is_user_logged_in()) return;
		
		wp_enqueue_style('auth_template_css', $this->plugin_url .'assets/dist/css/auth.css');

        wp_enqueue_script('auth_template_js', $this->plugin_url .'assets/dist/js/auth.js');
	}

	public function add_auth_template()
	{
		if (is_user_logged_in()) return;

		$file = $this->plugin_path . 'inc/Pages/auth.php';

		if (file_exists($file)) {

			load_template($file, true);
		}
	}

	public function login()
	{
		check_ajax_referer('ajax-login-nonce','seedwps_auth');

		$info = array();
		$info['user_login'] = $_POST['username'];
		$info['user_password'] = $_POST['password'];
		$info['remember'] = true;

		$user_signon = wp_signon($info, false);

		if (is_wp_error($user_signon)) {
			echo json_encode(
				array(
					'status' =>false,
					'message' => 'Wrong username or password.'
				)
			);

			die();
		}

		echo json_encode(
				array(
					'status' =>true,
					'message' => 'Login successful, redirecting...'
				)
			);

		die();
	}
	
}