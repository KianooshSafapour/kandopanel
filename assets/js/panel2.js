'use strict';
jQuery(document).ready(function ($) {
    $('.my_account_menu').click(function(e) {
        e.preventDefault();
        $('body').addClass('my_account_s');
    });
    $('.my_account_close').click(function(e) {
        e.preventDefault();
        $('.woocommerce-MyAccount-navigation').removeClass('is_active');
        $('body').removeClass('my_account_s');
    });


    $('.kando-site-mask').click(function() {
        $('body').removeClass('account_area my_account_s sidebar_open open_cart_sidebar open_filter_sidebar open_categories_sidebar');
    });

    $('.gototop, .go_up').click(function(){
        $('html,body').animate({scrollTop:0}, 'slow'); return false;
    });
});