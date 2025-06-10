'use strict';
var $j = jQuery;

window.ktCanAutoHide = false;
window.ktLastScrollTop = 0;
$j(document).ready(function () {
    ktOnLoad();
});

function ktGetURLParams(str) {
    var query = {};
    str = decodeURIComponent(str).replace(/-/g, '_').split('?')[1].split('&');
    str.map(function (value) {
        value = value.split('=');
        query[value[0]] = value[1];
    });
    return query;
}

function ktUpdateMinicart(response, modal = true) {
    response = JSON.parse(response);
    if (modal) {
        $j('.kt-minicart-modal').remove();
        $j('.kt-modal-holder').append($j(response.modal_content));
        $j('.kt-minicart-modal').css('max-height', $j(window).outerHeight() * 0.95);
        $j('<a href="#" class="kt-modal-button" data-modal="minicart"></a>').appendTo('body').click().remove();
    }
    $j('.header-minicart-content').empty().append($j(response.content));
    if (response.quantity > 0) {
        if ($j('.header-minicart-quantity').length) {
            $j('.header-minicart-quantity').text(response.quantity);
        } else {
            $j('.header-minicart-button-inner').append($j('<span class="header-minicart-quantity">' + response.quantity + '</span>'))
        }
    } else {
        $j('.header-minicart-quantity').remove();
    }
}


function ktOnLoad() {
    $j(document).on('click', '.kt-minicart-modal .button-light', function () {
        $j('.kt-minicart-modal .kt-modal-close').click();
        return false;
    });
    ktScrollProgressBar();
    ktUpdateModalsHeight();
    ktNavigationFixed();
    ktFullHeight();
    ktSubMenuPosition();
    ktScrollToSection();
    ktResponsiveMenu();
    ktInitStickySidebars();
    ktClassicTabs();
    ktAccordion();
    ktCountdown();
    ktAjaxContact();
    ktSetLazyLoadImageSize();

    $j('.dashboard-welcome-close').click(function () {
        setCookie('removeDashboardWelcome', 'yes');
        $j('.dashboard-welcome-box').stop(true, true).slideUp(700, 'easeInOutCubic', function () {
            $j(this).remove();
        });
    });
    $j('.kt-notice-close').click(function () {
        var notice = $j('.kt-notice-outer'),
            id = notice.attr('data-id');
        setCookie('remove_' + id, 'yes');
        notice.stop(true, true).slideUp(400, 'easeInOutCubic', function () {
            $j(this).remove();
        });
    });


    $j(".panel-menu-button").click(function () {
        if ($j(this).hasClass("active")) {
            $j(".panel-responsive-menu").stop(true, true).slideUp(400, 'easeOutCubic');
            $j(this).removeClass('active');
        } else {
            $j(".panel-responsive-menu").stop(true, true).slideDown(450, 'easeOutCubic');
            $j(this).addClass('active');
        }
    });


    $j(".menu-holder .menu .menu-item.menu-item-style-normal, .menu-holder .menu .menu-item.menu-item-style-normal .menu-item").hover(function () {
        $j(this).find(".sub-menu").first().stop(true, true).delay(200).fadeIn(200);
    }, function () {
        $j(this).find(".sub-menu").first().stop(true, true).delay(200).fadeOut(150);
    });

    $j(".menu-holder .menu .menu-item, .menu-holder .menu .menu-item .menu-item").hover(function () {
        $j(this).find(".sub-menu").first().stop(true, true).delay(200).fadeIn(200);
    }, function () {
        $j(this).find(".sub-menu").first().stop(true, true).delay(200).fadeOut(150);
    });


    $j(".header-user-area").hover(function () {
        $j('.header-user-area-list').stop(true, true).delay(200).fadeIn(200);
    }, function () {
        $j('.header-user-area-list').stop(true, true).delay(200).fadeOut(150);
    });

    $j(".menu-holder .menu .menu-item.menu-item-style-mega-menu").hover(function () {
        $j(this).find(".kt-mega-menu-holder").stop(true, true).delay(200).fadeIn(200);
    }, function () {
        $j(this).find(".kt-mega-menu-holder").stop(true, true).delay(200).fadeOut(150);
    });
    $j('.comment-open-button').click(function () {
        $j('.comment-form-outer').stop(true, true).slideDown(500, 'easeOutCubic');
        $j(this).stop(true, true).fadeOut(300, 'easeOutCubic');

        return false;
    });
    $j('.ticket-single-reply-button').click(function () {
        $j('.ticket-single-form-holder').stop(true, true).slideDown(500, 'easeOutCubic');
        $j(this).stop(true, true).fadeOut(300, 'easeOutCubic');

        return false;
    });


    $j('.header-search-content .search-field').keyup(function () {
        var $this = $j(this);
        $this.parents('.header-search-content').addClass('is-loading');

        var timeout = $this.data("timeout") || 0;
        clearTimeout(timeout);
        timeout = setTimeout(function () {
            ktUpdateSearchResults($this.val());
        }, 800);
        $this.data("timeout", timeout);
    });

    $j('.search-form').each(function () {
        var $this = $j(this),
            input = $this.find('.search-field'),
            removeButton = $this.find('.search-remove-value');
        input.keyup(function () {
            if ($j(this).val().length > 1) {
                removeButton.addClass('active');
            } else {
                removeButton.removeClass('active');
            }
        });
        removeButton.click(function () {
            input.val('');
            $j(this).removeClass('active');
            ktUpdateSearchResults('');
        })
    });
    $j(document).on('click', function () {
        $j('.header-search-content, .header-search-button').removeClass('active');
        setTimeout(function () {
            $j('.header-search-content').css('display', 'none');
        }, 300);
        $j('.blog-header-filters-holder').fadeOut(150);
        $j('.blog-header-filters .button, .blog-header-filters').removeClass('active');
    });
    $j('.blog-header-filters > .button').click(function (e) {
        e.stopPropagation();
        $j('.header-search-content, .header-search-button').removeClass('active');
        setTimeout(function () {
            $j('.header-search-content').css('display', 'none');
        }, 300);
        if ($j(this).hasClass('active')) {
            $j('.blog-header-filters-holder').fadeOut(200);
            $j('.blog-header-filters > .button, .blog-header-filters').removeClass('active');
        } else {
            $j('.blog-header-filters-holder').fadeIn(250);
            $j('.blog-header-filters > .button, .blog-header-filters').addClass('active');
        }
        return false;
    });
    $j(".blog-header-filters form").submit(function () {
        $j(this).find("select").filter(function () {
            return !this.value;
        }).attr("disabled", "disabled");
        return true; // ensure form still submits
    });
    $j('.header-search-button').click(function (e) {
        e.stopPropagation();
        $j('.blog-header-filters-holder').fadeOut(200);
        $j('.blog-header-filters .button, .blog-header-filters').removeClass('active');
        if (!$j(this).hasClass('active')) {
            $j(this).addClass('active');
            $j('.header-search-content').css('display', 'block');
            setTimeout(function () {
                $j('.header-search-content').addClass('active');
            }, 10);
            $j('.header-search-content .search-field').focus();
        } else {
            $j(this).removeClass('active');
            $j('.header-search-content').removeClass('active');
            setTimeout(function () {
                $j('.header-search-content').css('display', 'none');
            }, 300);
        }
        return false;
    });
    $j('.header-search-content,.blog-header-filters-holder').click(function (e) {
        e.stopPropagation();
    });


    $j('.blog-note-share').click(function () {
        $j(this).stop(true, true).fadeOut(150, 'easeOutCubic', function () {
            $j(this).parent().find('.blog-note-share-icons').fadeIn(150, 'easeOutCubic');
        })
    });

    $j(document).on('click', '.kt-modal-button', function () {

        if ($j(this).hasClass('kt-login-button')) {
            $j("#kando-login-tab .kt-login-form .step1").show();
            $j("#kando-login-tab").show();
            $j("#kando-register-tab").hide();
            $j("#kando-forget-tab").hide();
            $j("#kando-login-tab .kt-login-form .step2").hide();

            $j('.kt-modal-tabs .tabs-content-holder .tabs-content-inner .tab-content:nth-child(2), .kt-modal-tabs .tabs-title-holder .tab-title:nth-child(2)').removeClass('active');
            $j('.kt-modal-tabs .tabs-content-holder .tabs-content-inner .tab-content:nth-child(2) .tab-content-inner').css('opacity', '0');
            $j('.kt-modal-tabs .tabs-content-holder .tabs-content-inner .tab-content:nth-child(1), .kt-modal-tabs .tabs-title-holder .tab-title:nth-child(1)').addClass('active');
            $j('.kt-modal-tabs .tabs-content-holder .tabs-content-inner .tab-content:nth-child(1) .tab-content-inner').css('opacity', '1');
        }

        if ($j(this).hasClass('kt-register-button')) {
            $j("#kando-login-tab .kt-register-form .step1").show();
            $j("#kando-login-tab").hide();
            $j("#kando-register-tab").show();
            $j("#kando-forget-tab").hide();
            $j('.kt-modal-tabs .tabs-content-holder .tabs-content-inner .tab-content:nth-child(1), .kt-modal-tabs .tabs-title-holder .tab-title:nth-child(1)').addClass('active');
            $j('.kt-modal-tabs .tabs-content-holder .tabs-content-inner .tab-content:nth-child(1) .tab-content-inner').css('opacity', '1');
            // $j('.kt-modal-tabs .tabs-content-holder .tabs-content-inner .tab-content:nth-child(2), .kt-modal-tabs .tabs-title-holder .tab-title:nth-child(2)').addClass('active');
            // $j('.kt-modal-tabs .tabs-content-holder .tabs-content-inner .tab-content:nth-child(2) .tab-content-inner').css('opacity', '1');
        }
        $j('.kt-modal-outer-holder').addClass($j(this).attr('data-modal-outer'));
        $j('html').addClass('kt-modal-opened');
        $j('.kt-modal-outer-holder').css('visibility', 'visible').addClass('active');
        $j('.kt-' + $j(this).attr('data-modal') + '-modal').css({
            'position': 'relative',
            'left': '0'
        }).addClass('active');
        return false;
    });
    $j(document).on('click', '.kt-modal-close, .kt-modal-overlay, .kt-modal-transparent-overlay', function () {
        $j('.kt-modal-outer-holder, .kt-modal-inner').removeClass('active');
        $j('html').removeClass('kt-modal-opened');
        setTimeout(function () {
            $j('.kt-modal-outer-holder').css('visibility', 'hidden');
            $j('.kt-modal-inner').css({
                'position': 'absolute',
                'left': '-10000px'
            });
            $j('.kt-modal-outer-holder')[0].className = 'kt-modal-outer-holder';
        }, 450);

    });
    setInterval(function () {
        ktInitStickySidebars();
    }, 10);
    $j('.header-minicart-holder').hover(function () {
        $j(".header-minicart-content").stop(true, true).delay(200).fadeIn(200);
    }, function () {
        $j(".header-minicart-content").stop(true, true).delay(200).fadeOut(150);
    });
    $j('body').on('input', '.qty', function () {
        var timeout = $j(this).data("timeout") || 0;
        clearTimeout(timeout);
        timeout = setTimeout(function () {
            $j('.woocommerce-cart-form').submit();
        }, 1000);
        $j(this).data("timeout", timeout);
    });


    $j('.button-demo.kt-ajax-button').click(function () {
        var $this = $j(this);

        if (!$this.hasClass('is-loading')) {
            $this.addClass('is-loading');
            $j.ajax({
                url: kando_data.ajaxurl,
                type: 'post',
                data: {
                    action: 'kt_ajax_course_newsletter',
                    product_id: $this.attr('data-id')
                },
                success: function (response) {
                    response = JSON.parse(response);
                    $this.removeClass('is-loading');
                    $j('.course-details-inner .kt-newsletter-message').remove();
                    if (response.error) {
                        $j('<span class="kt-newsletter-message error">' + response.error.replace("\n", '<br/>') + '</span>').insertAfter($this);
                    } else {
                        if (response.file)
                            window.location.assign(response.file);
                        $j('<span class="kt-newsletter-message success">' + response.success + '</span>').insertAfter($this);
                    }
                },
                error: function () {
                    $this.removeClass('is-loading');
                    $j('.course-details-inner .kt-newsletter-message').remove();
                    $j('<span class="kt-newsletter-message error">با عرض پوزش، خطایی رخ داد. لطفا مجددا تلاش کنید.</span>').insertAfter($this);
                }
            });
        }
        return false;
    });


    //add by morteza
    kando_show_coupon();
    KandoAjaxApplyCoupon();
    SamyarAjaxNewTicketReply();
    SamyarAjaxDeleteTicket();
    SamyarAjaxCloseTicket();
    SamyarAjaxEditTicket();
    SamyarAjaxNewTicket();

    SamyarAjaxNewApiProvider();
    SamyarAjaxInquiryRateApiProvider();
    SamyarAjaxDeleteApiProvider();
    // SamyarAjaxDisableApiProvider();
    SamyarAjaxSyncCreditProvider();
    SamyarAjaxSyncApiProvider();
    SamyarAjaxApiProviderServiceList();
    SamyarAjaxLoadServiceInfo();
    // SamyarAjaxSyncBalanceProvider();
    SamyarAjaxLoadServiceDescription();
    SamyarAjaxLoadServiceDescriptionLocal();

    SamyarAjaxNewSocial();
    SamyarAjaxDeleteSocial();

    SamyarAjaxNewCategory();
    SamyarAjaxDeleteCategory();
    // SamyarAjaxDisableCategory();
    SamyarAjaxDeleteAllCategory();
    SamyarAjaxNewService();
    SamyarAjaxNewServiceFromModal();
    SamyarChangeAddTypeApi();
    SamyarAjaxDeleteService();
    // SamyarAjaxDisableService();
    SamyarAjaxDeleteAllService();
    SamyarAjaxGetServiceList();
    samyarShowOrderServices();
    samyarShowServiceInfo();
    samyarProccessOrderPrice();
    SamyarAjaxNewOrder();
    SamyarAjaxMassOrder();
    SamyarAjaxPackageOrder();
    samyarDeleteAllOrders();
    SamyarAjaxShowPackageForm();
    SamyarAjaxShowOrderForm();
    SamyarAjaxGetOrders();
    SamyarAjaxUpdateOrder();
    SamyarAjaxUpdateRefillOrder();
    SamyarAjaxDeleteOrder();
    SamyarAjaxDeleteRefillOrder();
    SamyarAjaxCancelOrder();
    SamyarAjaxSendFastOrder();
    SamyarAjaxAddCredit();
    SamyarAjaxNewNotification();
    SamyarAjaxShowNotification();
    SamyarAjaxDeleteNotification();
    SamyarAjaxLike();
    SamyarSocialShare();
    SamyarConsultation();
    SamyarAjaxFilterOrders();
    SamyarAjaxFilterRefillOrders();
    SamyarAjaxSearchPayment();
    SamyarAjaxSearchServices();
    SamyarAjaxFilterServices();
    SamyarAjaxShowRepaymentForm();
    SamyarAjaxRepayment();
    SamyarAjaxSearchTickets();
    SamyarAjaxEditProfile();
    SamyarAjaxUpdateTicketSettingsProfile();
    SamyarAjaxCreateApiKey();
    SamyarAjaxChangeMobileNumber();
    SamyarAjaxDisable();
    SamyarShowProfileMenu();
    SamyarAjaxShowInfo();
    // SamyarAjaxProcessLink();
    SamyarAjaxDeleteUpdate();
    SamyarAjaxBulkUpdatePrice();
    SamyarAjaxChangeProfileAvatar();
    SamyarAjaxFilterPackages();
    // SamyarAjaxSmartPanelSyncUsers();

    //new in v10
    KandoAjaxLoginStep1();
    KandoAjaxLoginStep2();
    KandoAjaxSendOtpCode();
    KandoAjaxLoginByOtp()
    KandoAjaxSendOtpCodeAgain();

    KandoAjaxSendOtpCodeDashboard();
    KandoAjaxVerifyOtpCodeDashboard();

    KandoAjaxRegisterStep1()
    KandoAjaxRegisterStep2()
    KandoAjaxRegisterStep3();
    KandoAjaxSendOtpCodeAgainRegister();
    KandoAjaxForgetStep1();
    KandoAjaxForgetStep2();
    KandoAjaxSendOtpCodeAgainForget();
    //end by morteza

    kandoNotificationAlert();
    kandoChangeLanguage();
    /*
        jQuery('.hasDatepicker').persianDatepicker({
            initialValue: false,
            format: 'YYYY-MM-DD',
            initialValueType: 'persian',
        });
    */
    $j(document).on('click', '.btn-toggler', function () {
        var $this = $j(this);
        var alert_id = $this.data('id')
        if ($this.hasClass('active')) {
            $this.removeClass('active');
        } else {
            $this.addClass('active');
        }

        $j('#' + alert_id).slideToggle(500);
        return false;
    });



    $j(document).on('click', '.up_top_notify', function (e) {
        $j('body').addClass('notifications-open');
        return false;
    })

    $j(document).on('click', '.rtl-dimmer', function (e) {
        $j('body').removeClass('notifications-open');
    })

    $j(document).on('click', '#notifications-collapse', function (e) {
        $j('body').removeClass('notifications-open');
    })


    $j(document).on('click', '#notifications-read-all', function (e) {
        Swal.fire({
            title: kando_data.langs.all_notifications_marked,
            // text: "",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: kando_data.langs.yes_do_it,
            cancelButtonText: kando_data.langs.cancel
        }).then((result) => {
            // let provider_id = $j(this).data('id');
            if (result.isConfirmed) {
                $j.ajax({
                    url: kando_data.ajaxurl,
                    type: 'post',
                    data: {action: 'kando_seen_all_notification'},
                    success: function (response) {
                        if (!response.success) {
                            Swal.fire({
                                title: kando_data.langs.an_error,
                                icon: 'error',
                                html: response.data,
                                showCloseButton: true,
                                confirmButtonText: kando_data.langs.ok,
                            })
                        } else {
                            Swal.fire({
                                // title: kando_data.langs.an_error,
                                icon: 'success',
                                html: response.data,
                                showCloseButton: true,
                                confirmButtonText: kando_data.langs.ok,
                            })
                            window.location.reload();
                        }
                    },
                    error: function () {
                        Swal.fire({
                            title: kando_data.langs.an_error,
                            icon: 'error',
                            html: response.data,
                            showCloseButton: true,
                            confirmButtonText: kando_data.langs.ok,
                        })
                    }
                });
            }
        });
    })


}

$j(window).resize(function () {
    ktInitStickySidebars();
    ktScrollProgressBar();
    ktUpdateModalsHeight();
    ktNavigationFixed();

    ktFullHeight();
    ktSubMenuPosition();

});
$j(window).bind("load", function () {
    ktUpdateModalsHeight();
    if ($j('.carousel-table-holder').length) $j('.carousel-table-holder').addClass('carousel-table-loaded');
    ktInitStickySidebars();
    $j('body').ktLazyLoad();
    ktScrollProgressBar();
    ktSubMenuPosition();
    if ($j('.blog-academy-box').length) {
        $j('.blog-academy-box').fadeIn(200);
    }
});
$j(window).scroll(function () {
    ktInitStickySidebars();
    $j('body').ktLazyLoad();
    ktScrollProgressBar();
});

$j(window).unbind('scroll.ktScroll');
$j(window).bind('scroll.ktScroll', function () {

    ktNavigationFixed();
    window.ktCanAutoHide = true;

})

function ktIsRtl() {
    return $j('body').hasClass('rtl');
}

setInterval(function () {
    if (window.ktCanAutoHide) {
        ktAutoHide();
        window.ktCanAutoHide = false;
    }
}, 150);


function ktAutoHide() {
    var scrollTop = $j(window).scrollTop();

    if ($j('.menu-holder').hasClass('scrolled')) {
        var height = 106,
            speed = Math.round(height * 2.5) + 100;
        if (scrollTop > window.ktLastScrollTop + 20 && $j('.menu-holder').hasClass('show')) {
            $j('.menu-holder').stop(true, true).addClass('hide').removeClass('show').css('top', '0px').animate({
                'top': (-height) + 'px'
            }, speed, 'easeOutCubic');
        } else if (scrollTop < window.ktLastScrollTop - 40 && !$j('.menu-holder').hasClass('show')) {
            $j('.menu-holder').stop(true, true).addClass('show').removeClass('hide').css('top', (-height) + 'px').animate({
                'top': '0px'
            }, speed, 'easeOutCubic');
        }
    }


    window.ktLastScrollTop = scrollTop;
}


function ktResponsiveMenu() {
    $j(".responsive-menu-holder .menu-item > .menu-item-inner a .menu-item-toggle-icon").click(function () {
        var $this = $j(this).closest('.menu-item');
        if ($this.hasClass("active")) {
            $this.find(".sub-menu").stop(true, true).slideUp(350, 'easeOutCubic');
            $this.removeClass('active');
            $this.find('.menu-item').removeClass('active');
        } else {
            $this.find(".sub-menu").first().stop(true, true).slideDown(400, 'easeOutCubic');
            $this.addClass('active');
        }
        return false;
    });
    $j('.responsive-menu-holder .menu-item.active').each(function () {
        $j(this).find('.sub-menu').first().css('display', 'block');
    });

    $j('.responsive-menu-button').click(function () {
        $j('.responsive-menu-overlay').css('visibility', 'visible');
        $j('html').addClass('responsive-menu-opened');
        $j(this).addClass('active');
        var timeout = $j('.responsive-menu-overlay').data("timeout") || 0;
        clearTimeout(timeout);
    });
    $j('.responsive-menu-button.active, .responsive-menu-overlay').click(function () {
        $j('html').removeClass('responsive-menu-opened');
        $j('.responsive-menu-button').removeClass('active');
        var timeout = $j('.responsive-menu-overlay').data("timeout") || 0;
        clearTimeout(timeout);
        timeout = setTimeout(function () {
            $j('.responsive-menu-overlay').css('visibility', 'hidden');
        }, (Math.round($j('.responsive-menu-outer-holder').outerWidth()) + 300));
        $j('.responsive-menu-overlay').data("timeout", timeout);
    });


}


function ktScrollToSection() {
    // Add smooth scrolling to all links
    $j('a[href*="#"]').on('click', function (event) {

        // Make sure this.hash has a value before overriding default behavior
        if (this.hash !== "") {
            // Prevent default anchor click behavior
            event.preventDefault();

            // Store hash
            var hash = this.hash;

            // Using jQuery's animate() method to add smooth page scroll
            // The optional number (800) specifies the number of milliseconds it takes to scroll to the specified area
            $j('html, body').animate({
                scrollTop: $j(hash).offset().top
            }, 800, function () {

                // Add hash (#) to URL when done scrolling (default click behavior)
                window.location.hash = hash;
            });
        } // End if
    });
    /*
    $j('a[href*="#"]').click(function () {
        var a = document.createElement('a'),
            hashURL = '#' + $j(this).attr('href').split("#")[1],
            ID = $j(this).attr('id') ? $j(this).attr('id') : '';
        a.href = $j(this).attr("href");

        if ($j(hashURL).length && ID.indexOf('cancel-comment-reply-link') === -1 && ID.indexOf('acomment-comment-') === -1 && !$j(this).hasClass('comment-reply-link') && (window.location.pathname === a.pathname || a.pathname === '')) {
            var offsetTop = $j(hashURL).offset().top;
            $j('html, body').animate({
                scrollTop: offsetTop - $j('#wpadminbar').outerHeight()
            }, 2000, 'easeInOutQuint');
            return false;

        }
    });
    */
}


function ktScrollProgressBar() {
    if ($j('.scroll-progress-bar').length) {
        var height = $j('.blog-single-content-holder').outerHeight() + $j('.blog-single-top-holder').offset().top + $j('.blog-single-top-holder').outerHeight() - ($j(window).outerHeight() * 1.38) + ($j('body').hasClass('admin-bar') ? 32 : 0),
            width = (($j(window).scrollTop() - $j('.blog-single-top-holder').offset().top + ($j(window).outerHeight() * 0.12)) / height) * 100;
        if (width > 100) width = 100;
        if (width < 0) width = 0;
        $j('.scroll-progress-bar').css('width', width + '%');
    }
}


function ktUpdateModalsHeight() {
    if ($j('.kt-modal-inner').length) {
        var h = $j(window).outerHeight() * 0.95;
        $j('.kt-modal-inner').css('max-height', h);
    }
}

function ktSetLazyLoadImageSize() {
    $j('.kt-lazyload:not(.kt-lazyload-init)').each(function () {
        $j(this).css('padding-top', parseFloat($j(this).outerWidth()) * parseFloat($j(this).attr('data-image-ratio') + '%'));
        $j(this).addClass('kt-lazyload-init')
    });
}

$j.fn.ktLazyLoad = function () {
    $j(this).find('.kt-lazyload:not(.kt-lazyloaded):not(.kt-lazyloading)').each(function () {
        if ($j(window).scrollTop() + $j(window).outerHeight() + 100 > $j(this).offset().top) {
            var $this = $j(this);
            $this.addClass('kt-lazyloading');
            if ($this.attr('data-src')) {
                $this.attr('src', $this.attr('data-src')).on('load', function () {
                    $this.css('padding-top', '0').addClass('kt-lazyloaded');
                    $this.removeClass('kt-lazyloading');
                });
            }
        }
    });
}


function ktAjaxContact() {
    $j('.contact-form').submit(function () {
        var $this = $j(this),
            errors = $this.find('.contact-form-errors'),
            speed = errors.is(':empty') ? 0 : 400,
            formData = new FormData(this);
        formData.append('file', $j('.contact-form-file').prop('files')[0]);
        formData.append('name', $this.find('.contact-form-name').val());
        formData.append('phone', $this.find('.contact-form-phone').val());
        formData.append('action', 'kt_ajax_contact');
        formData.append('email', $this.find('.contact-form-email').val());
        formData.append('website', $this.find('.contact-form-website').val());
        formData.append('text', $this.find('.contact-form-text').val());
        formData.append('subject', $this.find('.contact-form-subject').val());
        if (!$this.hasClass('is-loading')) {
            $this.addClass('is-loading');
            $this.find('.contact-form-loading').fadeIn(200);
            $j.ajax({
                url: kando_data.ajaxurl,
                type: 'post',
                contentType: false,
                cache: false,
                processData: false,
                data: formData,
                success: function (response) {
                    response = $j(response);

                    if (response.length && response.html() != '') {
                        errors.slideUp(speed, 'easeInOutCubic', function () {
                            $j(this).empty().append(response).slideDown(500, 'easeInOutCubic');
                        });
                    } else {
                        errors.slideUp(speed, 'easeInOutCubic', function () {
                            $j(this).empty();
                        });

                    }
                    $this.removeClass('is-loading');
                    $this.find('.contact-form-loading').fadeOut(200);
                },
                error: function () {
                    $this.removeClass('is-loading');
                    $this.find('.contact-form-loading').fadeOut(200);
                }
            });
        }
        return false;
    });
}

function setCookie(cname, cvalue) {
    var d = new Date();
    d.setTime(d.getTime() + (24 * 60 * 60 * 30 * 12 * 15 * 1000));
    document.cookie = cname + '=' + cvalue + '; expires=' + d.toUTCString() + ';path=/';
}

function getCookie(cname) {
    var name = cname + "=", decodedCookie = decodeURIComponent(document.cookie), ca = decodedCookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}


function ktRecaptcha(action, callback) {
    if (kando_data.google_captcha_enable === "1") {
        grecaptcha.ready(function () {
            grecaptcha.execute(kando_data.captcha_google_key, {action: action}).then(function (token) {
                callback(token);
            });
        });
    } else {
        callback("");
    }

}


function ktCountdown() {
    if ($j('.dashboard-discount-box-timer').length) {
        $j('.dashboard-discount-box-timer').each(function () {
            var $this = $j(this),
                finalDate = $this.attr('data-final-date'),
                content = $this.attr('data-content');
            $this.countdown(finalDate, function (e) {
                var days = e.offset.totalDays,
                    hours = e.offset.hours,
                    minutes = e.offset.minutes,
                    seconds = e.offset.seconds;
                if (days.toString().length == 1) days = '0' + days;
                if (hours.toString().length == 1) hours = '0' + hours;
                if (minutes.toString().length == 1) minutes = '0' + minutes;
                if (seconds.toString().length == 1) seconds = '0' + seconds;
                $this.html(e.strftime(content.replace('/*روز*/', days).replace('/*ساعت*/', hours).replace('/*دقیقه*/', minutes).replace('/*ثانیه*/', seconds)));
            })
        })
    }
}

function ktAccordion() {
    if ($j('.accordions').length) {
        $j('.accordions').each(function () {
            var $this = $j(this),
                titles = $this.find('.accordion-title'),
                contents = $this.find('.accordion-content');
            contents.css('height', '0px');
            if (!$this.hasClass('accordion-items-closed')) {
                titles.first().addClass('active');
                contents.first().css('height', contents.first().find('.accordion-content-inner').outerHeight(true));
            }
            titles.click(function () {
                var content = $j(this).closest('.accordion').find('.accordion-content');
                if (!$j(this).hasClass('active')) {
                    contents.css('height', '0px');
                    titles.removeClass('active');
                    $j(this).addClass('active');
                    content.css('height', content.find('.accordion-content-inner').outerHeight(true));
                } else {
                    $j(this).removeClass('active');
                    content.css('height', '0px');
                }
            });
        });
    }
}

function ktNavigationFixed() {


    var scrollTop = $j(window).scrollTop(),
        height = 106,
        h = window.innerHeight - height,
        speed = Math.round(height * 2.5) + 100;
    if (!$j('.carousel-table-holder').length) {
        if (scrollTop > h && scrollTop > (height * 3)) {
            if ($j('.menu-holder').hasClass('scrolled'))
                return false;
            $j('.menu-holder').addClass('scrolled').removeClass('hiding').css('top', (-height) + 'px');
            ktSubMenuPosition();
        } else {
            if (!$j('.menu-holder').hasClass('scrolled') || $j('.menu-holder').hasClass('hiding'))
                return false;
            $j('.menu-holder').stop(true, true).addClass('hiding').animate({
                top: -height
            }, speed - 100, 'easeInCubic', function () {
                $j('.menu-holder').css('top', '0px').removeClass('scrolled show').removeClass('hiding');
                ktSubMenuPosition();
            });

        }
    }

}


/*============================================
 Set row's height to the screen's height
 ============================================*/

function ktFullHeight() {
    $j('.row-full-height').css('height', $j(window).height() + 'px');
}


/*============================================
 Set position for the navigation's sub menus
 ============================================*/

