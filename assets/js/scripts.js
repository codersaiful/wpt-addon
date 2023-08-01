jQuery(function ($) {
    'use strict';
    $(document).ready(function () {
        
        $('.variations_form').on('woocommerce_variation_has_changed', function() {

            var hasSubscribeFormClass = $('section.cwginstock-subscribe-form').hasClass('cwginstock-subscribe-form');
            
            if(hasSubscribeFormClass){
                $('.woocommerce-variation-add-to-cart.variations_button.woocommerce-variation-add-to-cart-enabled').hide();
                $('p.stock.in-stock').hide();
            }else{
                $('.woocommerce-variation-add-to-cart.variations_button.woocommerce-variation-add-to-cart-enabled').show();
                $('p.stock.in-stock').show();
            }
            
        });
    });
});