<?php
/**
 * Checkout Form
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="onepagecheckout-wrapper">

	<?php
	do_action( 'woocommerce_before_checkout_form', $checkout );

	// If checkout registration is disabled and not logged in, the user cannot checkout
	if ( ! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in() ) {
		echo esc_html( apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'onepagecheckout-for-woocommerce' ) ) );
		return;
	}

	// filter hook for include new pages inside the payment method

	$layout = get_option( 'onepagecheckout_layout', 'layout-1');

	$get_checkout_url = apply_filters( 'woocommerce_get_checkout_url', wc_get_checkout_url());
	?>
	<div class="onepagecheckout-backdrop"></div>
	<form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url( $get_checkout_url ); ?>" enctype="multipart/form-data">
		<div class="express-one-page-checkout-main checkout-<?php echo $layout;?>">
			<?php include_once(WCVN_OPC_WC_TEMPLATE_PATH .'checkout/layouts/'.$layout.'.php'); ?>
		</div>
	</form>

	<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>

</div>
