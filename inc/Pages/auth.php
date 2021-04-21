<form id="seedwps-auth-form" action="#" method="post" data-url="<?php echo admin_url('admin-ajax.php');?>">
	<div class="auth-btn">
		<input type="button" value="Login" id="seedwps-show-auth-form">
	</div>

	<div id="seedwps-auth-container" class="auth-container">
		<a id="seedwps-auth-close" class="close" href="#">&times;</a>

		<h2>Site Login</h2>
		<label for="username">Username</label>
		<input type="text" name="username" id="username" required>

		<label for="password">Password</label>
		<input type="password" name="password" id="password" required>

		<input type="submit" name="submit" class="submit_button" value="Login">

		<p class="status" data-message="status"></p>
		<p class="actions">
			<a href="<?php echo wp_lostpassword_url();?>">Forgot Password?</a> - <a href="<?php echo wp_registration_url();?>">Register</a>
		</p>
		<input type="hidden" name="action" value="seedwps_login">
		<?php wp_nonce_field('ajax-login-nonce','seedwps_auth');?>
	</div>	
</form>
<div class="site-login-overlay"></div><!-- .site login-overlay -->
 