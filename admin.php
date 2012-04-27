<?php

// Register settings page under the WordPress settings menu
add_action( 'admin_menu', 'basic_cmis_menu' );
function basic_cmis_menu() {
	add_options_page( __('CMIS Options','menu-cmis'), __('CMIS Options','menu-cmis'), 'manage_options', 'basic-cmis-settings', 'basic_cmis_admin' );
	add_action( 'admin_init', 'register_cmis_settings' );
}

// Render settings page
function basic_cmis_admin() {
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
	?>
	<div class="wrap">
	<h2>Simple CMIS</h2>
	<form method="post" action="options.php">
		<?php settings_fields( 'cmis-settings-group' ); ?>
		<?php do_settings_sections( 'cmis_repository' ); ?>
		<table class="form-table">
			<tr valign="top">
				<th scope="row">
					<label for="cmis_repository_url">CMIS Repository URL</label>
				</th>
				<td>
					<input type="text" class="regular-text" name="cmis_repository_url" id="cmis_repository_url" value="<?php echo get_option('cmis_repository_url') ?>">
                    <span class="description">e.g. http://www.example.com/alfresco/service/api/cmis</span>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row">
					<label for="cmis_username">Username</label>
				</th>
				<td>
					<input type="text" name="cmis_username" id="cmis_username" value="<?php echo get_option('cmis_username') ?>">
				</td>
			</tr>
			<tr valign="row">
				<th scope="row">
					<label for="cmis_password">Password</label>
				</th>
				<td>
					<input type="password" name="cmis_password" id="cmis_password" value="<?php echo get_option('cmis_password') ?>">
				</td>
			</tr>
		</table>
		<p class="submit">
			<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
		</p>
	</form>
	</div>
	<?php
}

// Register CMIS settings with WordPress
function register_cmis_settings() {
	register_setting( 'cmis-settings-group', 'cmis_repository_url' );
	register_setting( 'cmis-settings-group', 'cmis_username' );
	register_setting( 'cmis-settings-group', 'cmis_password' );
	add_settings_section( 'cmis_repository', 'CMIS Repository Settings', 'f_cmis_repository_settings_section', 'cmis_repository' );
}

// Render section content for CMIS Repository section
function f_cmis_repository_settings_section() {
	?>
	<p>
		Provide connection URL for a CMIS compliant repository.
	</p>
	<?php
}
?>