function ktSubMenuPosition() {
    $j('.menu-holder .main-menu .menu .menu-item-style-normal .sub-menu, .menu-holder .main-menu .menu-item-style-mega-menu .kt-mega-menu-holder').css('visibility', 'hidden').css('display', 'block');
    $j('.menu-holder .main-menu .menu .menu-item-style-normal .sub-menu').each(function () {
        var offset = $j(this).offset().left + (!ktIsRtl() ? $j(this).outerWidth() : 0),
            windowWidth = ($j(window).width());
        if (windowWidth < offset) {
            $j(this).addClass('sub-menu-left');
            $j(this).parents('.sub-menu').addClass('sub-menu-left');
        }
    });
    $j('.menu-holder .main-menu .menu-item-style-mega-menu').each(function () {
        $j(this).find('.kt-mega-menu-holder .kt-mega-menu-shortcode-holder').css('height', $j(this).find('.kt-mega-menu-holder .mega-menu-sub-menu-outer').outerHeight());
        $j(this).find('.kt-mega-menu-holder').css({
            'right': ($j(this).offset().left + $j(this).outerWidth()) - ($j('.menu-inner').offset().left + $j('.menu-inner').outerWidth()),
            'width': $j('.menu-inner').outerWidth(),
        });
    });
    $j('.header-top-widget .menu .menu-item .sub-menu, .header-widget .menu .menu-item .sub-menu, .menu-holder .main-menu .menu .menu-item-style-normal .sub-menu, .menu-holder .main-menu .menu-item-style-mega-menu .kt-mega-menu-holder').css('display', 'none').css('visibility', 'visible');

}

function ktClassicTabs() {
    if ($j('.tabs').length) {
        $j('.tabs').each(function () {
            var $this = $j(this),
                titles = $this.find('> .tabs-title-holder > .tab-title'),
                contentsHolder = $this.find('> .tabs-content-holder > .tabs-content-inner'),
                contents = $this.find('> .tabs-content-holder > .tabs-content-inner > .tab-content'),
                firstTab = $this.find('.' + titles.first().attr('data-tab-id'));
            contents.find('> .tabs-content-holder > .tabs-content-inner').css('opacity', 0);
            titles.first().addClass('active');
            firstTab.addClass('active');
            firstTab.find('.tab-content-inner').css('opacity', 1);

            titles.click(function () {
                var newTabTitle = $j(this),
                    currentTab = $this.find('> .tabs-content-holder > .tabs-content-inner > .tab-content.active'),
                    newTab = $this.find('.' + newTabTitle.attr('data-tab-id'));
                if (!newTabTitle.hasClass('active')) {
                    contentsHolder.css('height', currentTab.outerHeight());
                    currentTab.find('> .tab-content-inner').stop(true, true).animate({
                        'opacity': 0
                    }, 150, function () {
                        currentTab.removeClass('active');
                        newTab.addClass('active');
                        newTab.find('> .tab-content-inner').stop(true, true).animate({
                            'opacity': 1
                        }, 300);
                    });
                    titles.removeClass('active');
                    newTabTitle.addClass('active');
                    contentsHolder.css('height', newTab.outerHeight());
                    var timeout = contentsHolder.data("timeout") || 0;
                    clearTimeout(timeout);
                    timeout = setTimeout(function () {
                        contentsHolder.css('height', 'auto');
                    }, 600);
                }
            });
        });
    }
}


function ktUpdateSearchResults(searchContent) {

    if (window.ktAjaxSearchCurrentContent != searchContent && searchContent != '') {

        $j.ajax({
            type: "POST",
            dataType: "html",
            url: ktSearchAjax.kando_data.ajaxurl,
            data: {
                action: 'kt_ajax_search_results',
                searchContent: searchContent,
            },
            success: function (data) {
                var $data = $j(data);
                window.ktAjaxSearchCurrentContent = searchContent;
                if ($data.length > 0) {


                    if ($j('.header-search-content').hasClass('has-animation')) {
                        $j('.header-search-content').css('height', $j('.header-search-content .header-search-content-outer').outerHeight() + $j('.header-search-content .search-form').outerHeight() + 'px');
                        var $i = 0;
                        $data.find('.header-search-item,.header-search-not-found').each(function () {
                            if ($i > 0) $j(this).css('animation-delay', $i * 50 + 'ms');
                            $i++;
                        });
                    }

                    $j(".header-search-content-outer").empty().append($data);
                    if ($j('.header-search-content-inner').length) {
                        $j('.header-search-content-inner').css('max-height', $j(window).outerHeight() * 0.4);
                        new PerfectScrollbar('.header-search-content-inner', {
                            wheelPropagation: true,
                            suppressScrollX: true,
                            wheelSpeed: 0.7
                        });
                    }
                    if ($j('.header-search-content').hasClass('has-animation')) {
                        $j('.header-search-content').animate({
                            'height': $j('.header-search-content .header-search-content-outer').outerHeight() + $j('.header-search-content .search-form').outerHeight() + 'px'
                        }, 700, 'easeInOutQuint');
                    }


                } else {
                    if ($j('.header-search-content').hasClass('has-animation')) $j('.header-search-content').css('height', $j('.header-search-content .header-search-content-outer').outerHeight() + $j('.header-search-content .search-form').outerHeight() + 'px');
                    if ($j('.header-search-content').hasClass('has-animation')) {
                        $j('.header-search-content').animate({
                            'height': $j('.header-search-content .search-form').outerHeight() + 'px'
                        }, 700, 'easeInOutQuint', function () {
                            $j(".header-search-content-outer").empty();
                        });
                    } else {
                        $j(".header-search-content-outer").empty();
                    }
                }
                $j('.header-search-content').removeClass('is-loading');
            },
            error: function () {
                var animationClass;
                if ($j('.header-search-content').hasClass('has-animation')) {
                    animationClass = ' header-search-item-animated';
                    $j('.header-search-content').css('height', $j('.header-search-content .header-search-content-outer').outerHeight() + $j('.header-search-content .search-form').outerHeight() + 'px');
                }
                $j(".header-search-content-outer").empty().append('<div class="header-search-content-holder"><div class="header-search-content-inner"><div class="header-search-not-found' + animationClass + '">' + ktSearchAjax.error + '</div></div></div>');
                $j('.header-search-content').removeClass('is-loading');
                if ($j('.header-search-content').hasClass('has-animation')) {
                    $j('.header-search-content').animate({
                        'height': $j('.header-search-content .header-search-content-outer').outerHeight() + $j('.header-search-content .search-form').outerHeight() + 'px'
                    }, 700, 'easeInOutQuint');
                }

            }
        });
    } else {

        $j('.header-search-content').removeClass('is-loading');
        if (searchContent == '') {
            window.ktAjaxSearchCurrentContent = searchContent;

            if ($j('.header-search-content').hasClass('has-animation')) {
                $j('.header-search-content').css('height', $j('.header-search-content .header-search-content-outer').outerHeight() + $j('.header-search-content .search-form').outerHeight() + 'px').animate({
                    'height': $j('.header-search-content .search-form').outerHeight() + 'px'
                }, 700, 'easeInOutQuint', function () {
                    $j('.header-search-content-outer').empty();
                });
            }
        }
    }
}

function ktInitStickySidebars() {
    ktStickySidebar($j('.blog-single-social-links'), $j('.blog-single-content-sidebar'), $j('.blog-single-content-sidebar'));
    ktStickySidebar($j('.course-details-inner'), $j('.course-single-content-inner'), $j('.course-details-outer'));
    ktStickySidebar($j('.kt-custom-package-cart-holder .kt-custom-package-cart'), $j('.kt-custom-package-cart-holder'), $j('.kt-custom-package-cart-holder'));
}

function ktStickySidebar(selector, target, parent) {

    var h = $j(window).outerHeight(),
        scrollTop = $j(window).scrollTop(),
        height = selector.outerHeight(),
        containerHeight = target.outerHeight();
    if (height < containerHeight) {
        var width = parent.width(),
            offsetLeft = parent.offset().left + parseFloat(parent.css('padding-left')),
            offsetTop = parent.offset().top,
            marginBottom = h - selector.outerHeight() - 40,
            marginTop = $j('#wpadminbar').outerHeight() + 126;
        if (height + marginTop < h) {
            if (offsetTop + containerHeight > scrollTop + height + marginTop) {
                if (offsetTop - marginTop < scrollTop) {
                    selector.css({
                        'position': 'fixed',
                        'top': marginTop + 'px',
                        'left': offsetLeft,
                        'width': width
                    });
                } else {
                    selector.css({
                        'position': 'relative',
                        'left': '0',
                        'top': '0'
                    });
                }
            } else {
                selector.css({
                    'position': 'relative',
                    'top': (containerHeight - height) + 'px',
                    'left': '0'
                });
            }
        } else {
            if (offsetTop + containerHeight > scrollTop + height + marginBottom) {
                if ((offsetTop + 40 + height) < scrollTop + h) {
                    selector.css({
                        'left': offsetLeft,
                        'width': width,
                        'position': 'fixed',
                        'top': marginBottom + 'px'
                    });
                } else {
                    selector.css({
                        'position': 'relative',
                        'top': '0',
                        'left': '0'
                    });
                }
            } else {
                selector.css({
                    'position': 'relative',
                    'top': (containerHeight - height) + 'px',
                    'left': '0'
                });
            }

        }
    } else {
        selector.css({
            'position': 'relative',
            'top': '0',
            'left': '0'
        });
    }
}


//add by morteza
function SamyarAjaxNewTicket() {
    $j('#new-ticket-form-file').change(function () {
        $j('#new-ticket-form-file + label').text($j('#new-ticket-form-file').prop('files')[0].name);
    });
    var post_id = $j('.product.type-product').length ? $j('.product.type-product').attr('id').replace('product-', '') : '',
        user_id = $j('.new-ticket-form').attr('data-user-id');
    $j('.new-ticket-form').submit(function () {
        var $this = $j(this),
            text = $this.find('.new-ticket-form-text').val(),
            title = $this.find('.new-ticket-form-title').val(),
            order = $this.find('.new-ticket-form-order-id').val(),
            errors = $this.find('.new-ticket-form-errors'),
            sms = $j('#new-ticket-noti').is(':checked'),
            speed = errors.is(':empty') ? 0 : 400,
            formData = new FormData(this);

        if ($j('.new-ticket-form-user-id').length > 0) {
            var user_data = $j('.new-ticket-form-user-id').select2('data');
            var user_id = user_data[0]['id'];
            formData.append('user_id', user_id);
        }


        if ($j('#ticket-single-form-file').length > 0) {
            var fileInput = $j('#ticket-single-form-file').prop('files')[0];
            if (fileInput) {
                formData.append('file', fileInput);
            }
        }

        // formData.append('file', $j('#new-ticket-form-file').prop('files')[0]);
        formData.append('user_id', user_id);
        formData.append('action', 'samyar_ajax_new_ticket');
        formData.append('title', title);
        formData.append('text', text);
        formData.append('sms', sms);
        formData.append('order', order);
        formData.append('post_id', post_id);
        if (!$this.hasClass('is-loading')) {
            $this.addClass('is-loading');
            $this.find('.new-ticket-form-loading').fadeIn(200);
            $j.ajax({
                url: kando_data.ajaxurl,
                type: 'post',
                contentType: false,
                cache: false,
                processData: false,
                data: formData,
                success: function (response) {
                    if (response.success) {
                        errors.slideUp(speed, 'easeInOutCubic', function () {
                            window.location.href = response.data.url;
                        });
                    } else {
                        Swal.fire({
                            title: kando_data.langs.an_error,
                            icon: 'error',
                            html: response.data,
                            showCloseButton: true,
                            confirmButtonText: kando_data.langs.ok,
                        })
                    }
                    /*
                    response = $j(response);
                    if (response.is('.new-ticket-form-errors-inner')) {
                        errors.slideUp(speed, 'easeInOutCubic', function () {
                            $j(this).empty().append(response).slideDown(500, 'easeInOutCubic');
                        });
                    } else {
                        errors.slideUp(speed, 'easeInOutCubic', function () {
                            window.location.href = response.text();
                        });

                    }
                    */
                    $this.removeClass('is-loading');
                    $this.find('.new-ticket-form-loading').fadeOut(200);
                },
                error: function () {
                    $this.removeClass('is-loading');
                    $this.find('.new-ticket-form-loading').fadeOut(200);
                }
            });

        }

        return false;
    });
}

function SamyarAjaxNewTicketReply() {
    var ticket_id = $j('.ticket-single-form').attr('data-ticket-id'),
        user_id = $j('.ticket-single-form').attr('data-user-id');
    $j('.ticket-single-form').submit(function () {
        var $this = $j(this),
            text = $this.find('.ticket-single-form-text').val(),
            errors = $this.find('.ticket-single-form-errors'),
            speed = errors.is(':empty') ? 0 : 400;
        var formData = new FormData(this);

        if ($j('#ticket-single-form-file').length > 0) {
            var fileInput = $j('#ticket-single-form-file').prop('files')[0];
            if (fileInput) {
                formData.append('file', fileInput);
            }
        }


        // formData.append('file', $j('#ticket-single-form-file').prop('files')[0]);
        formData.append('user_id', user_id);
        formData.append('ticket_id', ticket_id);
        formData.append('action', 'samyar_ajax_ticket_reply');
        formData.append('text', text);
        if (!$this.hasClass('is-loading')) {
            $this.addClass('is-loading');
            $this.find('.ticket-single-form-loading').fadeIn(200);
            $j.ajax({
                url: kando_data.ajaxurl,
                type: 'post',
                contentType: false,
                cache: false,
                processData: false,
                data: formData,
                success: function (response) {
                    if (response.success) {
                        location.reload();
                    } else {
                        Swal.fire({
                            title: kando_data.langs.an_error,
                            icon: 'error',
                            html: response.data,
                            showCloseButton: true,
                            confirmButtonText: kando_data.langs.ok,
                        })
                    }

                    /*
                    response = $j(response);
                    if (response.length && response.html() != '') {
                        errors.slideUp(speed, 'easeInOutCubic', function () {
                            $j(this).empty().append(response).slideDown(500, 'easeInOutCubic');
                        });
                    } else {
                        errors.slideUp(speed, 'easeInOutCubic', function () {
                            $j(this).empty();
                        });

                    }
                     */
                    $this.removeClass('is-loading');
                    $this.find('.ticket-single-form-loading').fadeOut(200);
                },
                error: function () {
                    $this.removeClass('is-loading');
                    $this.find('.ticket-single-form-loading').fadeOut(200);
                }
            });

        }

        return false;
    });
}

function SamyarAjaxDeleteTicket() {
    var ticket_id = $j('.ticket-single-form').attr('data-ticket-id'),
        user_id = $j('.ticket-single-form').attr('data-user-id');
    $j(document).on('click', '.ticket-delete-button', function () {

        Swal.fire({
            title: kando_data.langs.are_you_sure,
            // text: "",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: kando_data.langs.yes_delete,
            cancelButtonText: kando_data.langs.cancel
        }).then((result) => {
            // let provider_id = $j(this).data('id');
            if (result.isConfirmed) {
                $j.ajax({
                    url: kando_data.ajaxurl,
                    type: 'post',
                    data: {id: ticket_id, action: 'samyar_ticket_delete'},
                    success: function (response) {
                        if (!response.success) {
                            Swal.fire({
                                title: kando_data.langs.an_error,
                                icon: 'error',
                                html: response.data,
                                showCloseButton: true,
                                confirmButtonText: kando_data.langs.ok,
                            })
                        } else {

                            Swal.fire({
                                icon: 'success',
                                html: response.data.message,
                                showCloseButton: true,
                                confirmButtonText: kando_data.langs.ok,
                            })
                            window.location.replace(response.data.redirect);
                        }
                    },
                    error: function () {
                        Swal.fire({
                            title: kando_data.langs.an_error,
                            icon: 'error',
                            html: response.data,
                            showCloseButton: true,
                            confirmButtonText: kando_data.langs.ok,
                        })
                    }
                });

            }
        })

    })
}

function SamyarAjaxCloseTicket() {
    var ticket_id = $j('.ticket-single-form').attr('data-ticket-id'),
        user_id = $j('.ticket-single-form').attr('data-user-id');
    $j(document).on('click', '.ticket-close-button', function () {

        Swal.fire({
            title: kando_data.langs.are_you_sure_want_to_close,
            // text: "",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: kando_data.langs.yes_close,
            cancelButtonText: kando_data.langs.cancel
        }).then((result) => {
            // let provider_id = $j(this).data('id');
            if (result.isConfirmed) {
                $j.ajax({
                    url: kando_data.ajaxurl,
                    type: 'post',
                    data: {id: ticket_id, action: 'samyar_ticket_close'},
                    success: function (response) {
                        if (!response.success) {
                            Swal.fire({
                                title: kando_data.langs.an_error,
                                icon: 'error',
                                html: response.data,
                                showCloseButton: true,
                                confirmButtonText: kando_data.langs.ok,
                            })
                        } else {

                            Swal.fire({
                                icon: 'success',
                                html: response.data.message,
                                showCloseButton: true,
                                confirmButtonText: kando_data.langs.ok,
                            })
                            location.reload();
                            // window.location.replace(response.data.redirect);
                        }
                    },
                    error: function () {
                        Swal.fire({
                            title: kando_data.langs.an_error,
                            icon: 'error',
                            html: response.data,
                            showCloseButton: true,
                            confirmButtonText: kando_data.langs.ok,
                        })
                    }
                });

            }
        })

    })
}

function SamyarAjaxEditTicket() {
    // $j('a.forget-password').click(function () {
    $j(document).on('click', 'a.edit-message', function () {
        if (!$j(this).hasClass('is-loading')) {
            var $this = $j(this);
            var message_id = $this.attr('data-id');
            $this.addClass('is-loading');

            $j('.message-' + message_id + ' .ticket-single-text-holder p').hide();
            $j('.message-' + message_id + ' .ticket-single-text-holder textarea').slideDown(400, 'easeInOutCubic');


            $this.removeClass('is-loading').hide();
            $j('.message-' + message_id + ' .ticket-single-text-holder .cancel-update').slideDown(400, 'easeInOutCubic');
            $j('.message-' + message_id + ' .ticket-single-text-holder .update-message').slideDown(400, 'easeInOutCubic');
            // $this.hide()

        }
        return false;
    });

    $j(document).on('click', 'a.cancel-update', function () {
        if (!$j(this).hasClass('is-loading')) {
            var $this = $j(this);
            var message_id = $this.attr('data-id');
            $this.addClass('is-loading');

            $j('.message-' + message_id + ' .ticket-single-text-holder p').slideDown(400, 'easeInOutCubic');
            $j('.message-' + message_id + ' .ticket-single-text-holder textarea').slideUp(400, 'easeInOutCubic');


            $j('.message-' + message_id + ' .ticket-single-text-holder .cancel-update').slideUp(400, 'easeInOutCubic');
            $j('.message-' + message_id + ' .ticket-single-text-holder .update-message').slideUp(400, 'easeInOutCubic');
            $j('.message-' + message_id + ' .ticket-single-text-holder .edit-message').slideDown(400, 'easeInOutCubic');

            $this.removeClass('is-loading').hide();

        }
        return false;
    });

    $j(document).on('click', 'a.update-message', function () {
        if (!$j(this).hasClass('is-loading')) {

            var $this = $j(this);
            var message_id = $this.attr('data-id');
            var message = $j('.message-' + message_id + ' .ticket-single-text-holder textarea').val();
            $this.addClass('is-loading');

            $j.ajax({
                url: kando_data.ajaxurl,
                type: 'post',
                data: {
                    action: 'samyar_update_message',
                    message: message,
                    id: message_id
                },
                success: function (response) {
                    if (!response.success) {
                        Swal.fire({
                            title: kando_data.langs.an_error,
                            icon: 'error',
                            html: response.data,
                            showCloseButton: true,
                            confirmButtonText: kando_data.langs.ok,
                        })
                    } else {

                        Swal.fire({
                            icon: 'success',
                            html: response.data.message,
                            showCloseButton: true,
                            confirmButtonText: kando_data.langs.ok,
                        })
                        $j('.message-' + message_id + ' .ticket-single-text-holder p').html(response.data.text);
                        $j('.message-' + message_id + ' .ticket-single-text-holder p').slideDown(400, 'easeInOutCubic');
                        $j('.message-' + message_id + ' .ticket-single-text-holder textarea').slideUp(400, 'easeInOutCubic');

                        $j('.message-' + message_id + ' .ticket-single-text-holder .cancel-update').slideUp(400, 'easeInOutCubic');
                        $j('.message-' + message_id + ' .ticket-single-text-holder .update-message').slideUp(400, 'easeInOutCubic');
                        $j('.message-' + message_id + ' .ticket-single-text-holder .edit-message').slideDown(400, 'easeInOutCubic');
                        // location.reload();
                        // window.location.replace(response.data.redirect);
                    }
                    $this.removeClass('is-loading');
                },
                error: function () {
                    Swal.fire({
                        title: kando_data.langs.an_error,
                        icon: 'error',
                        html: response.data,
                        showCloseButton: true,
                        confirmButtonText: kando_data.langs.ok,
                    });
                    $this.removeClass('is-loading');
                }
            });
        }
        return false;
    });


    $j(document).on('click', '.delete-message', function () {

        Swal.fire({
            title: kando_data.langs.are_you_sure,
            text: kando_data.langs.message_deleted,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: kando_data.langs.yes_delete,
            cancelButtonText: kando_data.langs.cancel
        }).then((result) => {
            let message_id = $j(this).data('id');
            if (result.isConfirmed) {
                $j.ajax({
                    url: kando_data.ajaxurl,
                    type: 'post',
                    data: {
                        action: 'samyar_delete_message',
                        id: message_id
                    },
                    success: function (response) {
                        if (!response.success) {
                            Swal.fire({
                                title: kando_data.langs.an_error,
                                icon: 'error',
                                html: response.data,
                                showCloseButton: true,
                                confirmButtonText: kando_data.langs.ok,
                            })
                        } else {
                            $j('.message-' + message_id).slideUp(1000, function () {
                                $j(this).remove();
                            });
                            Swal.fire({
                                // title: kando_data.langs.an_error,
                                icon: 'success',
                                html: response.data,
                                showCloseButton: true,
                                confirmButtonText: kando_data.langs.ok,
                            })
                        }
                    },
                    error: function () {
                        Swal.fire({
                            title: kando_data.langs.an_error,
                            icon: 'error',
                            html: response.data,
                            showCloseButton: true,
                            confirmButtonText: kando_data.langs.ok,
                        })
                    }
                });

            }
        })
        return false;
    })


    $j(document).on('click', '.approve-cart-to-cart', function () {
        let amount = $j(this).data('amount');
        amount = kando_number_format(amount);
        Swal.fire({
            title: kando_data.langs._are_you_sure,
            // text: "حساب کاربر به مبلغ " + amount + " " + kando_base_rate_text(kando_data.base_rate) + " شارژ خواهد شد",
            text: kando_data.langs.charge_user_message.replace('{amount}', kando_number_format(amount)).replace('{base_rate}', ""),
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: kando_data.langs.yes_charge,
            cancelButtonText: kando_data.langs.cancel
        }).then((result) => {
            let payment_id = $j(this).data('payment');
            let uid = $j(this).data('uid');
            if (result.isConfirmed) {
                $j.ajax({
                    url: kando_data.ajaxurl,
                    type: 'post',
                    data: {
                        action: 'samyar_approve_cart_to_cart',
                        payment_id: payment_id,
                        uid: uid
                    },
                    success: function (response) {
                        if (response.success) {
                            Swal.fire({
                                // title: kando_data.langs.an_error,
                                icon: 'success',
                                html: response.data,
                                showCloseButton: true,
                                confirmButtonText: kando_data.langs.ok,
                            })
                            window.location.reload();
                        } else {
                            Swal.fire({
                                title: kando_data.langs.an_error,
                                icon: 'error',
                                html: response.data,
                                showCloseButton: true,
                                confirmButtonText: kando_data.langs.ok,
                            })

                        }
                    },
                    error: function () {
                        Swal.fire({
                            title: kando_data.langs.an_error,
                            icon: 'error',
                            html: response.data,
                            showCloseButton: true,
                            confirmButtonText: kando_data.langs.ok,
                        })
                    }
                });

            }
        })
        return false;
    })
}


function SamyarAjaxNewApiProvider() {

    $j('.new-api-provider-form').submit(function () {
        var $this = $j(this);
        if (!$this.hasClass('is-loading')) {
            $this.addClass('is-loading');
            $this.find('.samyar-form-loading').fadeIn(200);
            $j.ajax({
                url: kando_data.ajaxurl,
                type: 'post',
                data: $this.serialize(),
                success: function (response) {
                    if (!response.success) {
                        Swal.fire({
                            title: kando_data.langs.an_error,
                            icon: 'error',
                            html: response.data,
                            showCloseButton: true,
                            confirmButtonText: kando_data.langs.ok,
                        })
                    } else {
                        setTimeout(function () {
                            Swal.fire({
                                // title: kando_data.langs.an_error,
                                icon: 'success',
                                html: response.data.message,
                                showCloseButton: true,
                                confirmButtonText: kando_data.langs.ok,
                            })
                            if (response.data.link !== undefined) {
                                window.location = response.data.link;
                            }

                        }, 200);

                    }


                    $this.removeClass('is-loading');
                    $this.find('.samyar-form-loading').fadeOut(200);


                },
                error: function () {
                    $this.removeClass('is-loading');
                    $this.find('.samyar-form-loading').fadeOut(200);
                }
            });

        }

        return false;
    });
}

function SamyarAjaxInquiryRateApiProvider() {

    $j(document).on('click', '#inquiry_rate', function () {
        var $this = $j(this);
        var api_key = $j(".new-api-provider-form input[name=api-key]").val();
        var api_url = $j(".new-api-provider-form input[name=url]").val();
        if (!$this.hasClass('is-loading')) {
            $this.addClass('is-loading');
            $this.find('.samyar-form-loading').fadeIn(200);
            $j.ajax({
                url: kando_data.ajaxurl,
                type: 'post',
                data: {url: api_url, 'api-key': api_key, action: 'samyar_inquiry_rate'},
                success: function (response) {
                    if (!response.success) {
                        Swal.fire({
                            title: kando_data.langs.an_error,
                            icon: 'error',
                            html: response.data,
                            showCloseButton: true,
                            confirmButtonText: kando_data.langs.ok,
                        })
                    } else {
                        setTimeout(function () {
                            Swal.fire({
                                // title: kando_data.langs.an_error,
                                icon: 'success',
                                html: response.data.message,
                                showCloseButton: true,
                                confirmButtonText: kando_data.langs.ok,
                            })
                            if (response.data.link !== undefined) {
                                window.location = response.data.link;
                            }

                        }, 200);

                    }


                    $this.removeClass('is-loading');
                    $this.find('.samyar-form-loading').fadeOut(200);


                },
                error: function () {
                    $this.removeClass('is-loading');
                    $this.find('.samyar-form-loading').fadeOut(200);
                }
            });

        }
        return false;
    });
}

function SamyarAjaxDeleteApiProvider() {
    $j(document).on('click', '.delete-provider', function () {

        Swal.fire({
            title: kando_data.langs.are_you_sure,
            text: "تمام سرویس های این ارائه دهنده نیز حذف خواهد شد",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: kando_data.langs.yes_delete,
            cancelButtonText: kando_data.langs.cancel
        }).then((result) => {
            let provider_id = $j(this).data('id');
            if (result.isConfirmed) {
                $j.ajax({
                    url: kando_data.ajaxurl,
                    type: 'post',
                    data: {id: provider_id, action: 'samyar_api_provider_delete'},
                    success: function (response) {
                        if (!response.success) {
                            Swal.fire({
                                title: kando_data.langs.an_error,
                                icon: 'error',
                                html: response.data,
                                showCloseButton: true,
                                confirmButtonText: kando_data.langs.ok,
                            })
                        } else {
                            $j('#provider-' + provider_id).slideUp(1000, function () {
                                $j(this).remove();
                            });
                            Swal.fire({
                                // title: kando_data.langs.an_error,
                                icon: 'success',
                                html: response.data,
                                showCloseButton: true,
                                confirmButtonText: kando_data.langs.ok,
                            })
                        }
                    },
                    error: function () {
                        Swal.fire({
                            title: kando_data.langs.an_error,
                            icon: 'error',
                            html: response.data,
                            showCloseButton: true,
                            confirmButtonText: kando_data.langs.ok,
                        })
                    }
                });

            }
        })

    })
}

function SamyarAjaxDisableApiProvider() {
    $j('.ajax-switch').change(function () {
        var $this = $j(this);
        var provider_id = $this.attr('data-id');
        var status = $this.is(':checked');

        $j.ajax({
            url: kando_data.ajaxurl,
            type: 'post',
            data: {
                action: 'samyar_disable_provider',
                provider_id: provider_id,
                status: status,
            },
            success: function (response) {
                /*
                if (!response.success) {
                    Swal.fire({
                        title: kando_data.langs.an_error,
                        icon: 'error',
                        html: response.data,
                        showCloseButton: true,
                        confirmButtonText: kando_data.langs.ok,
                    });
                    $this.removeClass('clicked');
                    $this.removeClass('is-loading');
                } else {
                    setTimeout(function () {
                        Swal.fire({
                            // title: kando_data.langs.an_error,
                            icon: 'success',
                            html: response.data,
                            showCloseButton: true,
                            confirmButtonText: kando_data.langs.ok,
                        })
                    }, 200);
                }
*/
            },
            error: function () {

            }
        });
        // if(this.checked) {
        //     var returnVal = confirm("Are you sure?");
        //     $(this).prop("checked", returnVal);
        // }
        // $('.ajax-switch').val(this.checked);
    });
}

function SamyarAjaxSyncCreditProvider() {
    $j(document).on('click', '.sync-credit-provider', function () {
        let provider_id = $j(this).data('id');
        let $this = $j('#provider-' + provider_id);
        $this.append('<div class="samyar-form-loading"></div>');
        $this.addClass('is-loading');
        $this.find('.samyar-form-loading').fadeIn(200);
        $j.ajax({
            url: kando_data.ajaxurl,
            type: 'POST',
            dataType: 'JSON',
            data: {id: provider_id, action: 'samyar_sync_credit_provider'},
            success: function (response) {
                if (!response.success) {
                    Swal.fire({
                        title: kando_data.langs.an_error,
                        icon: 'error',
                        html: response.data,
                        showCloseButton: true,
                        confirmButtonText: kando_data.langs.ok,
                    });
                    $this.removeClass('is-loading');
                    $this.find('.samyar-form-loading').fadeOut(200);
                    $this.find('.samyar-form-loading').remove();
                } else {

                    Swal.fire({
                        // title: kando_data.langs.an_error,
                        icon: 'success',
                        html: response.data.message,
                        showCloseButton: true,
                        confirmButtonText: kando_data.langs.ok,
                    });
                    $this.find('.credit').html(response.data.credit);
                    $this.removeClass('is-loading');
                    $this.find('.samyar-form-loading').fadeOut(200);
                    $this.find('.samyar-form-loading').remove();
                    // location.reload();
                }
            },
            error: function (xhr, status, error) {
                $this.removeClass('is-loading');
                $this.find('.samyar-form-loading').fadeOut(200);
                $this.find('.samyar-form-loading').remove();
            }
        });
        return false;
    })
}

