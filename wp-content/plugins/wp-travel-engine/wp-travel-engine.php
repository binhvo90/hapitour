<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://wptravelengine.com/
 * @since             1.0.0
 * @package           WP_Travel_Engine
 *
 * @wordpress-plugin
 * Plugin Name:       WP Travel Engine
 * Plugin URI:        https://wordpress.org/plugins/wp-travel-engine/
 * Description:       WP Travel Engine is a free travel booking WordPress plugin to create travel and tour packages for tour operators and travel agencies. It is a complete travel management system and includes plenty of useful features. You can create your travel booking website using WP Travel Engine in less than 5 minutes.
 * Version:           1.9.2
 * Author:            WP Travel Engine
 * Author URI:        https://wptravelengine.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wp-travel-engine
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'WP_TRAVEL_ENGINE_FILE_PATH', __FILE__ );
define( 'WP_TRAVEL_ENGINE_BASE_PATH', dirname( __FILE__ ) );
define( 'WP_TRAVEL_ENGINE_IMG_PATH', WP_TRAVEL_ENGINE_BASE_PATH.'/admin/css/icons' );
define( 'WP_TRAVEL_ENGINE_TEMPLATE_PATH', WP_TRAVEL_ENGINE_BASE_PATH.'/includes/templates' );
define( 'WP_TRAVEL_ENGINE_FILE_URL', plugins_url( '', __FILE__ ) );
define( 'WP_TRAVEL_ENGINE_VERSION', '1.9.2' );
define( 'WP_TRAVEL_ENGINE_POST_TYPE', 'trip' );
define( 'WP_TRAVEL_ENGINE_URL', rtrim( plugin_dir_url( __FILE__ ), '/' ) );
define( 'WP_TRAVEL_ENGINE_IMG_URL', rtrim( plugin_dir_url( __FILE__ ), '/' ) );
// this is the URL our updater / license checker pings. This should be the URL of the site with EDD installed
define( 'WP_TRAVEL_ENGINE_STORE_URL', 'https://wptravelengine.com/' ); // IMPORTANT: change the name of this constant to something unique to prevent conflicts with other plugins using this system
define( 'WP_TRAVEL_ENGINE_PLUGIN_LICENSE_PAGE', 'wp_travel_engine_license_page' );

/**
 * Load plugin updater file
 */
require plugin_dir_path( __FILE__ ) . 'plugin-updater.php';

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wp-travel-engine-activator.php
 */
function activate_wp_travel_engine() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-travel-engine-activator.php';
	Wp_Travel_Engine_Activator::activate();
}

/**
 * Add a flag that will allow to flush the rewrite rules when needed.
 */
function wte_activate() {
    if ( ! get_option( 'wte_flush_rewrite_rules_flag' ) ) {
        add_option( 'wte_flush_rewrite_rules_flag', true );
    }
}
/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wp-travel-engine-deactivator.php
 */
function deactivate_wp_travel_engine() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-travel-engine-deactivator.php';
	Wp_Travel_Engine_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'wte_activate' );
register_activation_hook( __FILE__, 'activate_wp_travel_engine' );
register_deactivation_hook( __FILE__, 'deactivate_wp_travel_engine' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wp-travel-engine.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_Wp_Travel_Engine() {

	$plugin = new Wp_Travel_Engine();
	$plugin->run();

}
run_Wp_Travel_Engine();
