<?php

/**
 * The plugin bootstrap file
 *
 * @link              https://github.com/thientran235/onepagecheckout-for-woocommerce
 * @since             1.0.0
 * @package           WCVN_OnePageCheckout
 *
 * @wordpress-plugin
 * Plugin Name:       One Page Checkout for WooCommerce
 * Plugin URI:        https://github.com/thientran235/onepagecheckout-for-woocommerce
 * Description:       Combine Cart and Checkout process which gives users a faster checkout experience and best UI.
 * Version:           1.0.0
 * Author:            Thien Tran
 * Author URI:        http://fb.com/makiosp1
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       onepagecheckout-for-woocommerce
 * Domain Path:       /languages
 * Requires at least: 4.0
 * WC tested up to:   5.3
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'WCVN_OPC_VERSION', '1.0.0' );
define( 'WCVN_OPC_PATH', plugin_dir_path( __FILE__ ) );
define( 'WCVN_OPC_URL', plugin_dir_url( __FILE__ ) );
define( 'WCVN_OPC_BASENAME', plugin_basename( __FILE__ ) );
define( 'WCVN_OPC_WC_TEMPLATE_PATH', WCVN_OPC_PATH . 'public/templates/' );

if (!function_exists('is_woocommerce_active')){
	function is_woocommerce_active(){
	    $active_plugins = (array) get_option('active_plugins', array());
	    if(is_multisite()){
		   $active_plugins = array_merge($active_plugins, get_site_option('active_sitewide_plugins', array()));
	    }
	    return in_array('woocommerce/woocommerce.php', $active_plugins) || array_key_exists('woocommerce/woocommerce.php', $active_plugins) || class_exists('WooCommerce');
	}
}

 /**
* The code that runs during plugin activation.
* This action is documented in includes/class-onepagecheckout-activator.php
*/
function activate_onepagecheckout() {
	require_once WCVN_OPC_PATH . 'includes/class-onepagecheckout-activator.php';
	WCVN_OnePageCheckout_Activator::activate();
}

/**
* The code that runs during plugin deactivation.
* This action is documented in includes/class-onepagecheckout-deactivator.php
*/
function deactivate_onepagecheckout() {
	require_once WCVN_OPC_PATH . 'includes/class-onepagecheckout-deactivator.php';
	WCVN_OnePageCheckout_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_onepagecheckout' );
register_deactivation_hook( __FILE__, 'deactivate_onepagecheckout' );

require_once WCVN_OPC_PATH . 'integrations/integrations.php';

/**
* The core plugin class that is used to define internationalization,
* admin-specific hooks, and public-facing site hooks.
*/
require WCVN_OPC_PATH . 'includes/class-onepagecheckout.php';

function run_onepagecheckout() {

	$plugin = new WCVN_OnePageCheckout();
	$plugin->run();

}
run_onepagecheckout();
// add_action('plugins_loaded', 'run_onepagecheckout');