function SamyarAjaxSyncBalanceProvider() {
    $j(document).on('click', '.sync-credit-provider', function () {
        let provider_id = $j(this).data('id');
        let $this = $j('#provider-' + provider_id);
        $this.append('<div class="samyar-form-loading"></div>');
        $this.addClass('is-loading');
        $this.find('.samyar-form-loading').fadeIn(200);

        $j.ajax({
            url: kando_data.ajaxurl,
            type: 'post',
            data: {id: provider_id, action: 'samyar_sync_credit_provider'},
            success: function (response) {
                if (!response.success) {
                    Swal.fire({
                        title: kando_data.langs.an_error,
                        icon: 'error',
                        html: response.data,
                        showCloseButton: true,
                        confirmButtonText: kando_data.langs.ok,
                    })
                } else {
                    setTimeout(function () {
                        Swal.fire({
                            // title: kando_data.langs.an_error,
                            icon: 'success',
                            html: response.data.message,
                            showCloseButton: true,
                            confirmButtonText: kando_data.langs.ok,
                        })
                        $j('#sync-result').html(response.data.table);

                    }, 200);

                }


                $this.removeClass('is-loading');
                $this.find('.samyar-form-loading').fadeOut(200);


            },
            error: function () {
                $this.removeClass('is-loading');
                $this.find('.samyar-form-loading').fadeOut(200);
            }
        });
    });
}

function SamyarAjaxSyncApiProvider() {

    $j('.sync-api-provider-form').submit(function () {
        var $this = $j(this);
        if (!$this.hasClass('is-loading')) {
            $this.addClass('is-loading');
            $this.find('.samyar-form-loading').fadeIn(200);
            $j.ajax({
                url: kando_data.ajaxurl,
                type: 'post',
                data: $this.serialize(),
                success: function (response) {
                    if (!response.success) {
                        Swal.fire({
                            title: kando_data.langs.an_error,
                            icon: 'error',
                            html: response.data,
                            showCloseButton: true,
                            confirmButtonText: kando_data.langs.ok,
                        })
                    } else {
                        setTimeout(function () {
                            Swal.fire({
                                // title: kando_data.langs.an_error,
                                icon: 'success',
                                html: response.data.message,
                                showCloseButton: true,
                                confirmButtonText: kando_data.langs.ok,
                            })
                            $j('#sync-result').html(response.data.table);

                        }, 200);

                    }


                    $this.removeClass('is-loading');
                    $this.find('.samyar-form-loading').fadeOut(200);


                },
                error: function () {
                    $this.removeClass('is-loading');
                    $this.find('.samyar-form-loading').fadeOut(200);
                }
            });

        }

        return false;
    });
}

function SamyarAjaxApiProviderServiceList() {

    $j('.provider-service-list-form').submit(function () {
        var $this = $j(this);
        if (!$this.hasClass('is-loading')) {
            $this.addClass('is-loading');
            $this.find('.samyar-form-loading').fadeIn(200);
            $j.ajax({
                url: kando_data.ajaxurl,
                type: 'post',
                data: $this.serialize(),
                success: function (response) {

                    if (isJson(response)) {//اگر نوعش جیسون هست یعنی خطایی رخ داده و خطا رو نشون بده
                        Swal.fire({
                            title: kando_data.langs.an_error,
                            icon: 'error',
                            html: response.data,
                            showCloseButton: true,
                            confirmButtonText: kando_data.langs.ok,
                        })
                    } else {// در غیر اینصورت جدول خدمات رو بر گردون

                        $j('#provider-services-result').slideUp(400, 'easeInOutCubic', function () {
                            $j(this).empty().html(response).slideDown(500, 'easeInOutCubic');
                        });
                    }


                    $this.removeClass('is-loading');
                    $this.find('.samyar-form-loading').fadeOut(200);


                },
                error: function () {
                    $this.removeClass('is-loading');
                    $this.find('.samyar-form-loading').fadeOut(200);
                }
            });

        }

        return false;
    });
}

function SamyarAjaxLoadServiceInfo() {
    $j(document).on('click', '.add_service_from_list', function () {

        $j(".kt-service-modal .representation-rates input[type=number]").val('');
        $j(".kt-service-modal input[name=price]").val('');
        $j(".kt-service-modal input[name=profit_rate]").val('');

        $j(".kt-service-modal input[name=name]").val($j(this).attr('data-name'));
        // $j(".kt-service-modal select[name=cate_id]").val($j(this).attr('data-category'));
        $j(".kt-service-modal input[name=min]").val($j(this).attr('data-min'));
        $j(".kt-service-modal input[name=max]").val($j(this).attr('data-max'));
        $j(".kt-service-modal input[name=original_price]").val($j(this).attr('data-rate'));
        $j(".kt-service-modal select[name=type]").val($j(this).attr('data-type'));
        $j(".kt-service-modal select[name=dripfeed]").val($j(this).attr('data-dripfeed'));
        $j(".kt-service-modal select[name=refill]").val($j(this).attr('data-refill'));
        $j(".kt-service-modal select[name=cancel]").val($j(this).attr('data-cancel'));
        $j(".kt-service-modal input[name=add_type]").val('api');
        $j(".kt-service-modal input[name=api_provider_id]").val($j(this).attr('data-provider'));
        $j(".kt-service-modal input[name=api_service_id]").val($j(this).attr('data-service'));
        $j(".kt-service-modal textarea[name=description]").val($j(this).attr('data-desc'));
        $j(".kt-service-modal #api_currency").text($j(this).attr('data-currency'));
    });
}

function SamyarAjaxLoadServiceDescription() {
    $j(document).on('click', '.samyar-show-description-service', function () {
        $j(".kt-show-description-modal .kt-modal-content").html('')
        let service_id = $j(this).attr('data-id');
        $j.ajax({
            url: kando_data.ajaxurl,
            type: 'post',
            data: {id: service_id, action: 'show_service_description'},
            success: function (response) {
                $j(".kt-show-description-modal .kt-modal-content").html(response);
            },
            error: function () {
            }
        });


    });
}

function SamyarAjaxLoadServiceDescriptionLocal() {
    $j(document).on('click', '.samyar-show-description-service-local', function () {
        let $desc = $j(this).attr('data-desc');
        $j(".kt-show-description-modal .kt-modal-content").html('')
        $j(".kt-show-description-modal .kt-modal-content").html($desc);
    });
}

function SamyarAjaxNewSocial() {

    $j('.new-social-form').submit(function () {
        var $this = $j(this);
        if (!$this.hasClass('is-loading')) {
            $this.addClass('is-loading');
            $this.find('.samyar-form-loading').fadeIn(200);

            $j.ajax({
                url: kando_data.ajaxurl,
                type: 'post',
                data: $this.serialize(),
                success: function (response) {
                    if (!response.success) {
                        Swal.fire({
                            title: kando_data.langs.an_error,
                            icon: 'error',
                            html: response.data,
                            showCloseButton: true,
                            confirmButtonText: kando_data.langs.ok,
                        })
                    } else {
                        setTimeout(function () {
                            Swal.fire({
                                // title: kando_data.langs.an_error,
                                icon: 'success',
                                html: response.data.message,
                                showCloseButton: true,
                                confirmButtonText: kando_data.langs.ok,
                            })
                            if (response.data.link !== undefined) {
                                window.location = response.data.link;
                            }

                        }, 200);

                    }


                    $this.removeClass('is-loading');
                    $this.find('.samyar-form-loading').fadeOut(200);


                },
                error: function () {
                    $this.removeClass('is-loading');
                    $this.find('.samyar-form-loading').fadeOut(200);
                }
            });

        }

        return false;
    });
}

function SamyarAjaxDeleteSocial() {
    $j(document).on('click', '.delete-social', function () {

        Swal.fire({
            title: kando_data.langs.are_you_sure,
            // text: "همه سرویس های این دسته نیز حذف خواهند شد",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: kando_data.langs.yes_delete,
            cancelButtonText: kando_data.langs.cancel
        }).then((result) => {
            let provider_id = $j(this).data('id');
            if (result.isConfirmed) {
                $j.ajax({
                    url: kando_data.ajaxurl,
                    type: 'post',
                    data: {id: provider_id, action: 'samyar_social_delete'},
                    success: function (response) {
                        if (!response.success) {
                            Swal.fire({
                                title: kando_data.langs.an_error,
                                icon: 'error',
                                html: response.data,
                                showCloseButton: true,
                                confirmButtonText: kando_data.langs.ok,
                            })
                        } else {
                            $j('#social-' + provider_id).slideUp(1000, function () {
                                $j(this).remove();
                            });
                            Swal.fire({
                                // title: kando_data.langs.an_error,
                                icon: 'success',
                                html: response.data,
                                showCloseButton: true,
                                confirmButtonText: kando_data.langs.ok,
                            })
                        }

                    },
                    error: function () {
                        Swal.fire({
                            title: kando_data.langs.an_error,
                            icon: 'error',
                            html: response.data,
                            showCloseButton: true,
                            confirmButtonText: kando_data.langs.ok,
                        })
                    }
                });

            }
        })

    })
}


function SamyarAjaxNewCategory() {

    $j('.new-category-form').submit(function () {
        var $this = $j(this);
        if (!$this.hasClass('is-loading')) {
            $this.addClass('is-loading');
            $this.find('.samyar-form-loading').fadeIn(200);
            tinyMCE.triggerSave();
            $j.ajax({
                url: kando_data.ajaxurl,
                type: 'post',
                data: $this.serialize(),
                success: function (response) {
                    if (!response.success) {
                        Swal.fire({
                            title: kando_data.langs.an_error,
                            icon: 'error',
                            html: response.data,
                            showCloseButton: true,
                            confirmButtonText: kando_data.langs.ok,
                        })
                    } else {
                        setTimeout(function () {
                            Swal.fire({
                                // title: kando_data.langs.an_error,
                                icon: 'success',
                                html: response.data.message,
                                showCloseButton: true,
                                confirmButtonText: kando_data.langs.ok,
                            })
                            if (response.data.link !== undefined) {
                                window.location = response.data.link;
                            }

                        }, 200);

                    }


                    $this.removeClass('is-loading');
                    $this.find('.samyar-form-loading').fadeOut(200);


                },
                error: function () {
                    $this.removeClass('is-loading');
                    $this.find('.samyar-form-loading').fadeOut(200);
                }
            });

        }

        return false;
    });
}

function SamyarAjaxDeleteCategory() {
    $j(document).on('click', '.delete-category', function () {

        Swal.fire({
            title: kando_data.langs.are_you_sure,
            text: "همه سرویس های این دسته نیز حذف خواهند شد",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: kando_data.langs.yes_delete,
            cancelButtonText: kando_data.langs.cancel
        }).then((result) => {
            let provider_id = $j(this).data('id');
            if (result.isConfirmed) {
                $j.ajax({
                    url: kando_data.ajaxurl,
                    type: 'post',
                    data: {id: provider_id, action: 'samyar_category_delete'},
                    success: function (response) {
                        if (!response.success) {
                            Swal.fire({
                                title: kando_data.langs.an_error,
                                icon: 'error',
                                html: response.data,
                                showCloseButton: true,
                                confirmButtonText: kando_data.langs.ok,
                            })
                        } else {
                            $j('#category-' + provider_id).slideUp(1000, function () {
                                $j(this).remove();
                            });
                            Swal.fire({
                                // title: kando_data.langs.an_error,
                                icon: 'success',
                                html: response.data,
                                showCloseButton: true,
                                confirmButtonText: kando_data.langs.ok,
                            })
                        }

                    },
                    error: function () {
                        Swal.fire({
                            title: kando_data.langs.an_error,
                            icon: 'error',
                            html: response.data,
                            showCloseButton: true,
                            confirmButtonText: kando_data.langs.ok,
                        })
                    }
                });

            }
        })

    })
}

function SamyarAjaxDisableCategory() {
    $j('.ajax-switch').change(function () {
        var $this = $j(this);
        var category_id = $this.attr('data-id');
        var status = $this.is(':checked');

        $j.ajax({
            url: kando_data.ajaxurl,
            type: 'post',
            data: {
                action: 'samyar_disable_category',
                category_id: category_id,
                status: status,
            },
            success: function (response) {
                /*
                if (!response.success) {
                    Swal.fire({
                        title: kando_data.langs.an_error,
                        icon: 'error',
                        html: response.data,
                        showCloseButton: true,
                        confirmButtonText: kando_data.langs.ok,
                    });
                    $this.removeClass('clicked');
                    $this.removeClass('is-loading');
                } else {
                    setTimeout(function () {
                        Swal.fire({
                            // title: kando_data.langs.an_error,
                            icon: 'success',
                            html: response.data,
                            showCloseButton: true,
                            confirmButtonText: kando_data.langs.ok,
                        })
                    }, 200);
                }
*/
            },
            error: function () {

            }
        });
        // if(this.checked) {
        //     var returnVal = confirm("Are you sure?");
        //     $(this).prop("checked", returnVal);
        // }
        // $('.ajax-switch').val(this.checked);
    });
}

function SamyarAjaxDeleteAllCategory() {
    $j(document).on('click', '#delete-category-all', function () {

        Swal.fire({
            title: 'آیا شما از حذف همه دسته ها مطمئن هستید؟',
            text: "همه دسته ها و سرویس های زیر مجموعه حذف خواهند شد",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: kando_data.langs.yes_delete,
            cancelButtonText: kando_data.langs.cancel
        }).then((result) => {
            // let provider_id = $j(this).data('id');
            if (result.isConfirmed) {
                $j.ajax({
                    url: kando_data.ajaxurl,
                    type: 'post',
                    data: {action: 'samyar_category_delete_all'},
                    success: function (response) {
                        if (!response.success) {
                            Swal.fire(
                                kando_data.langs.an_error,
                                response.data,
                                'error'
                            )
                        } else {
                            Swal.fire(
                                'حذف شد',
                                response.data,
                                'success'
                            )
                            window.location.reload();
                        }

                    },
                    error: function () {
                        Swal.fire({
                            title: kando_data.langs.an_error,
                            icon: 'error',
                            html: response.data,
                            showCloseButton: true,
                            confirmButtonText: kando_data.langs.ok,
                        })
                    }
                });

            }
        })

    })
}

function SamyarAjaxNewService() {

    $j('.new-service-form').submit(function () {
        var $this = $j(this);
        if (!$this.hasClass('is-loading')) {
            $this.addClass('is-loading');
            $this.find('.samyar-form-loading').fadeIn(200);
            tinyMCE.triggerSave();
            $j.ajax({
                url: kando_data.ajaxurl,
                type: 'post',
                data: $this.serialize(),
                success: function (response) {
                    if (!response.success) {
                        Swal.fire({
                            title: kando_data.langs.an_error,
                            icon: 'error',
                            html: response.data,
                            showCloseButton: true,
                            confirmButtonText: kando_data.langs.ok,
                        })
                    } else {
                        setTimeout(function () {
                            Swal.fire({
                                // title: kando_data.langs.an_error,
                                icon: 'success',
                                html: response.data.message,
                                showCloseButton: true,
                                confirmButtonText: kando_data.langs.ok,
                            })
                            if (response.data.link !== undefined) {
                                window.location = response.data.link;
                            }

                        }, 200);

                    }


                    $this.removeClass('is-loading');
                    $this.find('.samyar-form-loading').fadeOut(200);


                },
                error: function () {
                    $this.removeClass('is-loading');
                    $this.find('.samyar-form-loading').fadeOut(200);
                }
            });

        }

        return false;
    });
}

function SamyarAjaxNewServiceFromModal() {

    $j('.new-service-form-modal').submit(function () {
        var $this = $j(this);
        if (!$this.hasClass('is-loading')) {
            $this.addClass('is-loading');
            $this.find('.samyar-form-loading').fadeIn(200);
            // tinyMCE.triggerSave();
            $j.ajax({
                url: kando_data.ajaxurl,
                type: 'post',
                data: $this.serialize(),
                success: function (response) {
                    if (!response.success) {
                        Swal.fire({
                            title: kando_data.langs.an_error,
                            icon: 'error',
                            html: response.data,
                            showCloseButton: true,
                            confirmButtonText: kando_data.langs.ok,
                        })
                    } else {
                        setTimeout(function () {
                            Swal.fire({
                                // title: kando_data.langs.an_error,
                                icon: 'success',
                                html: response.data.message,
                                showCloseButton: true,
                                confirmButtonText: kando_data.langs.ok,
                            })
                            $j(".kt-modal-close").trigger("click");
                        }, 200);

                    }


                    $this.removeClass('is-loading');
                    $this.find('.samyar-form-loading').fadeOut(200);


                },
                error: function () {
                    $this.removeClass('is-loading');
                    $this.find('.samyar-form-loading').fadeOut(200);
                }
            });

        }

        return false;
    });
}

function SamyarChangeAddTypeApi() {
    $j('#service_add_type_select').on('change', function () {
        if (this.value === "api") {
            $j('#add_type_api').slideDown(400, 'easeOutCubic');//نمایش بده
            // $j('#add_type_api').slideDown(400, 'easeOutCubic');
            $j("#manual_currency").slideUp(400, 'easeOutCubic');// مخفی کن
            $j("#api_currency").slideDown(400, 'easeOutCubic');//نمایش بده

            // $j("input[name=price]").hide();
        } else {
            $j('#add_type_api').slideUp(400, 'easeOutCubic');//مخفی کن
            $j("#manual_currency").css('display', 'block');
            $j("#manual_currency").slideDown(400, 'easeOutCubic');//نمایش یده
            $j("#api_currency").slideUp(400, 'easeOutCubic');// مخفی کن


            // $j("input[name=price]").show();
        }
    });

}

function SamyarAjaxDeleteService() {
    $j(document).on('click', '.delete-service', function () {

        Swal.fire({
            title: kando_data.langs.are_you_sure,
            text: "این سرویس حذف خواهد شد",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: kando_data.langs.yes_delete,
            cancelButtonText: kando_data.langs.cancel
        }).then((result) => {
            let provider_id = $j(this).data('id');
            if (result.isConfirmed) {
                $j.ajax({
                    url: kando_data.ajaxurl,
                    type: 'post',
                    data: {id: provider_id, action: 'samyar_service_delete'},
                    success: function (response) {
                        if (!response.success) {
                            Swal.fire({
                                title: kando_data.langs.an_error,
                                icon: 'error',
                                html: response.data,
                                showCloseButton: true,
                                confirmButtonText: kando_data.langs.ok,
                            })
                        } else {
                            $j('#service-' + provider_id).slideUp(1000, function () {
                                $j(this).remove();
                            });
                            Swal.fire({
                                // title: kando_data.langs.an_error,
                                icon: 'success',
                                html: response.data,
                                showCloseButton: true,
                                confirmButtonText: kando_data.langs.ok,
                            })
                        }

                    },
                    error: function () {
                        Swal.fire({
                            title: kando_data.langs.an_error,
                            icon: 'error',
                            html: response.data,
                            showCloseButton: true,
                            confirmButtonText: kando_data.langs.ok,
                        })
                    }
                });

            }
        })

    })
}


function SamyarAjaxDeleteAllService() {
    $j(document).on('click', '#delete-service-all', function () {

        Swal.fire({
            title: 'آیا شما از حذف همه سرویس ها مطمئن هستید؟',
            text: "همه سرویس ها حذف خواهند شد",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: kando_data.langs.yes_delete,
            cancelButtonText: kando_data.langs.cancel
        }).then((result) => {
            // let provider_id = $j(this).data('id');
            if (result.isConfirmed) {
                $j.ajax({
                    url: kando_data.ajaxurl,
                    type: 'post',
                    data: {action: 'samyar_service_delete_all'},
                    success: function (response) {
                        if (!response.success) {
                            Swal.fire(
                                kando_data.langs.an_error,
                                response.data,
                                'error'
                            )
                        } else {
                            Swal.fire(
                                'حذف شد',
                                response.data,
                                'success'
                            )
                            window.location.reload();
                        }

                    },
                    error: function () {
                        Swal.fire({
                            title: kando_data.langs.an_error,
                            icon: 'error',
                            html: response.data,
                            showCloseButton: true,
                            confirmButtonText: kando_data.langs.ok,
                        })
                    }
                });

            }
        })

    })
}

function SamyarAjaxGetServiceList() {

    $j('.get-service-list-category-form').submit(function () {
        var $this = $j(this);
        if (!$this.hasClass('is-loading')) {
            $this.addClass('is-loading');
            $this.find('.samyar-form-loading').fadeIn(200);
            $j.ajax({
                url: kando_data.ajaxurl,
                type: 'post',
                data: $this.serialize(),
                success: function (response) {

                    $j('#services-result').slideUp(400, 'easeInOutCubic', function () {
                        $j(this).empty().html(response).slideDown(500, 'easeInOutCubic');
                    });

                    $this.removeClass('is-loading');
                    $this.find('.samyar-form-loading').fadeOut(200);


                },
                error: function () {
                    $this.removeClass('is-loading');
                    $this.find('.samyar-form-loading').fadeOut(200);
                }
            });

        }

        return false;
    });
}

//افزودن سفارش
function samyarShowOrderServices() {
    $j('#samyar_select_category').on('change', function () {
        //reset basket
        const baskett = ({url, img, title}) => `<table class="shop_table woocommerce-checkout-review-order-table">
<thead>
<tr>
<th class="product-name">${kando_data.langs.service}</th>
            <th class="product-total">${kando_data.langs.charge}</th>
            </tr>
            </thead>
            <tbody>
            <tr class="cart_item">
            <td class="product-name">
            <span class="product-title">
                ${kando_data.langs.service_name}&nbsp;<strong class="product-quantity">× ${kando_data.langs.quantity} </strong></span>
            </td>
            <td class="product-total">
             0 
           </td>
            </tr>
           </tbody>
           <tfoot>
           
            <tr class="cart-subtotal" style="display: none">
            <th> ${kando_data.langs.total_price}</th>
           <td><span class="woocommerce-Price-amount amount">0&nbsp;<span class="woocommerce-Price-currencySymbol"></span></span></td>
             </tr>
           <tr class="cart-discount" style="display: none">
            <th>${kando_data.langs.cart_discount}</th>
            <td class="align-left" data-title="${kando_data.langs.cart_discount}">0</td>
            </tr>
            <tr class="order-total">
           <th>${kando_data.langs.payable_amount}</th>
            <td><strong><span class="woocommerce-Price-amount amount">0&nbsp;<span class="woocommerce-Price-currencySymbol"></span></span></strong></td>
           </tr>
            </tfoot>
            </table>`;
        $j('.new-order-form .shop_table').html([
            {url: '/foo', img: 'foo.png', title: 'Foo item'},
        ].map(baskett).join(''));


        // $j('.shop_table').html('');
        $j('.shop_table').slideDown(400, 'easeOutCubic');


        let Category_id = this.value;
        let form = $j('.new-api-form-outer');
        if (Category_id !== "0") {
            form.addClass('is-loading');
            form.find('.samyar-form-loading').fadeIn(200);
            $j.ajax({
                url: kando_data.ajaxurl,
                type: 'post',
                data: {id: Category_id, action: 'samyar_get_services'},
                success: function (response) {

                    let service_html = '';
                    service_html += `<option value='0'>${kando_data.langs.select_service}</option>`;
                    const services_data = response.data.services;

                    let dataArray = Object.values(services_data);

                    if(kando_data.select_service_order==="price"){
                        dataArray.sort(function(a, b) {
                            return a.price - b.price;
                        });
                    }else{
                        dataArray.sort(function(a, b) {
                            return a.order - b.order;
                        });
                    }

                    for (let i = 0; i < dataArray.length; i++) {
                        let item = dataArray[i];
                        service_html += `<option value="${item.service_id}" data-average="${item.average}" data-min="${item.min}" data-max="${item.max}"
                                                                data-type="${item.type}"
                                                                data-dripfeed="${item.dripfeed}" data-price="${item.price}" data-name="${item.name}"
                                                                data-description="" data-is-free="${item.is_free}" data-free-number="${item.free_number}">${item.text}
                                                        </option>`;
                    }

                    $j('#select-order-service select').html(service_html);

                    $j('.new-order-form .new-ticket-help ul,.service-description .s-d-text').html(response.data.category_desc);


                    $j('#select-order-service').slideDown(400, 'easeOutCubic');
                    form.removeClass('is-loading');
                    form.find('.samyar-form-loading').fadeOut(200);
                },
                error: function () {
                    form.removeClass('is-loading');
                    form.find('.samyar-form-loading').fadeOut(200);
                }
            });



        }
    });
}

