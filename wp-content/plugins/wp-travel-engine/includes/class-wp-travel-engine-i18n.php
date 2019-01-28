<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * 
 * @since      1.0.0
 *
 * @package    Wp_Travel_Engine
 * @subpackage Wp_Travel_Engine/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Wp_Travel_Engine
 * @subpackage Wp_Travel_Engine/includes
 * @author     WP Travel Engine <https://wptravelengine.com/>
 */
class Wp_Travel_Engine_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'wp-travel-engine',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);
	}
}
