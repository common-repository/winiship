<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://woosignal.com
 * @since      1.0.0
 *
 * @package    Wini_Ship
 * @subpackage Wini_Ship/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Wini_Ship
 * @subpackage Wini_Ship/public
 * @author     WooSignal <support@woosignal.com>
 */
class Wini_Ship_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wini-ship-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wini-ship-public.js', array( 'jquery' ), $this->version, false );

	}
	


function winiship_add_admin_menu () { 
	add_menu_page( 'WiniShip', 'WiniShip', 'manage_options', 'winiship', [$this,'winiship_options_page'], 'data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBzdGFuZGFsb25lPSJubyI/Pgo8IURPQ1RZUEUgc3ZnIFBVQkxJQyAiLS8vVzNDLy9EVEQgU1ZHIDIwMDEwOTA0Ly9FTiIKICJodHRwOi8vd3d3LnczLm9yZy9UUi8yMDAxL1JFQy1TVkctMjAwMTA5MDQvRFREL3N2ZzEwLmR0ZCI+CjxzdmcgdmVyc2lvbj0iMS4wIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciCiB3aWR0aD0iNjQwLjAwMDAwMHB0IiBoZWlnaHQ9IjUwOC4wMDAwMDBwdCIgdmlld0JveD0iMCAwIDY0MC4wMDAwMDAgNTA4LjAwMDAwMCIKIHByZXNlcnZlQXNwZWN0UmF0aW89InhNaWRZTWlkIG1lZXQiPgoKPGcgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoMC4wMDAwMDAsNTA4LjAwMDAwMCkgc2NhbGUoMC4xMDAwMDAsLTAuMTAwMDAwKSIKZmlsbD0iIzAwMDAwMCIgc3Ryb2tlPSJub25lIj4KPHBhdGggZD0iTTEwIDI1NDAgbDAgLTI1MzAgMzE5MCAwIDMxOTAgMCAwIDI1MzAgMCAyNTMwIC0zMTkwIDAgLTMxOTAgMCAwCi0yNTMweiBtNjIzOCAtMiBsMiAtMjM4OCAtMzA1MCAwIC0zMDUwIDAgMCAyMzgzIGMwIDEzMTEgMyAyMzg3IDcgMjM5MCAzIDQKMTM3NSA2IDMwNDcgNSBsMzA0MSAtMyAzIC0yMzg3eiIvPgo8cGF0aCBkPSJNMTEyMiAzODYzIGMzIC0xMCAxMTkgLTMwOCAyNTggLTY2MyAxMzkgLTM1NSAzNzcgLTk2MiA1MjkgLTEzNTAKbDI3NiAtNzA1IDMxNCAwIDMxNSAwIDM1IDkwIGMyMCA1MCAxMDYgMjY3IDE5MSA0ODQgMTEzIDI4NyAxNTcgMzg5IDE2NCAzNzgKNSAtOCA5MyAtMjI2IDE5NSAtNDgzIGwxODcgLTQ2OSAzMTQgMCAzMTUgMCAzNjIgOTI1IGMxOTkgNTA5IDQzOCAxMTIxIDUzMgoxMzYwIDk0IDIzOSAxNzEgNDM5IDE3MSA0NDMgMCA0IC0xODMgNiAtNDA3IDUgbC00MDggLTMgLTE1MSAtNDgwIGMtODMgLTI2NAotMjEzIC02NzggLTI4OSAtOTIwIC03NiAtMjQyIC0xNDEgLTQ0NCAtMTQ1IC00NDggLTggLTkgLTIzIDMyIC0xMjkgMzQxIGwtNzAKMjAzIDE5MCA1NTIgYzEwNSAzMDQgMjA2IDU5NiAyMjUgNjUwIDE5IDU1IDM0IDEwMSAzNCAxMDMgMCAyIC0xNTUgNCAtMzQ1IDQKbC0zNDQgMCAtOSAtMzIgYy04OCAtMzExIC0yMjYgLTc4NSAtMjMxIC03OTAgLTMgLTQgLTUzIDE1OCAtMTExIDM2MCAtNTcgMjAyCi0xMTAgMzg4IC0xMTggNDE1IGwtMTQgNDcgLTM0NSAwIGMtMjcyIDAgLTM0NCAtMyAtMzQxIC0xMiAzIC03IDEwMyAtMzAyIDIyMgotNjU1IGwyMTggLTY0MiAtOTIgLTI3NiBjLTUxIC0xNTIgLTk2IC0yNzMgLTEwMCAtMjY4IC00IDQgLTEyMyAzNzUgLTI2NSA4MjMKLTE0MSA0NDggLTI3MiA4NjMgLTI5MSA5MjMgbC0zNSAxMDcgLTQwNiAwIGMtMzgxIDAgLTQwNSAtMSAtNDAxIC0xN3oiLz4KPC9nPgo8L3N2Zz4K' );
}

