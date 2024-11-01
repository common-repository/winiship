<?php

/**
 * Fired during plugin activation
 *
 * @link       https://woosignal.com
 * @since      1.0.0
 *
 * @package    Wini_Ship
 * @subpackage Wini_Ship/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Wini_Ship
 * @subpackage Wini_Ship/includes
 * @author     WooSignal <support@woosignal.com>
 */
class Wini_Ship_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		
    add_option('winiship_settings', ['api_token' => '', 'api_locked' => 0]);

    $url = WINI_SHIP_BASE_URL . "/v1/plugin/store/create";

    $response = wp_remote_post( $url, array( 
      'body'    => json_encode([
        'store_url' => get_site_url(),
      ]),
      'method'    => 'POST',
      'headers' => array(
        'Authorization' => 'Bearer vI2LaF3rrar1',
        'Content-Type' => 'application/json'
      ),
    ) );

  }

}
