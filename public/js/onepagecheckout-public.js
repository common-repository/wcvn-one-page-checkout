var One_Page_Checkout = {
    onInit: function() {
        jQuery('form.checkout').on("click", "button.onepagecheckout-minus", function() {
            var inputqty = jQuery(this).next('input.qty');
            var val = parseInt(inputqty.val());
            var max = parseFloat(inputqty.attr('max'));
            var min = parseFloat(inputqty.attr('min'));
            var step = parseFloat(inputqty.attr('step'));

            if (val > min) {
                inputqty.val(val - step);
                jQuery(this).next('input.qty').trigger("change");
            }

        });

        jQuery('form.checkout').on("click", "button.onepagecheckout-plus", function() {

            var inputqty = jQuery(this).prev('input.qty');
            var val = parseInt(inputqty.val());
            var max = inputqty.attr('max');
            var min = parseFloat(inputqty.attr('min'));
            var step = parseFloat(inputqty.attr('step'));

            if (val < max || max == '') {
                inputqty.val(val + step);
                jQuery(this).prev('input.qty').trigger("change");
            }
        });

        jQuery('.woocommerce-checkout .form-row input.input-text').each(function() {
            if (!jQuery(this).attr('placeholder') && jQuery(this).closest('p.form-row').find('label').text()) {
                jQuery(this).attr('placeholder', jQuery(this).closest('p.form-row').find('label').text());
            }
            if (jQuery(this).val() || !jQuery(this).attr('placeholder')) {
                jQuery(this).closest('p.form-row').addClass('form-row-active');
            } else {
                jQuery(this).closest('p.form-row').removeClass('form-row-active');
            }
        });

        jQuery('.woocommerce-checkout .form-row input.input-text').on("input", function() {
            if (jQuery(this).val()) {
                jQuery(this).closest('p.form-row').addClass('form-row-active');
            } else {
                jQuery(this).closest('p.form-row').removeClass('form-row-active');
            }
        });


        jQuery("form.checkout #order_review_table").on("change", "input.qty", function() {
            var data = {
                action: 'onepagecheckout_update_order_review',
                security: wc_checkout_params.update_order_review_nonce,
                post_data: jQuery('form.checkout').serialize()
            };

            jQuery.post(WCVN_OnePageCheckout.ajaxurl, data, function(response) {
                jQuery('body').trigger('update_checkout');
            });
        });

        jQuery(document.body).on('added_to_cart', function() {
            jQuery('body').trigger('update_checkout');
        });

        var width = jQuery(window).width();
        if (width < 849) {
            jQuery(document.body).on('update_checkout', function() {
                jQuery('.review-order-title .review-order-title-price').html(jQuery('.express-one-page-checkout-main .cart_totals .order-total span.right-corner').html());
            });

            jQuery('.review-order-title').click(function() {
                jQuery( '#onepagecheckout-order_details_table' ).slideToggle();
    			return false;
            });
        }

        jQuery(document.body).on('updated_checkout', function() {

            /* Open lightbox on button click */
            jQuery('.onepagecheckout-lightbox-toggle').click(function() {
                jQuery('.onepagecheckout-backdrop').animate({
                    'opacity': '.50'
                }, 300, 'linear').css('display', 'block');
                console.log(jQuery(this).attr('lightbox-target'));
                jQuery( jQuery(this).attr('lightbox-target') ).fadeIn();
                return false;
            });

            /* Click to close lightbox */
            jQuery('.onepagecheckout-close, .onepagecheckout-backdrop').click(function() {
                jQuery('.onepagecheckout-backdrop').animate({
                    'opacity': '0'
                }, 300, 'linear', function() {
                    jQuery('.onepagecheckout-backdrop').css('display', 'none');
                });
                jQuery('.onepagecheckout-box').fadeOut();
                return false;
            });

        });

    },
    openLightbox: function() {

    },
    closeLightbox: function() {

    }
};

(function($) {
    'use strict';

    $(function() {

        One_Page_Checkout.onInit();


    });

})(jQuery);
