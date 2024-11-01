<div class="onepagecheckout-cart_table">
   <h3 class="border_html review-order-title"><?php esc_html_e('Review Order', 'onepagecheckout-for-woocommerce' ); ?></h3>
	 <?php include_once WCVN_OPC_WC_TEMPLATE_PATH . 'checkout/parts/review_order_section.php'; ?>
</div>
<div class="layout-1-left">
    <h3 class="border_html billing-details-title"> <?php esc_html_e('Billing Details', 'onepagecheckout-for-woocommerce' ); ?></h3>
	<?php include_once WCVN_OPC_WC_TEMPLATE_PATH . 'checkout/parts/billing_details_section.php'; ?>
</div>
<div class="layout-1-right">
 	<h3 class="border_html confirm-pay-title"><?php esc_html_e('Confirm & Pay', 'onepagecheckout-for-woocommerce' ); ?></h3>
	<?php include_once WCVN_OPC_WC_TEMPLATE_PATH . 'checkout/parts/payment_section.php'; ?>
</div>
<?php do_action( 'woocommerce_checkout_after_order_review' ); ?>
