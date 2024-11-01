<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://winiship.com
 * @since             1.0.0
 * @package           Wini_Ship
 *
 * @wordpress-plugin
 * Plugin Name:       WiniShip
 * Plugin URI:        winiship.com
 * Description:       Your One Stop Dropshipping Solution for WooCommerce.
 * Version:           1.2.0
 * Author:            WiniShip
 * Author URI:        https://winiship.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wini-ship
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
define( 'WINI_SHIP_VERSION', '1.2.0' );

define( 'WINI_SHIP_BASE_URL', 'https://winiship.com' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wini-ship-activator.php
 */
function activate_wini_ship() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wini-ship-activator.php';
	Wini_Ship_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wini-ship-deactivator.php
 */
function deactivate_wini_ship() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wini-ship-deactivator.php';
	Wini_Ship_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_wini_ship' );
register_deactivation_hook( __FILE__, 'deactivate_wini_ship' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wini-ship.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_wini_ship() {

	$plugin = new Wini_Ship();
	$plugin->run();

}
run_wini_ship();
