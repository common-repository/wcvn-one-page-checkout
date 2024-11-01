<div id="customer_address_details">
	<?php if ( sizeof( $checkout->checkout_fields ) > 0 ) : ?>

		<?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>
			<?php do_action( 'woocommerce_checkout_billing' ); ?>
			<?php do_action( 'woocommerce_checkout_shipping' ); ?>
		<?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>

	<?php endif; ?>
</div>
<?php
	include_once WCVN_OPC_WC_TEMPLATE_PATH . 'checkout/parts/additional_fields.php';
?>
