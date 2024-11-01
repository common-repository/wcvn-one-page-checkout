<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://github.com/thientran235/onepagecheckout-for-woocommerce
 * @since      1.0.0
 *
 * @package    WCVN_OnePageCheckout
 * @subpackage WCVN_OnePageCheckout/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    WCVN_OnePageCheckout
 * @subpackage WCVN_OnePageCheckout/includes
 * @author     Thien Tran <thientran2359@gmail.com>
 */
class WCVN_OnePageCheckout_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'onepagecheckout-for-woocommerce',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
