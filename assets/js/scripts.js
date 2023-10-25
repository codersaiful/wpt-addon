jQuery(function ($) {
    'use strict';
    $(document).ready(function () {
        // $('input.input-text.qty.text.wcmmq-qty-input-box')
        var hiddenInput = $('.woocommerce-cart-form__contents .wcmmq-qty-input-box');
        hiddenInput.attr('type', 'number');
    });
});