function winiship_settings_init () { 

	register_setting( 'pluginPage', 'winiship_settings' );
	
	add_settings_section(
		'winiship_pluginPage_section', 
		__( '', 'http://winiship.com' ), 
[$this, 'winiship_settings_section_callback'], 
		'pluginPage'
	);

	add_settings_field( 
		'winiship_settings_api_token', 
		__( 'API Token', 'http://winiship.com' ), 
		[$this,'winiship_settings_api_token_render'], 
		'pluginPage', 
		'winiship_pluginPage_section' 
	);
}

function winiship_settings_api_token_render() {

	$options = get_option( 'winiship_settings' );
	?>
	<input type='password' name='winiship_settings[api_token]' value='<?php echo $options['api_token']; ?>'>
	<input type='hidden' name='winiship_settings[api_locked]' value='1'>
	
	<?php
}


function winiship_settings_section_callback(  ) { 
	
}

function winiship_options_page () { 

		?>
	<style>
		tr {
			background-color: white;
			border-left: 2px solid black;
		}
		
		th[scope] {
			padding-left: 15px;
		}
		
		.form-table {
			margin-top: 25px;
		}
		
		td input {
			width: 100%;
			border: 1px solid #d9d9d9 !important;
		}
</style>
		<div style="width:100%; display:inline-flex;">
			
			<div style="width:70%; padding-top: 30px;">
				<img style="height: 100px;" src="<?php echo WINI_SHIP_BASE_URL ?>/images/logo.png" />
				
				<form action='options.php' style="margin-top: 15px;" method='post'>
			<h1>WiniShip </h1> 
					<span style="clear:both;">Official WordPress Plugin for WooCommerce Stores. Get started for free on </span>
					<a target="_BLANK" href="<?php echo WINI_SHIP_BASE_URL ?>/register">winiship.com</a>
					
					<p style="border-top: 1px solid #e6e6e6; padding-top: 15px;">
						Copy your WiniShip API token from the <a href="<?php echo WINI_SHIP_BASE_URL ?>/dashboard/stores" target="_BLANK">dashboard</a>.<br>Select your store on the dashboard, then go into setting and copy your API token from the right tab.
					</p>

			<?php
			settings_fields( 'pluginPage' );
			do_settings_sections( 'pluginPage' );
			submit_button();
			?>

		</form>
		<?php do_settings_sections( 'connectWiniShip' ); ?>
				
			</div>
			
			
			<div style="width: 30%; padding: 30px;">
				<div>
					
				<h2>
					New to WiniShip?
				</h2>
				
				<p>
					Watch the introduction video below to get started
				</p>
				
				<a href="https://www.youtube.com/watch?v=rGWR04C_ZMc" target="_BLANK">
					<img style="width: 100%;border: 4px solid #ffffff;" src="<?php echo WINI_SHIP_BASE_URL ?>/images/intro_dropshipping_yt.png">
				</a>
					</div>
				
				<div style="margin-top:15px; padding: 15px; background-color: #ffffff;border: 2px solid #dddddd;">
					<span style="display: inline-flex;width: 100%;justify-content: space-between;">
						<span style="height: 100%;align-self: center;font-weight: 600;">
							<h3 style="margin: 0;">
								Help &amp; Support
							</h3>
							
							<p>
						Need help getting setup?<br>Contact our <a href="<?php echo WINI_SHIP_BASE_URL ?>/support" target="_BLANK">support</a> team 
					</p>
						</span> 
						<div style="width:40px;display: flex;">
							<img style="height:40px; float: right; margin:auto;" src="<?php echo WINI_SHIP_BASE_URL ?>/images/001-emoji.png">
						</div>
					</span>	
				</div>
			</div>
		</div>
		<?php
}
}