function samyarShowServiceInfo() {
    // $j('#select-order-service select').on('change', function () {
    $j(document).on("change", "#select-order-service select", function () {
        let service_id = this.value;
        let _dripfeed = $j(this).children("option:selected").attr("data-dripfeed");
        let _service_type = $j(this).children("option:selected").attr("data-type");
        let average_time = $j(this).children("option:selected").attr("data-average");
        let table = $j('.samyar_order_table');

        //start
        $j(".new-order-form .order-default-quantity input[name=quantity]").attr("disabled", false);
        $j(".new-order-form .order-usernames-custom").addClass("d-none");
        $j(".new-order-form .order-comments-custom-package").addClass("d-none");

        /*----------  reset quantity  ----------*/
        $j(".new-order-form input[name=service_price]").val();
        $j(".new-order-form input[name=service_min]").val();
        $j(".new-order-form input[name=service_max]").val();
        $j(".new-order-form #order-average-time").val();

        //reset basket
        const baskettt = ({url, img, title}) => `<table class="shop_table woocommerce-checkout-review-order-table">
<thead>
<tr>
<th class="product-name">${kando_data.langs.service}</th>
            <th class="product-total">${kando_data.langs.charge}</th>
            </tr>
            </thead>
            <tbody>
            <tr class="cart_item">
            <td class="product-name">
            <span class="product-title">
               ${kando_data.langs.service_name}&nbsp;<strong class="product-quantity">× ${kando_data.langs.quantity} </strong></span>
            </td>
            <td class="product-total"> 0 </td>
            </tr>
           </tbody>
           <tfoot>
           
            <tr class="cart-subtotal" style="display: none">
            <th> ${kando_data.langs.total_price}</th>
           <td><span class="woocommerce-Price-amount amount">0&nbsp;<span class="woocommerce-Price-currencySymbol"></span></span></td>
             </tr>
           <tr class="cart-discount" style="display: none">
            <th>${kando_data.langs.cart_discount}</th>
            <td class="align-left" data-title="${kando_data.langs.cart_discount}">0</td>
            </tr>
            <tr class="order-total">
           <th>${kando_data.langs.payable_amount}</th>
            <td><strong><span class="woocommerce-Price-amount amount">0&nbsp;<span class="woocommerce-Price-currencySymbol"></span></span></strong></td>
           </tr>
            </tfoot>
            </table>`;
        $j('.new-order-form .shop_table').html([
            {url: '/foo', img: 'foo.png', title: 'Foo item'},
        ].map(baskettt).join(''));

        $j('.shop_table').slideDown(400, 'easeOutCubic');


        $j(".new-order-form .order-default-quantity input[name=quantity]").val('');
        // let _total_charge = 0;
        // let _currency_symbol = $j(".new-order-form input[name=currency_symbol]").val();
        // $j(".new-order-form input[name=total_charge]").val(_total_charge);
        // $j(".new-order-form .total_charge span").html(_total_charge +' '+ _currency_symbol);//morteza
        switch (_service_type) {
            case "subscriptions":
                $j(".new-order-form input[name=sub_expiry]").val('');

                $j(".new-order-form .order-default-link").addClass("d-none");
                $j(".new-order-form .order-default-quantity").addClass("d-none");
                $j(".new-order-form #result_total_charge").addClass("d-none");

                $j(".new-order-form .order-comments").addClass("d-none");
                $j(".new-order-form .order-usernames").addClass("d-none");
                $j(".new-order-form .order-hashtags").addClass("d-none");
                $j(".new-order-form .order-username").addClass("d-none");
                $j(".new-order-form .order-hashtag").addClass("d-none");
                $j(".new-order-form .order-media").addClass("d-none");
                $j(".new-order-form .order-groups").addClass("d-none");
                $j(".new-order-form .order-poll").addClass("d-none");
                $j(".new-order-form .order-subscriptions").removeClass("d-none");

                $j('.kando_show_factor').show();

                // console.log(_service_type);
                // if(type !== "" && type=="subscriptions"){
                $j('ul.payment_methods').slideUp(400, 'easeOutCubic');
                // }
                break;

            case "custom_comments":
                $j(".new-order-form .order-default-link").removeClass("d-none");
                $j(".new-order-form .order-comments").removeClass("d-none");
                $j(".new-order-form #result_total_charge").removeClass("d-none");

                $j(".new-order-form .order-usernames").addClass("d-none");
                $j(".new-order-form .order-hashtags").addClass("d-none");
                $j(".new-order-form .order-username").addClass("d-none");
                $j(".new-order-form .order-hashtag").addClass("d-none");
                $j(".new-order-form .order-media").addClass("d-none");
                $j(".new-order-form .order-groups").addClass("d-none");
                $j(".new-order-form .order-poll").addClass("d-none");
                $j(".new-order-form .order-default-quantity").removeClass("d-none");
                $j(".new-order-form .order-default-quantity input[name=quantity]").attr("disabled", true);

                $j(".new-order-form .order-subscriptions").addClass("d-none");
                break;

            case "custom_comments_package":
                $j(".new-order-form .order-default-link").removeClass("d-none");
                $j(".new-order-form .order-comments-custom-package").removeClass("d-none");
                $j(".new-order-form #result_total_charge").removeClass("d-none");

                $j(".new-order-form .order-comments").addClass("d-none");
                $j(".new-order-form .order-default-quantity").addClass("d-none");
                $j(".new-order-form .order-usernames").addClass("d-none");
                $j(".new-order-form .order-hashtags").addClass("d-none");
                $j(".new-order-form .order-username").addClass("d-none");
                $j(".new-order-form .order-hashtag").addClass("d-none");
                $j(".new-order-form .order-media").addClass("d-none");
                $j(".new-order-form .order-groups").addClass("d-none");
                $j(".new-order-form .order-poll").addClass("d-none");
                $j(".new-order-form .order-subscriptions").addClass("d-none");

                $j('.kando_show_factor').show();
                break;

            //add for hivepanel
            case "mentions":
                $j(".new-order-form .order-default-link").removeClass("d-none");
                $j(".new-order-form .order-default-quantity").removeClass("d-none");
                $j(".new-order-form .order-usernames-custom").removeClass("d-none");
                $j(".new-order-form #result_total_charge").removeClass("d-none");

                $j(".new-order-form .order-comments").addClass("d-none");
                $j(".new-order-form .order-username").addClass("d-none");
                $j(".new-order-form .order-usernames").addClass("d-none");
                $j(".new-order-form .order-hashtags").addClass("d-none");
                $j(".new-order-form .order-hashtag").addClass("d-none");
                $j(".new-order-form .order-media").addClass("d-none");
                $j(".new-order-form .order-groups").addClass("d-none");
                $j(".new-order-form .order-poll").addClass("d-none");
                $j(".new-order-form .order-subscriptions").addClass("d-none");
                break;

            case "mentions_with_hashtags":
                $j(".new-order-form .order-default-link").removeClass("d-none");
                $j(".new-order-form .order-default-quantity").removeClass("d-none");
                $j(".new-order-form .order-usernames").removeClass("d-none");
                $j(".new-order-form .order-hashtags").removeClass("d-none");
                $j(".new-order-form #result_total_charge").removeClass("d-none");

                $j(".new-order-form .order-comments").addClass("d-none");
                $j(".new-order-form .order-username").addClass("d-none");
                $j(".new-order-form .order-hashtag").addClass("d-none");
                $j(".new-order-form .order-media").addClass("d-none");
                $j(".new-order-form .order-groups").addClass("d-none");
                $j(".new-order-form .order-poll").addClass("d-none");
                $j(".new-order-form .order-subscriptions").addClass("d-none");

                break;

            case "mentions_custom_list":
                $j(".new-order-form .order-default-link").removeClass("d-none");
                $j(".new-order-form .order-usernames-custom").removeClass("d-none");
                $j(".new-order-form #result_total_charge").removeClass("d-none");
                $j(".new-order-form .order-default-quantity").removeClass("d-none");
                $j(".new-order-form .order-default-quantity input[name=quantity]").attr("disabled", true);

                $j(".new-order-form .order-usernames").addClass("d-none");
                $j(".new-order-form .order-comments").addClass("d-none");
                $j(".new-order-form .order-username").addClass("d-none");
                $j(".new-order-form .order-hashtags").addClass("d-none");
                $j(".new-order-form .order-hashtag").addClass("d-none");
                $j(".new-order-form .order-media").addClass("d-none");
                $j(".new-order-form .order-groups").addClass("d-none");
                $j(".new-order-form .order-poll").addClass("d-none");
                $j(".new-order-form .order-subscriptions").addClass("d-none");

                break;

            case "mentions_hashtag":
                $j(".new-order-form .order-default-link").removeClass("d-none");
                $j(".new-order-form .order-default-quantity").removeClass("d-none");
                $j(".new-order-form .order-hashtag").removeClass("d-none");
                $j(".new-order-form #result_total_charge").removeClass("d-none");

                $j(".new-order-form .order-comments").addClass("d-none");
                $j(".new-order-form .order-usernames").addClass("d-none");
                $j(".new-order-form .order-hashtags").addClass("d-none");
                $j(".new-order-form .order-username").addClass("d-none");
                $j(".new-order-form .order-media").addClass("d-none");
                $j(".new-order-form .order-groups").addClass("d-none");
                $j(".new-order-form .order-poll").addClass("d-none");
                $j(".new-order-form .order-subscriptions").addClass("d-none");

                break;

            case "mentions_user_followers":
                $j(".new-order-form .order-default-link").removeClass("d-none");
                $j(".new-order-form .order-default-quantity").removeClass("d-none");
                $j(".new-order-form .order-username").removeClass("d-none");
                $j(".new-order-form #result_total_charge").removeClass("d-none");

                $j(".new-order-form .order-comments").addClass("d-none");
                $j(".new-order-form .order-usernames").addClass("d-none");
                $j(".new-order-form .order-hashtags").addClass("d-none");
                $j(".new-order-form .order-hashtag").addClass("d-none");
                $j(".new-order-form .order-media").addClass("d-none");
                $j(".new-order-form .order-groups").addClass("d-none");
                $j(".new-order-form .order-poll").addClass("d-none");
                $j(".new-order-form .order-subscriptions").addClass("d-none");
                break;

            case "mentions_media_likers":
                $j(".new-order-form .order-default-link").removeClass("d-none");
                $j(".new-order-form .order-default-quantity").removeClass("d-none");
                $j(".new-order-form .order-media").removeClass("d-none");
                $j(".new-order-form #result_total_charge").removeClass("d-none");

                $j(".new-order-form .order-comments").addClass("d-none");
                $j(".new-order-form .order-usernames").addClass("d-none");
                $j(".new-order-form .order-hashtags").addClass("d-none");
                $j(".new-order-form .order-username").addClass("d-none");
                $j(".new-order-form .order-hashtag").addClass("d-none");
                $j(".new-order-form .order-groups").addClass("d-none");
                $j(".new-order-form .order-poll").addClass("d-none");
                $j(".new-order-form .order-subscriptions").addClass("d-none");

                break;

            case "package":
                $j(".new-order-form .order-default-link").removeClass("d-none");
                $j(".new-order-form #result_total_charge").removeClass("d-none");


                $j(".new-order-form .order-default-quantity").addClass("d-none");
                $j(".new-order-form .order-comments").addClass("d-none");
                $j(".new-order-form .order-usernames").addClass("d-none");
                $j(".new-order-form .order-hashtags").addClass("d-none");
                $j(".new-order-form .order-username").addClass("d-none");
                $j(".new-order-form .order-hashtag").addClass("d-none");
                $j(".new-order-form .order-media").addClass("d-none");
                $j(".new-order-form .order-groups").addClass("d-none");
                $j(".new-order-form .order-poll").addClass("d-none");
                $j(".new-order-form .order-subscriptions").addClass("d-none");

                $j('.kando_show_factor').show();


                sendOrderFormData(service_id, 1000, table);
                break;

            case "gift_card":
                $j(".new-order-form .order-default-quantity").removeClass("d-none");
                $j(".new-order-form #result_total_charge").removeClass("d-none");

                $j(".new-order-form .order-default-link").addClass("d-none");
                $j(".new-order-form .order-comments").addClass("d-none");
                $j(".new-order-form .order-usernames").addClass("d-none");
                $j(".new-order-form .order-hashtags").addClass("d-none");
                $j(".new-order-form .order-username").addClass("d-none");
                $j(".new-order-form .order-hashtag").addClass("d-none");
                $j(".new-order-form .order-media").addClass("d-none");
                $j(".new-order-form .order-groups").addClass("d-none");
                $j(".new-order-form .order-poll").addClass("d-none");
                $j(".new-order-form .order-subscriptions").addClass("d-none");

                // $j('.kando_show_factor').show();

                // let table = $j('.samyar_order_table');
                // sendOrderFormData(service_id, 1000, table);
                break;

            case "comment_likes":
                $j(".new-order-form .order-default-link").removeClass("d-none");
                $j(".new-order-form .order-default-quantity").removeClass("d-none");
                $j(".new-order-form .order-username").removeClass("d-none");
                $j(".new-order-form #result_total_charge").removeClass("d-none");

                $j(".new-order-form .order-comments").addClass("d-none");
                $j(".new-order-form .order-usernames").addClass("d-none");
                $j(".new-order-form .order-hashtags").addClass("d-none");
                $j(".new-order-form .order-hashtag").addClass("d-none");
                $j(".new-order-form .order-media").addClass("d-none");
                $j(".new-order-form .order-groups").addClass("d-none");
                $j(".new-order-form .order-poll").addClass("d-none");
                $j(".new-order-form .order-subscriptions").addClass("d-none");

                break;

            case "poll":
                $j(".new-order-form .order-default-link").removeClass("d-none");
                $j(".new-order-form .order-default-quantity").removeClass("d-none");
                $j(".new-order-form #result_total_charge").removeClass("d-none");
                $j(".new-order-form .order-poll").removeClass("d-none");


                $j(".new-order-form .order-comments").addClass("d-none");
                $j(".new-order-form .order-usernames").addClass("d-none");
                $j(".new-order-form .order-hashtags").addClass("d-none");
                $j(".new-order-form .order-username").addClass("d-none");
                $j(".new-order-form .order-hashtag").addClass("d-none");
                $j(".new-order-form .order-media").addClass("d-none");
                $j(".new-order-form .order-groups").addClass("d-none");
                $j(".new-order-form .order-subscriptions").addClass("d-none");

                break;

            case "invites_from_groups":
                $j(".new-order-form .order-default-link").removeClass("d-none");
                $j(".new-order-form .order-default-quantity").removeClass("d-none");
                $j(".new-order-form #result_total_charge").removeClass("d-none");
                $j(".new-order-form .order-groups").removeClass("d-none");


                $j(".new-order-form .order-poll").addClass("d-none");
                $j(".new-order-form .order-comments").addClass("d-none");
                $j(".new-order-form .order-usernames").addClass("d-none");
                $j(".new-order-form .order-hashtags").addClass("d-none");
                $j(".new-order-form .order-username").addClass("d-none");
                $j(".new-order-form .order-hashtag").addClass("d-none");
                $j(".new-order-form .order-media").addClass("d-none");
                $j(".new-order-form .order-poll").addClass("d-none");
                $j(".new-order-form .order-subscriptions").addClass("d-none");

                break;

            case "comment_replies":
                $j(".new-order-form .order-default-link").removeClass("d-none");
                $j(".new-order-form .order-default-quantity").removeClass("d-none");
                $j(".new-order-form #result_total_charge").removeClass("d-none");
                $j(".new-order-form .order-username").removeClass("d-none");
                $j(".new-order-form .order-comments").removeClass("d-none");

                $j(".new-order-form .order-groups").addClass("d-none");
                $j(".new-order-form .order-poll").addClass("d-none");
                $j(".new-order-form .order-comments").addClass("d-none");
                $j(".new-order-form .order-usernames").addClass("d-none");
                $j(".new-order-form .order-hashtags").addClass("d-none");
                $j(".new-order-form .order-username").addClass("d-none");
                $j(".new-order-form .order-hashtag").addClass("d-none");
                $j(".new-order-form .order-media").addClass("d-none");
                $j(".new-order-form .order-groups").addClass("d-none");
                $j(".new-order-form .order-poll").addClass("d-none");
                $j(".new-order-form .order-subscriptions").addClass("d-none");

                break;


            default:
                $j(".new-order-form .order-default-link").removeClass("d-none");
                $j(".new-order-form .order-default-quantity").removeClass("d-none");
                $j(".new-order-form #result_total_charge").removeClass("d-none");


                $j(".new-order-form .order-comments").addClass("d-none");
                $j(".new-order-form .order-usernames").addClass("d-none");
                $j(".new-order-form .order-hashtags").addClass("d-none");
                $j(".new-order-form .order-username").addClass("d-none");
                $j(".new-order-form .order-hashtag").addClass("d-none");
                $j(".new-order-form .order-media").addClass("d-none");
                $j(".new-order-form .order-groups").addClass("d-none");
                $j(".new-order-form .order-poll").addClass("d-none");

                $j(".new-order-form .order-subscriptions").addClass("d-none");

                break;
        }

        if (_dripfeed === '1') {
            $j(".new-order-form .drip-feed-option").removeClass("d-none");
        } else {
            $j(".new-order-form .drip-feed-option").addClass("d-none");
        }
        //end


        let form = $j('.new-api-form-outer');

        if (service_id !== "0") {
            let min = $j(this).children("option:selected").attr("data-min");
            let max = $j(this).children("option:selected").attr("data-max");
            var price = $j(this).children("option:selected").attr("data-price");
            var is_free = $j(this).children("option:selected").attr("data-is-free");
            var free_number = $j(this).children("option:selected").attr("data-free-number");
            // let price_format = Intl.NumberFormat('fa-IR', {}).format(price);
            let average_time = $j(this).children("option:selected").attr("data-average");
            let average_time_display = "";
            let price_format = kando_number_format(price);
            if(kando_data.enable_average_time === "0" || average_time == ""){
                average_time = "";
                average_time_display = "d-none";
            }

            if (average_time != "" && kando_data.enable_average_time) {
                $j('.order-average-time').removeClass("d-none");
                $j('#order-average-time').val(average_time);
            } else {
                $j('.order-average-time').addClass("d-none");
            }


            let price_per_1 = price / 1000;
            // price_per_1 = Intl.NumberFormat('fa-IR', {}).format(price_per_1);
            price_per_1 = kando_number_format(price_per_1);

            let description = get_service_description(service_id);

            const service_info = ({url, img, title}) => `<li>${kando_data.langs.minimum_quantity}: <strong>${min}</strong></li>
<li>${kando_data.langs.maximum_quantity}: <strong>${max}</strong></li>
<li>${kando_data.langs.price_per_1000}: <strong>${price_format}</strong></li>
<li class="${average_time_display}">${kando_data.langs.estimated_order}: <strong>${average_time} </strong></li>
 <li> <strong>${kando_data.langs.description}: </strong>${description}</li>
`;

            const service_info2 = ({
                                       url,
                                       img,
                                       title
                                   }) => `<li>${kando_data.langs.charge}: <strong>${price_per_1} </strong></li><li class="${average_time_display}">${kando_data.langs.estimated_order}: <strong>${average_time} </strong></li><li> <strong>${kando_data.langs.description}: </strong>${description}</li>`;

            const service_info4 = ({
                                       url,
                                       img,
                                       title
                                   }) => `<li>${kando_data.langs.minimum_quantity}: <strong>${min}</strong></li>
<li>${kando_data.langs.maximum_quantity}: <strong>${max}</strong></li><li>${kando_data.langs.charge}: <strong>${price_per_1} </strong></li><li> <strong>${kando_data.langs.description}: </strong>${description}</li>`;


            if (_service_type === "gift_card") {
                price_per_1 = price;
                price_per_1 = kando_number_format(price_per_1);
                $j('.new-order-form .new-ticket-help ul,.service-description .s-d-text').html([
                    {url: '/foo', img: 'foo.png', title: 'Foo item'},
                ].map(service_info4).join(''));

            }else if (_service_type === "package") {
                price_per_1 = price;
                price_per_1 = kando_number_format(price_per_1);
                $j('.new-order-form .new-ticket-help ul,.service-description .s-d-text').html([
                    {url: '/foo', img: 'foo.png', title: 'Foo item'},
                ].map(service_info2).join(''));
            } else {
                if (is_free === "1") {
                    const service_info3 = ({url, img, title}) => `<li>${kando_data.langs.minimum_quantity}: <strong>${min}</strong></li>
<li>${kando_data.langs.maximum_quantity}: <strong>${max}</strong></li>
<li class="${average_time_display}">${kando_data.langs.estimated_order}: <strong>${average_time} </strong></li>
<li>${kando_data.langs.estimated_order}: <strong>${kando_data.langs.free} </strong></li>
<li>${kando_data.langs.order_limit_per_day_label}: <strong>${free_number} بار</strong></li>
 <li> <strong>${kando_data.langs.description}: </strong>${description}</li>
`;
                    $j('.new-order-form .new-ticket-help ul,.service-description .s-d-text').html([
                        {url: '/foo', img: 'foo.png', title: 'Foo item'},
                    ].map(service_info3).join(''));
                } else {
                    $j('.new-order-form .new-ticket-help ul,.service-description .s-d-text').html([
                        {url: '/foo', img: 'foo.png', title: 'Foo item'},
                    ].map(service_info).join(''));
                }

            }


            $j('#insert-order-data').slideDown(400, 'easeOutCubic');
            /*
            $j.ajax({
                url: kando_data.ajaxurl,
                type: 'post',
                data: {id: service_id, action: 'samyar_get_service_info'},
                success: function (response) {
                    if (response) {
                        $j('.new-ticket-help ul').html(response);
                        $j('.new-ticket-help ul').slideDown(400, 'easeOutCubic');
                    }
                    $j('#insert-order-data').slideDown(400, 'easeOutCubic');
                    form.removeClass('is-loading');
                    form.find('.samyar-form-loading').fadeOut(200);
                },
                error: function () {
                    form.removeClass('is-loading');
                    form.find('.samyar-form-loading').fadeOut(200);
                }
            });
            */
        } else {
            $j('.new-ticket-help ul').html('<li>${kando_data.langs.service_description_placeholder}</li>');
        }
        ;

    });
}



function get_service_description(service_id) {
    var jqXHR = $j.ajax({
        url: kando_data.ajaxurl,
        type: 'post',
        async: false,
        data: {service_id: service_id, action: 'samyar_get_service_description'},
        success: function (response) {
            // description = response;
        },
        error: function () {

        }
    });

    return jqXHR.responseText;
    // return description;
}

function samyarProccessOrderPrice() {
    $j(document).on("input", ".ajaxQuantity", function () {
        let that = $j(this);
        let quantity = that.val();
        let total_quantity = "";
        let service_id = $j("#select-order-service select option:selected").val();
        let table = $j('.samyar_order_table');
        let min = $j("#select-order-service select option:selected").data('min');
        let max = $j("#select-order-service select option:selected").data('max');
        let type = $j("#select-order-service select option:selected").data('type');
        if (quantity < min || max < quantity) {
            that.css("border-color", "#f35f5f");
        } else {
            that.css("border-color", "#7ccc77");
        }


        let is_drip_feed = $j(".new-order-form input[name=is_drip_feed]:checked").val();
        if (is_drip_feed) {
            let runs = $j(".new-order-form input[name=runs]").val();
            let interval = $j(".new-order-form input[name=interval]").val();
            total_quantity = runs * quantity;
            if (total_quantity != "") {
                $j(".new-order-form input[name=total_quantity]").val(total_quantity);
            }
        } else {
            total_quantity = quantity;
        }


        if (total_quantity > 0) {
            $j('.kando_show_factor').show();
        } else {
            $j('.kando_show_factor').hide();
        }


        sendOrderFormData(service_id, total_quantity, table,type);
    });

    // callback ajax_custom_comments
    $j(document).on("keyup", ".ajax_custom_comments", function () {
        let table = $j('.samyar_order_table');
        let quantity = $j(".new-order-form .order-comments textarea[name=comments]").val();
        if (quantity == "") {
            quantity = 0;
        } else {
            quantity = quantity.split("\n").length;
        }
        let service_id = $j("#select-order-service select option:selected").val();
        $j(".new-order-form .order-default-quantity input[name=quantity]").val(quantity);


        if (quantity > 0) {
            $j('.kando_show_factor').show();
        } else {
            $j('.kando_show_factor').hide();
        }


        sendOrderFormData(service_id, quantity, table);
    })

    // callback ajax_custom_lists
    $j(document).on("keyup", ".ajax_custom_lists", function () {
        let quantity = 0;
        let table = $j('.samyar_order_table');
        let _quantity = $j(".new-order-form .order-usernames-custom textarea[name=usernames_custom]").val();

        if (_quantity === "") {
            quantity = 0;
        } else {
            quantity = _quantity.split("\n").length;
        }

        let service_id = $j("#select-order-service select option:selected").val();

        $j(".new-order-form .order-default-quantity input[name=quantity]").val(quantity);

        if (quantity > 0) {
            $j('.kando_show_factor').show();
        } else {
            $j('.kando_show_factor').hide();
        }

        sendOrderFormData(service_id, quantity, table);
    })

    // callback ajaxDripFeedRuns
    $j(document).on("input", ".ajaxDripFeedRuns", function () {
        let table = $j('.samyar_order_table');
        let that = $j(this);
        let runs = that.val();
        let service_id = $j("#select-order-service select option:selected").val();
        let quantity = $j(".new-order-form input[name=quantity]").val();
        let total_quantity = "";
        // let service_max    = $j("#order_resume input[name=service_max]").val();
        // let service_min    = $j("#order_resume input[name=service_min]").val();
        // let service_price  = $j("#order_resume input[name=service_price]").val();
        let is_drip_feed = $j(".new-order-form input[name=is_drip_feed]:checked").val();
        if (is_drip_feed) {
            let interval = $j(".new-order-form input[name=interval]").val();
            total_quantity = runs * quantity;
            if (total_quantity != "") {
                $j(".new-order-form input[name=total_quantity]").val(total_quantity);
            }
        } else {
            total_quantity = quantity;
        }

        if (total_quantity > 0) {
            $j('.kando_show_factor').show();
        } else {
            $j('.kando_show_factor').hide();
        }

        sendOrderFormData(service_id, total_quantity, table);
        // let total_charge = (total_quantity != "" && service_price != "") ? (total_quantity * service_price)/1000 : 0;
        // let currency_symbol = $j("#new_order input[name=currency_symbol]").val();
        // $j(".new-order-form input[name=total_charge]").val(total_charge);
        // $j(".new-order-form .total_charge span").html(total_charge +' '+ currency_symbol);//morteza
    })
}

function numberFormat(value, decimals = 0, decimal_sep = '.', thousand_sep = ',') {
    // تبدیل ورودی به عدد
    const number = parseFloat(value);

    // اطمینان از اینکه مقدار ورودی عدد معتبر است
    if (isNaN(number)) {
        return 'Invalid number';
    }

    let parts = number.toFixed(decimals).split('.'); // جدا کردن بخش اعشاری از بخش صحیح
    parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, thousand_sep); // اضافه کردن جداکننده هزارگان
    return parts.join(decimal_sep); // پیوستن بخش‌ها با جداکننده اعشار
}

function kando_number_format(price) {
    var decimal_sep = kando_data.currency.decimal_sep;
    var thousand_sep = kando_data.currency.thousand_sep;
    var decimals = kando_data.currency.decimal_place;
    var currency_pos = kando_data.currency.currency_pos;
    var _currency_symbol = kando_data.currency.symbol;

    // price = Intl.NumberFormat('en-US').format(price);
    price = numberFormat(price, decimals , decimal_sep, thousand_sep)

    switch (currency_pos) {
        case 'left':
            return price+''+_currency_symbol;
            break;
        case 'right':
            return _currency_symbol+''+price;
            break;
        case 'left_space':
            return price+' '+_currency_symbol;
            break;
        case 'right_space':
            return _currency_symbol+' '+price;
            break;
    }
}

function sendOrderFormData(service_id, quantity, place,type="") {
    let user_credit, total_service, total_service_format;
    let numberToWords = "";
    let display_wallet_payment = "none";
    let display_total_payment = "";
    let show_gateways = true;
    const data = [];
    place.addClass('is-loading');
    place.find('.samyar-form-loading').fadeIn(200);
    let price = $j("#select-order-service select").children("option:selected").attr("data-price");
    let service_name = $j("#select-order-service select").children("option:selected").attr("data-name");

    if (typeof kando_data.wallet === 'undefined') {
        user_credit = 0;
    } else {
        user_credit = kando_data.wallet;
    }

    if(kando_data.currency.selected_currency==="IRT"){
        total_service = Math.floor((price / 1000) * quantity)
    }else{
        total_service = (price / 1000) * quantity;
    }




    if(type !== "" && type=="gift_card"){
        if(kando_data.currency.selected_currency==="IRT"){
            total_service = Math.floor(price  * quantity)
        }else{
            total_service = price  * quantity;
        }

    }

    total_service_format = kando_number_format(total_service);
    // Intl.NumberFormat('fa-IR', {}).format(total_service);

    if (user_credit > 0) {//اگر اعتبار در کیف پول کاربر بزرگتر از صفر بود
        // چک می کنیم ببینیم آیا کیف پول، پول سرویس رو جواب میده یا نه
        if (total_service > user_credit) {//اگر مبلغ سفارش بالاتر از اعتبار کاربر بود
            if(kando_data.currency.selected_currency==="IRT"){
                data['total_payment'] = Math.floor(total_service - user_credit);//مبلغ قابل پرداخت
            }else{
                data['total_payment'] = total_service - user_credit;//مبلغ قابل پرداخت
            }

            // data['total_payment_format'] = Intl.NumberFormat('fa-IR', {}).format(Math.floor(data['total_payment']));//مبلغ قابل پرداخت
            data['total_payment_format'] = kando_number_format(data['total_payment']);//مبلغ قابل پرداخت

            if(kando_data.currency.selected_currency==="IRT"){
                data['wallet_payment'] = Math.floor(user_credit);//کل کیف پول کاربر کسر میشه
            }else{
                data['wallet_payment'] = user_credit;//کل کیف پول کاربر کسر میشه
            }

            // data['wallet_payment_format'] = Intl.NumberFormat('fa-IR', {}).format(Math.floor(user_credit));//کل کیف پول کاربر کسر میشه
            data['wallet_payment_format'] = kando_number_format(user_credit);//کل کیف پول کاربر کسر میشه
            numberToWords = Num2persian(data['total_payment']);
        } else if (total_service === user_credit) {//اگر مقدار کیف پول با سرویس مساوی بود
            if(kando_data.currency.selected_currency==="IRT"){
                data['wallet_payment'] = Math.floor(user_credit); //مبلغی که از کیف پول باید کسر بشه
            }else{
                data['wallet_payment'] = user_credit; //مبلغی که از کیف پول باید کسر بشه
            }

            // data['wallet_payment_format'] = Intl.NumberFormat('fa-IR', {}).format(Math.floor(user_credit)); //مبلغی که از کیف پول باید کسر بشه
            data['wallet_payment_format'] = kando_number_format(user_credit); //مبلغی که از کیف پول باید کسر بشه

            data['total_payment'] = 0;//مبلغ قابل پرداخت
            data['total_payment_format'] = 0;//مبلغ قابل پرداخت

            display_total_payment = "none";
        } else {//اگر مقدار کیف پول از مقدار سرویس بیشتر بود
            if(kando_data.currency.selected_currency==="IRT"){
                data['wallet_payment'] = Math.floor(total_service); //مبلغی که از کیف پول باید کسر بشه
            }else{
                data['wallet_payment'] = total_service; //مبلغی که از کیف پول باید کسر بشه
            }

            // data['wallet_payment_format'] = Intl.NumberFormat('fa-IR', {}).format(Math.floor(total_service)); //مبلغی که از کیف پول باید کسر بشه
            data['wallet_payment_format'] = kando_number_format(total_service); //مبلغی که از کیف پول باید کسر بشه


            data['total_payment'] = 0;//مبلغ قابل پرداخت
            data['total_payment_format'] = 0;//مبلغ قابل پرداخت

            display_total_payment = "none";
        }
        display_wallet_payment = "";
    } else {
        //اگر کیف پول کلا صفر بود مبلغ سرویس و مبلغ قابل پرداخت یکی هست
        data['wallet_payment'] = 0;
        if(kando_data.currency.selected_currency==="IRT"){
            data['total_payment'] = Math.floor(total_service);
        }else{
            data['total_payment'] = total_service;
        }

        // data['total_payment_format'] = Intl.NumberFormat('fa-IR', {}).format(Math.floor(total_service));
        data['total_payment_format'] = kando_number_format(total_service);
        numberToWords = Num2persian(data['total_payment']);
        // dasplay_wallet_payment = "none";
    }

    var selected_currency = kando_data.currency.selected_currency;
    if(selected_currency !== "IRT"){
        display_total_payment = "none";
    }

    const basket_html = ({url, img, title}) => `<table class="shop_table">
            <thead>
            <tr>
                <th class="product-name">${kando_data.langs.service}</th>
                <th class="product-total">${kando_data.langs.charge}</th>
            </tr>
            </thead>
            <tbody>
            <tr class="cart_item">
                <td class="product-name">
                            <span class="product-title">
							    ${service_name}&nbsp;<strong class="product-quantity">× ${quantity} </strong>							                                </span>
                </td>
                <td class="product-total">
                    ${total_service_format}
                </td>
            </tr>
            </tbody>
            <tfoot>

            <tr class="cart-discount" style="display: ${display_wallet_payment}">
                <th>${kando_data.langs.deduct_from_wallet}</th>
                <td class="align-left" data-title="${kando_data.langs.wallet_credit}">${data['wallet_payment_format']} </td>
            </tr>

            <tr class="order-total">
                <th>${kando_data.langs.payable_amount}</th>
                <td><strong><span class="woocommerce-Price-amount amount">${data['total_payment_format']}&nbsp;<span class="woocommerce-Price-currencySymbol"></span></span></strong></td>
            </tr>

            <tr style="display: ${display_total_payment}">
                <th colspan="2">به حروف: <strong><span class="woocommerce-Price-amount amount">${numberToWords}&nbsp;<span class="woocommerce-Price-currencySymbol"></span>${kando_base_rate_text(kando_data.base_rate)}</span></strong></th>
            </tr>
            </tfoot>
        </table> `;
    $j('.new-order-form .shop_table').html([
        {url: '/foo', img: 'foo.png', title: 'Foo item'},
    ].map(basket_html).join(''));

    show_gateways = data['total_payment'] === 0 ? false : true;
    if (show_gateways === false) {
        $j('ul.payment_methods').slideUp(400, 'easeOutCubic');
        // $j('ul.payment_methods').hide();
    } else {
        $j('ul.payment_methods').slideDown(400, 'easeOutCubic');
        // $j('ul.payment_methods').show();
    }


    var sum = Number(data['total_payment']) + Number(data['wallet_payment']);
    if (isNaN(sum)) {
        $j(".final-price-number").html('لطفا دسته و سرویس را انتخاب نمایید');
    } else {
        $j(".final-price-number").html(kando_number_format(sum));
    }



}

function kando_base_rate_text($base_rate) {
    switch ($base_rate) {
        case "IRT":
            return "تومان";
            break;
        case "USD":
            return "دلار";
            break;
        case "AFN":
            return "افغانی";
            break;
        default:
            return "";
            break;
    }
}

function SamyarAjaxNewOrder() {

    // $j('.new-order-form').submit(function () {
    $j(document).on("click", ".new-order-form #place_order", function () {
        var $this = $j(".new-order-form");
        var $btn = $j(this);
        if (!$btn.hasClass('clicked') && !$btn.hasClass('is-loading')) {
            $btn.addClass('is-loading');
            $btn.addClass('clicked');
            // $this.find('.samyar-form-loading').fadeIn(200);
            $j.ajax({
                url: kando_data.ajaxurl,
                type: 'post',
                data: $this.serialize(),
                success: function (response) {

                    //اگر مرحله شروع پرداخت موفقیت آمیز بود به درگاه پرداخت برو
                    if (response.success) {
                        setTimeout(function () {
                            Swal.fire({
                                title: kando_data.langs.successful,
                                icon: 'success',
                                html: response.data.redirect_message,
                                showCloseButton: true,
                                confirmButtonText: kando_data.langs.ok,
                            })


                            if (response.data.method === "get") {
                                if (typeof response.data.url !== undefined) {
                                    window.location = response.data.url;
                                }
                            } else if (response.data.method === "post") {
                                $j('#checkout_form').attr('action', response.data.url);
                                if (typeof response.data.extend_fields !== "undefined") {
                                    $j('#checkout_form .payment_info').html('').append(response.data.extend_fields);
                                }
                                $j("#checkout_form").attr("method", "post");
                                $j("#checkout_form #payment_submit").trigger("click");

                            }


                        }, 1000);
                    } else {
                        setTimeout(function () {
                            if (response.data.no_credit) {
                                Swal.fire({
                                    title: kando_data.langs.an_error,
                                    icon: 'error',
                                    html: response.data.message,
                                    showCloseButton: true,
                                    confirmButtonText: kando_data.langs.ok,
                                    footer: '<a target="_blank" href="' + response.data.add_credit_credit + '">'+kando_data.langs.add_credit+'</a>'
                                })
                            } else {
                                Swal.fire({
                                    title: kando_data.langs.an_error,
                                    icon: 'error',
                                    html: response.data.message,
                                    showCloseButton: true,
                                    confirmButtonText: kando_data.langs.ok,
                                })
                            }


                        }, 200);
                        $btn.removeClass('is-loading');
                        $btn.removeClass('clicked');
                        // $this.find('.samyar-form-loading').fadeOut(200);
                    }


                },
                error: function () {
                    $btn.removeClass('is-loading');
                    $btn.removeClass('clicked');
                    // $this.find('.samyar-form-loading').fadeOut(200);
                }
            });

        }

        return false;
    });
}

