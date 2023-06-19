<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://markussbrikmanis.lv
 * @since      1.0.0
 *
 * @package    Random_Posts
 * @subpackage Random_Posts/admin/partials
 */

?>


<div class="wrap">
	<h1><?php echo get_admin_page_title(); ?></h1>
	<?php settings_errors(); ?>
	<form method="post" action="options.php">
		<?php
			settings_fields( 'rp-settings-page-options-group' );

			do_settings_sections( 'rp-settings-page' );
		?>
		<?php submit_button();?>
	</form>
</div>