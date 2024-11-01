<?php

class WCVN_OnePageCheckout_Integrations_Avada extends WCVN_OnePageCheckout_Integrations_Base {
	public function is_available(): bool {
		return function_exists( 'fusion_should_defer_styles_loading' );
	}

	public function run() {
		// Avada 7.3
		add_action( 'wp', array( $this, 'checkout_page_fixes' ), 100 );
		global $avada_woocommerce;

		// Remove actions
		remove_action( 'woocommerce_before_checkout_form', array( $avada_woocommerce, 'avada_top_user_container' ), 1 );
		remove_action( 'woocommerce_before_checkout_form', array( $avada_woocommerce, 'before_checkout_form' ) );
		remove_action( 'woocommerce_after_checkout_form', array( $avada_woocommerce, 'after_checkout_form' ) );
		remove_action( 'woocommerce_before_checkout_form', array( $avada_woocommerce, 'checkout_coupon_form' ), 10 );
		remove_action( 'woocommerce_checkout_after_order_review', array( $avada_woocommerce, 'checkout_after_order_review' ), 20 );
		remove_action( 'woocommerce_checkout_before_customer_details', array( $avada_woocommerce, 'checkout_before_customer_details' ) );
		remove_action( 'woocommerce_checkout_after_customer_details', array( $avada_woocommerce, 'checkout_after_customer_details' ) );
		remove_action( 'woocommerce_checkout_billing', array( $avada_woocommerce, 'checkout_billing' ), 20 );
		remove_action( 'woocommerce_checkout_shipping', array( $avada_woocommerce, 'checkout_shipping' ), 20 );


		$this->disable_lazy_loading();
	}

	function checkout_page_fixes() {
		global $avada_woocommerce;

		remove_action( 'woocommerce_before_checkout_form', array( $avada_woocommerce, 'avada_top_user_container' ), 1 );
		remove_action( 'woocommerce_before_checkout_form', array( $avada_woocommerce, 'checkout_coupon_form' ), 10 );
		remove_action( 'woocommerce_before_checkout_form', array( $avada_woocommerce, 'before_checkout_form' ), 10 );
	}

	function disable_lazy_loading() {
		if ( ! class_exists( '\\Fusion' ) ) {
			return;
		}

		$fusion = \Fusion::get_instance();
		remove_filter( 'wp_get_attachment_image_attributes', array( $fusion->images, 'lazy_load_attributes' ), 10 );
	}

}
