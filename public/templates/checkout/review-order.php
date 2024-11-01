<?php
/**
 * Review order table
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/review-order.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.8.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$non_changeable_quantity = get_option( 'onepagecheckout_non_changeable_quantity', '' ); ?>
<div class="shop_table woocommerce-checkout-review-order-table">
	<table class="onestepcheckout-summary">
		<tbody>
		<?php
		do_action( 'woocommerce_review_order_before_cart_contents' );

		foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
			$_product     = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );

			if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_checkout_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
				$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
			}
			?>

			<tr>
		        <td class="thumb">
					<?php
					$thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(array( 50, 80 )), $cart_item, $cart_item_key );
					if ( ! $product_permalink ) {
						echo $thumbnail; // PHPCS: XSS ok.
					} else {
						printf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $thumbnail ); // PHPCS: XSS ok.
					}
					?>
					<span class="product-thumb-quantity"><?php echo intval($cart_item['quantity']);?></span>
		        </td>

				<td class="name more_details">
					<div class="more_details_title"><?php  echo apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) . '&nbsp;'; ?></div>
					<div class="more_details_slide"><?php   echo wc_get_formatted_cart_item_data( $cart_item ); ?></div>
					<div class="onepagecheckout-qty" nowrap="">
					<div class="wrapper_qty">
						<?php
						if($non_changeable_quantity == 'yes') {
							echo intval($cart_item['quantity']);
						} else { ?>
							<button type="button" class="onepagecheckout-minus" >
								<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><path d="M376 232H8c-4.42 0-8 3.58-8 8v32c0 4.42 3.58 8 8 8h368c4.42 0 8-3.58 8-8v-32c0-4.42-3.58-8-8-8z"></path></svg>
							</button>
							<input type="hidden" id="qty1" class="input-text qty text" step="1" min="1" max="<?php echo $_product->backorders_allowed() ? '' : $_product->get_stock_quantity();?>" name="cart[<?php echo esc_attr($cart_item_key); ?>][qty]" value="<?php echo intval($cart_item['quantity']);?>" title="Qty" size="4" inputmode="numeric">
							<button type="button" class="onepagecheckout-plus" >
								<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><path d="M376 232H216V72c0-4.42-3.58-8-8-8h-32c-4.42 0-8 3.58-8 8v160H8c-4.42 0-8 3.58-8 8v32c0 4.42 3.58 8 8 8h160v160c0 4.42 3.58 8 8 8h32c4.42 0 8-3.58 8-8V280h160c4.42 0 8-3.58 8-8v-32c0-4.42-3.58-8-8-8z"></path></svg>
							</button>
							<?php
						}
						?>
					</div>
				   </div>
				   <div class="removepro">
	  				 	 <a href="<?php echo  esc_url( wc_get_cart_remove_url( $cart_item_key ) );?>" class="onepagecheckout-remove" title="<?php echo __('Remove this item', "onepagecheckout-for-woocommerce") ?>">
							 <?php echo __('Remove', "onepagecheckout-for-woocommerce") ?>
						 </a>
	  				</div>
				</td>

		        <td class="total">
		        	<span class="price"><?php echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); ?></span>
				</td>

		    </tr>

			<?php
		}
		do_action( 'woocommerce_review_order_after_cart_contents' );?>

		<tbody>
	</table>

    <div class="cart_totals">
		<div class="woocommerce-form-coupon-btn">
			<?php echo apply_filters( 'woocommerce_checkout_coupon_message', esc_html__( 'Have a coupon?', 'onepagecheckout-for-woocommerce' ) ) . ' <a href="#/" lightbox-target="#woocommerce-form-coupon-lightbox" class="onepagecheckout-lightbox-toggle">' . esc_html__( 'Click here to enter your code', 'onepagecheckout-for-woocommerce' ) . '</a>'; ?>
		</div>
		<!-- <h3 class="border_html order-total-class"><?php // esc_html_e('Order total', 'onepagecheckout-for-woocommerce'); ?></h3> -->

		<div class="cart-subtotal">
			<p class="left-corner"><?php esc_html_e( 'Subtotal', 'onepagecheckout-for-woocommerce' ); ?></p>
			<span class="right-corner"><?php wc_cart_totals_subtotal_html(); ?></span>
		</div>

		 <?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>
        <div class="shipping-total">
		    <?php do_action( 'woocommerce_review_order_before_shipping' ); ?>
			<p class="left-corner"><?php esc_html_e( 'Shipping Fee', 'onepagecheckout-for-woocommerce' ); ?></p>
			<span class="right-corner"><?php echo wc_price( WC()->cart->get_shipping_total() ); ?></span>
			<?php do_action( 'woocommerce_review_order_after_shipping' ); ?>
		</div>
		<?php endif; ?>

		<?php foreach ( WC()->cart->get_coupons() as $code => $coupon ) : ?>
			<div class="cart-discount coupon-<?php echo esc_attr( sanitize_title( $code ) ); ?>">
				<p class="left-corner"><?php wc_cart_totals_coupon_label( $coupon ); ?></p>
				<span class="right-corner"><?php wc_cart_totals_coupon_html( $coupon ); ?></span>
			</div>
		<?php endforeach; ?>

		<?php foreach ( WC()->cart->get_fees() as $fee ) : ?>
			<div class="fee">
				<p class="left-corner"><?php echo esc_html( $fee->name ); ?></p>
				<span class="right-corner"><?php wc_cart_totals_fee_html( $fee ); ?></span>
			</div>
		<?php endforeach; ?>

		<?php if ( wc_tax_enabled() && ! WC()->cart->display_prices_including_tax() ) : ?>
			<?php if ( 'itemized' === get_option( 'woocommerce_tax_total_display' ) ) : ?>
				<?php foreach ( WC()->cart->get_tax_totals() as $code => $tax ) : ?>
					<div class="tax-rate tax-rate-<?php echo sanitize_title( $code ); ?>">
						<p class="left-corner"><?php echo esc_html( $tax->label ); ?></p>
						<span class="right-corner"><?php echo wp_kses_post( $tax->formatted_amount ); ?></span>
					</div>
				<?php endforeach; ?>
			<?php else : ?>
				<div class="tax-total">
					<p class="left-corner"><?php echo esc_html( WC()->countries->tax_or_vat() ); ?></p>
					<span class="right-corner"><?php wc_cart_totals_taxes_total_html(); ?></span>
				</div>
			<?php endif; ?>
		<?php endif; ?>

		<?php do_action( 'woocommerce_review_order_before_order_total' ); ?>

		<div class="order-total">
			<p class="left-corner"><?php esc_html_e( 'Total', 'onepagecheckout-for-woocommerce' ); ?></p>
			<span class="right-corner"><?php wc_cart_totals_order_total_html(); ?></span>
		</div>

		<?php do_action( 'woocommerce_review_order_after_order_total' ); ?>

	</div>
</div>
