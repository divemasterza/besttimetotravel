<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://bigambitions.co.za/meet-the-team/
 * @since      1.0.0
 *
 * @package    Time_To_Travel
 * @subpackage Time_To_Travel/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Time_To_Travel
 * @subpackage Time_To_Travel/includes
 * @author     Steph Reinstein <steph@bigambitions.co.za>
 */
class Time_To_Travel_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'time-to-travel',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