function SamyarAjaxMassOrder() {

    // $j('.new-order-form').submit(function () {
    $j(document).on("click", ".mass-order-form #place_order", function () {
        var $this = $j(".mass-order-form");
        var $btn = $j(this);

        var _data = $this.find("input[name!=mass_order]").serialize();
        var _mass_order_array = [];
        var _mass_orders = $this.find("textarea[name=mass_order]").val();
        if (_mass_orders.length > 0) {
            _mass_orders = _mass_orders.split(/\n/);
            for (var i = 0; i < _mass_orders.length; i++) {
                // only push this line if it contains a non whitespace character.
                if (/\S/.test(_mass_orders[i])) {
                    _mass_order_array.push($j.trim(_mass_orders[i]));
                }
            }
        }

        _data = _data + '&' + $j.param({mass_order: _mass_order_array});

        if (!$btn.hasClass('clicked') && !$btn.hasClass('is-loading')) {
            $btn.addClass('is-loading');
            $btn.addClass('clicked');
            // $this.find('.samyar-form-loading').fadeIn(200);
            $j.ajax({
                url: kando_data.ajaxurl,
                type: 'post',
                data: _data,
                success: function (response) {

                    if (isJson(response)) {//اگر نوعش جیسون هست یعنی خطایی رخ داده و خطا رو نشون بده
                        //اگر مرحله شروع پرداخت موفقیت آمیز بود به درگاه پرداخت برو
                        if (response.success) {
                            setTimeout(function () {
                                Swal.fire({
                                    title: kando_data.langs.successful,
                                    icon: 'success',
                                    html: response.data.message,
                                    showCloseButton: true,
                                    confirmButtonText: kando_data.langs.ok,
                                })
                                if (response.data.url !== undefined) {
                                    window.location = response.data.url;
                                }

                            }, 2000);
                        } else {
                            setTimeout(function () {
                                if (response.data.no_credit) {
                                    Swal.fire({
                                        title: kando_data.langs.an_error,
                                        icon: 'error',
                                        html: response.data.message,
                                        showCloseButton: true,
                                        confirmButtonText: kando_data.langs.ok,
                                        footer: '<a target="_blank" href="' + response.data.add_credit_credit + '">'+kando_data.langs.add_credit+'</a>'
                                    })
                                } else {
                                    Swal.fire({
                                        title: kando_data.langs.an_error,
                                        icon: 'error',
                                        html: response.data,
                                        showCloseButton: true,
                                        confirmButtonText: kando_data.langs.ok,
                                    })
                                }


                            }, 200);
                            $btn.removeClass('is-loading');
                            $btn.removeClass('clicked');
                            // $this.find('.samyar-form-loading').fadeOut(200);
                        }
                    } else {// در غیر اینصورت جدول خدمات رو بر گردون

                        // $j(this).closest( "form" ).find( ".process-link-result")
                        $this.closest("form").find("#kando-mass-errors").slideUp(400, 'easeInOutCubic', function () {
                            $j(this).empty().html(response).slideDown(500, 'easeInOutCubic');
                        });
                        $btn.removeClass('is-loading');
                        $btn.removeClass('clicked');
                    }


                },
                error: function () {
                    $btn.removeClass('is-loading');
                    $btn.removeClass('clicked');
                    // $this.find('.samyar-form-loading').fadeOut(200);
                }
            });

        }

        return false;
    });
}

function samyarDeleteAllOrders() {

    $j(document).on('click', '#delete-order-all', function () {

        Swal.fire({
            title: kando_data.langs.are_you_sure,
            text: "تمام سفارش ها حذف خواهند شد",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: kando_data.langs.yes_delete,
            cancelButtonText: kando_data.langs.cancel
        }).then((result) => {
            let provider_id = $j(this).data('id');
            if (result.isConfirmed) {
                $j.ajax({
                    url: kando_data.ajaxurl,
                    type: 'post',
                    data: {action: 'samyar_delete_orders'},
                    success: function (response) {
                        if (!response.success) {
                            Swal.fire({
                                title: kando_data.langs.an_error,
                                icon: 'error',
                                html: response.data,
                                showCloseButton: true,
                                confirmButtonText: kando_data.langs.ok,
                            })
                        } else {
                            Swal.fire({
                                // title: kando_data.langs.an_error,
                                icon: 'success',
                                html: response.data,
                                showCloseButton: true,
                                confirmButtonText: kando_data.langs.ok,
                            })
                            window.location.reload();
                        }
                    },
                    error: function () {
                        Swal.fire({
                            title: kando_data.langs.an_error,
                            icon: 'error',
                            html: response.data,
                            showCloseButton: true,
                            confirmButtonText: kando_data.langs.ok,
                        })
                    }
                });

            }
        })

    })

}

function SamyarAjaxShowPackageForm() {

    $j(document).on('click', '.samyar-show-package-form', function () {
        $j(".kt-send-package-modal .kt-modal-content").html('');
        let service_id = $j(this).attr('data-service');
        let quantity = $j(this).attr('data-quantity');
        let title = $j(this).attr('data-title');
        let price = $j(this).attr('data-price');
        $j.ajax({
            url: kando_data.ajaxurl,
            type: 'post',
            data: {service_id: service_id, quantity: quantity, title: title, price: price, action: 'samyar_show_package_form'},
            success: function (response) {
                // if (response.success) {
                $j(".kt-send-package-modal .kt-modal-content").html(response);
                // }
            },
            error: function () {
            }
        });


    });

}

function SamyarAjaxShowOrderForm() {

    $j(document).on('click', '.samyar-show-order-form', function () {
        $j(".kt-send-package-modal .kt-modal-content").html('');
        let service_id = $j(this).attr('data-service');
        let cat_id = $j(this).attr('data-cat');
        let type = $j(this).attr('data-type');
        $j.ajax({
            url: kando_data.ajaxurl,
            type: 'GET',
            data: {service_id: service_id, cat_id: cat_id, type: type, action: 'samyar_show_order_form'},
            success: function (response) {
                // if (response.success) {
                $j(".kt-send-package-modal .kt-modal-content").html(response);
                // }
            },
            error: function () {
            }
        });


    });

}

function SamyarAjaxShowInfo() {

    $j(document).on('click', '.kando-show-info', function () {
        $j(".kt-info-modal .kt-modal-content").html('');
        let type = $j(this).attr('data-type');
        let info = $j(this).attr('data-info');
        let order = $j(this).attr('data-order');
        $j.ajax({
            url: kando_data.ajaxurl,
            type: 'post',
            data: {order: order, info: info, action: 'samyar_show_' + type + '_info'},
            beforeSend: function () {
                $j(".kt-info-modal .kt-modal-content").html("<span class='is-loading'><div class='samyar-form-loading' style='display: block;'></div></span>");
            },
            success: function (response) {
                // if (response.success) {
                $j(".kt-info-modal .kt-modal-content").html(response);
                // }
            },
            error: function () {
            }
        });


    });

}

function SamyarAjaxGetOrders() {

    $j('.get-orders-form').submit(function () {
        var $this = $j(this);
        if (!$this.hasClass('is-loading')) {
            $this.addClass('is-loading');
            $this.find('.samyar-form-loading').fadeIn(200);
            $j.ajax({
                url: kando_data.ajaxurl,
                type: 'post',
                data: $this.serialize(),
                success: function (response) {

                    if (isJson(response) && !response.success) {
                        Swal.fire({
                            title: kando_data.langs.an_error,
                            icon: 'error',
                            html: response.data,
                            showCloseButton: true,
                            confirmButtonText: kando_data.langs.ok,
                        })
                    } else {
                        $j('.dashboard-tickets-box').html(response)
                    }
                    $this.removeClass('is-loading');
                    $this.find('.samyar-form-loading').fadeOut(200);
                },
                error: function () {
                    $this.removeClass('is-loading');
                    $this.find('.samyar-form-loading').fadeOut(200);
                }
            });

        }

        return false;
    });
}


//برای بازگشت وجه سفارش استفاده میشه
$j(document).on("change", "#select-status-for-edit-order select", function () {

    let status = this.value;

    if (status === "partial" || status === "canceled") {
        $j('.refund').show();
    } else {
        $j('.refund').hide();
    }
})

function SamyarAjaxUpdateOrder() {

    $j('.update-order-form').submit(function () {
        var $this = $j(this);
        if (!$this.hasClass('is-loading')) {
            $this.addClass('is-loading');
            $this.find('.samyar-form-loading').fadeIn(200);
            $j.ajax({
                url: kando_data.ajaxurl,
                type: 'post',
                data: $this.serialize(),
                success: function (response) {
                    if (!response.success) {
                        Swal.fire({
                            title: kando_data.langs.an_error,
                            icon: 'error',
                            html: response.data,
                            showCloseButton: true,
                            confirmButtonText: kando_data.langs.ok,
                        })
                    } else {
                        setTimeout(function () {
                            Swal.fire({
                                // title: kando_data.langs.an_error,
                                icon: 'success',
                                html: response.data.message,
                                showCloseButton: true,
                                confirmButtonText: kando_data.langs.ok,
                            })
                            if (response.data.link !== undefined) {
                                window.location = response.data.link;
                            }

                        }, 500);

                    }


                    $this.removeClass('is-loading');
                    $this.find('.samyar-form-loading').fadeOut(200);


                },
                error: function () {
                    $this.removeClass('is-loading');
                    $this.find('.samyar-form-loading').fadeOut(200);
                }
            });

        }

        return false;
    });
}

function SamyarAjaxUpdateRefillOrder() {

    $j('.update-order-refill-form').submit(function () {
        var $this = $j(this);
        if (!$this.hasClass('is-loading')) {
            $this.addClass('is-loading');
            $this.find('.samyar-form-loading').fadeIn(200);
            $j.ajax({
                url: kando_data.ajaxurl,
                type: 'post',
                data: $this.serialize(),
                success: function (response) {
                    if (!response.success) {
                        Swal.fire({
                            title: kando_data.langs.an_error,
                            icon: 'error',
                            html: response.data,
                            showCloseButton: true,
                            confirmButtonText: kando_data.langs.ok,
                        })
                    } else {
                        setTimeout(function () {
                            Swal.fire({
                                // title: kando_data.langs.an_error,
                                icon: 'success',
                                html: response.data.message,
                                showCloseButton: true,
                                confirmButtonText: kando_data.langs.ok,
                            })
                            if (response.data.link !== undefined) {
                                window.location = response.data.link;
                            }

                        }, 200);

                    }


                    $this.removeClass('is-loading');
                    $this.find('.samyar-form-loading').fadeOut(200);


                },
                error: function () {
                    $this.removeClass('is-loading');
                    $this.find('.samyar-form-loading').fadeOut(200);
                }
            });

        }

        return false;
    });
}

function SamyarAjaxDeleteOrder() {
    $j(document).on('click', '.delete-order', function () {

        Swal.fire({
            title: 'آیا شما از حذف این سفارش مطمئن هستید؟',
            text: "اگر وضعیت سفارش کامل نشده باشد مبلغ عودت داده خواهد شد",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: kando_data.langs.yes_delete,
            cancelButtonText: kando_data.langs.cancel
        }).then((result) => {
            let order_id = $j(this).data('id');
            if (result.isConfirmed) {
                $j.ajax({
                    url: kando_data.ajaxurl,
                    type: 'post',
                    data: {id: order_id, action: 'samyar_order_delete'},
                    success: function (response) {
                        if (!response.success) {
                            Swal.fire(
                                kando_data.langs.an_error,
                                response.data,
                                'error'
                            )
                        } else {
                            Swal.fire(
                                'حذف شد',
                                response.data,
                                'success'
                            )
                            window.location.reload();
                        }

                    },
                    error: function () {
                        Swal.fire({
                            title: kando_data.langs.an_error,
                            icon: 'error',
                            html: response.data,
                            showCloseButton: true,
                            confirmButtonText: kando_data.langs.ok,
                        })
                    }
                });

            }
        })

    })
}

function SamyarAjaxDeleteRefillOrder() {
    $j(document).on('click', '.delete-refill-order', function () {

        Swal.fire({
            title: 'آیا شما از حذف این سفارش مطمئن هستید؟',
            text: "",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: kando_data.langs.yes_delete,
            cancelButtonText: kando_data.langs.cancel
        }).then((result) => {
            let order_id = $j(this).data('id');
            if (result.isConfirmed) {
                $j.ajax({
                    url: kando_data.ajaxurl,
                    type: 'post',
                    data: {id: order_id, action: 'samyar_refill_order_delete'},
                    success: function (response) {
                        if (!response.success) {
                            Swal.fire(
                                kando_data.langs.an_error,
                                response.data,
                                'error'
                            )
                        } else {
                            Swal.fire(
                                'حذف شد',
                                response.data,
                                'success'
                            )
                            window.location.reload();
                        }

                    },
                    error: function () {
                        Swal.fire({
                            title: kando_data.langs.an_error,
                            icon: 'error',
                            html: response.data,
                            showCloseButton: true,
                            confirmButtonText: kando_data.langs.ok,
                        })
                    }
                });

            }
        })

    })
}

function SamyarAjaxCancelOrder() {
    $j(document).on('click', '.cancel-order', function () {

        Swal.fire({
            title: 'آیا شما از لغو این سفارش مطمئن هستید؟',
            text: "",
            html: '<div id="recaptcha"></div>',
            didOpen: () => {
                if(kando_data.google_captcha_enable==1){
                    grecaptcha.render('recaptcha', {
                        'sitekey': kando_data.captcha_google_key
                    })
                }

            },
            preConfirm: function () {
                if(kando_data.google_captcha_enable==1) {
                    if (grecaptcha.getResponse().length === 0) {
                        Swal.showValidationMessage(`لطفاً تایید کنید که ربات نیستید`)
                    }
                }
            },
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'بله، لغو کن',
            cancelButtonText: 'انصراف از لغو'
        }).then((result) => {
            let order_id = $j(this).data('id');
            let token = $j("#g-recaptcha-response").val();
            if (result.isConfirmed) {
                // ktRecaptcha('samyar_order_cancel', function (token) {
                $j.ajax({
                    url: kando_data.ajaxurl,
                    type: 'post',
                    data: {id: order_id, action: 'samyar_order_cancel', token: token},
                    success: function (response) {
                        if (!response.success) {
                            if(kando_data.google_captcha_enable==="1"){
                                grecaptcha.reset();
                            }
                            Swal.fire(
                                kando_data.langs.an_error,
                                response.data,
                                'error'
                            )
                        } else {
                            Swal.fire(
                                'لغو شد',
                                response.data,
                                'success'
                            )
                            window.location.reload();
                        }

                    },
                    error: function () {
                        if(kando_data.google_captcha_enable==="1"){
                            grecaptcha.reset();
                        }
                        Swal.fire({
                            title: kando_data.langs.an_error,
                            icon: 'error',
                            html: response.data,
                            showCloseButton: true,
                            confirmButtonText: kando_data.langs.ok,
                        })
                    }
                });
                // });
            }
        })

    })
}

function SamyarAjaxSendFastOrder() {
    $j(document).on('click', '.fast-send-order', function () {

        Swal.fire({
            title: kando_data.langs.are_you_sure_send_order,
            text: "",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: kando_data.langs.yes_send,
            cancelButtonText: kando_data.langs.cancel
        }).then((result) => {
            let order_id = $j(this).data('id');
            if (result.isConfirmed) {
                $j.ajax({
                    url: kando_data.ajaxurl,
                    type: 'post',
                    data: {id: order_id, action: 'samyar_fast_order'},
                    success: function (response) {
                        if (!response.success) {
                            Swal.fire(
                                kando_data.langs.an_error,
                                response.data,
                                'error'
                            )
                        } else {
                            Swal.fire(
                                kando_data.langs.done,
                                response.data,
                                'success'
                            )
                            window.location.reload();
                        }

                    },
                    error: function () {
                        Swal.fire({
                            title: kando_data.langs.an_error,
                            icon: 'error',
                            html: response.data,
                            showCloseButton: true,
                            confirmButtonText: kando_data.langs.ok,
                        })
                    }
                });

            }
        })

    })
}

function SamyarAjaxAddCredit() {

    $j('.samyar-add-credit').submit(function () {
        var $this = $j(this);
        if (!$this.hasClass('is-loading')) {
            $this.addClass('is-loading');
            $this.find('.samyar-form-loading').fadeIn(200);
            $j.ajax({
                url: kando_data.ajaxurl,
                type: 'post',
                dataType: 'JSON',
                data: $this.serialize(),
                success: function (response) {

                    //اگر مرحله شروع پرداخت موفقیت آمیز بود به درگاه پرداخت برو
                    if (response.success) {
                        setTimeout(function () {

                            Swal.fire({
                                title: kando_data.langs.successful,
                                icon: 'success',
                                html: response.data.redirect_message,
                                showCloseButton: true,
                                confirmButtonText: kando_data.langs.ok,
                            })

                            if (response.data.method === "get") {
                                if (typeof response.data.url !== undefined) {
                                    window.location = response.data.url;
                                }
                            } else if (response.data.method === "post") {
                                $j('#checkout_form').attr('action', response.data.url);
                                if (typeof response.data.extend_fields !== "undefined") {
                                    $j('#checkout_form .payment_info').html('').append(response.data.extend_fields);
                                }
                                $j("#checkout_form").attr("method", "post");
                                $j("#checkout_form #payment_submit").trigger("click");

                            }


                        }, 1000);
                    } else {
                        setTimeout(function () {
                            Swal.fire({
                                title: kando_data.langs.an_error,
                                icon: 'error',
                                html: response.data,
                                showCloseButton: true,
                                confirmButtonText: kando_data.langs.ok,
                            })


                        }, 200);
                        $this.removeClass('is-loading');
                        $this.find('.samyar-form-loading').fadeOut(200);
                    }


                },
                error: function () {
                    $this.removeClass('is-loading');
                    $this.find('.samyar-form-loading').fadeOut(200);
                }
            });

        }

        return false;
    });
}

function SamyarAjaxNewNotification() {

    $j('.new-notification-form').submit(function () {
        var $this = $j(this);
        if (!$this.hasClass('is-loading')) {
            $this.addClass('is-loading');
            $this.find('.samyar-form-loading').fadeIn(200);
            tinyMCE.triggerSave();
            $j.ajax({
                url: kando_data.ajaxurl,
                type: 'post',
                data: $this.serialize(),
                success: function (response) {
                    if (!response.success) {
                        Swal.fire({
                            title: kando_data.langs.an_error,
                            icon: 'error',
                            html: response.data,
                            showCloseButton: true,
                            confirmButtonText: kando_data.langs.ok,
                        })
                    } else {
                        setTimeout(function () {
                            Swal.fire({
                                // title: kando_data.langs.an_error,
                                icon: 'success',
                                html: response.data,
                                showCloseButton: true,
                                confirmButtonText: kando_data.langs.ok,
                            })
                        }, 200);

                    }


                    $this.removeClass('is-loading');
                    $this.find('.samyar-form-loading').fadeOut(200);


                },
                error: function () {
                    $this.removeClass('is-loading');
                    $this.find('.samyar-form-loading').fadeOut(200);
                }
            });

        }

        return false;
    });
}

function SamyarAjaxLike() {

    $j(document).on('click', '.kt-like-button, .kt-dislike-button', function () {
        var $this = $j(this).closest('.kt-like-holder');
        if (!$this.hasClass('is-loading')) {
            $this.addClass('is-loading');
            var id = $this.data('id'),
                button = $j(this),
                like_status,
                dislike_status;
            if (button.hasClass('kt-like-button')) {
                like_status = $this.hasClass('liked') ? 'unliked' : 'liked';
                if ($this.hasClass('disliked')) dislike_status = 'undisliked';
            }
            if (button.hasClass('kt-dislike-button')) {
                dislike_status = $this.hasClass('disliked') ? 'undisliked' : 'disliked';
                if ($this.hasClass('liked')) like_status = 'unliked';
            }
            var status = '{"like_status":"' + like_status + '","dislike_status":"' + dislike_status + '"}';
            $j.ajax({
                url: kando_data.ajaxurl,
                type: 'post',
                data: {
                    action: $this.hasClass('kt-comment-like-holder') ? 'samyar_comments_add_like' : 'samyar_posts_add_like',
                    id: id,
                    status: status
                },
                success: function (response) {
                    // response = JSON.parse(response);
                    $this.find('.kt-like-count').html(response.likes);
                    $this.find('.kt-dislike-count').html(response.dislikes);
                    $this.attr('data-likes', response.likes);
                    $this.attr('data-dislikes', response.dislikes);
                    if (button.hasClass('kt-like-button')) {
                        $this.hasClass('liked') ? $this.removeClass('liked') : $this.addClass('liked');
                        if ($this.hasClass('disliked')) $this.removeClass('disliked');
                    }
                    if (button.hasClass('kt-dislike-button')) {
                        $this.hasClass('disliked') ? $this.removeClass('disliked') : $this.addClass('disliked');
                        if ($this.hasClass('liked')) $this.removeClass('liked');
                    }
                    $this.removeClass('is-loading');
                }
            });
        }
        return false;
    });
}

function SamyarSocialShare() {

    $j('.social-share-button').click(function () {
        var $this = $j(this);
        if (!$this.hasClass('is-loading')) {
            $this.addClass('is-loading');

            $j.ajax({
                url: kando_data.ajaxurl,
                type: 'post',
                data: {
                    action: 'samyar_social_share',
                    post_id: $this.data('id'),
                    type: $this.data('type')
                },
                success: function (response) {
                    $this.find('span').html(response);
                    $this.removeClass('is-loading');

                }
            });
        }
    });

}


function SamyarConsultation() {
    $j('.modal-contact-form').submit(function () {
        var $this = $j(this),
            type = $j('.course-single-advice').length ? 'academy' : 'normal',
            name = $this.find('.modal-contact-form-name').val(),
            website = $this.find('.modal-contact-form-website').val(),
            email = $this.find('.modal-contact-form-email').val(),
            subject = $this.find('.modal-contact-form-subject').val(),
            phone = $this.find('.modal-contact-form-phone').val(),
            errors = $this.find('.modal-contact-form-errors'),
            speed = errors.is(':empty') ? 0 : 400;

        if (!$this.hasClass('is-loading')) {
            $this.addClass('is-loading');
            $j.ajax({
                url: kando_data.ajaxurl,
                type: 'post',
                data: {
                    action: 'samyar_ajax_consultation',
                    name: name,
                    website: website,
                    phone: phone,
                    email: email,
                    subject: subject,
                    type: type,
                    url: window.location.href
                },
                success: function (response) {
                    if (!response.success) {
                        Swal.fire({
                            title: kando_data.langs.an_error,
                            icon: 'error',
                            html: response.data,
                            showCloseButton: true,
                            confirmButtonText: kando_data.langs.ok,
                        })
                    } else {
                        setTimeout(function () {
                            Swal.fire({
                                // title: kando_data.langs.an_error,
                                icon: 'success',
                                html: response.data,
                                showCloseButton: true,
                                confirmButtonText: kando_data.langs.ok,
                            })
                        }, 200);

                    }
                    /*
                    response = $j(response);

                    if (response.length && response.html() != '') {
                        errors.slideUp(speed, 'easeInOutCubic', function () {
                            $j(this).empty().append(response).slideDown(500, 'easeInOutCubic');
                        });
                    } else {
                        errors.slideUp(speed, 'easeInOutCubic', function () {
                            $j(this).empty();
                        });

                    }
                     */
                    $this.removeClass('is-loading');
                }
            });
        }

        return false;
    });
}

function SamyarAjaxFilterOrders() {

    $j('.filter-orders-form').submit(function () {
        var $this = $j(this);
        if (!$this.hasClass('is-loading')) {
            $this.addClass('is-loading');
            $this.find('.samyar-form-loading').fadeIn(200);
            $j.ajax({
                url: kando_data.ajaxurl,
                type: 'post',
                data: $this.serialize(),
                success: function (response) {

                    if (isJson(response) && !response.success) {
                        Swal.fire({
                            title: kando_data.langs.an_error,
                            icon: 'error',
                            html: response.data,
                            showCloseButton: true,
                            confirmButtonText: kando_data.langs.ok,
                        })
                    } else {
                        $j('.dashboard-tickets-box').html(response)
                    }
                    $this.removeClass('is-loading');
                    $this.find('.samyar-form-loading').fadeOut(200);
                },
                error: function () {
                    $this.removeClass('is-loading');
                    $this.find('.samyar-form-loading').fadeOut(200);
                }
            });

        }

        return false;
    });
}

function SamyarAjaxFilterRefillOrders() {

    $j('.filter-refill-orders-form').submit(function () {
        var $this = $j(this);
        if (!$this.hasClass('is-loading')) {
            $this.addClass('is-loading');
            $this.find('.samyar-form-loading').fadeIn(200);
            $j.ajax({
                url: kando_data.ajaxurl,
                type: 'post',
                data: $this.serialize(),
                success: function (response) {

                    if (isJson(response) && !response.success) {
                        Swal.fire({
                            title: kando_data.langs.an_error,
                            icon: 'error',
                            html: response.data,
                            showCloseButton: true,
                            confirmButtonText: kando_data.langs.ok,
                        })
                    } else {
                        $j('.dashboard-tickets-box').html(response)
                    }
                    $this.removeClass('is-loading');
                    $this.find('.samyar-form-loading').fadeOut(200);
                },
                error: function () {
                    $this.removeClass('is-loading');
                    $this.find('.samyar-form-loading').fadeOut(200);
                }
            });

        }

        return false;
    });
}

function SamyarAjaxSearchPayment() {

    $j('.filter-payments-form').submit(function () {
        var $this = $j(this);
        if (!$this.hasClass('is-loading')) {
            $this.addClass('is-loading');
            $this.find('.samyar-form-loading').fadeIn(200);
            $j.ajax({
                url: kando_data.ajaxurl,
                type: 'post',
                data: $this.serialize(),
                success: function (response) {

                    if (isJson(response) && !response.success) {
                        Swal.fire({
                            title: kando_data.langs.an_error,
                            icon: 'error',
                            html: response.data,
                            showCloseButton: true,
                            confirmButtonText: kando_data.langs.ok,
                        })
                    } else {
                        $j('.dashboard-tickets-box').html(response)
                    }
                    $this.removeClass('is-loading');
                    $this.find('.samyar-form-loading').fadeOut(200);
                },
                error: function () {
                    $this.removeClass('is-loading');
                    $this.find('.samyar-form-loading').fadeOut(200);
                }
            });

        }

        return false;
    });
}

function SamyarAjaxSearchServices() {

    $j('.filter-services-form').submit(function () {
        var $this = $j(this);
        if (!$this.hasClass('is-loading')) {
            $this.addClass('is-loading');
            $this.find('.samyar-form-loading').fadeIn(200);
            $j.ajax({
                url: kando_data.ajaxurl,
                type: 'post',
                data: $this.serialize(),
                success: function (response) {

                    if (isJson(response) && !response.success) {
                        Swal.fire({
                            title: kando_data.langs.an_error,
                            icon: 'error',
                            html: response.data,
                            showCloseButton: true,
                            confirmButtonText: kando_data.langs.ok,
                        })
                    } else {
                        $j('.kando-services-box').html(response)
                    }
                    $this.removeClass('is-loading');
                    $this.find('.samyar-form-loading').fadeOut(200);
                },
                error: function () {
                    $this.removeClass('is-loading');
                    $this.find('.samyar-form-loading').fadeOut(200);
                }
            });

        }

        return false;
    });
}


function SamyarAjaxFilterServices() {

    $j('.filter-services-form2').submit(function () {
        var $this = $j(this);
        if (!$this.hasClass('is-loading')) {
            $this.addClass('is-loading');
            $this.find('.samyar-form-loading').fadeIn(200);
            $j.ajax({
                url: kando_data.ajaxurl,
                type: 'post',
                data: $this.serialize(),
                success: function (response) {

                    if (isJson(response) && !response.success) {
                        Swal.fire({
                            title: kando_data.langs.an_error,
                            icon: 'error',
                            html: response.data,
                            showCloseButton: true,
                            confirmButtonText: kando_data.langs.ok,
                        })
                    } else {
                        $j('.kando-services-box').html(response)
                    }
                    $this.removeClass('is-loading');
                    $this.find('.samyar-form-loading').fadeOut(200);
                },
                error: function () {
                    $this.removeClass('is-loading');
                    $this.find('.samyar-form-loading').fadeOut(200);
                }
            });

        }

        return false;
    });
}


function SamyarAjaxShowRepaymentForm() {

    $j(document).on('click', '.repayment-order', function () {
        $j(".kt-repayment-modal .kt-modal-content").html('');
        let order_id = $j(this).attr('data-id');
        $j.ajax({
            url: kando_data.ajaxurl,
            type: 'post',
            data: {order_id: order_id, action: 'samyar_repayment_form'},
            success: function (response) {
                // if (response.success) {
                $j(".kt-repayment-modal .kt-modal-content").html(response);
                // }
            },
            error: function () {
            }
        });


    });

}

function SamyarAjaxRepayment() {

    // $j('.new-order-form').submit(function () {
    $j(document).on("click", ".repayment-form #btn_repayment", function () {
        var $this = $j(".repayment-form");
        var $btn = $j(this);
        if (!$btn.hasClass('clicked') && !$btn.hasClass('is-loading')) {
            $btn.addClass('is-loading');
            $btn.addClass('clicked');
            // $this.find('.samyar-form-loading').fadeIn(200);
            $j.ajax({
                url: kando_data.ajaxurl,
                type: 'post',
                data: $this.serialize(),
                success: function (response) {

                    //اگر مرحله شروع پرداخت موفقیت آمیز بود به درگاه پرداخت برو
                    if (response.success) {
                        setTimeout(function () {
                            Swal.fire({
                                title: kando_data.langs.successful,
                                icon: 'success',
                                html: response.data.redirect_message,
                                showCloseButton: true,
                                confirmButtonText: kando_data.langs.ok,
                            })
                            if (response.data.url !== undefined) {
                                window.location = response.data.url;
                            }

                        }, 1000);
                    } else {
                        setTimeout(function () {
                            Swal.fire({
                                title: kando_data.langs.an_error,
                                icon: 'error',
                                html: response.data,
                                showCloseButton: true,
                                confirmButtonText: kando_data.langs.ok,
                            })


                        }, 200);
                        $btn.removeClass('is-loading');
                        $btn.removeClass('clicked');
                        // $this.find('.samyar-form-loading').fadeOut(200);
                    }


                },
                error: function () {
                    $btn.removeClass('is-loading');
                    $btn.removeClass('clicked');
                    // $this.find('.samyar-form-loading').fadeOut(200);
                }
            });

        }

        return false;
    });
}

