<?php
/**
 * Template part for displaying Custom portfolio custom fields
 *
 * @link
 *
 * @package SeedwpsPlugin
 */

?>

<div class="wrap">
	<h1>Portfolio Settings</h1>
	<?php settings_errors(); ?>

	<ul class="nav nav-tabs">
		<li class="active"><a href="#tab-1">Manage settings</a></li>
		<li><a href="#tab-2">Updates</a></li>
		<li><a href="#tab-3">About</a></li>
	</ul>
	
	<div class="tab-content">
		<div id="tab-1" class="tab-pane active">
			<form method="post" action="options.php">
				<?php 
					settings_fields('seedwps_plugin_portfolio_settings');
					do_settings_sections('seedwps_portfolio_manager');
					submit_button();
				?>		
			</form>
		</div>
		<div id="tab-2" class="tab-pane">
			<h3>Updates</h3>
		</div>
		<div id="tab-3" class="tab-pane">
			<h3>About</h3>
			<p> Everything you need to know about this plugin is on</p><a target="__blank" href="https://github.com/Maccbrainy/seedwps-plugin">Github</a>
		</div>
	</div><!-- .tab-content -->
</div>