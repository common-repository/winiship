<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://woosignal.com
 * @since      1.0.0
 *
 * @package    Wini_Ship
 * @subpackage Wini_Ship/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Wini_Ship
 * @subpackage Wini_Ship/includes
 * @author     WooSignal <support@woosignal.com>
 */
class Wini_Ship {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Wini_Ship_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'WINI_SHIP_VERSION' ) ) {
			$this->version = WINI_SHIP_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'wini-ship';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
		$this->define_public_rest_api();

	}

	function define_public_rest_api() {
		add_action( 'rest_api_init', function() {
			$prefixPluginV3 = 'winiship/plugin/v1';

			// PLUGIN
			register_rest_route( $prefixPluginV3, '/update', [
				'methods' => 'POST',
				'callback' => [$this, 'winiship_update_plugin_key'],
				'permission_callback' => '__return_true'
			]);

			register_rest_route( $prefixPluginV3, '/check', [
				'methods' => 'GET',
				'callback' => [$this, 'winiship_check_plugin_key'],
				'permission_callback' => '__return_true'
			]);
		});
	}

	function winiship_check_plugin_key() {
		$options = get_option('winiship_settings');
		return $this->standardizePayload([], '', empty($options['api_token']) ? 500 : 200);
	}

	function winiship_update_plugin_key(WP_REST_Request $request) {
		$params = $this->wpapp_get_params($request);

		$options = get_option('winiship_settings');
		if (!array_key_exists('api_locked', $options)) {
            return $this->standardizePayload([], '', 423);
        }

        if (intval($options['api_locked']) != 0) {
            return $this->standardizePayload([], '', 403);
        }

		if (empty($params['plugin_key'])) {
			return $this->standardizePayload([], '', 520);
		}

		$succeeded = update_option('winiship_settings', ['api_token' => $params['plugin_key'], 'api_locked' => 1]);

		return $this->standardizePayload([], '', ($succeeded ? 200 : 500));
	}

	/**
	 * Fetch params from request
	 *
	 * @param WP_REST_Request $request - Core class used to implement a REST request object.
	 * @return array
	 */
	public function wpapp_get_params($request) {
		return $request != null 
		? (array)$request->get_params()
		: [];
	}

	/**
	 * Standardized payload response for requests
	 *
	 * @param array $result - Result payload.
	 * @param string $message - Message payload.
	 * @param int $status - Status of the request.
	 * @return mixed
	 */
    function standardizePayload($result = [], $message = '', $status = 200) {
    	return [
    		'data' => $result,
    		'message' => $message,
    		'status' => $status
    	];
    }

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Wini_Ship_Loader. Orchestrates the hooks of the plugin.
	 * - Wini_Ship_i18n. Defines internationalization functionality.
	 * - Wini_Ship_Admin. Defines all hooks for the admin area.
	 * - Wini_Ship_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wini-ship-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wini-ship-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-wini-ship-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-wini-ship-public.php';

		$this->loader = new Wini_Ship_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Wini_Ship_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Wini_Ship_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Wini_Ship_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		
		$this->loader->add_action( 'woocommerce_new_order', $plugin_admin, 'winiOrderPlaced');
		$this->loader->add_action( 'woocommerce_before_order_itemmeta', $plugin_admin, 'winiship_before_order_itemmeta', 10, 3);
		$this->loader->add_action( 'woocommerce_order_status_changed', $plugin_admin, 'winiship_status_changed', 10, 3);
	}	

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Wini_Ship_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
		$this->loader->add_action( 'admin_menu', $plugin_public, 'winiship_add_admin_menu' );
		$this->loader->add_action( 'admin_init', $plugin_public, 'winiship_settings_init' );
		
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Wini_Ship_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