function SamyarAjaxSearchTickets() {

    $j('.filter-tickets-form').submit(function () {
        var $this = $j(this);
        if (!$this.hasClass('is-loading')) {
            $this.addClass('is-loading');
            $this.find('.samyar-form-loading').fadeIn(200);
            $j.ajax({
                url: kando_data.ajaxurl,
                type: 'post',
                data: $this.serialize(),
                success: function (response) {

                    if (isJson(response) && !response.success) {
                        Swal.fire({
                            title: kando_data.langs.an_error,
                            icon: 'error',
                            html: response.data,
                            showCloseButton: true,
                            confirmButtonText: kando_data.langs.ok,
                        })
                    } else {
                        $j('.dashboard-tickets-box').html(response)
                    }
                    $this.removeClass('is-loading');
                    $this.find('.samyar-form-loading').fadeOut(200);
                },
                error: function () {
                    $this.removeClass('is-loading');
                    $this.find('.samyar-form-loading').fadeOut(200);
                }
            });

        }

        return false;
    });
}

function SamyarAjaxEditProfile() {

    $j('.edit-profile-form').submit(function () {
        var $this = $j(this);
        if (!$this.hasClass('is-loading')) {
            $this.addClass('is-loading');
            $this.find('.samyar-form-loading').fadeIn(200);
            $j.ajax({
                url: kando_data.ajaxurl,
                type: 'post',
                data: $this.serialize(),
                success: function (response) {

                    if (!response.success) {
                        Swal.fire({
                            title: kando_data.langs.an_error,
                            icon: 'error',
                            html: response.data,
                            showCloseButton: true,
                            confirmButtonText: kando_data.langs.ok,
                        })
                    } else {
                        setTimeout(function () {
                            Swal.fire({
                                // title: kando_data.langs.an_error,
                                icon: 'success',
                                html: response.data,
                                showCloseButton: true,
                                confirmButtonText: kando_data.langs.ok,
                            })
                        }, 200);

                    }
                    $this.removeClass('is-loading');
                    $this.find('.samyar-form-loading').fadeOut(200);
                },
                error: function () {
                    $this.removeClass('is-loading');
                    $this.find('.samyar-form-loading').fadeOut(200);
                }
            });

        }

        return false;
    });
}


function SamyarAjaxUpdateTicketSettingsProfile() {

    $j('.update-ticket-settings-form').submit(function () {
        var $this = $j(this);
        if (!$this.hasClass('is-loading')) {
            $this.addClass('is-loading');
            $this.find('.samyar-form-loading').fadeIn(200);
            tinyMCE.triggerSave();
            $j.ajax({
                url: kando_data.ajaxurl,
                type: 'post',
                data: $this.serialize(),
                success: function (response) {

                    if (!response.success) {
                        Swal.fire({
                            title: kando_data.langs.an_error,
                            icon: 'error',
                            html: response.data,
                            showCloseButton: true,
                            confirmButtonText: kando_data.langs.ok,
                        })
                    } else {
                        setTimeout(function () {
                            Swal.fire({
                                // title: kando_data.langs.an_error,
                                icon: 'success',
                                html: response.data,
                                showCloseButton: true,
                                confirmButtonText: kando_data.langs.ok,
                            })
                        }, 200);

                    }
                    $this.removeClass('is-loading');
                    $this.find('.samyar-form-loading').fadeOut(200);
                },
                error: function () {
                    $this.removeClass('is-loading');
                    $this.find('.samyar-form-loading').fadeOut(200);
                }
            });

        }

        return false;
    });
}

function SamyarAjaxCreateApiKey() {

    $j('.create-api-key-form').submit(function () {
        var $this = $j(this);
        if (!$this.hasClass('is-loading')) {
            $this.addClass('is-loading');
            $this.find('.samyar-form-loading').fadeIn(200);
            $j.ajax({
                url: kando_data.ajaxurl,
                type: 'post',
                data: $this.serialize(),
                success: function (response) {

                    if (!response.success) {
                        Swal.fire({
                            title: kando_data.langs.an_error,
                            icon: 'error',
                            html: response.data.message,
                            showCloseButton: true,
                            confirmButtonText: kando_data.langs.ok,
                        })
                    } else {
                        $j('#api-key').val(response.data.token);
                        setTimeout(function () {
                            Swal.fire({
                                // title: kando_data.langs.an_error,
                                icon: 'success',
                                html: response.data.message,
                                showCloseButton: true,
                                confirmButtonText: kando_data.langs.ok,
                            })
                        }, 200);

                    }
                    $this.removeClass('is-loading');
                    $this.find('.samyar-form-loading').fadeOut(200);
                },
                error: function () {
                    $this.removeClass('is-loading');
                    $this.find('.samyar-form-loading').fadeOut(200);
                }
            });

        }

        return false;
    });
}

function SamyarAjaxChangeMobileNumber() {
    $j(document).on('click', '.samyar-verify-change-number', function () {
        $j('.edit-mobile-step1').slideUp();
        $j('.edit-mobile-step2').slideDown();
        $j('.edit-mobile-step3').slideUp();
        return false;
    });


    $j('.edit-mobile-step2').submit(function () {
        var $this = $j(this);
        if (!$this.hasClass('is-loading')) {
            $this.addClass('is-loading');
            $this.find('.samyar-form-loading').fadeIn(200);
            $j.ajax({
                url: kando_data.ajaxurl,
                type: 'post',
                data: $this.serialize(),
                success: function (response) {

                    if (!response.success) {
                        Swal.fire({
                            title: kando_data.langs.an_error,
                            icon: 'error',
                            html: response.data.message,
                            showCloseButton: true,
                            confirmButtonText: kando_data.langs.ok,
                        })
                    } else {
                        $j('.edit-mobile-step2').hide();
                        $j('.edit-mobile-step3').show();
                        setTimeout(function () {
                            Swal.fire({
                                // title: kando_data.langs.an_error,
                                icon: 'success',
                                html: response.data.message,
                                showCloseButton: true,
                                confirmButtonText: kando_data.langs.ok,
                            })
                        }, 200);
                        onTimer('.samyar-verify-send-again');
                    }
                    $this.removeClass('is-loading');
                    $this.find('.samyar-form-loading').fadeOut(200);
                },
                error: function () {
                    $this.removeClass('is-loading');
                    $this.find('.samyar-form-loading').fadeOut(200);
                }
            });

        }

        return false;
    });
    $j('.edit-mobile-step3').submit(function () {
        var $this = $j(this);
        var $button = $j('.samyar-verify-submit');
        var mobile = $j(".edit-mobile-step2 input[name=mobile]").val();
        if (!$this.hasClass('is-loading')) {
            $button.addClass('is-loading');
            $button.find('.samyar-form-loading').fadeIn(200);
            $j.ajax({
                url: kando_data.ajaxurl,
                type: 'post',
                data: $this.serialize() + '&mobile=' + mobile,
                success: function (response) {

                    if (!response.success) {
                        Swal.fire({
                            title: kando_data.langs.an_error,
                            icon: 'error',
                            html: response.data.message,
                            showCloseButton: true,
                            confirmButtonText: kando_data.langs.ok,
                        })
                    } else {
                        setTimeout(function () {
                            Swal.fire({
                                // title: kando_data.langs.an_error,
                                icon: 'success',
                                html: response.data,
                                showCloseButton: true,
                                confirmButtonText: kando_data.langs.ok,
                            })
                        }, 200);
                        location.reload();
                    }
                    $button.removeClass('is-loading');
                    $button.find('.samyar-form-loading').fadeOut(200);
                },
                error: function () {
                    $button.removeClass('is-loading');
                    $button.find('.samyar-form-loading').fadeOut(200);
                }
            });

        }

        return false;
    });

    $j(document).on("click", '.samyar-profile-verify-number', function () {
        var $button = $j(this);
        if (!$button.hasClass('is-loading')) {
            $button.addClass('is-loading');
            $j.ajax({
                url: kando_data.ajaxurl,
                type: 'post',
                data: 'action=profile_approve_mobile',
                success: function (response) {

                    if (!response.success) {
                        Swal.fire({
                            title: kando_data.langs.an_error,
                            icon: 'error',
                            html: response.data.message,
                            showCloseButton: true,
                            confirmButtonText: kando_data.langs.ok,
                        })
                    } else {
                        $j('.edit-mobile-step1').hide();
                        $j('.edit-mobile-step2').hide();
                        $j('.edit-mobile-step3').show();
                        setTimeout(function () {
                            Swal.fire({
                                // title: kando_data.langs.an_error,
                                icon: 'success',
                                html: response.data.message,
                                showCloseButton: true,
                                confirmButtonText: kando_data.langs.ok,
                            })
                        }, 200);
                        onTimer('.samyar-verify-send-again');
                    }
                    $button.removeClass('is-loading');

                },
                error: function () {
                    $button.removeClass('is-loading');

                }
            });

        }

        return false;
    })


    $j('.samyar-verify-send-again').click(function () {
        if (!$j(this).hasClass('clicked') && !$j(this).hasClass('is-loading')) {
            var $this = $j(this);
            var mobile = $j(".edit-mobile-step2 input[name=mobile]").val();


            $this.addClass('clicked');
            $this.addClass('is-loading');
            if (mobile !== '') {
                // ktRecaptcha('send_code_again', function (token) {
                $j.ajax({
                    url: kando_data.ajaxurl,
                    type: 'post',
                    data: {
                        action: 'samyar_send_approve_code',
                        mobile: mobile,
                    },
                    success: function (response) {
                        if (!response.success) {
                            Swal.fire({
                                title: kando_data.langs.an_error,
                                icon: 'error',
                                html: response.data.message,
                                showCloseButton: true,
                                confirmButtonText: kando_data.langs.ok,
                            })
                        } else {
                            $j('.edit-mobile-step2').hide();
                            $j('.edit-mobile-step3').show();
                            setTimeout(function () {
                                Swal.fire({
                                    // title: kando_data.langs.an_error,
                                    icon: 'success',
                                    html: response.data.message,
                                    showCloseButton: true,
                                    confirmButtonText: kando_data.langs.ok,
                                })
                            }, 200);
                            onTimer('.samyar-verify-send-again');
                        }
                        $this.removeClass('is-loading');
                        $this.find('.samyar-form-loading').fadeOut(200);
                    },
                    error: function () {
                        $this.removeClass('clicked');
                        $this.removeClass('is-loading');
                    }
                });
                // });
            }
        }
        return false;
    })


    //ارسال کد تایید به موبایل در فرم ارسال سفارش
    // $j('.new-order-form .samyar-verify-send,.get-orders-form .samyar-verify-send').click(function () {
    $j(document).on("click", '.new-order-form .samyar-verify-send,.get-orders-form .samyar-verify-send', function () {
        if (!$j(this).hasClass('clicked') && !$j(this).hasClass('is-loading')) {
            var $this = $j(this);
            // var mobile = $j(".new-order-form #mobile-number,.get-orders-form #mobile-number").val();
            var mobile = $this.parent().parent().find('#mobile-number').val();


            // $this.addClass('clicked');
            $this.addClass('is-loading');
            if (mobile !== '') {
                // ktRecaptcha('send_code_again', function (token) {
                $j.ajax({
                    url: kando_data.ajaxurl,
                    type: 'post',
                    data: {
                        action: 'samyar_send_approve_code_order',
                        mobile: mobile,
                    },
                    success: function (response) {
                        if (!response.success) {
                            Swal.fire({
                                title: kando_data.langs.an_error,
                                icon: 'error',
                                html: response.data.message,
                                showCloseButton: true,
                                confirmButtonText: kando_data.langs.ok,
                            });
                            // $this.removeClass('clicked');
                            $this.removeClass('is-loading');
                        } else {
                            setTimeout(function () {
                                Swal.fire({
                                    // title: kando_data.langs.an_error,
                                    icon: 'success',
                                    html: response.data.message,
                                    showCloseButton: true,
                                    confirmButtonText: kando_data.langs.ok,
                                })
                            }, 200);
                            onTimer('.new-order-form .samyar-verify-send,.get-orders-form .samyar-verify-send');
                        }
                        $this.removeClass('is-loading');
                    },
                    error: function () {
                        $this.removeClass('clicked');
                        $this.removeClass('is-loading');
                    }
                });
                // });
            } else {
                $this.removeClass('clicked');
                $this.removeClass('is-loading');
                Swal.fire({
                    title: kando_data.langs.enter_mobile_number,
                    icon: 'error',
                    html: "",
                    showCloseButton: true,
                    confirmButtonText: kando_data.langs.ok,
                })
            }
        }
        return false;
    })

    //برای ارسال کد تایید در ارسال سفارش چند مرحله ای
    // برای این جدا شده چون موبایل رو در این فرم نمی گیره
    $j(document).on("click", '.new-order-form .samyar-wizard-verify-send', function () {
        if (!$j(this).hasClass('clicked') && !$j(this).hasClass('is-loading')) {
            var $this = $j(this);
            // var mobile = $j(".new-order-form #mobile-number,.get-orders-form #mobile-number").val();
            var mobile = $this.parent().parent().parent().find('#mobile-number').val();


            // $this.addClass('clicked');
            $this.addClass('is-loading');
            if (mobile !== '') {
                // ktRecaptcha('send_code_again', function (token) {
                $j.ajax({
                    url: kando_data.ajaxurl,
                    type: 'post',
                    data: {
                        action: 'samyar_send_approve_code_order',
                        mobile: mobile,
                    },
                    success: function (response) {
                        if (!response.success) {
                            Swal.fire({
                                title: kando_data.langs.an_error,
                                icon: 'error',
                                html: response.data.message,
                                showCloseButton: true,
                                confirmButtonText: kando_data.langs.ok,
                            });
                            // $this.removeClass('clicked');
                            $this.removeClass('is-loading');
                        } else {
                            setTimeout(function () {
                                Swal.fire({
                                    // title: kando_data.langs.an_error,
                                    icon: 'success',
                                    html: response.data.message,
                                    showCloseButton: true,
                                    confirmButtonText: kando_data.langs.ok,
                                })
                            }, 200);
                            onTimer('.samyar-wizard-verify-send');
                        }
                        $this.removeClass('is-loading');
                    },
                    error: function () {
                        $this.removeClass('clicked');
                        $this.removeClass('is-loading');
                    }
                });
                // });
            } else {
                $this.removeClass('clicked');
                $this.removeClass('is-loading');
                Swal.fire({
                    title: kando_data.langs.enter_mobile_number,
                    icon: 'error',
                    html: "",
                    showCloseButton: true,
                    confirmButtonText: kando_data.langs.ok,
                })
            }
        }
        return false;
    })

    /*
    //ارسال مجدد سفارش های خطا خورده
    $j('.kando-change-status').click(function () {
        if (!$j(this).hasClass('clicked') && !$j(this).hasClass('is-loading')) {
            var $this = $j(this);

            // $this.addClass('clicked');
            $this.addClass('is-loading');

            // ktRecaptcha('send_code_again', function (token) {
            $j.ajax({
                url: kando_data.ajaxurl,
                type: 'post',
                data: {
                    action: 'kando_change_status',
                },
                success: function (response) {
                    if (!response.success) {
                        Swal.fire({
                            title: kando_data.langs.an_error,
                            icon: 'error',
                            html: response.data,
                            showCloseButton: true,
                            confirmButtonText: kando_data.langs.ok,
                        });
                        // $this.removeClass('clicked');
                        $this.removeClass('is-loading');
                    } else {
                        setTimeout(function () {
                            Swal.fire({
                                // title: kando_data.langs.an_error,
                                icon: 'success',
                                html: response.data,
                                showCloseButton: true,
                                confirmButtonText: kando_data.langs.ok,
                            })
                            location.reload();
                        }, 200);
                    }
                    $this.removeClass('is-loading');
                },
                error: function () {
                    $this.removeClass('clicked');
                    $this.removeClass('is-loading');
                }
            });
            // });

        }
        return false;
    })
*/
    //ارسال مجدد سفارش های خطا خورده
    $j(document).on("change", "select.kando-select-new-status", function () {

        let status = this.value;
        if (status === "canceled") {
            $j('.not-refund').show();
        } else {
            $j('.not-refund').hide();
        }
    })
    $j('.kando-change-status').click(function () {
        var $this = $j(this);
        var $select = $j('.kando_change_selected').val();
        if ($select === "change-status") {
            const {value: formValues} = Swal.fire({
                title: 'لطفا وضعیت مورد نظر را انتخاب نمایید',
                text: "توجه:مبلغ در وضعیت لغو برگشت خواهد خورد",
                html:
                    '<b style="margin-bottom: 30px;display: block;">توجه:سفارش هایی که شناسه سفارش در api گرفته باشند قابلیت لغو شدن نخواهند داشت.</b>\n' +
                    '<select class="swal2-select kando-select-new-status" id="kando-select-new-order-status" style="display: flex;"><option value="" disabled="">انتخاب وضعیت</option><option value="pending">در دست انجام</option><option value="completed">کامل شده</option><option value="canceled">لغو</option></select>' +
                    '<input type="checkbox" value="1" class="kando-cb-checkbox" id="cb-select-all-11" name="cb-select-all-11">\n' +
                    '<label class="not-refund" style="padding-right: 36px; position: relative; cursor: pointer; font-size: 18px;text-align: right;display: none;" for="cb-select-all-11">نمی خواهم مبلغ برگشت بخورد</label>',
                inputPlaceholder: 'انتخاب وضعیت',
                showCancelButton: true,
                confirmButtonText: 'اعمال کن',
                cancelButtonText: 'بی خیال',
                showLoaderOnConfirm: true,
                preConfirm: () => {
                    var checked = 0;
                    if ($j('#cb-select-all-11').is(':checked')) {
                        checked = 1;
                    }
                    return [
                        checked,
                        document.getElementById('kando-select-new-order-status').value
                    ]
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    var orders = [];
                    $j('.shop_table .kando-cb-checkbox:checkbox:checked').each(function () {
                        orders.push($j(this).attr('name'));
                    });

                    $j.ajax({
                        url: kando_data.ajaxurl,
                        type: 'post',
                        data: {
                            action: 'kando_change_status',
                            not_refund: result.value[0],
                            new_status: result.value[1],
                            orders: orders,
                        },
                        success: function (response) {
                            if (!response.success) {
                                Swal.fire({
                                    title: kando_data.langs.an_error,
                                    icon: 'error',
                                    html: response.data,
                                    showCloseButton: true,
                                    confirmButtonText: kando_data.langs.ok,
                                });
                                // $this.removeClass('clicked');
                                $this.removeClass('is-loading');
                            } else {
                                setTimeout(function () {
                                    Swal.fire({
                                        // title: kando_data.langs.an_error,
                                        icon: 'success',
                                        html: response.data,
                                        showCloseButton: true,
                                        confirmButtonText: kando_data.langs.ok,
                                    })
                                    window.location.reload();
                                }, 200);
                            }
                            $this.removeClass('is-loading');
                        },
                        error: function () {
                            $this.removeClass('clicked');
                            $this.removeClass('is-loading');
                        }
                    });
                }
            })
        } else {
            Swal.fire({
                title: 'آیا شما از حذف سفارش های انتخاب شده مطمئن هستید؟',
                html:
                    '<b style="margin-bottom: 30px;display: block;">توجه:مبلغ برگشت خواهد خورد</b>\n' +
                    '<input type="checkbox" value="1" class="kando-cb-checkbox" id="cb-select-all-12" name="cb-select-all-12">\n' +
                    '<label class="not-refund" style="padding-right: 36px; position: relative; cursor: pointer; font-size: 18px;text-align: right;" for="cb-select-all-12">نمی خواهم مبلغ برگشت بخورد</label>',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: kando_data.langs.yes_delete,
                cancelButtonText: kando_data.langs.cancel,
                preConfirm: () => {
                    var checked = 0;
                    if ($j('#cb-select-all-12').is(':checked')) {
                        checked = 1;
                    }
                    return [
                        checked,
                    ]
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    var orders = [];
                    $j('.shop_table .kando-cb-checkbox:checkbox:checked').each(function () {
                        orders.push($j(this).attr('name'));
                    });

                    $j.ajax({
                        url: kando_data.ajaxurl,
                        type: 'post',
                        data: {
                            action: 'kando_delete_orders',
                            not_refund: result.value[0],
                            orders: orders,
                        },
                        success: function (response) {
                            if (!response.success) {
                                Swal.fire({
                                    title: kando_data.langs.an_error,
                                    icon: 'error',
                                    html: response.data,
                                    showCloseButton: true,
                                    confirmButtonText: kando_data.langs.ok,
                                });
                                // $this.removeClass('clicked');
                                $this.removeClass('is-loading');
                            } else {
                                setTimeout(function () {
                                    Swal.fire({
                                        // title: kando_data.langs.an_error,
                                        icon: 'success',
                                        html: response.data,
                                        showCloseButton: true,
                                        confirmButtonText: kando_data.langs.ok,
                                    })
                                    window.location.reload();
                                }, 200);
                            }
                            $this.removeClass('is-loading');
                        },
                        error: function () {
                            $this.removeClass('clicked');
                            $this.removeClass('is-loading');
                        }
                    });
                }
            });
        }


        return false;
    })


    //ارسال مجدد سفارش های خطا خورده
    $j('.samyar-resend-orders').click(function () {
        if (!$j(this).hasClass('clicked') && !$j(this).hasClass('is-loading')) {
            var $this = $j(this);

            // $this.addClass('clicked');
            $this.addClass('is-loading');

            // ktRecaptcha('send_code_again', function (token) {
            $j.ajax({
                url: kando_data.ajaxurl,
                type: 'post',
                data: {
                    action: 'samyar_resend_orders',
                },
                success: function (response) {
                    if (!response.success) {
                        Swal.fire({
                            title: kando_data.langs.an_error,
                            icon: 'error',
                            html: response.data,
                            showCloseButton: true,
                            confirmButtonText: kando_data.langs.ok,
                        });
                        // $this.removeClass('clicked');
                        $this.removeClass('is-loading');
                    } else {
                        setTimeout(function () {
                            Swal.fire({
                                // title: kando_data.langs.an_error,
                                icon: 'success',
                                html: response.data,
                                showCloseButton: true,
                                confirmButtonText: kando_data.langs.ok,
                            })
                            location.reload();
                        }, 200);
                    }
                    $this.removeClass('is-loading');
                },
                error: function () {
                    $this.removeClass('clicked');
                    $this.removeClass('is-loading');
                }
            });
            // });

        }
        return false;
    })

    //ارسال مجدد سفارش های خطا خورده
    $j('.resend-order').click(function () {
        if (!$j(this).hasClass('clicked') && !$j(this).hasClass('is-loading')) {
            var $this = $j(this);
            var order_id = $this.attr('data-id');


            $this.addClass('clicked');
            $this.addClass('is-loading');


            $j.ajax({
                url: kando_data.ajaxurl,
                type: 'post',
                data: {
                    action: 'samyar_resend_order',
                    order_id: order_id,
                },
                success: function (response) {
                    if (!response.success) {
                        Swal.fire({
                            title: kando_data.langs.an_error,
                            icon: 'error',
                            html: response.data,
                            showCloseButton: true,
                            confirmButtonText: kando_data.langs.ok,
                        });
                        $this.removeClass('clicked');
                        $this.removeClass('is-loading');
                    } else {
                        setTimeout(function () {
                            Swal.fire({
                                // title: kando_data.langs.an_error,
                                icon: 'success',
                                html: response.data,
                                showCloseButton: true,
                                confirmButtonText: kando_data.langs.ok,
                            })
                        }, 200);
                        $j('#order-' + order_id).slideUp(500, 'easeInOutCubic');
                    }
                    $this.removeClass('is-loading');
                },
                error: function () {
                    $this.removeClass('clicked');
                    $this.removeClass('is-loading');
                }
            });


        }
        return false;
    })

    $j('.samyar-resend-refill-orders').click(function () {
        if (!$j(this).hasClass('clicked') && !$j(this).hasClass('is-loading')) {
            var $this = $j(this);

            // $this.addClass('clicked');
            $this.addClass('is-loading');

            // ktRecaptcha('send_code_again', function (token) {
            $j.ajax({
                url: kando_data.ajaxurl,
                type: 'post',
                data: {
                    action: 'samyar_resend_refill_orders',
                },
                success: function (response) {
                    if (!response.success) {
                        Swal.fire({
                            title: kando_data.langs.an_error,
                            icon: 'error',
                            html: response.data,
                            showCloseButton: true,
                            confirmButtonText: kando_data.langs.ok,
                        });
                        // $this.removeClass('clicked');
                        $this.removeClass('is-loading');
                    } else {
                        setTimeout(function () {
                            Swal.fire({
                                // title: kando_data.langs.an_error,
                                icon: 'success',
                                html: response.data,
                                showCloseButton: true,
                                confirmButtonText: kando_data.langs.ok,
                            })
                            location.reload();
                        }, 200);
                    }
                    $this.removeClass('is-loading');
                },
                error: function () {
                    $this.removeClass('clicked');
                    $this.removeClass('is-loading');
                }
            });
            // });

        }
        return false;
    })
    //ارسال مجدد سفارش های خطا خورده
    $j('.resend-refill-order').click(function () {
        if (!$j(this).hasClass('clicked') && !$j(this).hasClass('is-loading')) {
            var $this = $j(this);
            var order_id = $this.attr('data-id');


            $this.addClass('clicked');
            $this.addClass('is-loading');


            $j.ajax({
                url: kando_data.ajaxurl,
                type: 'post',
                data: {
                    action: 'samyar_resend_refill_order',
                    order_id: order_id,
                },
                success: function (response) {
                    if (!response.success) {
                        Swal.fire({
                            title: kando_data.langs.an_error,
                            icon: 'error',
                            html: response.data,
                            showCloseButton: true,
                            confirmButtonText: kando_data.langs.ok,
                        });
                        $this.removeClass('clicked');
                        $this.removeClass('is-loading');
                    } else {
                        setTimeout(function () {
                            Swal.fire({
                                // title: kando_data.langs.an_error,
                                icon: 'success',
                                html: response.data,
                                showCloseButton: true,
                                confirmButtonText: kando_data.langs.ok,
                            })
                        }, 200);
                        $j('#order-' + order_id).slideUp(500, 'easeInOutCubic');
                    }
                    $this.removeClass('is-loading');
                },
                error: function () {
                    $this.removeClass('clicked');
                    $this.removeClass('is-loading');
                }
            });


        }
        return false;
    })

    //ارسال مجدد سفارش های خطا خورده
    // $j('.kando-send-refill').click(function () {
    $j(document).on('click', '.kando-send-refill', function () {
        if (!$j(this).hasClass('clicked') && !$j(this).hasClass('is-loading')) {
            var $this = $j(this);
            var order_id = $this.attr('data-id');


            $this.addClass('clicked');
            $this.addClass('is-loading');


            $j.ajax({
                url: kando_data.ajaxurl,
                type: 'post',
                data: {
                    action: 'samyar_send_refill',
                    order_id: order_id,
                },
                success: function (response) {
                    if (!response.success) {
                        Swal.fire({
                            title: kando_data.langs.an_error,
                            icon: 'error',
                            html: response.data,
                            showCloseButton: true,
                            confirmButtonText: kando_data.langs.ok,
                        });
                        $this.removeClass('clicked');
                        $this.removeClass('is-loading');
                    } else {
                        setTimeout(function () {
                            Swal.fire({
                                // title: kando_data.langs.an_error,
                                icon: 'success',
                                html: response.data,
                                showCloseButton: true,
                                confirmButtonText: kando_data.langs.ok,
                            })
                        }, 200);
                    }
                    $this.removeClass('is-loading');
                },
                error: function () {
                    $this.removeClass('clicked');
                    $this.removeClass('is-loading');
                }
            });


        }
        return false;
    })


    //تایید سفارش در دست اقدام
    $j(document).on('click', '.kando-approve-awaiting-action', function () {
        if (!$j(this).hasClass('clicked') && !$j(this).hasClass('is-loading')) {
            var $this = $j(this);
            var order_id = $this.attr('data-id');


            $this.addClass('clicked');
            $this.addClass('is-loading');


            $j.ajax({
                url: kando_data.ajaxurl,
                type: 'post',
                data: {
                    action: 'kando_approve_awaiting_action',
                    order_id: order_id,
                },
                success: function (response) {
                    if (!response.success) {
                        Swal.fire({
                            title: kando_data.langs.an_error,
                            icon: 'error',
                            html: response.data,
                            showCloseButton: true,
                            confirmButtonText: kando_data.langs.ok,
                        });
                        $this.removeClass('clicked');
                        $this.removeClass('is-loading');
                    } else {
                        setTimeout(function () {
                            Swal.fire({
                                // title: kando_data.langs.an_error,
                                icon: 'success',
                                html: response.data,
                                showCloseButton: true,
                                confirmButtonText: kando_data.langs.ok,
                            })
                            window.location.reload();
                        }, 200);
                    }
                    $this.removeClass('is-loading');
                },
                error: function () {
                    $this.removeClass('clicked');
                    $this.removeClass('is-loading');
                }
            });


        }
        return false;
    })
}

function isJson(item) {
    item = typeof item !== "string"
        ? JSON.stringify(item)
        : item;

    try {
        item = JSON.parse(item);
    } catch (e) {
        return false;
    }

    if (typeof item === "object" && item !== null) {
        return true;
    }

    return false;
}

function onTimer(type) {
    //type is login or register or remember
    //timer
    if (!$j(type).hasClass('clicked')) {
        var count = 60;
        $j(type).addClass('clicked');
        var timer = setInterval(function () {
            // $j(type).html("ارسال مجدد (" + count-- + " ثانیه" + ")");
            $j(type).html(kando_data.langs.resend_message.replace('{count}', count--));
            if (count == 0) {
                $j(type).text(kando_data.langs.resend_label);
                $j(type).removeClass('clicked');
                clearInterval(timer)
            }
        }, 1000);
    }


}

function SamyarAjaxShowNotification() {

    $j(document).on('click', '.samyar-show-notification', function () {
        $j(".kt-show-notification-modal .kt-modal-content").html('');
        let notification_id = $j(this).attr('data-id');
        $j.ajax({
            url: kando_data.ajaxurl,
            type: 'post',
            data: {id: notification_id, action: 'show_notification_description'},
            success: function (response) {
                // if (response.success) {
                $j(".kt-show-notification-modal .kt-modal-content").html(response);
                // }
            },
            error: function () {
            }
        });


    });

}

function SamyarAjaxDeleteNotification() {
    $j(document).on('click', '.delete-notification', function () {

        Swal.fire({
            title: 'آیا شما از حذف این اطلاعیه مطمئن هستید؟',
            text: "",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: kando_data.langs.yes_delete,
            cancelButtonText: kando_data.langs.cancel
        }).then((result) => {
            let notification_id = $j(this).data('id');
            if (result.isConfirmed) {
                $j.ajax({
                    url: kando_data.ajaxurl,
                    type: 'post',
                    data: {notification_id: notification_id, action: 'samyar_notification_delete'},
                    success: function (response) {
                        if (!response.success) {
                            Swal.fire(
                                kando_data.langs.an_error,
                                response.data,
                                'error'
                            )
                        } else {
                            Swal.fire(
                                'حذف شد',
                                response.data,
                                'success'
                            )
                            window.location.reload();
                        }

                    },
                    error: function () {
                        Swal.fire({
                            title: kando_data.langs.an_error,
                            icon: 'error',
                            html: response.data,
                            showCloseButton: true,
                            confirmButtonText: kando_data.langs.ok,
                        })
                    }
                });

            }
        })
        return false;
    })
}


