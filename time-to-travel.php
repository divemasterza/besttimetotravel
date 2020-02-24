<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://bigambitions.co.za/meet-the-team/
 * @since             1.0.0
 * @package           Time_To_Travel
 *
 * @wordpress-plugin
 * Plugin Name:       Best Time To Travel
 * Plugin URI:        https://bigambitions.co.za
 * Description:       Displays an array icons of best months to travel.
 * Version:           1.0.0
 * Author:            Steph Reinstein
 * Author URI:        https://bigambitions.co.za/meet-the-team/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       time-to-travel
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
define( 'TIME_TO_TRAVEL_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-time-to-travel-activator.php
 */
function activate_time_to_travel() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-time-to-travel-activator.php';
	Time_To_Travel_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-time-to-travel-deactivator.php
 */
function deactivate_time_to_travel() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-time-to-travel-deactivator.php';
	Time_To_Travel_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_time_to_travel' );
register_deactivation_hook( __FILE__, 'deactivate_time_to_travel' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-time-to-travel.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_time_to_travel() {

	$plugin = new Time_To_Travel();
	$plugin->run();

}
run_time_to_travel();
