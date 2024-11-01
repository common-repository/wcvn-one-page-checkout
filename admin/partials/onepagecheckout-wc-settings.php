<?php
/**
 * Provide a admin area settings view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://github.com/thientran235/onepagecheckout-for-woocommerce
 * @since      1.0.0
 *
 * @package    WCVN_OnePageCheckout
 * @subpackage WCVN_OnePageCheckout/admin/partials
 */

class WC_Settings_Tab_WCVN_OnePageCheckout {

    /**
     * Bootstraps the class and hooks required actions & filters.
     *
     */
    public static function init() {
        add_filter( 'woocommerce_settings_tabs_array', __CLASS__ . '::add_settings_tab', 50 );
        add_action( 'woocommerce_settings_tabs_onepagecheckout', __CLASS__ . '::settings_tab' );
        add_action( 'woocommerce_update_options_onepagecheckout', __CLASS__ . '::update_settings' );

        //add custom type
        add_action( 'woocommerce_admin_field_custom_type', __CLASS__ . '::output_custom_type', 10, 1 );
    }

    public static function output_custom_type($value){
	//you can output the custom type in any format you'd like
        echo $value['desc'];
    }


    /**
     * Add a new settings tab to the WooCommerce settings tabs array.
     *
     * @param array $settings_tabs Array of WooCommerce setting tabs & their labels, excluding the Subscription tab.
     * @return array $settings_tabs Array of WooCommerce setting tabs & their labels, including the Subscription tab.
     */
    public static function add_settings_tab( $settings_tabs ) {
        $settings_tabs['onepagecheckout'] = __( 'One Page Checkout', 'onepagecheckout-for-woocommerce' );
        return $settings_tabs;
    }


    /**
     * Uses the WooCommerce admin fields API to output settings via the @see woocommerce_admin_fields() function.
     *
     * @uses woocommerce_admin_fields()
     * @uses self::get_settings()
     */
    public static function settings_tab() {
        woocommerce_admin_fields( self::get_settings() );
    }


    /**
     * Uses the WooCommerce options API to save settings via the @see woocommerce_update_options() function.
     *
     * @uses woocommerce_update_options()
     * @uses self::get_settings()
     */
    public static function update_settings() {
        woocommerce_update_options( self::get_settings() );
    }