function SamyarShowProfileMenu() {
    $j(document).on('click', '.header-user-area-inner', function (event) {
        // event.preventDefault();

        if ($j('.header-user-area-list').is(':visible')) {
            $j('.header-user-area-list').stop(true, true).delay(200).fadeOut(150);
        } else {
            $j('.header-user-area-list').stop(true, true).delay(200).fadeIn(200);
        }

        return false;
    });

    // Closes notification dropdown on click outside the conatainer
    var mouse_is_inside = false;
    $j('.header-user-area-list').on("mouseenter", function () {
        mouse_is_inside = true;
    });
    $j('.header-user-area-list').on("mouseleave", function () {
        mouse_is_inside = false;
    });

    $j("body").mouseup(function () {
        if (!mouse_is_inside) {
            $j('.header-user-area-list').removeClass('active').slideUp(400, 'easeInOutCubic');
        }
        ;
    });

}

function SamyarAjaxDisable() {
    $j(document).on('change', '.ajax-switch', function () {
        var $this = $j(this);
        var item_id = $this.attr('data-id');
        var type = $this.attr('data-type');
        var status = $this.is(':checked');

        $j.ajax({
            url: kando_data.ajaxurl,
            type: 'post',
            data: {
                action: 'samyar_disable_' + type,
                item_id: item_id,
                // type: type,
                status: status,
            },
            success: function (response) {
                kando_show_toast(response.data);
                /*
                if (!response.success) {
                    Swal.fire({
                        title: kando_data.langs.an_error,
                        icon: 'error',
                        html: response.data,
                        showCloseButton: true,
                        confirmButtonText: kando_data.langs.ok,
                    });
                    $this.removeClass('clicked');
                    $this.removeClass('is-loading');
                } else {
                    setTimeout(function () {
                        Swal.fire({
                            // title: kando_data.langs.an_error,
                            icon: 'success',
                            html: response.data,
                            showCloseButton: true,
                            confirmButtonText: kando_data.langs.ok,
                        })
                    }, 200);
                }
*/
            },
            error: function () {

            }
        });
        // if(this.checked) {
        //     var returnVal = confirm("Are you sure?");
        //     $(this).prop("checked", returnVal);
        // }
        // $('.ajax-switch').val(this.checked);
    });
}


$j(document).on("click", ".is_drip_feed", function () {
    let _is_drip_feed = $j(".new-order-form input[name=is_drip_feed]:checked").val();
    if (_is_drip_feed) {
        $j('#drip-feed').slideDown("slow");
    } else {
        $j('#drip-feed').slideUp("slow");
    }
});

/* این برای صفحه ورود گذاشتم*/
$j(document).on("click", " .login-page > .tabs-title-holder > .tab-title", function () {
    var Tabs = $j('.login-page'),
        newTabTitle = $j(this),
        currentTab = Tabs.find('> .tabs-content-holder > .tabs-content-inner > .tab-content.active'),
        titles = Tabs.find('> .tabs-title-holder > .tab-title'),
        contentsHolder = Tabs.find('> .tabs-content-holder > .tabs-content-inner'),
        newTab = Tabs.find('.' + newTabTitle.attr('data-tab-id'));
    if (!newTabTitle.hasClass('active')) {
        contentsHolder.css('height', currentTab.outerHeight());
        currentTab.find('> .tab-content-inner').stop(true, true).animate({
            'opacity': 0
        }, 150, function () {
            currentTab.removeClass('active');
            newTab.addClass('active');
            newTab.find('> .tab-content-inner').stop(true, true).animate({
                'opacity': 1
            }, 300);
        });
        titles.removeClass('active');
        newTabTitle.addClass('active');
        contentsHolder.css('height', newTab.outerHeight());
        var timeout = contentsHolder.data("timeout") || 0;
        clearTimeout(timeout);
        timeout = setTimeout(function () {
            contentsHolder.css('height', 'auto');
        }, 600);
    }
})


jQuery(document).ready(function ($) {
    var $timeline_block = $('.cd-timeline-block');

    //hide timeline blocks which are outside the viewport
    $timeline_block.each(function () {
        if ($(this).offset().top > $(window).scrollTop() + $(window).height() * 0.75) {
            $(this).find('.cd-timeline-img, .cd-timeline-content').addClass('is-hidden');

        }
    });

    //on scolling, show/animate timeline blocks when enter the viewport
    $(window).on('scroll', function () {
        $timeline_block.each(function () {
            if ($(this).offset().top <= $(window).scrollTop() + $(window).height() * 0.75 && $(this).find('.cd-timeline-img').hasClass('is-hidden')) {
                $(this).find('.cd-timeline-img, .cd-timeline-content').removeClass('is-hidden').addClass('bounce-in');
            }
        });
    });

});

function SamyarAjaxProcessLink() {
    // $j('.process-link').click(function () {
    $j(document).on("click", ".process-link", function () {
        if (!$j(this).hasClass('clicked') && !$j(this).hasClass('is-loading')) {
            var $this = $j(this);
            // var link = $j(".new-order-form [name='link']").val();
            var link = $j(this).closest("form").find("[name='link']").val();


            $this.addClass('clicked');
            $this.addClass('is-loading');


            $j.ajax({
                url: kando_data.ajaxurl,
                type: 'post',
                data: {
                    action: 'samyar_process_link',
                    link: link,
                },
                success: function (response) {
                    if (isJson(response)) {//اگر نوعش جیسون هست یعنی خطایی رخ داده و خطا رو نشون بده
                        Swal.fire({
                            title: kando_data.langs.an_error,
                            icon: 'error',
                            html: response.data,
                            showCloseButton: true,
                            confirmButtonText: kando_data.langs.ok,
                        })
                    } else {// در غیر اینصورت جدول خدمات رو بر گردون

                        // $j(this).closest( "form" ).find( ".process-link-result")
                        $this.closest("form").find(".process-link-result").slideUp(400, 'easeInOutCubic', function () {
                            $j(this).empty().html(response).slideDown(500, 'easeInOutCubic');
                        });
                    }


                    /*
                                        if (!response.success) {
                                            Swal.fire({
                                                title: kando_data.langs.an_error,
                                                icon: 'error',
                                                html: response.data,
                                                showCloseButton: true,
                                                confirmButtonText: kando_data.langs.ok,
                                            });
                                            $this.removeClass('clicked');
                                            $this.removeClass('is-loading');
                                        } else {
                                            setTimeout(function () {
                                                Swal.fire({
                                                    // title: kando_data.langs.an_error,
                                                    icon: 'success',
                                                    html: response.data,
                                                    showCloseButton: true,
                                                    confirmButtonText: kando_data.langs.ok,
                                                })
                                            }, 200);
                                            $j('#order-' + order_id).slideUp(500, 'easeInOutCubic');
                                        }
                                        */
                    $this.removeClass('is-loading');
                    $this.removeClass('clicked');
                },
                error: function () {
                    $this.removeClass('clicked');
                    $this.removeClass('is-loading');
                }
            });


        }
        return false;
    })
}

function SamyarAjaxDeleteUpdate() {
    $j(document).on('click', '.delete-update', function () {

        Swal.fire({
            title: kando_data.langs.are_you_sure,
            text: "",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: kando_data.langs.yes_delete,
            cancelButtonText: kando_data.langs.cancel
        }).then((result) => {
            let update_id = $j(this).data('id');
            if (result.isConfirmed) {
                $j.ajax({
                    url: kando_data.ajaxurl,
                    type: 'post',
                    data: {update_id: update_id, action: 'samyar_update_delete'},
                    success: function (response) {
                        // console.log(response);
                        if (!response.success) {
                            Swal.fire(
                                kando_data.langs.an_error,
                                response.data,
                                'error'
                            )
                        } else {
                            Swal.fire(
                                'حذف شد',
                                response.data,
                                'success'
                            )
                            window.location.reload();
                        }

                    },
                    error: function () {
                        Swal.fire({
                            title: kando_data.langs.an_error,
                            icon: 'error',
                            html: response.data,
                            showCloseButton: true,
                            confirmButtonText: kando_data.langs.ok,
                        })
                    }
                });

            }
        })
        return false;
    })
}


function SamyarAjaxBulkUpdatePrice() {

    $j('.bulk-update-price-form').submit(function () {
        var $this = $j(this);
        if (!$this.hasClass('is-loading')) {
            $this.addClass('is-loading');
            $this.find('.samyar-form-loading').fadeIn(200);
            $j.ajax({
                url: kando_data.ajaxurl,
                type: 'post',
                data: $this.serialize(),
                success: function (response) {
                    if (!response.success) {
                        Swal.fire({
                            title: kando_data.langs.an_error,
                            icon: 'error',
                            html: response.data,
                            showCloseButton: true,
                            confirmButtonText: kando_data.langs.ok,
                        })
                    } else {
                        setTimeout(function () {
                            Swal.fire({
                                // title: kando_data.langs.an_error,
                                icon: 'success',
                                html: response.data,
                                showCloseButton: true,
                                confirmButtonText: kando_data.langs.ok,
                            })
                            location.reload();
                        }, 200);

                    }


                    $this.removeClass('is-loading');
                    $this.find('.samyar-form-loading').fadeOut(200);


                },
                error: function () {
                    $this.removeClass('is-loading');
                    $this.find('.samyar-form-loading').fadeOut(200);
                }
            });

        }

        return false;
    });
}

function SamyarAjaxChangeProfileAvatar() {
    $j('#kando-upload-avatar').change(function () {

        $j('#kando-upload-avatar + label').text($j('#kando-upload-avatar').prop('files')[0].name);

    });


    $j('.kando-avatar-form').submit(function () {
        var $this = $j(this),
            formData = new FormData(this);

        formData.append('file', $j('#kando-upload-avatar').prop('files')[0]);
        formData.append('action', 'kando_update_avatar');
        if (!$this.hasClass('is-loading')) {
            $this.addClass('is-loading');
            $this.find('.new-ticket-form-loading').fadeIn(200);
            $j.ajax({
                url: kando_data.ajaxurl,
                type: 'post',
                contentType: false,
                cache: false,
                processData: false,
                data: formData,
                success: function (response) {
                    // console.log(response);
                    if (response.success) {
                        setTimeout(function () {
                            Swal.fire({
                                // title: kando_data.langs.an_error,
                                icon: 'success',
                                html: response.data.message,
                                showCloseButton: true,
                                confirmButtonText: kando_data.langs.ok,
                            })
                            location.reload();
                        }, 200);

                    } else {
                        Swal.fire({
                            title: kando_data.langs.an_error,
                            icon: 'error',
                            html: response.data.upload_error,
                            showCloseButton: true,
                            confirmButtonText: kando_data.langs.ok,
                        })
                    }
                    $this.removeClass('is-loading');
                    $this.find('.new-ticket-form-loading').fadeOut(200);
                },
                error: function () {
                    $this.removeClass('is-loading');
                    $this.find('.new-ticket-form-loading').fadeOut(200);
                }
            });

        }

        return false;
    });

}

function SamyarAjaxFilterPackages() {

    $j('.filter-packages-form').submit(function () {
        var $this = $j(this);
        if (!$this.hasClass('is-loading')) {
            $this.addClass('is-loading');
            $this.find('.samyar-form-loading').fadeIn(200);
            $j.ajax({
                url: kando_data.ajaxurl,
                type: 'post',
                data: $this.serialize(),
                success: function (response) {

                    if (isJson(response) && !response.success) {
                        Swal.fire({
                            title: kando_data.langs.an_error,
                            icon: 'error',
                            html: response.data,
                            showCloseButton: true,
                            confirmButtonText: kando_data.langs.ok,
                        })
                    } else {
                        $j('#packages-body').html(response)
                    }
                    $this.removeClass('is-loading');
                    $this.find('.samyar-form-loading').fadeOut(200);
                },
                error: function () {
                    $this.removeClass('is-loading');
                    $this.find('.samyar-form-loading').fadeOut(200);
                }
            });

        }

        return false;
    });
}

function kando_copy_Link(e) {
    var copyText = document.querySelector("#" + e);
    copyText.select();
    var cc = document.execCommand("Copy");
    window.getSelection().removeAllRanges();
    if (cc) {
        kando_show_toast(kando_data.langs.copied_successfully_message);
    }
}

function kando_copy_Link_by_click(e) {
    var a = document.getElementById(e).value;
    var b = document.getElementById(e).innerHTML;
    if (a == '' && b == '') {
        return false
    }
    ;
    var copyText = document.querySelector("#" + e);
    copyText.select();
    document.execCommand("Copy");
    window.getSelection().removeAllRanges();
    kando_show_toast(kando_data.langs.copied_successfully_message);
}

//کپی پیوند
$j(document).on('click', '.CopyToClipBoard2', function (event) {
    event.preventDefault();

    var $temp = $j("<input>");
    $j("body").append($temp);
    $temp.val($j(this).attr('href')).select();
    document.execCommand("copy");
    $temp.remove();

    kando_show_toast(kando_data.langs.copied_successfully_message);
});

$j(document).on('click', '.CopyToClipBoard3', function (event) {
    event.preventDefault();
    var id = $j(this).data('copy');
    var $temp = $j("<textarea></textarea>");
    $j("body").append($temp);
    var comments = $j('#'+id).html();
    $temp.val(comments.replace(/<br>/g, '')).select();
    document.execCommand("copy");
    $temp.remove();

    kando_show_toast(kando_data.langs.copied_successfully_message);
});

function kando_show_toast(title) {


    const Toast = Swal.mixin({
        toast: true,
        position: 'bottom',
        showConfirmButton: false,
        timer: 2000
    })

    Toast.fire({
        type: 'success',
        title: title,
        customClass: {
            popup: 'copy-rad',
        }
    })

}


$j(document).on('click', '.kando-show-packages-form', function () {
    $j(".kt-send-package-modal .kt-modal-content").html('');
    let package_id = $j(this).attr('data-package');
    let type = $j(this).attr('data-type');
    $j.ajax({
        url: kando_data.ajaxurl,
        type: 'GET',
        data: {package_id: package_id, action: 'kando_show_package_form'},
        success: function (response) {
            // if (response.success) {
            $j(".kt-send-package-modal .kt-modal-content").html(response);
            // }
        },
        error: function () {
        }
    });


});


function SamyarAjaxPackageOrder() {

    // $j('.new-order-form').submit(function () {
    $j(document).on("click", ".package-form-order #place_order", function () {
        var $this = $j(".package-form-order");
        var $btn = $j(this);
        if (!$btn.hasClass('clicked') && !$btn.hasClass('is-loading')) {
            $btn.addClass('is-loading');
            $btn.addClass('clicked');

            // $this.find('.samyar-form-loading').fadeIn(200);
            $j.ajax({
                url: kando_data.ajaxurl,
                type: 'post',
                data: $this.serialize(),
                success: function (response) {

                    //اگر مرحله شروع پرداخت موفقیت آمیز بود به درگاه پرداخت برو
                    if (response.success) {
                        setTimeout(function () {
                            Swal.fire({
                                title: kando_data.langs.successful,
                                icon: 'success',
                                html: response.data.redirect_message,
                                showCloseButton: true,
                                confirmButtonText: kando_data.langs.ok,
                            })
                            if (response.data.url !== undefined) {
                                window.location = response.data.url;
                            }

                        }, 1000);
                    } else {
                        setTimeout(function () {
                            if (response.data.not_login) {
                                Swal.fire({
                                    title: kando_data.langs.an_error,
                                    icon: 'error',
                                    html: response.data.message,
                                    showCloseButton: true,
                                    confirmButtonText: kando_data.langs.ok,
                                    footer: '<a target="_blank" href="' + response.data.login_page + '">'+kando_data.langs.go_to_login_page+'</a>'
                                })
                            } else {

                                Swal.fire({
                                    title: kando_data.langs.an_error,
                                    icon: 'error',
                                    html: response.data,
                                    showCloseButton: true,
                                    confirmButtonText: kando_data.langs.ok,
                                })


                            }
                        }, 200);
                        $btn.removeClass('is-loading');
                        $btn.removeClass('clicked');
                        // $this.find('.samyar-form-loading').fadeOut(200);
                    }


                },
                error: function () {
                    $btn.removeClass('is-loading');
                    $btn.removeClass('clicked');
                    // $this.find('.samyar-form-loading').fadeOut(200);
                }
            });

        }

        return false;
    });
}


/* برای تب های صفحه ورود در ورژن 10 نوشته شده*/
$j(document).on('click', '#tab-login-mobile', function () {//ورود با موبایل
    $j(this).addClass('active');
    $j('#tab-login-email').removeClass('active');
    $j("form.kt-login-form .kt-login-email").hide();
    $j("form.kt-login-form .kt-login-mobile").show();

    $j("form.kt-login-form #login-type").val('mobile');
    $j("form.kt-login-form").find('.field-error').remove();
});

$j(document).on('click', '#tab-login-email', function () {// ورود با ایمیل
    $j(this).addClass('active');
    $j('#tab-login-mobile').removeClass('active');
    $j("form.kt-login-form .kt-login-mobile").hide();
    $j("form.kt-login-form .kt-login-email").show();

    $j("form.kt-login-form #login-type").val('email');

    $j("form.kt-login-form").find('.field-error').remove();
});

/* برای تب های صفحه فراموشی رمز عبور در ورژن 10 نوشته شده*/
$j(document).on('click', '#tab-forget-mobile', function () {//ورود با موبایل
    $j(this).addClass('active');
    $j('#tab-forget-email').removeClass('active');
    $j("form.kt-forget-form .kt-forget-email").hide();
    $j("form.kt-forget-form .kt-forget-mobile").show();

    $j("form.kt-forget-form #forget-type").val('mobile');
    $j("form.kt-forget-form").find('.field-error').remove();
});

$j(document).on('click', '#tab-forget-email', function () {// ورود با ایمیل
    $j(this).addClass('active');
    $j('#tab-forget-mobile').removeClass('active');
    $j("form.kt-forget-form .kt-forget-mobile").hide();
    $j("form.kt-forget-form .kt-forget-email").show();

    $j("form.kt-forget-form #forget-type").val('email');

    $j("form.kt-forget-form").find('.field-error').remove();
});


//ظاهر کردن فرم ثبت نام
$j(document).on('click', '.kt-register-btn', function () {// ورود با ایمیل
    $j(this).addClass('active');
    $j("#kando-login-tab").hide();
    $j("#kando-forget-tab").hide();
    $j("#kando-register-tab").show();
    return false;
});

//ظاهر کردن فرم ثبت نام
$j(document).on('click', '.kt-login-btn', function () {// ورود با ایمیل
    // $j(this).addClass('active');
    $j("#kando-login-tab").show();
    $j("#kando-register-tab").hide();
    $j("#kando-forget-tab").hide();
    return false;
});

//ظاهر کردن فرم ثبت نام
$j(document).on('click', '.kt-password-btn', function () {// ورود با ایمیل
    // $j(this).addClass('active');
    $j('.kt-login-form').show();
    $j('.kt-login-form .step2').slideDown();
    $j(".kt-verify-form").hide();
    return false;
});


//ظاهر کردن فرم ثبت نام
$j(document).on('click', '.kt-register-button', function () {// ورود با ایمیل
    $j('#kando-register-tab .tab-login-mobile').addClass('active');
    $j("#kando-login-tab").hide();
    $j("#kando-register-tab").show();
    $j("#kando-forget-tab").hide();
    return false;
});

//ظاهر کردن فرم فراموشی رمز عبور
$j(document).on('click', '.kt-forget-btn', function () {// ورود با ایمیل
    $j("#kando-login-tab").hide();
    $j("#kando-register-tab").hide();
    $j("#kando-forget-tab").show();
    return false;
});

//بررسی موبایل نام کاربری یا ایمیل
function KandoAjaxLoginStep1() {//این مرحله ایمیل یا نام کاربر و یا موبایل رو بررسی میکنه ببینه وجود داره یا خیر
    $j(document).on('click', '.kt-login-form #kando_user_process', function () {
        var $form = $j(".kt-login-form");
        var $btn = $j(this);
        var errors = $form.find('.kt-login-form-errors');
        var speed = errors.is(':empty') ? 0 : 400;
        var emailOrUsername = $form.find('.kt-login-email').val();
        var mobile = $form.find('.kt-login-mobile').val();
        var login_type = $form.find('#login-type').val();

        if (!$btn.hasClass('is-loading')) {
            $btn.addClass('is-loading');


            $j.ajax({
                url: kando_data.ajaxurl,
                type: 'post',
                data: {emailOrUsername: emailOrUsername, mobile: mobile, login_type: login_type, action: 'kando_check_user'},
                beforeSend: function () {
                    $form.find('.field-error').remove();
                    $form.find('input').removeClass('is-invalid');
                },
                success: function (response) {
                    if (response.success) { // اگر مشکلی وجود نداشت به اطلاعات کاربر درست بود
                        $j('.kt-login-form .step1').slideUp();
                        $j('.kt-login-form .step2').slideDown();
                        $btn.removeClass('is-loading');
                    } else {

                        $form.find('.kt-login-' + login_type).addClass('is-invalid');
                        $form.find('.kt-login-' + login_type).after(response.data).slideDown(1000, 'easeInOutCubic');
                        $btn.removeClass('is-loading');
                    }

                }
            });

        }
        return false;
    });
}


//بررسی موبایل نام کاربری یا ایمیل
function KandoAjaxLoginStep2() {//این مرحله ایمیل یا نام کاربر و یا موبایل رو بررسی میکنه ببینه وجود داره یا خیر
    $j(document).on('click', '.kt-login-form .kt-login-submit', function () {
        var $form = $j(".kt-login-form");
        var $redirect = $form.data('redirect');
        var $btn = $j(this);
        var errors = $form.find('.kt-login-form-errors');
        var speed = errors.is(':empty') ? 0 : 400;

        if (!$btn.hasClass('is-loading')) {
            $btn.addClass('is-loading');

            // ktRecaptcha('login', function (token) {
            $j.ajax({
                url: kando_data.ajaxurl,
                type: 'post',
                data: $form.serialize() + '&do=login'+ '&redirect=' + $redirect,
                beforeSend: function () {
                    $form.find('.field-error').remove();
                    $form.find('input').removeClass('is-invalid');
                },
                success: function (response) {
                    if (response.success) { // اگر مشکلی وجود نداشت به اطلاعات کاربر درست بود

                        kando_show_toast(response.data.message)
                        setTimeout(function () {
                            window.location.replace(response.data.redirect);
                        }, 1000);

                    } else {
                        if(kando_data.google_captcha_enable==="1"){
                            grecaptcha.reset();
                        }
                        $form.find('.kt-login-password').addClass('is-invalid');
                        $form.find('.kt-login-password').after(response.data).slideDown(1000, 'easeInOutCubic');
                        $btn.removeClass('is-loading');
                    }

                }
            });
            // });
        }
        return false;
    });
}

//ارسال رمز عبور یک بار مصرف به کاربر
function KandoAjaxSendOtpCode() {//این مرحله ایمیل یا نام کاربر و یا موبایل رو بررسی میکنه ببینه وجود داره یا خیر
    $j(document).on('click', '.kt-login-form .kt-send-otp', function () {
        var $form = $j(".kt-login-form");
        var $redirect= $form.data('redirect');
        var $btn = $j(this);
        var $SendAgainbtn = $j('#kando-login-tab .kt-verify-form .kt-verify-send-again');
        // var errors = $form.find('.kt-login-form-errors');
        // var speed = errors.is(':empty') ? 0 : 400;

        var emailOrUsername = $form.find('.kt-login-email').val();
        var mobile = $form.find('.kt-login-mobile').val();
        var type = $form.find('#login-type').val();
        var token = $form.find('.g-recaptcha-response').val();

        if (!$btn.hasClass('is-loading')) {
            $btn.addClass('is-loading');

            // ktRecaptcha('sendotp', function (token) {
            $j.ajax({
                url: kando_data.ajaxurl,
                type: 'post',
                data: {email: emailOrUsername, mobile: mobile, type: type, action: 'kando_ajax_login', do: 'send_otp_code',redirect:$redirect,token:token},
                beforeSend: function () {
                    $form.find('.field-error').remove();
                    $form.find('input').removeClass('is-invalid');
                    $form.find('.fa-3x').addClass('display-inline');
                },
                success: function (response) {
                    if (response.success) { // اگر مشکلی وجود نداشت به اطلاعات کاربر درست بود

                        kando_show_toast(response.data)
                        $j('form.kt-login-form').slideUp();
                        $j('#kando-login-tab form.kt-verify-form').slideDown();
                        $btn.removeClass('is-loading');
                        $form.find('.fa-3x').removeClass('display-inline');
                        onTimer($SendAgainbtn);

                    } else {
                        kando_show_toast(response.data);
                        $form.find('.kt-login-password').addClass('is-invalid');
                        $form.find('.kt-login-password').after(response.data).slideDown(1000, 'easeInOutCubic');
                        $btn.removeClass('is-loading');
                        $form.find('.fa-3x').removeClass('display-inline');
                        $SendAgainbtn.removeClass('clicked');
                    }

                }
            });
            // });
        }
        return false;
    });
}

function KandoAjaxSendOtpCodeAgain() {//این مرحله ایمیل یا نام کاربر و یا موبایل رو بررسی میکنه ببینه وجود داره یا خیر
    $j(document).on('click', '#kando-login-tab .kt-verify-form .kt-verify-send-again', function () {
        var $form = $j(".kt-login-form");
        var $redirect= $form.data('redirect');
        var $btn = $j(this);
        var $SendAgainbtn = $j('#kando-login-tab .kt-verify-form .kt-verify-send-again');
        // var errors = $form.find('.kt-login-form-errors');
        // var speed = errors.is(':empty') ? 0 : 400;

        var emailOrUsername = $form.find('.kt-login-email').val();
        var mobile = $form.find('.kt-login-mobile').val();
        var type = $form.find('#login-type').val();


        if (!$btn.hasClass('is-loading')) {
            $btn.addClass('is-loading');

            // ktRecaptcha('sendotp', function (token) {
            $j.ajax({
                url: kando_data.ajaxurl,
                type: 'post',
                data: {email: emailOrUsername, mobile: mobile, type: type, action: 'kando_ajax_login', do: 'send_otp_code',redirect:$redirect},
                beforeSend: function () {
                    $form.find('.field-error').remove();
                    $form.find('input').removeClass('is-invalid');
                },
                success: function (response) {
                    if (response.success) { // اگر مشکلی وجود نداشت به اطلاعات کاربر درست بود

                        kando_show_toast(response.data)
                        $btn.removeClass('is-loading');
                        // $j('form.kt-login-form').slideUp();
                        // $j('form.kt-verify-form').slideDown();

                        onTimer($btn);

                    } else {
                        kando_show_toast(response.data);
                        // $form.find('.kt-login-password').addClass('is-invalid');
                        // $form.find('.kt-login-password').after(response.data).slideDown(1000, 'easeInOutCubic');
                        $btn.removeClass('is-loading');
                        $btn.removeClass('clicked');
                    }

                }
            });
            // });
        }
        return false;
    });
}

//ارسال رمز عبور یک بار مصرف به کاربر
function KandoAjaxSendOtpCodeDashboard() {//این مرحله ایمیل یا نام کاربر و یا موبایل رو بررسی میکنه ببینه وجود داره یا خیر
    $j(document).on('click', '#kando-verify-form .kt-verify-send-again', function () {
        var $form = $j("#kando-verify-form");
        var $redirect= $form.data('redirect');
        var $btn = $j(this);
        // var $SendAgainbtn = $j('#kando-login-tab .kt-verify-form .kt-verify-send-again');
        // var errors = $form.find('.kt-login-form-errors');
        // var speed = errors.is(':empty') ? 0 : 400;

        // var emailOrUsername = $form.find('.kt-login-email').val();
        // var mobile = $form.find('.kt-login-mobile').val();
        // var type = $form.find('#login-type').val();
        // var token = $form.find('.g-recaptcha-response').val();

        if (!$btn.hasClass('is-loading')) {
            $btn.addClass('is-loading');

            // ktRecaptcha('sendotp', function (token) {
            $j.ajax({
                url: kando_data.ajaxurl,
                type: 'post',
                data: {action: 'kando_send_verify_mobile', nonce: kando_data.resend_otp_nonce},
                beforeSend: function () {
                    // $form.find('.field-error').remove();
                    // $form.find('input').removeClass('is-invalid');
                    // $form.find('.fa-3x').addClass('display-inline');
                },
                success: function (response) {
                    if (response.success) { // اگر مشکلی وجود نداشت به اطلاعات کاربر درست بود

                        kando_show_toast(response.data.message)
                        // $j('form.kt-login-form').slideUp();
                        // $j('#kando-login-tab form.kt-verify-form').slideDown();
                        // $btn.removeClass('is-loading');
                        // $form.find('.fa-3x').removeClass('display-inline');
                        $btn.removeClass('is-loading');
                        $btn.prop('disabled', true);
                        onTimer($btn);

                    } else {
                        kando_show_toast(response.data.message);
                        // $form.find('.kt-login-password').addClass('is-invalid');
                        // $form.find('.kt-login-password').after(response.data).slideDown(1000, 'easeInOutCubic');
                        $btn.removeClass('is-loading');
                        // $form.find('.fa-3x').removeClass('display-inline');
                        $btn.removeClass('clicked');
                        $btn.prop('disabled', false);
                    }

                }
            });
            // });
        }
        return false;
    });
}

//ارسال رمز عبور یک بار مصرف به کاربر
function KandoAjaxVerifyOtpCodeDashboard() {//این مرحله ایمیل یا نام کاربر و یا موبایل رو بررسی میکنه ببینه وجود داره یا خیر
    $j(document).on('click', '#kando-verify-form .kt-verify-otp-code', function () {
        var $form = $j("#kando-verify-form");
        var $redirect= $form.data('redirect');
        var $btn = $j(this);
        // var $SendAgainbtn = $j('#kando-login-tab .kt-verify-form .kt-verify-send-again');
        // var errors = $form.find('.kt-login-form-errors');
        // var speed = errors.is(':empty') ? 0 : 400;

        // var emailOrUsername = $form.find('.kt-login-email').val();
        // var mobile = $form.find('.kt-login-mobile').val();
        // var type = $form.find('#login-type').val();
        // var token = $form.find('.g-recaptcha-response').val();

        if (!$btn.hasClass('is-loading')) {
            $btn.addClass('is-loading');

            // ktRecaptcha('sendotp', function (token) {
            $j.ajax({
                url: kando_data.ajaxurl,
                type: 'post',
                data: $form.serialize() + '&nonce=' + kando_data.resend_otp_nonce,
                beforeSend: function () {
                },
                success: function (response) {
                    if (response.success) { // اگر مشکلی وجود نداشت به اطلاعات کاربر درست بود

                        kando_show_toast(response.data.message)
                        $btn.removeClass('is-loading');
                        $btn.prop('disabled', true);
                        setTimeout(function () {
                            window.location.replace(response.data.redirect);
                        }, 1000);

                    } else {
                        kando_show_toast(response.data);
                        $btn.removeClass('is-loading');
                        $btn.removeClass('clicked');
                        $btn.prop('disabled', false);
                    }

                }
            });
            // });
        }
        return false;
    });
}


