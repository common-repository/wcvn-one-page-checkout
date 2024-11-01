<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://github.com/thientran235/onepagecheckout-for-woocommerce
 * @since      1.0.0
 *
 * @package    WCVN_OnePageCheckout
 * @subpackage WCVN_OnePageCheckout/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    WCVN_OnePageCheckout
 * @subpackage WCVN_OnePageCheckout/public
 * @author     Thien Tran <thientran2359@gmail.com>
 */
class WCVN_OnePageCheckout_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $onepagecheckout    The ID of this plugin.
	 */
	private $onepagecheckout;

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
	 * @param      string    $onepagecheckout       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $onepagecheckout, $version ) {

		$this->onepagecheckout = $onepagecheckout;
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
		 * defined in WCVN_OnePageCheckout_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The WCVN_OnePageCheckout_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		if (!is_checkout()) {
 			return;
 		}
		wp_enqueue_style( $this->onepagecheckout, WCVN_OPC_URL . 'public/css/onepagecheckout-public.min.css', array(), $this->version, 'all' );
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
		 * defined in WCVN_OnePageCheckout_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The WCVN_OnePageCheckout_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		if (!is_checkout()) {
 			return;
 		}
		wp_enqueue_script( $this->onepagecheckout, WCVN_OPC_URL . 'public/js/onepagecheckout-public.min.js', array( 'jquery' ), $this->version, false );

		wp_localize_script($this->onepagecheckout, 'WCVN_OnePageCheckout', array(
	        'ajaxurl' => admin_url('admin-ajax.php'),
	    ));

	}

	public function body_class( $classes ) {
		if (!is_checkout()) {
 			return $classes;
 		}
		$layout = get_option( 'onepagecheckout_layout', 'layout-1');
		return array_merge( $classes, array( 'body-checkout-' . $layout ) );
	}

	public function locate_template( $template, $template_name, $template_path ) {
		global $woocommerce;
		$_template = $template;
		if ( !$template_path )
			$template_path = $woocommerce->template_url;
		$plugin_path  = WCVN_OPC_WC_TEMPLATE_PATH;
		if(is_checkout()) {
			$template = $plugin_path . $template_name;
			if ( file_exists( $template ) ) {
				$template = $plugin_path . $template_name;
			} else {
			$template = $_template;
			}
		} else {
			$template = $_template;
		}
		return $template;
	}

	public function filter_woocommerce_currency_symbol( $currency_symbol, $currency ) {
		if ( get_option( 'onepagecheckout_currency_symbol', 'no' ) == 'yes' ) {
			$currency_symbol = get_option( 'onepagecheckout_currency_symbol_text', 'VND' );
		}

		return $currency_symbol;
	}

	public function filter_formatted_woocommerce_price( $formatted_price, $price, $decimals, $decimal_separator, $thousand_separator ) {
		if (get_option( 'onepagecheckout_convert_price', 'no' ) == 'yes' ) {
			$thousand_text = get_option( 'onepagecheckout_convert_price_text', 'K' );
			if ( $price < 1000 ) {
				return $formatted_price;
			} else {
				$new_formatted_price = number_format( $price / 1000, $decimals, $decimal_separator, $thousand_separator ) . $thousand_text;

				return $new_formatted_price;
			}
		}

		return $formatted_price;
	}

	public function checkout_fields( $fields ) {
		if ( !empty($fields['billing']) ) {
			foreach ($fields['billing'] as $key => $billing) {
				if ( empty($billing['placeholder']) ) {
					$billing['placeholder'] = $billing['label'];
				}
				$fields['billing'][$key] = $billing;
			}
		}

		if ( !empty($fields['shipping']) ) {
			foreach ($fields['shipping'] as $key => $shipping) {
				if ( empty($shipping['placeholder']) ) {
					$shipping['placeholder'] = $shipping['label'];
				}
				$fields['shipping'][$key] = $shipping;
			}
		}

	     return $fields;
	}

	public function add_cart_item_quantity( $cart_item, $cart_item_key ) {
		   $product_quantity= '';
		   return intval($product_quantity);
	}

	public function wp_head() {
		if (!is_checkout()) {
			return;
		}

		$skip_cart = get_option( 'onepagecheckout_skipping_cart', 'yes' );

		if( $skip_cart == 'yes' ) {
			?>
			<style>
				.mini_cart_content .checkout {
					display: none !important;
				}
			</style>
			<?php
		}
	}

	public function update_order_review() {
		$values = array();
		parse_str($_POST['post_data'], $values);
		$cart = $values['cart'];
		foreach ( $cart as $cart_key => $cart_value ){
			WC()->cart->set_quantity( $cart_key, $cart_value['qty'], true );
			WC()->cart->calculate_totals();
			woocommerce_cart_totals();
		}
		exit;
	}

	public function custom_text_strings( $translated_text, $text, $domain ) {
		$skip_cart = get_option( 'onepagecheckout_skipping_cart', 'yes' );

		$addtocart = get_option( 'onepagecheckout_addtocart', '' );
		$viewcart = get_option( 'onepagecheckout_viewcart', '' );
		$placeorder = get_option( 'onepagecheckout_placeorder', '' );
		$continueshop = get_option( 'onepagecheckout_continueshop', '' );
		$billing_details = get_option( 'onepagecheckout_billing_details', '' );
		$review_order = get_option( 'onepagecheckout_review_order', '' );
		$confirm_pay = get_option( 'onepagecheckout_confirm_pay', '' );

		if( $addtocart != '') {
			$translated_text = str_ireplace( 'Add to cart', $addtocart, $translated_text );
		}
		if( $viewcart != '' && $skip_cart == 'yes' ) {
			$translated_text = str_ireplace( 'View cart', $viewcart, $translated_text );
		}
		if( $placeorder != '' ) {
			$translated_text = str_ireplace( 'Place order', $placeorder, $translated_text );
		}
		if( $continueshop != '' ) {
			$translated_text = str_ireplace( 'Continue shopping', $continueshop, $translated_text );
		}
		if( $billing_details != '' ) {
			$translated_text = str_ireplace( 'Billing Details', $billing_details, $translated_text );
		}
		if( $review_order != '' ) {
			$translated_text = str_ireplace( 'Review Order', $review_order, $translated_text );
		}
		if( $confirm_pay !='' ) {
			$translated_text = str_ireplace( 'Confirm & Pay', $confirm_pay, $translated_text );
		}

		return $translated_text;
	}

	public function redirect_to_checkout() {
		global $woocommerce;
		$skip_cart = get_option( 'onepagecheckout_skipping_cart', 'yes' );

		if ( is_cart() && WC()->cart->get_cart_contents_count() > 0 && $skip_cart == 'yes' ) {
			// Redirect to check out url
			wp_redirect( $woocommerce->cart->get_checkout_url(), '301' );
			exit;
		}
	}
}