    /**
     * Get all the settings for this plugin for @see woocommerce_admin_fields() function.
     *
     * @return array Array of settings for @see woocommerce_admin_fields() function.
     */
    public static function get_settings() {

        $settings = array(
            'layouts_title' => array(
                'name'     => __( 'Layouts Setting', 'onepagecheckout-for-woocommerce' ),
                'type'     => 'title',
                'desc'     => '',
                'id'       => 'onepagecheckout_layouts_title'
            ),
            'checkout_page_layout' => array(
                'name'    => __( 'Checkout Page Layout', 'onepagecheckout-for-woocommerce' ),
                'type'    => 'select',
                'default' => 'layout-1',
                'css'      => 'width:auto;',
                'options' => array(
					'layout-1' => __( 'Layout 1', 'onepagecheckout-for-woocommerce' ),
					'layout-2'   => __( 'Layout 2', 'onepagecheckout-for-woocommerce' ),
				),
                'desc'    => __( 'This is a paragraph describing the setting.', 'onepagecheckout-for-woocommerce' ),
                'id'      => 'onepagecheckout_layout'
            ),
            'skipping_cart' => array(
                'name' => __( 'Skipping Cart', 'onepagecheckout-for-woocommerce' ),
                'type' => 'checkbox',
                'default' => 'yes',
                'desc' => __( 'Enable', 'onepagecheckout-for-woocommerce' ).'</ br><p class="description">'.__( 'Recommended "Checked". We recommend to skip cart page to shorten the checkout process.', 'onepagecheckout-for-woocommerce' ).'</p>',
                'id'   => 'onepagecheckout_skipping_cart'
            ),
            'non_changeable_quantity' => array(
                'name' => __( 'Non Changeable Quantity', 'onepagecheckout-for-woocommerce' ),
                'type' => 'checkbox',
                'label'=>  __( 'Enable', 'onepagecheckout-for-woocommerce' ),
                'default' => '',
                'desc' => __( 'Enable', 'onepagecheckout-for-woocommerce' ).'</ br><p class="description">'.__( 'Product quantity will be nonchangeable if you are selling only one item or You donot want your buyers to change quantity at checkout.', 'onepagecheckout-for-woocommerce' ).'</p>',
                'id'   => 'onepagecheckout_non_changeable_quantity'
            ),
            'layouts_end' => array(
                 'type' => 'sectionend',
                 'id' => 'onepagecheckout_layouts_title_end'
            ),

            'custom_title' => array(
                'name'     => __( 'Custom Checkout Setting', 'onepagecheckout-for-woocommerce' ),
                'type'     => 'title',
                'desc'     => '',
                'id'       => 'onepagecheckout_custom_title'
            ),
            'currency_symbol' => array(
                'name' => __( 'Change currency symbol', 'onepagecheckout-for-woocommerce' ),
                'type' => 'checkbox',
                'desc'=>  __( 'Enable', 'onepagecheckout-for-woocommerce' ),
                'default' => '',
                'description' => '',
                'id'   => 'onepagecheckout_currency_symbol'
            ),
            'currency_symbol_text' => array(
				'name' => '',
				'desc' => sprintf( __( 'Insert a text to change the current symbol <code>%s</code>', 'onepagecheckout-for-woocommerce' ), get_woocommerce_currency_symbol() ),
				'type' => 'text',
                'css' => 'margin-top:-15px;',
				'id'   => 'onepagecheckout_currency_symbol_text',
				'placeholder' => __( 'For `$` Example : Dolar', 'onepagecheckout-for-woocommerce' ),
			),
            'convert_price' => array(
                'name' => __( 'Convert 000 of prices to K (or anything)', 'onepagecheckout-for-woocommerce' ),
                'type' => 'checkbox',
                'desc'=>  __( 'Enable', 'onepagecheckout-for-woocommerce' ),
                'default' => '',
                'id'   => 'onepagecheckout_convert_price'
            ),
            'convert_price_text' => array(
				'name' => '',
				'desc' => __( 'Choose what you want to change. E.g:', 'onepagecheckout-for-woocommerce' ),
				'type' => 'text',
				'id'   => 'onepagecheckout_convert_price_text',
                'default' => 'K',
                'css' => 'margin-top:-15px',
				'placeholder' => __( 'For Example : K', 'onepagecheckout-for-woocommerce' ),
			),
            'custom_end' => array(
                 'type' => 'sectionend',
                 'id' => 'onepagecheckout_custom_title_end'
            ),

            'text_title' => array(
                'name'     => __( 'Text Setting', 'onepagecheckout-for-woocommerce' ),
                'type'     => 'title',
                'desc'     => '',
                'id'       => 'onepagecheckout_text_title'
            ),
            'addtocart_text' => array(
				'name' => __( 'Add to cart', 'onepagecheckout-for-woocommerce' ),
				'desc' => __( 'Replace "Add to cart" with ....', 'onepagecheckout-for-woocommerce' ),
				'type' => 'text',
				'id'   => 'onepagecheckout_addtocart',
				'placeholder' => __( 'For Example :- Add to Basket', 'onepagecheckout-for-woocommerce' ),
			),
            'viewcart_text' => array(
				'name' => __( 'View cart', 'onepagecheckout-for-woocommerce' ),
				'desc' => __( 'Replace "View cart" with checkout (recommended) as every cart link is redirected to checkout page', 'onepagecheckout-for-woocommerce' ),
				'type' => 'text',
				'id'   => 'onepagecheckout_viewcart',
				'placeholder' => __( 'Checkout', 'onepagecheckout-for-woocommerce' ),
			),
            'placeorder_text' => array(
 				'name' => __( 'Place Order', 'onepagecheckout-for-woocommerce' ),
 				'desc' => __( 'Replace "Place Order" with ....', 'onepagecheckout-for-woocommerce' ),
 				'type' => 'text',
 				'id'   => 'onepagecheckout_placeorder',
				'placeholder' => __( 'For example :- Complete payment', 'onepagecheckout-for-woocommerce' ),
 			),
            'continueshop_text' => array(
				'name' => __( 'Continue Shopping', 'onepagecheckout-for-woocommerce' ),
				'desc' => __( 'Repalce "Continue Shopping" with ....', 'onepagecheckout-for-woocommerce' ),
				'type' => 'text',
				'id'   => 'onepagecheckout_continueshop',
				'placeholder' => __( 'For example :- Explore More', 'onepagecheckout-for-woocommerce' ),
			),
            'billing_details_text' => array(
				'name' => __( 'Billing Details', 'onepagecheckout-for-woocommerce' ),
				'desc' => __( 'Repalce "Billing Details" with ....', 'onepagecheckout-for-woocommerce' ),
				'type' => 'text',
				'id'   => 'onepagecheckout_billing_details',
				'placeholder' => __( 'For example :- Customer Details', 'onepagecheckout-for-woocommerce' ),
			),
            'review_order_text' => array(
				'name' => __( 'Review Order', 'onepagecheckout-for-woocommerce' ),
				'desc' => __( 'Repalce "Review Order" with ....', 'onepagecheckout-for-woocommerce' ),
				'type' => 'text',
				'id'   => 'onepagecheckout_review_order',
				'placeholder' => __( 'For example :- Order Summary', 'onepagecheckout-for-woocommerce' ),
			),
            'confirm_pay_text' => array(
				'name' => __( 'Confirm & Pay', 'onepagecheckout-for-woocommerce' ),
				'desc' => __( 'Repalce "Confirm & Pay" with ....', 'onepagecheckout-for-woocommerce' ),
				'type' => 'text',
				'id'   => 'onepagecheckout_confirm_pay',
				'placeholder' => __( 'For example :- Pay Here', 'onepagecheckout-for-woocommerce' ),
			),
            'text_end' => array(
                 'type' => 'sectionend',
                 'id' => 'onepagecheckout_text_title_end'
            )
        );

        return apply_filters( 'onepagecheckout_settings', $settings );
    }

}