function KandoAjaxLoginByOtp() {//این مرحله ایمیل یا نام کاربر و یا موبایل رو بررسی میکنه ببینه وجود داره یا خیر
    $j(document).on('click', '#kando-login-tab .kt-verify-form .kt-verify-otp-code', function () {
        var $form = $j("#kando-login-tab .kt-verify-form");
        var $redirect = $form.data("redirect")
        var $btn = $j(this);
        // var errors = $form.find('.kt-login-form-errors');
        // var speed = errors.is(':empty') ? 0 : 400;

        var emailOrUsername = $j(".kt-login-form").find('.kt-login-email').val();
        var mobile = $j(".kt-login-form").find('.kt-login-mobile').val();
        var type = $j(".kt-login-form").find('#login-type').val();


        if (!$btn.hasClass('is-loading')) {
            $btn.addClass('is-loading');

            // ktRecaptcha('loginbyotp', function (token) {
            $j.ajax({
                url: kando_data.ajaxurl,
                type: 'post',
                data: $form.serialize() + '&email=' + emailOrUsername + '&mobile=' + mobile + '&type=' + type + '&redirect=' + $redirect + '&action=kando_ajax_login&do=login_by_otp',
                beforeSend: function () {
                    $form.find('.field-error').remove();
                    $form.find('input').removeClass('is-invalid');
                },
                success: function (response) {
                    if (response.success) { // اگر مشکلی وجود نداشت به اطلاعات کاربر درست بود

                        kando_show_toast(response.data.message)
                        setTimeout(function () {
                            window.location.replace(response.data.redirect);
                        }, 1000);

                    } else {
                        kando_show_toast(response.data)
                        $btn.removeClass('is-loading');
                    }

                }
            });
            // });
        }
        return false;
    });
}

//بررسی موبایل کاربر برای ثبت نام
function KandoAjaxRegisterStep1() {//این مرحله ایمیل یا نام کاربر و یا موبایل رو بررسی میکنه ببینه وجود داره یا خیر
    $j(document).on('click', '.kt-register-form #kando_user_process_for_register', function () {
        var $form = $j(".kt-register-form");
        var $btn = $j(this);
        var mobile = $form.find('.kt-register-mobile').val();
        var  $redirect = $form.data('redirect');
        var token = $form.find('.g-recaptcha-response').val();
        if (!$btn.hasClass('is-loading')) {
            $btn.addClass('is-loading');

            $j.ajax({
                url: kando_data.ajaxurl,
                type: 'post',
                data: {mobile: mobile, do: 'check_mobile', action: 'kando_ajax_register',redirect:$redirect,token:token},
                beforeSend: function () {
                    $form.find('.field-error').remove();
                    $form.find('input').removeClass('is-invalid');
                },
                success: function (response) {
                    if (response.success) { // اگر مشکلی وجود نداشت به اطلاعات کاربر درست بود
                        $j('.kt-register-form .step1').slideUp();
                        $j('.kt-register-form .step2').slideDown();
                    } else {

                        $form.find('.kt-register-mobile').addClass('is-invalid');
                        $form.find('.kt-register-mobile').after(response.data).slideDown(1000, 'easeInOutCubic');
                        $btn.removeClass('is-loading');
                    }

                }
            });

        }
        return false;
    });
}

function KandoAjaxRegisterStep2() {
    $j(document).on('click', '.kt-register-form #kando_check_password', function () {
        var $form = $j(".kt-register-form");
        var  $redirect = $form.data('redirect');
        var $btn = $j(this);
        var $SendAgainbtn = $j('#kando-register-tab .kt-verify-form .kt-verify-send-again');
        var password = $form.find('.kt-register-password').val();
        var mobile = $form.find('.kt-register-mobile').val();
        var name = $form.find('.kt-register-name').val();
        var token = $form.find('.g-recaptcha-response').val();
        if (!$btn.hasClass('is-loading')) {
            $btn.addClass('is-loading');

            $j.ajax({
                url: kando_data.ajaxurl,
                type: 'post',
                data: {mobile: mobile, name: name, password: password, do: 'check_password', action: 'kando_ajax_register',redirect:$redirect,token:token},
                beforeSend: function () {
                    $form.find('.field-error').remove();
                    $form.find('input').removeClass('is-invalid');
                },
                success: function (response) {
                    if (response.success) { // اگر مشکلی وجود نداشت به اطلاعات کاربر درست بود

                        if (kando_data.enable_sms === "1") {//اگر سیستم پیامک فعال هست
                            kando_show_toast(response.data)
                            $j('form.kt-register-form').slideUp();
                            $j('#kando-register-tab form.kt-verify-form').slideDown();
                        } else {
                            kando_show_toast(response.data.message)
                            setTimeout(function () {
                                window.location.replace(response.data.redirect);
                            }, 1000);
                        }


                        onTimer($SendAgainbtn);


                    } else {
                        if(kando_data.google_captcha_enable==="1"){
                            grecaptcha.reset();
                        }
                        kando_show_toast(response.data)
                        // $form.find('.kt-register-password').addClass('is-invalid');
                        // $form.find('.kt-register-password').after(response.data).slideDown(1000, 'easeInOutCubic');
                        $btn.removeClass('is-loading');
                    }

                }
            });

        }
        return false;
    });
}

function KandoAjaxRegisterStep3() {//این مرحله ایمیل یا نام کاربر و یا موبایل رو بررسی میکنه ببینه وجود داره یا خیر
    $j(document).on('click', '#kando-register-tab .kt-verify-form .kt-verify-otp-code', function () {
        var $form = $j("#kando-register-tab .kt-verify-form");
        var  $redirect = $form.data('redirect');
        var $btn = $j(this);
        // var errors = $form.find('.kt-login-form-errors');
        // var speed = errors.is(':empty') ? 0 : 400;

        var password = $j(".kt-register-form").find('.kt-register-password').val();
        var mobile = $j(".kt-register-form").find('.kt-register-mobile').val();
        var name = $j(".kt-register-form").find('.kt-register-name').val();

        if (!$btn.hasClass('is-loading')) {
            $btn.addClass('is-loading');

            // ktRecaptcha('register', function (token) {
            $j.ajax({
                url: kando_data.ajaxurl,
                type: 'post',
                data: $form.serialize() + '&password=' + password + '&mobile=' + mobile + '&name=' + name +'&redirect=' + $redirect + '&action=kando_ajax_register&do=register',
                beforeSend: function () {
                    $form.find('.field-error').remove();
                    $form.find('input').removeClass('is-invalid');
                },
                success: function (response) {
                    if (response.success) { // اگر مشکلی وجود نداشت به اطلاعات کاربر درست بود

                        kando_show_toast(response.data.message)
                        setTimeout(function () {
                            window.location.replace(response.data.redirect);
                        }, 1000);

                    } else {
                        kando_show_toast(response.data)
                        $btn.removeClass('is-loading');
                    }

                }
            });
            // });
        }
        return false;
    });
}

function KandoAjaxSendOtpCodeAgainRegister() {//این مرحله ایمیل یا نام کاربر و یا موبایل رو بررسی میکنه ببینه وجود داره یا خیر
    $j(document).on('click', '#kando-register-tab .kt-verify-form .kt-verify-send-again', function () {
        var $form = $j(".kt-register-form");
        var $btn = $j(this);
        var $SendAgainbtn = $j('#kando-register-tab .kt-verify-form .kt-verify-send-again');
        // var errors = $form.find('.kt-login-form-errors');
        // var speed = errors.is(':empty') ? 0 : 400;

        var mobile = $form.find('.kt-register-mobile').val();


        if (!$btn.hasClass('is-loading')) {
            $btn.addClass('is-loading');

            // ktRecaptcha('sendotp', function (token) {
            $j.ajax({
                url: kando_data.ajaxurl,
                type: 'post',
                data: {mobile: mobile, action: 'kando_ajax_register', do: 'send_otp_code'},
                beforeSend: function () {
                    $form.find('.field-error').remove();
                    $form.find('input').removeClass('is-invalid');
                },
                success: function (response) {
                    if (response.success) { // اگر مشکلی وجود نداشت به اطلاعات کاربر درست بود

                        kando_show_toast(response.data)
                        $btn.removeClass('is-loading');
                        // $j('form.kt-login-form').slideUp();
                        // $j('form.kt-verify-form').slideDown();

                        onTimer($btn);

                    } else {
                        kando_show_toast(response.data);
                        // $form.find('.kt-login-password').addClass('is-invalid');
                        // $form.find('.kt-login-password').after(response.data).slideDown(1000, 'easeInOutCubic');
                        $btn.removeClass('is-loading');
                        $btn.removeClass('clicked');
                    }

                }
            });
            // });
        }
        return false;
    });
}


//بررسی موبایل نام کاربری یا ایمیل
function KandoAjaxForgetStep1() {//این مرحله ایمیل یا نام کاربر و یا موبایل رو بررسی میکنه ببینه وجود داره یا خیر
    $j(document).on('click', '.kt-forget-form #kando_user_process', function () {
        var $form = $j(".kt-forget-form");
        var $btn = $j(this);
        var $SendAgainbtn = $j('#kando-forget-tab .kt-forget-form .kt-verify-send-again');
        var errors = $form.find('.kt-forget-form-errors');
        var speed = errors.is(':empty') ? 0 : 400;
        var emailOrUsername = $form.find('.kt-forget-email').val();
        var mobile = $form.find('.kt-forget-mobile').val();
        var forget_type = $form.find('#forget-type').val();
        var token = $form.find('.g-recaptcha-response').val();

        if (!$btn.hasClass('is-loading')) {
            $btn.addClass('is-loading');


            $j.ajax({
                url: kando_data.ajaxurl,
                type: 'post',
                data: {emailOrUsername: emailOrUsername, mobile: mobile, forget_type: forget_type, do: 'check_user', action: 'kando_ajax_forget', token: token},
                beforeSend: function () {
                    $form.find('.field-error').remove();
                    $form.find('input').removeClass('is-invalid');
                },
                success: function (response) {
                    if (response.success) { // اگر مشکلی وجود نداشت به اطلاعات کاربر درست بود
                        kando_show_toast(response.data);
                        $j('.kt-forget-form .step1').slideUp();
                        $j('.kt-forget-form .step2').slideDown();

                        onTimer($SendAgainbtn);

                    } else {
                        if(kando_data.google_captcha_enable==="1"){
                            grecaptcha.reset();
                        }
                        kando_show_toast(response.data);
                        // $form.find('.kt-forget-' + forget_type).addClass('is-invalid');
                        // $form.find('.kt-forget-' + forget_type).after(response.data.message).slideDown(1000, 'easeInOutCubic');
                        $btn.removeClass('is-loading');
                    }

                }
            });

        }
        return false;
    });
}

//بررسی کد تایید پیامک برای بازیابی رمز عبور
function KandoAjaxForgetStep2() {
    $j(document).on('click', '.kt-forget-form .kt-verify-otp-code', function () {
        var $form = $j(".kt-forget-form");
        var $btn = $j(this);
        var errors = $form.find('.kt-forget-form-errors');
        var speed = errors.is(':empty') ? 0 : 400;

        var emailOrUsername = $form.find('.kt-forget-email').val();
        var mobile = $form.find('.kt-forget-mobile').val();
        var forget_type = $form.find('#forget-type').val();

        if (!$btn.hasClass('is-loading')) {
            $btn.addClass('is-loading');

            // ktRecaptcha('sendotp', function (token) {
            $j.ajax({
                url: kando_data.ajaxurl,
                type: 'post',
                // data: {emailOrUsername: emailOrUsername,mobile: mobile,forget_type: forget_type,do:'check_otp',action: 'kando_ajax_forget'},
                data: $form.serialize() + '&do=save_password',
                beforeSend: function () {
                    $form.find('.field-error').remove();
                    $form.find('input').removeClass('is-invalid');
                },
                success: function (response) {
                    if (response.success) { // اگر مشکلی وجود نداشت به اطلاعات کاربر درست بود
                        kando_show_toast(response.data);
                        $j("#kando-login-tab").show();
                        $j("#kando-register-tab").hide();
                        $j("#kando-forget-tab").hide();
                        // $j('.kt-forget-form .step1').slideUp();
                        // $j('.kt-forget-form .step2').slideDown();

                    } else {
                        kando_show_toast(response.data);
                        // $form.find('.kt-forget-' + forget_type).addClass('is-invalid');
                        // $form.find('.kt-forget-' + forget_type).after(response.data).slideDown(1000, 'easeInOutCubic');
                        $btn.removeClass('is-loading');
                    }

                }
            });
            // });
        }
        return false;
    });
}

function KandoAjaxSendOtpCodeAgainForget() {//این مرحله ایمیل یا نام کاربر و یا موبایل رو بررسی میکنه ببینه وجود داره یا خیر
    $j(document).on('click', '#kando-forget-tab .kt-forget-form .kt-verify-send-again', function () {
        var $form = $j(".kt-forget-form");
        var $btn = $j(this);
        var $SendAgainbtn = $j('#kando-forget-tab .kt-verify-form .kt-verify-send-again');
        // var errors = $form.find('.kt-login-form-errors');
        // var speed = errors.is(':empty') ? 0 : 400;

        var mobile = $form.find('.kt-forget-mobile').val();


        if (!$btn.hasClass('is-loading')) {
            $btn.addClass('is-loading');

            // ktRecaptcha('sendotp', function (token) {
            $j.ajax({
                url: kando_data.ajaxurl,
                type: 'post',
                data: {mobile: mobile, action: 'kando_ajax_forget', do: 'send_otp_code'},
                beforeSend: function () {
                    $form.find('.field-error').remove();
                    $form.find('input').removeClass('is-invalid');
                },
                success: function (response) {
                    if (response.success) { // اگر مشکلی وجود نداشت به اطلاعات کاربر درست بود

                        kando_show_toast(response.data)
                        $btn.removeClass('is-loading');
                        // $j('form.kt-login-form').slideUp();
                        // $j('form.kt-verify-form').slideDown();

                        onTimer($btn);

                    } else {
                        kando_show_toast(response.data);
                        // $form.find('.kt-login-password').addClass('is-invalid');
                        // $form.find('.kt-login-password').after(response.data).slideDown(1000, 'easeInOutCubic');
                        $btn.removeClass('is-loading');
                        $btn.removeClass('clicked');
                    }

                }
            });
            // });
        }
        return false;
    });
}

//نمایش فیلد کوپن
function kando_show_coupon() {
    $j(document).on('click', '.showcoupon', function () {
        $j('.checkout_coupon').toggle(700, 'easeInOutCubic');
        return false;
    });

    $j(document).on('click', '.show-api-input', function () {
        $j('#api-key-edit').prop("disabled", false);
        return false;
    });


}


//
function KandoAjaxApplyCoupon() {//این مرحله ایمیل یا نام کاربر و یا موبایل رو بررسی میکنه ببینه وجود داره یا خیر
    $j(document).on('click', '.apply_coupon', function () {
        // var $form = $j(".kt-forget-form");
        var $btn = $j(this);
        // var $SendAgainbtn = $j('#kando-forget-tab .kt-verify-form .kt-verify-send-again');
        // var errors = $form.find('.kt-login-form-errors');
        // var speed = errors.is(':empty') ? 0 : 400;

        var amount = $j('#topup_amount').val();
        var coupon_code = $j('#coupon_code').val();


        if (!$btn.hasClass('is-loading')) {
            $btn.addClass('is-loading');

            // ktRecaptcha('sendotp', function (token) {
            $j.ajax({
                url: kando_data.ajaxurl,
                type: 'post',
                data: {code: coupon_code, price: amount, action: 'kando_ajax_apply_coupon'},
                beforeSend: function () {
                    // $form.find('.field-error').remove();
                    // $form.find('input').removeClass('is-invalid');
                },
                success: function (response) {
                    if (response.success) { // اگر مشکلی وجود نداشت به اطلاعات کاربر درست بود

                        kando_show_toast(response.data)
                        $btn.removeClass('is-loading');
                        // $j('form.kt-login-form').slideUp();
                        // $j('form.kt-verify-form').slideDown();

                        // onTimer($btn);

                    } else {
                        kando_show_toast(response.data);
                        // $form.find('.kt-login-password').addClass('is-invalid');
                        // $form.find('.kt-login-password').after(response.data).slideDown(1000, 'easeInOutCubic');
                        $btn.removeClass('is-loading');
                        $btn.removeClass('clicked');
                    }

                }
                // });
            });
        }
        return false;
    });
}

function kandoNotificationAlert() {

    $j('#notification-type').on('change', function () {
        var $type = $j('#notification-type').val();
        if ($type === "alert") {
            $j("#alert-section").slideDown();
        } else {
            $j("#alert-section").slideUp();
        }
    });
}

function kandoChangeLanguage(){
    jQuery(document).ready(function ($) {
        $('.kando-language-icon').on('click', function () {
            $('.kando-language-dropdown').toggleClass('active');
        });

        $('#kando-language-selector').on('change', function () {
            $j.ajax({
                url: kando_data.ajaxurl,
                type: 'post',
                data: $('#kando-change-language').serialize(),
                success: function (response) {

                    if (!response.success) {
                        Swal.fire({
                            title: kando_data.langs.an_error,
                            icon: 'error',
                            html: response.data,
                            showCloseButton: true,
                            confirmButtonText: kando_data.langs.ok,
                        })
                    } else {
                        setTimeout(function () {
                            Swal.fire({
                                // title: kando_data.langs.an_error,
                                icon: 'success',
                                html: response.data,
                                showCloseButton: true,
                                confirmButtonText: kando_data.langs.ok,
                            })
                            window.location.reload();
                        }, 200);

                    }
                },
                error: function () {
                }
            });
        });
    });
}
$j(document).on('click', '.kando-select-order', function () {
    var $btn = $j(this);
    $j(".kando-select-order").removeClass('multi-btn');
    $btn.addClass('multi-btn');
    var type = $btn.attr('href');
    // console.log(type);
    if (type === "#new_order") {
        $j("form.new-order-form").show();
        $j("form.mass-order-form").hide();
    } else {
        $j("form.new-order-form").hide();
        $j("form.mass-order-form").show();
    }

    return false;
});

$j(document).on('click', '#cb-select-all-0,#cb-select-all-1', function () {
    $j('.shop_table input.kando-cb-checkbox:checkbox').prop('checked', this.checked);
});

$j(document).on('click', '.kando-show-order-filter', function () {
    $j('.filter-orders-form').toggle();
    return false;
});

$j(document).on('click', '.kando-show-refill-order-filter', function () {
    $j('.filter-refill-orders-form').toggle();
    return false;
});


$j(document).on('click', '.kando-show-payment-filter', function () {
    $j('.filter-payments-form').toggle();
    return false;
});
$j(document).on('click', '.kando-show-tickets-filter', function () {
    $j('.filter-tickets-form').toggle();
    return false;
});
$j(document).on('click', '.kando-show-services-search', function () {
    $j('.filter-services-form').toggle();
    return false;
});
$j(document).on('click', '.kando-show-services-filter', function () {
    $j('.filter-services-form2').toggle();
    return false;
});


$j(document).on('click', '.brand-category', function (event) {
    event.preventDefault();
    var brand = jQuery(this).data('id');

    jQuery('.new-api-form-outer').find('.samyar-form-loading').fadeIn(200);
    // $('#orderform-category').html("");
    jQuery("#samyar_select_category").val(0);
    $j('#select-order-service').slideUp(400, 'easeOutCubic');
    jQuery("#samyar_select_category option").each(function () {

        if (brand == "others") {//اگر گفته دیگر رو نشون بده

            if (jQuery(this).data('brand') === "") {
                jQuery(this).show();
            } else {
                jQuery(this).hide();
            }
        } else if (brand == "all") {//اگر گفته همه رو نشون بده
            jQuery(this).show();
        } else if (jQuery(this).data('brand') !== brand) {
            jQuery(this).hide();
        } else {
            jQuery(this).show();
        }
        if (jQuery(this).val() == 0) {
            jQuery(this).show();
        }
    });


    jQuery('#samyar_select_category').trigger('change');

    jQuery('.new-api-form-outer').find('.samyar-form-loading').fadeOut(200);

});

//تغییر وضعیت پرداخت

$j(document).on("change", "select.kando-select-new-payment-status", function () {

    let status = this.value;
    if (status === "1") {
        $j('.refund').show();
    } else {
        $j('.refund').hide();
    }
})


$j(document).on('click', '.kando-change-payment-status', function (event) {
    event.preventDefault();
    var $this = $j(this);
    var $id = $j(this).data('id')
    var $status = $j(this).data('status')
    console.log($status);
    $j('#kando-select-new-payment-status').val($status).change();


    const {value: formValues} = Swal.fire({
        title: 'لطفا وضعیت مورد نظر را انتخاب نمایید',
        text: "توجه:اگر وضعیت را از ناموفق به موفق تغییر دهید مبلغ به کیف پول اضافه خواهد شد",
        html:
            '<select class="swal2-select kando-select-new-payment-status" id="kando-select-new-payment-status" style="display: flex;"><option value="" disabled="">انتخاب وضعیت</option><option value="0">ناموفق</option><option value="1">موفق</option></select>' +
            '<input type="checkbox" value="1" class="kando-cb-checkbox" id="cb-select-all-11" name="cb-select-all-11">\n' +
            '<label class="refund" style="padding-right: 36px; position: relative; cursor: pointer; font-size: 18px;text-align: right;display: none;" for="cb-select-all-11">مبلغ به کیف پول واریز شود</label>',
        inputPlaceholder: 'انتخاب وضعیت',
        showCancelButton: true,
        confirmButtonText: 'اعمال کن',
        cancelButtonText: 'بی خیال',
        showLoaderOnConfirm: true,
        preConfirm: () => {
            var checked = 0;
            if ($j('#cb-select-all-11').is(':checked')) {
                checked = 1;
            }
            return [
                checked,
                document.getElementById('kando-select-new-payment-status').value
            ]
        }
    }).then((result) => {
        if (result.isConfirmed) {

            $j.ajax({
                url: kando_data.ajaxurl,
                type: 'post',
                data: {
                    action: 'kando_change_payment_status',
                    refund: result.value[0],
                    new_status: result.value[1],
                    id: $id,
                },
                success: function (response) {
                    if (!response.success) {
                        Swal.fire({
                            title: kando_data.langs.an_error,
                            icon: 'error',
                            html: response.data,
                            showCloseButton: true,
                            confirmButtonText: kando_data.langs.ok,
                        });
                        // $this.removeClass('clicked');
                        $this.removeClass('is-loading');
                    } else {
                        setTimeout(function () {
                            Swal.fire({
                                // title: kando_data.langs.an_error,
                                icon: 'success',
                                html: response.data,
                                showCloseButton: true,
                                confirmButtonText: kando_data.langs.ok,
                            })
                            window.location.reload();
                        }, 200);
                    }
                    $this.removeClass('is-loading');
                },
                error: function () {
                    $this.removeClass('clicked');
                    $this.removeClass('is-loading');
                }
            });
        }
    })


    return false;
})


//ارسال مجدد سفارش های خطا خورده
$j(document).on("click", ".show-other-types", function () {
    $j('.link-type-fieldset').show();
    $j('.show-other-types').hide();
    return false;
})

$j(document).on('click', '.kando-change-service-status', function (event) {
    var $this = $j(this);

    const {value: formValues} = Swal.fire({
        title: 'لطفا عملیات مورد نظر را انتخاب نمایید',
        html:
            '<select class="swal2-select kando-select-new-status" id="kando-select-service-status" style="display: flex;"><option value="" disabled="">انتخاب وضعیت</option><option value="1">فعال سازی</option><option value="0">غیرفعال سازی</option><option value="2">حذف</option></select>' +
            '<input type="checkbox" value="1" class="kando-cb-checkbox" id="cb-select-all-11" name="cb-select-all-11">',
        inputPlaceholder: 'انتخاب وضعیت',
        showCancelButton: true,
        confirmButtonText: 'اعمال کن',
        cancelButtonText: 'بی خیال',
        showLoaderOnConfirm: true,
        preConfirm: () => {
            var checked = 0;
            if ($j('#cb-select-all-11').is(':checked')) {
                checked = 1;
            }
            return [
                checked,
                document.getElementById('kando-select-service-status').value
            ]
        }
    }).then((result) => {
        if (result.isConfirmed) {
            var services = [];
            $j('.shop_table input.kando-cb-checkbox:checked').each(function () {
                services.push($j(this).attr('name'));
            });

            $j.ajax({
                url: kando_data.ajaxurl,
                type: 'post',
                data: {
                    action: 'kando_change_service_status',
                    new_status: result.value[1],
                    services: services,
                },
                success: function (response) {
                    if (!response.success) {
                        Swal.fire({
                            title: kando_data.langs.an_error,
                            icon: 'error',
                            html: response.data,
                            showCloseButton: true,
                            confirmButtonText: kando_data.langs.ok,
                        });
                        // $this.removeClass('clicked');
                        $this.removeClass('is-loading');
                    } else {
                        setTimeout(function () {
                            Swal.fire({
                                // title: kando_data.langs.an_error,
                                icon: 'success',
                                html: response.data,
                                showCloseButton: true,
                                confirmButtonText: kando_data.langs.ok,
                            })
                            window.location.reload();
                        }, 200);
                    }
                    $this.removeClass('is-loading');
                },
                error: function () {
                    $this.removeClass('clicked');
                    $this.removeClass('is-loading');
                }
            });
        }
    })


    return false;
})


$j(document).on("click", " .kando-tabs > .tabs-title-holder > .tab-title", function () {
    var Tabs = $j('.kando-tabs'),
        newTabTitle = $j(this),
        currentTab = Tabs.find('> .tabs-content-holder > .tabs-content-inner > .tab-content.active'),
        titles = Tabs.find('> .tabs-title-holder > .tab-title'),
        contentsHolder = Tabs.find('> .tabs-content-holder > .tabs-content-inner'),
        newTab = Tabs.find('.' + newTabTitle.attr('data-tab-id'));

    if (!newTabTitle.hasClass('active')) {
        // contentsHolder.css('height', currentTab.outerHeight());
        currentTab.find('> .tab-content-inner').stop(true, true).animate({
            'display': 'none'
        }, 150, function () {
            currentTab.removeClass('active');
            newTab.addClass('active');
            newTab.find('> .tab-content-inner').stop(true, true).animate({
                'display': 'block'
            }, 300);
        });
        titles.removeClass('active');
        newTabTitle.addClass('active');
        // contentsHolder.css('height', newTab.outerHeight());
        // var timeout = contentsHolder.data("timeout") || 0;
        // clearTimeout(timeout);
        // timeout = setTimeout(function () {
        //     contentsHolder.css('height', 'auto');
        // }, 600);
    }
})


jQuery(document).on('focus',".hasDatepicker", function(){
    jQuery(this).persianDatepicker({
        initialValue: false,
        format: 'YYYY-MM-DD',
        initialValueType: 'persian',
    });

});



// $j(document).on('click', '.btn-toggler', function () {
//     var $this = $j(this);
//     var alert_id = $this.data('id')
//     $j('#'+alert_id).addClass('active');
//     $j('#'+alert_id).toggle(700, 'easeInOutCubic');
//     return false;
// });

/*
function KandoAjaxSendOtpCodeAgain() {
    $j(document).on('click', '.kt-verify-form .kt-verify-send-again', function () {

        var $form = $j(".kt-verify-form");
        var $btn = $j(this);
        // var errors = $form.find('.kt-login-form-errors');
        // var speed = errors.is(':empty') ? 0 : 400;

        var emailOrUsername = $j(".kt-login-form").find('.kt-login-email').val();
        var mobile = $j(".kt-login-form").find('.kt-login-mobile').val();
        var type = $j(".kt-login-form").find('#login-type').val();


        if (!$btn.hasClass('clicked') && !$btn.hasClass('is-loading')) {
            $btn.addClass('clicked');
            $btn.addClass('is-loading');

            ktRecaptcha('sendotpAgain', function (token) {
                $j.ajax({
                    url: kando_data.ajaxurl,
                    type: 'post',
                    data: $form.serialize() + '&token=' + token + '&email=' + emailOrUsername + '&mobile=' + mobile+ '&type=' + type+ '&action=kando_ajax_login&do=send_otp_code',
                    beforeSend: function () {

                    },
                    success: function (response) {
                        if (response.success) { // اگر مشکلی وجود نداشت به اطلاعات کاربر درست بود


                            // response = $j(response);
                            if (response.success) {
                                kando_show_toast(response.data);
                                $btn.removeClass('is-loading');
                                onTimer('.kt-verify-form .kt-verify-send-again');
                            } else {
                                kando_show_toast(response.data);
                                $btn.removeClass('is-loading');
                                $btn.removeClass('clicked');
                            }

                        } else {
                            kando_show_toast(response.data)
                            $btn.removeClass('is-loading');
                            $btn.removeClass('clicked');
                        }

                    }
                });
            });
        }
        return false;

    })
}
*/

//end by morteza

/*
introJs().setOptions({
    exitOnOverlayClick: false,
    nextLabel: 'بعد',
    prevLabel: 'قبل',
    doneLabel: 'اتمام',
    steps: [{
        title: 'سلام',
        intro: 'به پنل مدیریت کندو پنل خوش آمدید 👋'
    },
        {
            element: document.querySelector('.api-providers'),
            intro: 'ابتدا باید سایت خود را به حداقل یک ارائه دهنده متصل نمایید'
        },
        {
            title: 'Farewell!',
            element: document.querySelector('.card__image'),
            intro: 'And this is our final step!'
        }]
}).start();
*/
// add a flag when we're done
/*
var introguide = introJs();
window.addEventListener('load', function () {
    var doneTour = localStorage.getItem('EventTour') === 'Completed';

    if (doneTour) {
        return;
    }else {
    introguide.setOptions({
        exitOnOverlayClick: false,
        disableInteraction:false,
        nextLabel: 'بعد',
        prevLabel: 'قبل',
        doneLabel: 'اتمام',
        steps: [{
            title: 'سلام',
            intro: 'به پنل مدیریت کندو پنل خوش آمدید 👋'
        },
            {
                element: document.querySelector('.api-providers'),
                intro: 'ابتدا باید سایت خود را به حداقل یک ارائه دهنده متصل نمایید'
            },
            {
                element: document.querySelector('.add-api-provider'),
                intro: 'سپس بر روی این دکمه کلیک کنید'
            }]
    }).start();

        introguide.oncomplete(function () {
            localStorage.setItem('EventTour', 'Completed');
        });

        introguide.onexit(function () {
            localStorage.setItem('EventTour', 'Completed');
        });
    }
});
*/
