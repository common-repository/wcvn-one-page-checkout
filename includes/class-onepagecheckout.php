<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://github.com/thientran235/onepagecheckout-for-woocommerce
 * @since      1.0.0
 *
 * @package    WCVN_OnePageCheckout
 * @subpackage WCVN_OnePageCheckout/includes
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
 * @package    WCVN_OnePageCheckout
 * @subpackage WCVN_OnePageCheckout/includes
 * @author     Thien Tran <thientran2359@gmail.com>
 */
class WCVN_OnePageCheckout {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      WCVN_OnePageCheckout_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $onepagecheckout    The string used to uniquely identify this plugin.
	 */
	protected $onepagecheckout;

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
		if ( defined( 'WCVN_OPC_VERSION' ) ) {
			$this->version = WCVN_OPC_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->onepagecheckout = 'onepagecheckout';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - WCVN_OnePageCheckout_Loader. Orchestrates the hooks of the plugin.
	 * - WCVN_OnePageCheckout_i18n. Defines internationalization functionality.
	 * - WCVN_OnePageCheckout_Admin. Defines all hooks for the admin area.
	 * - WCVN_OnePageCheckout_Public. Defines all hooks for the public side of the site.
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
		require_once WCVN_OPC_PATH . 'includes/class-onepagecheckout-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once WCVN_OPC_PATH . 'includes/class-onepagecheckout-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once WCVN_OPC_PATH . 'admin/class-onepagecheckout-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once WCVN_OPC_PATH . 'public/class-onepagecheckout-public.php';

		$this->loader = new WCVN_OnePageCheckout_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the WCVN_OnePageCheckout_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new WCVN_OnePageCheckout_i18n();

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

		$plugin_admin = new WCVN_OnePageCheckout_Admin( $this->get_onepagecheckout(), $this->get_version() );

		if(is_woocommerce_active()) {
			$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

			$this->loader->add_action( 'admin_init', $plugin_admin, 'plugin_redirect' );

			$this->loader->add_filter( 'plugin_action_links_' . WCVN_OPC_BASENAME, $plugin_admin, 'action_links' );
		} else {
			$this->loader->add_action( 'admin_notices', $plugin_admin, 'show_woocommerce_error_message' );
		}

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new WCVN_OnePageCheckout_Public( $this->get_onepagecheckout(), $this->get_version() );
		if(is_woocommerce_active()) {
			$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles', 999 );
			$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts', 999 );
			$this->loader->add_action( 'wp_head', $plugin_public, 'wp_head' );

			$this->loader->add_filter( 'woocommerce_locate_template', $plugin_public, 'locate_template', 20, 3 );
			$this->loader->add_filter( 'woocommerce_checkout_cart_item_quantity', $plugin_public, 'add_cart_item_quantity', 10, 2 );

			$this->loader->add_action( 'wp_ajax_nopriv_onepagecheckout_update_order_review', $plugin_public, 'update_order_review' );
			$this->loader->add_action( 'wp_ajax_onepagecheckout_update_order_review', $plugin_public, 'update_order_review' );


			$this->loader->add_filter( 'gettext', $plugin_public, 'custom_text_strings', 20, 3 );

			$this->loader->add_action( 'template_redirect', $plugin_public, 'redirect_to_checkout' );

			$this->loader->add_action( 'init', $plugin_public, 'after_setup_theme' );

			$this->loader->add_filter( 'body_class', $plugin_public, 'body_class' );

			$this->loader->add_filter( 'woocommerce_currency_symbol', $plugin_public, 'filter_woocommerce_currency_symbol', 10, 2 );
			$this->loader->add_filter( 'formatted_woocommerce_price', $plugin_public, 'filter_formatted_woocommerce_price', 10, 5 );
			$this->loader->add_filter( 'woocommerce_checkout_fields', $plugin_public, 'checkout_fields', 20 );
		}

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
	public function get_onepagecheckout() {
		return $this->onepagecheckout;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    WCVN_OnePageCheckout_Loader    Orchestrates the hooks of the plugin.
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
