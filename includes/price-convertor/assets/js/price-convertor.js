
var PriceConvertor = (function($){

    var t;

    var callbacks = {
        base_currency: function(btn) {
            var baseCurrency = new BaseCurrency();
            baseCurrency.init(btn);
        },
        currencies: function(btn) {
            var currencies = new Currencies();
            currencies.init(btn);
        },
        profits: function(btn) {
            var profits = new Profits();
            profits.init(btn);
        },
        providers_profit: function(btn) {
            var providersProfit = new ProvidersProfit();
            providersProfit.init(btn);
        },
        convertor: function(btn) {
            var convertor = new Convertor();
            convertor.init(btn);
        }
    };

    function BaseCurrency() {
        var body 		= $( '.price_convertor__body' );
        var wrapper 		= $( '.price_convertor__content--base' );
        var complete, notice 	= $( '#base-currency-text' );

        function ajax_callback(r) {
            console.log(r);
            if (typeof r.success !== "undefined" && r.success) {
                notice.siblings( '.error-message' ).remove();
                setTimeout(function(){
                    notice.addClass("lead");
                },0);
                setTimeout(function(){
                    notice.addClass("success");
                    notice.html(r.message);
                },600);
                complete();
            } else {
                $( '.js-price-convertor-base-currency-button' ).removeClass( 'price_convertor__button--loading' ).data( 'done-loading', 'no' );
                notice.siblings( '.error-message' ).remove();
                wrapper.addClass('has-error');
                notice.html(r.message);
                notice.siblings( '.error-message' ).addClass("lead error");
            }
        }


        function do_ajax() {

            wrapper.removeClass('has-error');

            jQuery.post(price_convertor_params.ajaxurl, {
                action: "price_convertor_save_base_currency",
                wpnonce: price_convertor_params.wpnonce,
                base_currency: $('input[name="base-currency"]:checked').val()
            }, ajax_callback).fail(ajax_callback);


        }

        return {
            init: function(btn) {
                complete = function() {
                    setTimeout(function(){
                        wrapper.find('img').hide();
                        $(".price_convertor__body").addClass('js--finished');
                    },1500);

                    body.removeClass( drawer_opened );

                    // setTimeout(function(){
                    //     $('.price_convertor__body').addClass('exiting');
                    // },3500);

                    setTimeout(function(){
                        window.location.href=btn.href;
                    },4000);

                };
                do_ajax();
            }
        }
    }

    function Currencies() {
        var body 		= $( '.price_convertor__body' );
        var wrapper 		= $( '.price_convertor__content--currency' );
        var complete, notice 	= $( '#currencies-text' );
        const formData = $('#currencies-form').serialize();
        function ajax_callback(r) {
            console.log(r);
            if (typeof r.success !== "undefined" && r.success) {
                notice.siblings( '.error-message' ).remove();
                setTimeout(function(){
                    notice.addClass("lead");
                },0);
                setTimeout(function(){
                    notice.addClass("success");
                    notice.html(r.message);
                },600);
                complete();
            } else {
                $( '.js-price-convertor-currencies-button' ).removeClass( 'price_convertor__button--loading' ).data( 'done-loading', 'no' );
                notice.siblings( '.error-message' ).remove();
                wrapper.addClass('has-error');
                notice.html(r.message);
                notice.siblings( '.error-message' ).addClass("lead error");
            }
        }


        function do_ajax() {

            wrapper.removeClass('has-error');

            const fullData = formData + '&action=price_convertor_save_currencies&wpnonce=' + price_convertor_params.wpnonce;


            jQuery.post(price_convertor_params.ajaxurl, fullData, ajax_callback).fail(ajax_callback);


        }

        return {
            init: function(btn) {
                complete = function() {
                    setTimeout(function(){
                        wrapper.find('img').hide();
                        $(".price_convertor__body").addClass('js--finished');
                    },1500);

                    body.removeClass( drawer_opened );

                    // setTimeout(function(){
                    //     $('.price_convertor__body').addClass('exiting');
                    // },3500);

                    setTimeout(function(){
                        window.location.href=btn.href;
                    },4000);

                };
                do_ajax();
            }
        }
    }

    function Profits() {
        var body 		= $( '.price_convertor__body' );
        var wrapper 		= $( '.price_convertor__content--profits' );
        var complete, notice 	= $( '#profits-text' );
        const formData = $('#profits-form').serialize();
        function ajax_callback(r) {
            console.log(r);
            if (typeof r.success !== "undefined" && r.success) {
                notice.siblings( '.error-message' ).remove();
                setTimeout(function(){
                    notice.addClass("lead");
                },0);
                setTimeout(function(){
                    notice.addClass("success");
                    notice.html(r.message);
                },600);
                complete();
            } else {
                $( '.js-price-convertor-profits-button' ).removeClass( 'price_convertor__button--loading' ).data( 'done-loading', 'no' );
                notice.siblings( '.error-message' ).remove();
                wrapper.addClass('has-error');
                notice.html(r.message);
                notice.siblings( '.error-message' ).addClass("lead error");
            }
        }


        function do_ajax() {

            wrapper.removeClass('has-error');

            const fullData = formData + '&action=price_convertor_save_profits&wpnonce=' + price_convertor_params.wpnonce;


            jQuery.post(price_convertor_params.ajaxurl, fullData, ajax_callback).fail(ajax_callback);


        }

        return {
            init: function(btn) {
                complete = function() {
                    setTimeout(function(){
                        wrapper.find('img').hide();
                        $(".price_convertor__body").addClass('js--finished');
                    },1500);

                    body.removeClass( drawer_opened );

                    // setTimeout(function(){
                    //     $('.price_convertor__body').addClass('exiting');
                    // },3500);

                    setTimeout(function(){
                        window.location.href=btn.href;
                    },4000);

                };
                do_ajax();
            }
        }
    }

    function ProvidersProfit() {
        var body 		= $( '.price_convertor__body' );
        var wrapper 		= $( '.price_convertor__content--providers' );
        var complete, notice 	= $( '#providers-profit-text' );
        const formData = $('#providers-profit-form').serialize();
        function ajax_callback(r) {
            console.log(r);
            if (typeof r.success !== "undefined" && r.success) {
                notice.siblings( '.error-message' ).remove();
                setTimeout(function(){
                    notice.addClass("lead");
                },0);
                setTimeout(function(){
                    notice.addClass("success");
                    notice.html(r.message);
                },600);
                complete();
            } else {
                $( '.js-price-convertor-providers-profit-button' ).removeClass( 'price_convertor__button--loading' ).data( 'done-loading', 'no' );
                notice.siblings( '.error-message' ).remove();
                wrapper.addClass('has-error');
                notice.html(r.message);
                notice.siblings( '.error-message' ).addClass("lead error");
            }
        }


        function do_ajax() {

            wrapper.removeClass('has-error');

            const fullData = formData + '&action=price_convertor_save_providers_profit&wpnonce=' + price_convertor_params.wpnonce;


            jQuery.post(price_convertor_params.ajaxurl, fullData, ajax_callback).fail(ajax_callback);


        }

        return {
            init: function(btn) {
                complete = function() {
                    setTimeout(function(){
                        wrapper.find('img').hide();
                        $(".price_convertor__body").addClass('js--finished');
                    },1500);

                    body.removeClass( drawer_opened );

                    // setTimeout(function(){
                    //     $('.price_convertor__body').addClass('exiting');
                    // },3500);

                    setTimeout(function(){
                        window.location.href=btn.href;
                    },4000);

                };
                do_ajax();
            }
        }
    }

    function Convertor() {
        var body 		= $( '.price_convertor__body' );
        var wrapper 		= $( '.price_convertor__content--convertor' );
        var complete, notice 	= $( '#convertor-text' );
        var counter 	= wrapper.find( '.count' );//نشان دهنده تعداد سرویس های اپدیت شده
        var progress 	= wrapper.find( '.progress-bar' );
        var count =  wrapper.find( '.js-price-convertor-convertor-button' ).data('count');//تعداد کل سرویس ها
        var limit = 20;//محدودیت در هر بار بررسی
        var pages = Math.ceil(count / limit);//محاسبه تعداد صفحات

        function ajax_callback(r) {

            if (typeof r.success !== "undefined" && r.success) {

                if(r.data.page_done < pages){//اگر تعداد انجام شده از تعداد کل صفحات کمتذ بود ادامه بده
                    progress.css({ width: (r.data.page_done*limit)*100/count+"%" });
                    counter.text(r.data.page_done*limit);
                    do_ajax(r.data.page_done+1);
                }else{

                    progress.css({ width: "100%" });
                    counter.text(count);


                    notice.siblings( '.error-message' ).remove();
                    setTimeout(function(){
                        notice.addClass("lead");
                    },0);
                    setTimeout(function(){
                        notice.addClass("success");
                        notice.html(r.message);
                    },600);
                    complete();
                }
            } else {
                $( '.js-price-convertor-providers-profit-button' ).removeClass( 'price_convertor__button--loading' ).data( 'done-loading', 'no' );
                notice.siblings( '.error-message' ).remove();
                wrapper.addClass('has-error');
                notice.html(r.message);
                notice.siblings( '.error-message' ).addClass("lead error");
            }
        }


        function do_ajax(page) {

            wrapper.removeClass('has-error');

            jQuery.post(price_convertor_params.ajaxurl, {
                action: "price_convertor_price_calculator",
                wpnonce: price_convertor_params.wpnonce,
                page: page
            }, ajax_callback).fail(ajax_callback);


        }

        return {
            init: function(btn) {
                complete = function() {
                    setTimeout(function(){
                        wrapper.find('img').hide();
                        $(".price_convertor__body").addClass('js--finished');
                    },1500);

                    body.removeClass( drawer_opened );

                    // setTimeout(function(){
                    //     $('.price_convertor__body').addClass('exiting');
                    // },3500);

                    setTimeout(function(){
                        window.location.href=btn.href;
                    },4000);

                };
                do_ajax(1);
            }
        }
    }

    function window_loaded(){

        var
            body 		= $('.price_convertor__body'),
            body_loading 	= $('.price_convertor__body--loading'),
            body_exiting 	= $('.price_convertor__body--exiting'),
            drawer_trigger 	= $('#price_convertor__drawer-trigger'),
            drawer_opening 	= 'price_convertor__drawer--opening';
        drawer_opened 	= 'price_convertor__drawer--open';

        setTimeout(function(){
            body.addClass('loaded');
        },100);

        drawer_trigger.on('click', function(){
            body.toggleClass( drawer_opened );
        });

        $('.price_convertor__button--proceed:not(.price_convertor__button--closer)').click(function (e) {
            e.preventDefault();
            var goTo = this.getAttribute("href");

            body.addClass('exiting');

            setTimeout(function(){
                window.location = goTo;
            },400);
        });

        $(".price_convertor__button--closer").on('click', function(e){

            body.removeClass( drawer_opened );

            e.preventDefault();
            var goTo = this.getAttribute("href");

            setTimeout(function(){
                body.addClass('exiting');
            },600);

            setTimeout(function(){
                window.location = goTo;
            },1100);
        });

        $(".button-next").on( "click", function(e) {
            e.preventDefault();
            var loading_button = price_convertor_loading_button(this);
            if ( ! loading_button ) {
                return false;
            }
            var data_callback = $(this).data("callback");
            console.log(data_callback);
            if( data_callback && typeof callbacks[data_callback] !== "undefined"){
                // We have to process a callback before continue with form submission.
                callbacks[data_callback](this);
                return false;
            } else {
                return true;
            }
        });

        $( document ).on( 'change', '.js-price-convertor-demo-import-select', function() {
            var selectedIndex  = $( this ).val();

            $( '.js-price-convertor-select-spinner' ).show();

            $.post( price_convertor_params.ajaxurl, {
                action: 'price_convertor_update_selected_import_data_info',
                wpnonce: price_convertor_params.wpnonce,
                selected_index: selectedIndex,
            }, function( response ) {
                if ( response.success ) {
                    $( '.js-price-convertor-drawer-import-content' ).html( response.data );
                }
                else {
                    alert( price_convertor_params.texts.something_went_wrong );
                }

                $( '.js-price-convertor-select-spinner' ).hide();
            } )
                .fail( function() {
                    $( '.js-price-convertor-select-spinner' ).hide();
                    alert( price_convertor_params.texts.something_went_wrong )
                } );
        } );
    }

    function price_convertor_loading_button( btn ){

        var $button = jQuery(btn);

        if ( $button.data( "done-loading" ) == "yes" ) {
            return false;
        }

        var completed = false;

        var _modifier = $button.is("input") || $button.is("button") ? "val" : "text";

        $button.data("done-loading","yes");

        $button.addClass("price_convertor__button--loading");

        return {
            done: function(){
                completed = true;
                $button.attr("disabled",false);
            }
        }

    }


    return {
        init: function(){
            t = this;
            $(window_loaded);
        },
        callback: function(func){
            console.log(func);
            console.log(this);
        }
    }

})(jQuery);

PriceConvertor.init();
