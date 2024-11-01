<?php

/**
 * Fired during plugin activation
 *
 * @link       https://github.com/thientran235/onepagecheckout-for-woocommerce
 * @since      1.0.0
 *
 * @package    WCVN_OnePageCheckout
 * @subpackage WCVN_OnePageCheckout/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    WCVN_OnePageCheckout
 * @subpackage WCVN_OnePageCheckout/includes
 * @author     Thien Tran <thientran2359@gmail.com>
 */
class WCVN_OnePageCheckout_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		update_option('onepagecheckout_do_activation_redirect', true);
	}

}
