<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://markussbrikmanis.lv
 * @since             1.0.0
 * @package           Random_Posts
 *
 * @wordpress-plugin
 * Plugin Name:       Random Posts
 * Plugin URI:        https://markussbrikmanis.lv
 * Description:       Random post fetcher from API.
 * Version:           1.0.0
 * Author:            Markuss Brikmanis
 * Author URI:        https://markussbrikmanis.lv
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       random-posts
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'RANDOM_POSTS_VERSION', '1.0.0' );

define( 'RANDOM_POSTS_NAME', 'random-posts' );

/**
 * Plugin directly path
 */
define( 'RANDOM_POSTS_BASE_DIR', plugin_dir_path(__FILE__) );

/**
 * Plugin directly URL
 */
define( 'RANDOM_POSTS_PLUGIN_URL', plugin_dir_url( __FILE__ ) );


/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-random-posts-activator.php
 */
function activate_random_posts() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-random-posts-activator.php';
	Random_Posts_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-random-posts-deactivator.php
 */
function deactivate_random_posts() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-random-posts-deactivator.php';
	Random_Posts_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_random_posts' );
register_deactivation_hook( __FILE__, 'deactivate_random_posts' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-random-posts.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_random_posts() {

	$plugin = new Random_Posts();
	$plugin->run();

}
run_random_posts();
