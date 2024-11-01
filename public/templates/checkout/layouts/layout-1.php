<div class="layout-1-left">
   	<h3 class="border_html billing-details-title"> <?php esc_html_e('Billing Details', 'onepagecheckout-for-woocommerce' ); ?></h3>
	<?php include_once WCVN_OPC_WC_TEMPLATE_PATH . 'checkout/parts/billing_details_section.php'; ?>

    <h3 class="border_html shipping-method-title"> <?php esc_html_e('Shipping Method', 'onepagecheckout-for-woocommerce' ); ?></h3>
    <?php do_action( 'woocommerce_review_order_before_shipping' ); ?>
    <?php wc_cart_totals_shipping_html(); ?>
    <?php do_action( 'woocommerce_review_order_after_shipping' ); ?>

    <h3 class="border_html confirm-pay-title"><?php esc_html_e('Confirm & Pay', 'onepagecheckout-for-woocommerce' ); ?></h3>
    <?php include_once WCVN_OPC_WC_TEMPLATE_PATH . 'checkout/parts/payment_section.php'; ?>
</div>
<div class="layout-1-right">
    <h3 class="border_html review-order-title">
        <?php esc_html_e('Review Order', 'onepagecheckout-for-woocommerce' ); ?>
        <span class="review-order-title-toggle">
            <svg enable-background="new 0 0 492.001 492.001" version="1.1" viewBox="0 0 492 492" xml:space="preserve" xmlns="http://www.w3.org/2000/svg">
        		<path d="m333.81 375.44c-5.408-5.408-13.76-5.408-19.168 0l-49.416 49.864v-358.8l49.644 50.096c2.604 2.612 5.876 4.052 9.584 4.052s7.084-1.44 9.7-4.052l7.392-7.448c2.612-2.612 4.02-6.096 4.02-9.812 0-3.712-1.448-7.2-4.06-9.808l-85.508-85.496c-2.672-2.676-6.252-4.104-9.924-4.04-3.828-0.068-7.412 1.36-10.08 4.036l-85.464 85.464c-5.228 5.224-5.228 14.4 0 19.62l7.444 7.448c5.412 5.404 14.572 5.404 19.968-4e-3l48.816-48.456v355.98l-49.036-48.692c-5.416-5.408-14.396-5.408-19.804 0l-7.528 7.448c-5.236 5.224-5.276 14.4-0.048 19.62l85.468 85.5c2.68 2.668 6.244 4.104 9.916 4.028 3.828 0.076 7.404-1.356 10.076-4.028l85.46-85.464c5.232-5.224 5.232-14.396 0-19.62l-7.452-7.444z"/>
            </svg>
        </span>
        <span class="review-order-title-price"></span>
    </h3>
    <?php include_once WCVN_OPC_WC_TEMPLATE_PATH . 'checkout/parts/review_order_section.php'; ?>
</div>
<?php do_action( 'woocommerce_checkout_after_order_review' ); ?>
