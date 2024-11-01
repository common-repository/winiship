<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://woosignal.com
 * @since      1.0.0
 *
 * @package    Wini_Ship
 * @subpackage Wini_Ship/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wini_Ship
 * @subpackage Wini_Ship/admin
 * @author     WooSignal <support@woosignal.com>
 */
class Wini_Ship_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wini_Ship_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wini_Ship_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wini-ship-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wini_Ship_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wini_Ship_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wini-ship-admin.js', array( 'jquery' ), $this->version, false );

	}
	
	/**
	 * Add WiniShip product info before displaying line item.
	 * @param $item_id
	 * @param $item
	 * @param $product
	 * 
	 * @since    1.1.0
	 */
	function winiship_before_order_itemmeta( $item_id, $item, $product ) {
        if( ! ( is_admin() && $item->is_type('line_item') ) ) return;
        
        $metaData = $product->get_meta_data();
        foreach($metaData as $data) {
            $objectData = $data->get_data();
            if (empty($objectData['key'])) {
                continue;
            }
            if ($objectData['key'] == 'wc_winiship_token' && !empty($objectData['value'])) {
                echo 'Product managed by <a href="' . WINI_SHIP_BASE_URL . '/dashboard/orders" target="_BLANK">WiniShip</a>';
                break;
            }
        }
    }

    /**
	 * Sends orders to WiniShip when the Order status changes
	 * 
	 * @param $order_id
	 * @param $old_status
	 * @param $new_status
	 * 
	 * @since    1.0.0
	 */
	public function winiship_status_changed($order_id, $old_status, $new_status)
	{
		if ($new_status != 'processing') {
			return;
		}

    	$order = wc_get_order($order_id);

    	$this->postOrder($order);
	}

	/**
	 * Sends orders to WiniShip.
	 * @param $order_id
	 * 
	 * @since    1.0.0
	 */
	public function winiOrderPlaced($order_id) {
		$order = new WC_Order( $order_id );

		if (! $order->has_status('processing') ) {
		    return false;
		}
		
		$this->postOrder($order);
	}

	public function postOrder($order)
	{
		$items = $order->get_items();
		
		if ($items === false) {
			return false;
		}
		
		$winiOrderItems = [];
		foreach($items as $item_id => $item_obj) {
			$product = $item_obj->get_product();
			$quantity = $item_obj->get_quantity();
			
			$wcWiniId = $product->get_meta('wc_winiship_token');
			$variation_id = '';
			
			//check if the product is type WC_Product_Variation
		    if ($product instanceof WC_Product_Variation ) {
        		$variation_id = $product->get_meta('wc_winiship_token');
				
				$parentProductId = $product->get_parent_id();
				$prod = wc_get_product($parentProductId);
				$wcWiniId = $prod->get_meta('wc_winiship_token');
    		}
			
			if ($wcWiniId) {
				$winiOrderItems[] = ['id' => $wcWiniId, 'quantity' => $quantity, 'variation_id' => $variation_id];
			}
		}

		if (empty($winiOrderItems)) {
			return false;
		}

		$winiShipSettings = get_option("winiship_settings");
		if (empty($winiShipSettings['api_token'])) {
			return false;
		}

		$apiToken = $winiShipSettings['api_token'];

		$url = WINI_SHIP_BASE_URL . "/order/wini";

		$data = json_encode([
			'wini_meta'      => ["items" => $winiOrderItems],
			'order_id' => 	$order->id,
		]);

		$response = wp_remote_post( $url, array( 
			'body'    => $data,
			'method'    => 'POST',
			'headers' => array(
				'Authorization' => 'Bearer ' . $apiToken,
				'Content-Type' => 'application/json'
			),
		) );
	}
}
