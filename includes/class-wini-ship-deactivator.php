<?php

/**
 * Fired during plugin deactivation
 *
 * @link       https://woosignal.com
 * @since      1.0.0
 *
 * @package    Wini_Ship
 * @subpackage Wini_Ship/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Wini_Ship
 * @subpackage Wini_Ship/includes
 * @author     WooSignal <support@woosignal.com>
 */
class Wini_Ship_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
		
        delete_option('winiship_settings');

	}

}
