jQuery(document).ready(function ($) {

    function kando_base_rate_text($base_rate) {
        switch ($base_rate) {
            case "IRT":
                return kando_data.langs.currency_toman;
                break;
            case "USD":
                return kando_data.langs.currency_dollar;
                break;
            case "AFN":
                return kando_data.langs.currency_afghani;
                break;
            default:
                return "";
                break;
        }
    }

    if ($('.samyar-settings-area').length) {

        var currentHash = window.location.hash,
            thisToggle,
            $toggle;


        if (currentHash) {
            currentHash = currentHash.split('#');
            currentHash = currentHash[1];
        } else {
            currentHash = false;
        }

        if (!currentHash) {

            if ($('.uk-list-divider li.samyar-menu-item a.samyar-active').length) {
                thisToggle = $('.uk-list-divider li.samyar-menu-item a.samyar-active');
            } else {
                thisToggle = $('.uk-list-divider li.samyar-menu-item:nth-child(2) a');
            }

            $toggle = thisToggle.data('toggle');

        } else {

            thisToggle = $('.uk-list-divider li.samyar-menu-item a[data-toggle="' + currentHash + '"]');
            $toggle = thisToggle.data('toggle');

        }

        $('li.samyar-menu-item a').removeClass('samyar-active');
        $('.samyar-settings-area').removeClass('samyar-active');


        thisToggle.addClass('samyar-active');
        $('.samyar-settings-' + $toggle).addClass('samyar-active');

        var menuItem = $('.samyar-menu-item a');
        menuItem.click(function (e) {
            e.preventDefault();
            var $this = $(this);
            var $toggle = $this.data('toggle');

            window.location.hash = $toggle;

            $('.samyar-menu-item a').removeClass('samyar-active');
            $this.addClass('samyar-active');

            $('.samyar-settings-area').removeClass('samyar-active');
            $('.samyar-settings-' + $toggle).addClass('samyar-active');
        });

        /*
        $('body').on('click', 'a.toggle-panel-link', function (e) {

            e.preventDefault();
            var thisToggle = $(this),
                thisPanelTitle = thisToggle.html(),
                thisPanelName = thisToggle.data('panel');

            window.location.hash = thisPanelName;

            $('.ticketa-page-panel > article > h3 > span.panel-title').html(thisPanelTitle);

            $('a.toggle-panel-link').removeClass('current');
            thisToggle.addClass('current');
            $('.panel-hidden').hide();
            $('.panel-hidden[data-panel="' + thisPanelName + '"]').show();

        });
*/
    }

    /*
    var menuItem = $('.samyar-menu-item a');
    menuItem.click(function (e) {
        e.preventDefault();
        var $this = $(this);
        var $toggle = $this.data('toggle');
        $('.samyar-menu-item a').removeClass('samyar-active');
        $this.addClass('samyar-active');
        $('.samyar-settings-area').removeClass('samyar-active');
        $('.samyar-settings-' + $toggle).addClass('samyar-active');
    });
*/
    $(".samyar-confirm").click(function () {
        var $this = $(this);
        var $toggle = $this.data('toggle');
        if (this.checked) {
            $('#samyar-' + $toggle).slideDown();
        } else {
            $('#samyar-' + $toggle).slideUp();
        }
    });
    $(".samyar-confirm").each(function () {
        var $this = $(this);
        if ($this.is(':checked')) {
            var $toggle = $this.data('toggle');
            $('#samyar-' + $toggle).show();
        }
    });

    $("select.samyar-confirm").change(function () {
        var $this = $(this);
        var $name = $this.attr('name');
        if ($this.val()) {
            $('#samyar-' + $name).slideDown();
        } else {
            $('#samyar-' + $name).slideUp();
        }
    });
    $("select.samyar-confirm").each(function () {
        var $this = $(this);
        if ($this.val()) {
            var $name = $this.attr('name');
            $('#samyar-' + $name).show();
        }
    });

    $('.samyar-clipboard').click(function () {
        var $temp = $("<input>");
        $("body").append($temp);
        $temp.val($(this).text()).select();
        document.execCommand("copy");
        $temp.remove();
    });

    $(document).on('click', '.samyar-upload-file', function (e) {
        e.preventDefault();
        var $this = $(this);
        var image = wp.media({
            multiple: false,
        }).open().on('select', function (e) {

            var uploadedImage = image.state().get('selection').first();
            var imageID = uploadedImage.toJSON().id;
            var imageURL = uploadedImage.toJSON().url;
            $this.val(imageURL);
            $this.siblings('.samyar-url').attr('href', imageURL);
            $this.prev('input[type="hidden"]').val(imageID);
        });
    });

    $(document).on('click', '.samyar-upload-file-btn', function (e) {
        e.preventDefault();
        var $this = $("#samyar-popup-file");
        var image = wp.media({
            multiple: false,
        }).open().on('select', function (e) {

            var uploadedImage = image.state().get('selection').first();
            var imageID = uploadedImage.toJSON().id;
            var imageURL = uploadedImage.toJSON().url;
            $this.val(imageURL);
            $this.siblings('.samyar-url').attr('href', imageURL);
            $this.prev('input[type="hidden"]').val(imageID);
        });
    });

    $(document).on('click', '.samyar-remove', function (e) {
        e.preventDefault();
        var $this = $(this);
        var $toggle = $this.data('toggle');
        $('input[name="' + $toggle + '"], #samyar-' + $toggle).val('');
    });

    var nonce = $('meta[name="samyar-nonce"]').attr('content');

    $('#samyar-settings-form').submit(function (e) {
        e.preventDefault();
        var $this = $(this);
        // tinyMCE.triggerSave();
        var button = $this.find('.uk-button');
        var loader = button.find('.loader');
        button.prop('disabled', true);
        loader.show();

        $.ajax({
            url: ajaxurl,
            type: 'post',
            dataType: 'json',
            timeout: 20000,
            data: {
                action: 'samyar_update_settings',
                nonce: nonce,
                formData: $this.serialize()
            },
            success: function (response) {
                if (response.success === true) {
                    UIkit.notification({
                        message: response.data.message,
                        status: 'success',
                        pos: 'bottom-center',
                        timeout: 5000
                    });
                } else {
                    UIkit.notification({
                        message: response.data.message,
                        status: 'danger',
                        pos: 'bottom-center',
                        timeout: 5000
                    });
                }
            },
            error: function (response) {
                UIkit.notification({
                    message: response.data.message,
                    status: 'danger',
                    pos: 'bottom-center',
                    timeout: 5000
                });
            },
            complete: function (data) {
                button.prop('disabled', false);
                loader.hide();
            }
        });
    });


    $(document).on('click', '.samyar-select-uploader', function (e) {
        e.preventDefault();
        var $this = $(this);
        var $target = $this.data('target');
        var targetType = $this.data('target-type');
        var image = wp.media({multiple: false,}).open().on('select', function (e) {
            var uploadedImage = image.state().get('selection').first();
            var imageID = uploadedImage.toJSON().id;
            var imageURL = uploadedImage.toJSON().url;
            switch (true) {
                case targetType === 'image' :
                    $('#' + $target).attr('src', imageURL);
                    $('#' + $target + '_input').val(imageID);
                    break;
                case targetType === 'widget' :
                    $('#' + $target).attr('src', imageURL);
                    $('#' + $target + '_input').val(imageID).trigger('change');
                    break;
            }
        });
    });

    $(document).on('click', '.samyar-remove-uploader', function (e) {
        e.preventDefault();
        var $this = $(this);
        var target = $this.data('target');
        $('#' + target).attr('src', '');
        $('#' + target + '_input').attr('value', '').trigger('change');
    });


    if ($('.color-field').length) {
        $('.color-field').wpColorPicker();
    }


    $('#samyar-mce-add-shortcode-form').submit(function (e) {
        e.preventDefault();
        var $this = $(this);
        // tinyMCE.triggerSave();
        var button = $this.find('.uk-button');
        var loader = button.find('.loader');
        button.prop('disabled', true);
        loader.show();

        $.ajax({
            url: ajaxurl,
            type: 'post',
            dataType: 'json',
            timeout: 20000,
            data: {
                action: 'samyar_mce_add_shortcode',
                nonce: nonce,
                formData: $this.serialize()
            },
            success: function (response) {
                if (response.result === true) {
                    tinymce.activeEditor.execCommand('mceInsertContent', false, response.shortcode);
                    UIkit.modal("#samyar-add-shortcode-modal").hide();
                    // UIkit.notification({
                    //     message: "با موفقیت ذخیره شد",
                    //     status: 'success',
                    //     pos: 'bottom-center',
                    //     timeout: 5000
                    // });
                }
            },
            error: function () {
                UIkit.notification({
                    message: kando_data.langs.an_error_occurred,
                    status: 'danger',
                    pos: 'bottom-center',
                    timeout: 5000
                });
            },
            complete: function (data) {
                button.prop('disabled', false);
                loader.hide();
            }
        });
    });


    $(document).on("click", "#smartpanel-sync-users", function () {
        var $this = $(this);
        var loader = $(this).find(".loader");
        loader.show();
        $.ajax({
            url: ajaxurl,
            type: 'post',
            data: {
                action: 'samyar_sp_sync_users',
            },
            beforeSend: function () {
                $('#user_sync_stat').hide();
                $('#user_sync_stat').html('');

                $('#user_sync_errors').hide();
                $('#user_sync_errors').html('');
            },
            success: function (response) {
                if (response.success) {
                    UIkit.notification({
                        message: response.data.message,
                        status: 'success',
                        pos: 'bottom-center',
                        timeout: 5000
                    });
                    $('#user_sync_stat').append(kando_data.langs.registered_users_count + response.data.count);
                    $('#user_sync_stat').append('<br>');
                    $('#user_sync_stat').append(kando_data.langs.unregistered_users_count + response.data.error_count);
                    $('#user_sync_stat').append('<br>');
                    $('#user_sync_stat').show();

                    $('#user_sync_errors').append(kando_data.langs.errors_label + '<br>');
                    // $('#user_sync_stat').append('<br>');
                    $('#user_sync_errors').append(response.data.messages);
                    $('#user_sync_errors').show();
                } else {
                    UIkit.notification({
                        message: response.data.message,
                        status: 'danger',
                        pos: 'bottom-center',
                        timeout: 5000
                    });
                }
                loader.hide();
            },
            error: function () {
                UIkit.notification({
                    message: response.message,
                    status: 'danger',
                    pos: 'bottom-center',
                    timeout: 5000
                });
            }
        });
    });
    $(document).on("click", "#smartpanel-sync-services", function () {
        var $this = $(this);
        var loader = $(this).find(".loader");
        loader.show();
        $.ajax({
            url: ajaxurl,
            type: 'post',
            data: {
                action: 'samyar_sp_sync_services',
            },
            beforeSend: function () {
                $('#user_sync_stat').hide();
                $('#user_sync_stat').html('');

                $('#user_sync_errors').hide();
                $('#user_sync_errors').html('');
            },
            success: function (response) {
                if (response.success) {
                    UIkit.notification({
                        message: response.data.message,
                        status: 'success',
                        pos: 'bottom-center',
                        timeout: 5000
                    });
                    $('#user_sync_stat').append(kando_data.langs.registered_providers_count + response.data.count_api_provider);
                    $('#user_sync_stat').append('<br>');
                    $('#user_sync_stat').append(kando_data.langs.registered_categories_count + response.data.count_category);
                    $('#user_sync_stat').append('<br>');
                    $('#user_sync_stat').append(kando_data.langs.registered_services_count + response.data.count_category);
                    $('#user_sync_stat').show();

                    // $('#user_sync_errors').append(' خطاها: '+'<br>');
                    // $('#user_sync_stat').append('<br>');
                    // $('#user_sync_errors').append(response.data.messages);
                    // $('#user_sync_errors').show();
                } else {
                    UIkit.notification({
                        message: response.data.message,
                        status: 'danger',
                        pos: 'bottom-center',
                        timeout: 5000
                    });
                }
                loader.hide();
            },
            error: function () {
                UIkit.notification({
                    message: response.message,
                    status: 'danger',
                    pos: 'bottom-center',
                    timeout: 5000
                });
            }
        });
    });


    $(document).on("click", "#kando-set-start-order-id", function () {
        var $this = $(this);
        // var loader = $(this).find(".loader");
        var start = $('#samyar-start-order-id').val();
        var nonce = $('meta[name="samyar-nonce"]').attr('content');
        // loader.show();
        $.ajax({
            url: ajaxurl,
            type: 'post',
            data: {
                action: 'kando_set_start_order_id',
                start: start,
                nonce: nonce
            },
            beforeSend: function () {
                $this.attr('disabled', 'disabled');
            },
            success: function (response) {
                if (response.success) {
                    UIkit.notification({
                        message: response.data.message,
                        status: 'success',
                        pos: 'bottom-center',
                        timeout: 5000
                    });

                } else {
                    UIkit.notification({
                        message: response.data.message,
                        status: 'danger',
                        pos: 'bottom-center',
                        timeout: 5000
                    });
                }
                $this.removeAttr('disabled');
            },
            error: function () {
                UIkit.notification({
                    message: response.message,
                    status: 'danger',
                    pos: 'bottom-center',
                    timeout: 5000
                });
                $this.removeAttr('disabled');
            }
        });
        return false;
    });


    $(document).on("click", "#kando-genrate-cronjob-link", function () {
        var $this = $(this);
        // var loader = $(this).find(".loader");
        // var start = $('#samyar-start-order-id').val();
        // loader.show();
        $.ajax({
            url: ajaxurl,
            type: 'post',
            data: {
                action: 'kando_genrate_cronjob_key',
            },
            beforeSend: function () {
                $this.attr('disabled', 'disabled');
            },
            success: function (response) {
                if (response.success) {

                    $('#kando-order-cronjob').val(response.data.order_link);
                    $('#kando-order-cronjob').parent().find('a').attr('href', response.data.order_link);


                    $('#kando-status-cronjob').val(response.data.status_link);
                    $('#kando-status-cronjob').parent().find('a').attr('href', response.data.status_link);

                    $('#kando-multi-status-cronjob').val(response.data.multi_status_link);
                    $('#kando-multi-status-cronjob').parent().find('a').attr('href', response.data.multi_status_link);


                    $('#kando-autosync-cronjob').val(response.data.update_link);
                    $('#kando-autosync-cronjob').parent().find('a').attr('href', response.data.update_link);

                    $('#kando-refill-order-cronjob').val(response.data.refill_order_link);
                    $('#kando-refill-order-cronjob').parent().find('a').attr('href', response.data.refill_order_link);

                    $('#kando-refill-status-cronjob').val(response.data.refill_update_link);
                    $('#kando-refill-status-cronjob').parent().find('a').attr('href', response.data.refill_update_link);

                    $('#kando-dripfeed-cronjob').val(response.data.dripfeed_link);
                    $('#kando-dripfeed-cronjob').parent().find('a').attr('href', response.data.dripfeed_link);

                    $('#kando-subscriptions-cronjob').val(response.data.subscriptions_link);
                    $('#kando-subscriptions-cronjob').parent().find('a').attr('href', response.data.subscriptions_link);

                    $('#kando-cancel-cronjob').val(response.data.cancel_link);
                    $('#kando-cancel-cronjob').parent().find('a').attr('href', response.data.cancel_link);

                    $('.cronjob-link').show();

                    UIkit.notification({
                        message: response.data.message,
                        status: 'success',
                        pos: 'bottom-center',
                        timeout: 5000
                    });

                } else {
                    UIkit.notification({
                        message: response.data.message,
                        status: 'danger',
                        pos: 'bottom-center',
                        timeout: 5000
                    });
                }
                $this.removeAttr('disabled');
            },
            error: function () {
                UIkit.notification({
                    message: response.message,
                    status: 'danger',
                    pos: 'bottom-center',
                    timeout: 5000
                });
                $this.removeAttr('disabled');
            }
        });
        return false;
    });

    //کپی پیوند
    $(document).on("click", "button.kando-remove-data", function () {
        var $this = $(this);

        var type = $this.data('type');

        UIkit.modal.confirm(kando_data.langs.confirm_deletion_message, {
            labels: {
                ok: kando_data.langs.confirm_deletion_ok_button,
                cancel: kando_data.langs.cancel
            }
        }).then(function () {
            $.ajax({
                url: ajaxurl,
                type: 'post',
                data: {
                    action: 'kando_remove_data',
                    type: type,
                },
                beforeSend: function () {
                    $this.attr('disabled', 'disabled');
                },
                success: function (response) {
                    if (response.success) {
                        UIkit.notification({
                            message: response.data,
                            status: 'success',
                            pos: 'bottom-center',
                            timeout: 5000
                        });

                    } else {
                        UIkit.notification({
                            message: response.data,
                            status: 'danger',
                            pos: 'bottom-center',
                            timeout: 5000
                        });
                    }
                    $this.removeAttr('disabled');
                },
                error: function () {
                    UIkit.notification({
                        message: response.data,
                        status: 'danger',
                        pos: 'bottom-center',
                        timeout: 5000
                    });
                    $this.removeAttr('disabled');
                }
            });
        }, function () {
            return false;
        });

        return false;
    });

    $(document).on("click", "button.kando-remove-minor-data", function () {
        var $this = $(this);

        var type = $this.data('type');
        var remains = $('#samyar-' + type + '-remains-day').val();

        if (remains === "") {
            UIkit.notification({
                message: kando_data.langs.please_enter_remaining_days,
                status: 'danger',
                pos: 'bottom-center',
                timeout: 5000
            });
            return false;
        }

        const message = kando_data.langs.confirm_delete_recent_data.replace('%s', remains);
        UIkit.modal.confirm(message, {
            labels: {
                ok: kando_data.langs.confirm_deletion_ok_button,
                cancel: kando_data.langs.cancel
            }
        }).then(function () {

            $.ajax({
                url: ajaxurl,
                type: 'post',
                data: {
                    action: 'kando_remove_minor_data',
                    type: type,
                    nonce: nonce,
                    remains: remains,
                },
                beforeSend: function () {
                    $this.attr('disabled', 'disabled');
                },
                success: function (response) {
                    if (response.success) {
                        UIkit.notification({
                            message: response.data.message,
                            status: 'success',
                            pos: 'bottom-center',
                            timeout: 5000
                        });

                    } else {
                        UIkit.notification({
                            message: response.data.message,
                            status: 'danger',
                            pos: 'bottom-center',
                            timeout: 5000
                        });
                    }
                    $this.removeAttr('disabled');
                },
                error: function () {
                    UIkit.notification({
                        message: response.data.message,
                        status: 'danger',
                        pos: 'bottom-center',
                        timeout: 5000
                    });
                    $this.removeAttr('disabled');
                }
            });
        }, function () {
            return false;
        });

        return false;
    });

    //کپی پیوند
//کپی پیوند
//کپی پیوند
//کپی پیوند
    $(document).on('click', '.CopyToClipBoard', function (event) {
        event.preventDefault();

        var $temp = $("<input>");
        $("body").append($temp);
        $temp.val($(this).attr('href')).select();
        document.execCommand("copy");
        $temp.remove();

        // حذف کلاس از تمام inputها
        $('.samyar-upload-file-wrapper input').removeClass('copied-permanent');

        // اضافه کردن کلاس فقط به input فعلی
        var $input = $(this).closest('.samyar-upload-file-wrapper').find('input');
        $input.addClass('copied-permanent');

        UIkit.notification({
            message: kando_data.langs.link_copied_successfully,
            status: 'success',
            pos: 'bottom-center',
            timeout: 5000
        });
    });

    $('.samyar-sortable').sortable();

    $(document).on('click', '.samyar-actions .remove', function () {
        $(this).parentsUntil('.samyar-itemm').remove();
    });


    /*
        $("select.base_rate").change(function () {
            var $this = $(this);
            var $name = $this.val();
            console.log($name);
            switch ($name) {
                case'IRT':
                    $('.irt-rate').slideDown();
                    $('.afn-rate').slideUp();
                    $('.usd-rate').slideUp();
                    break;
                case'USD':
                    $('.irt-rate').slideDown();
                    $('.usd-rate').slideDown();
                    $('.afn-rate').slideUp();
                    break;
                case'AFN':
                    $('.irt-rate').slideUp();
                    $('.usd-rate').slideUp();
                    $('.afn-rate').slideDown();
                    break;
            }
        });
    */

    $('.post-type-kando_coupon').find('input#title').after(
        '<a href="#" class="button generate-coupon-code">' + kando_data.langs.generate_coupon_code_button + '</a>'
    );

    $(document).on('click', '.post-type-kando_coupon .button.generate-coupon-code', function (e) {
        e.preventDefault();
        var characters = "ABCDEFGHJKMNPQRSTUVWXYZ23456789";
        var $coupon_code_field = $('#title'),
            $coupon_code_label = $('#title-prompt-text'),
            $result = '';
        for (var i = 0; i < 8; i++) {
            $result += characters.charAt(
                Math.floor(Math.random() * characters.length)
            );
        }
        $coupon_code_field.trigger('focus').val($result);
        $coupon_code_label.addClass('screen-reader-text');
    });

    // $(document).on('click', '#kando-show-user-price', function (e) {
    //     e.preventDefault();
    //     UIkit.modal("#kando-user-price-modal").show();
    // });


    //کپی پیوند
    $(document).on("click", ".kando-show-info", function () {
        var $this = $(this);

        var type = $this.data('type');
        var user = $this.data('user');


        $.ajax({
            url: ajaxurl,
            type: 'post',
            data: {
                action: 'kando-show-' + type,
                user_id: user,
            },
            beforeSend: function () {
                $('#kando-user-price-modal .uk-modal-header').remove()
                $('#kando-user-price-modal .uk-modal-body').remove()
            },
            success: function (response) {
                $(response).insertAfter("#kando-user-price-modal button");
                UIkit.modal("#kando-user-price-modal").show();
                $(".kando-select2").select2({
                    width: '100%'
                });

                $(".kando-select2").on("change", function (e) {

                    if (type == "show-user-price") {//اگر برای نرخ دلخواه بود

                        // var data = $(".kando-select2").find(':selected').data('custom-attribute');
                        var select2Data = $(this).select2("data");
                        var selectedOption = select2Data.length > 0 && select2Data[0].element ? $(select2Data[0].element) : null;

                        // var selectedOption = $($(this).select2("data").element[0]);
                        var current_price = selectedOption.data("current-price");
                        current_price = Intl.NumberFormat('en-US', {}).format(current_price);

                        var user_price = selectedOption.data("user-price");
                        user_price = Intl.NumberFormat('en-US', {}).format(user_price);


                        var price_currency = selectedOption.data("price-currency");

                        var service_id = selectedOption.val();
                        var service_name = selectedOption.text();

                        const user_price_html = () => `
    <tr class="service-${service_id}">
        <td title="${kando_data.langs.id_title}">${service_id}</td>
        <td title="${kando_data.langs.title_title}">${service_name}</td>
        <td title="${kando_data.langs.current_price_title}">${current_price} ${price_currency}</td>
        <td title="${kando_data.langs.price_type_title}">
            <label>
                <select name="price_type[${service_id}]">
                    <option value="fixed">${kando_data.langs.fixed_option}</option>
                    <option value="discount">${kando_data.langs.discount_option}</option>
                    <option value="add">${kando_data.langs.add_option}</option>
                </select>
            </label>
        </td>
        <td title="${kando_data.langs.user_discount_title}">
            <div class="uk-inline uk-hidden">
                <span class="uk-form-icon uk-form-icon-flip">%</span>
                <input style="border-radius: 5px !important;" dir="ltr"
                       class="uk-input uk-form-width-small"
                       name="user-discount[${service_id}]"
                       type="text"
                       placeholder="${kando_data.langs.user_discount_title}"
                       value="${user_price}">
            </div>
                        <div class="uk-inline">
                <span class="uk-form-icon uk-form-icon-flip">${kando_data.site_currency}</span>
                <input style="border-radius: 5px !important;" dir="ltr"
                       class="uk-input uk-form-width-small"
                       name="user-service-price[${service_id}]"
                       type="text"
                       placeholder="${kando_data.langs.user_service_price}"
                       value="${user_price}">
            </div>
        </td>

        <td title="${kando_data.langs.delete_title}">
            <button class="uk-button uk-button-default user-price-delete"
                    data-service="${service_id}"
                    style="padding: 8px 8px 0px 8px;line-height: 28px;">
                <span uk-icon="trash"></span>
            </button>
        </td>
    </tr>
`;
                        if ($('#kando-user-price-modal .uk-modal-body table.user-price').find('tr.service-' + service_id).length === 0) {//بهش گفتم که اگر در جدول پیدا نشد اضافه کن

                            $('#kando-user-price-modal .uk-modal-body table.user-price tbody ').append([
                                {url: '/foo', img: 'foo.png', title: 'Foo item'},
                            ].map(user_price_html).join(''));

                        } else {
                            UIkit.notification({
                                message: kando_data.langs.service_already_added_message,
                                status: 'warning',
                                pos: 'bottom-center',
                                timeout: 5000
                            });

                        }

                    } else {//اگر برای غیر فعالسازی سرویس برای کاربر خاص بود

                        // var data = $(".kando-select2").find(':selected').data('custom-attribute');
                        var select2Data = $(this).select2("data");
                        var selectedOption = select2Data.length > 0 && select2Data[0].element ? $(select2Data[0].element) : null;


                        // var selectedOption = $($(this).select2("data").element[0]);

                        var service_id = selectedOption.val();
                        var service_name = selectedOption.text();

                        const user_price_html = ({
                                                     url,
                                                     img,
                                                     title
                                                 }) => `<tr class="service-${service_id}">
    <td title="${kando_data.langs.id_title}">${service_id}</td>
    <td title="${kando_data.langs.title_title}">${service_name}</td>
    <td title="${kando_data.langs.delete_title}">
        <button class="uk-button uk-button-default user-disable-service-delete" 
                data-service="${service_id}" 
                style="padding: 8px 8px 0px 8px;line-height: 28px;">
            <span uk-icon="trash"></span>
        </button>
    </td>
    <input type="hidden" name="disable-services[${service_id}]">
</tr>`;

                        if ($('#kando-user-price-modal .uk-modal-body table.user-disable-service').find('tr.service-' + service_id).length === 0) {//بهش گفتم که اگر در جدول پیدا نشد اضافه کن

                            $('#kando-user-price-modal .uk-modal-body table.user-disable-service tbody ').append([
                                {url: '/foo', img: 'foo.png', title: 'Foo item'},
                            ].map(user_price_html).join(''));

                        } else {
                            UIkit.notification({
                                message: kando_data.langs.service_already_added_message,
                                status: 'warning',
                                pos: 'bottom-center',
                                timeout: 5000
                            });

                        }
                    }


                });
            },
            error: function () {
            }
        });


        return false;
    });


    //برای حذف فیلد نرخ دلخواه
    $(document).on("click", ".user-price-delete", function () {
        var service_id = $(this).data('service');
        $('#kando-user-price-modal .uk-modal-body table.user-price tr.service-' + service_id).remove();
    });


    //برای حذف فیلد غیرفعالسازی سرویس برای کاربر
    $(document).on("click", ".user-disable-service-delete", function () {
        var service_id = $(this).data('service');
        $('#kando-user-price-modal .uk-modal-body table.user-disable-service tr.service-' + service_id).remove();
    });

    //برای ارسال موارد فرم نرخ دلخواه
    $(document).on("submit", "#kando-user-price-form", function () {
        var $form = $(this);
        var $btn = $(this).find('.kando-save');

        // $this.find('.samyar-form-loading').fadeIn(200);
        $.ajax({
            url: ajaxurl,
            type: 'post',
            data: $form.serialize(),
            beforeSend: function () {
                $btn.attr('disabled', 'disabled');
            },
            success: function (response) {

                //اگر مرحله شروع پرداخت موفقیت آمیز بود به درگاه پرداخت برو
                if (response.success) {
                    setTimeout(function () {
                        UIkit.notification({
                            message: response.data.message,
                            status: 'success',
                            pos: 'bottom-center',
                            timeout: 5000
                        });
                    }, 1000);
                } else {
                    setTimeout(function () {
                        UIkit.notification({
                            message: response.data.message,
                            status: 'danger',
                            pos: 'bottom-center',
                            timeout: 5000
                        });
                    }, 200);

                }

                $btn.removeAttr('disabled');
            },
            error: function () {
                $btn.removeAttr('disabled');
            }
        });


        return false;
    });

    //برای ارسال موارد فرم غیرفعالسازی سرویس برای کاربر خاص
    $(document).on("submit", "#kando-user-disable-service-form", function () {
        var $form = $(this);
        var $btn = $(this).find('.kando-save');

        // $this.find('.samyar-form-loading').fadeIn(200);
        $.ajax({
            url: ajaxurl,
            type: 'post',
            data: $form.serialize(),
            beforeSend: function () {
                $btn.attr('disabled', 'disabled');
            },
            success: function (response) {

                //اگر مرحله شروع پرداخت موفقیت آمیز بود به درگاه پرداخت برو
                if (response.success) {
                    setTimeout(function () {
                        UIkit.notification({
                            message: response.data.message,
                            status: 'success',
                            pos: 'bottom-center',
                            timeout: 5000
                        });
                    }, 1000);
                } else {
                    setTimeout(function () {
                        UIkit.notification({
                            message: response.data.message,
                            status: 'danger',
                            pos: 'bottom-center',
                            timeout: 5000
                        });
                    }, 200);

                }

                $btn.removeAttr('disabled');
            },
            error: function () {
                $btn.removeAttr('disabled');
            }
        });


        return false;
    });


    //for sort menu
    // var mySortable = $(".sortable").nestedSortable({
    //     attribute: 'data-item'
    // });


    //add icon popup
    $(document).click(function () {
        $('.iconpicker-popover').each(function (index, value) {
            $(this).addClass('uk-hidden');
        })
    });

    $(document).on('click', '.icon-select', function (e) {

        $('.iconpicker-popover').each(function (index, value) {
            $(this).addClass('uk-hidden');
        })

        // $('.icon-select').each(function (index, value) {
        //     $(this).removeClass('iconpicker-element iconpicker-container');
        // })

        $(this).find('.iconpicker-popover').removeClass('uk-hidden');

        $(this).iconpicker({
            templates: {
                // search: '<input type="search" class="form-control iconpicker-search" placeholder="Type to filter" /><a style="font-size: 14px;padding: 2px 8px;margin: 0 3px 12px 0;text-align: center;cursor: pointer;border-radius: 3px;box-shadow: 0 0 0 1px #ddd;color: inherit;" href="#" class="close-icon-picker"><i class="fas fa-times"></i></a>',
            }
        });
        $(this).on('iconpickerSelected', function (event) {
            var $action = $(this).data('category');
            $(this).find('.img-holder i').remove();
            $(this).find('.img-holder').append('<i class="' + event.iconpickerValue + '"></i>');
            $(this).find('input').val(event.iconpickerValue);

            $('li.' + $action + " input.icon-text").val(event.iconpickerValue);

            /* event.iconpickerValue */
        });

        return false;
    })

    $(".menu-status [type=checkbox]").on("change", function (e) {
        var $endpoint = $(this).parent().data('endpoint');
        var $status = $(this).is(':checked');

        if ($status == false) {
            $('li.' + $endpoint).addClass('opacity6');
        } else {
            $('li.' + $endpoint).removeClass('opacity6');
        }
    });

    $('#samyar-update-menu-form').submit(function (e) {
        e.preventDefault();
        var $this = $(this);
        // tinyMCE.triggerSave();
        var button = $this.find('.uk-button');
        var loader = button.find('.loader');
        button.prop('disabled', true);
        loader.show();


        var menusData = $this.serialize();

        // var mySortable = new Array();
        // jQuery(".sortable").each(function () {
        //      mySortable = jQuery(this).sortable('toArray', {attribute: "data-item"});
        // });
        //
        // console.log(mySortable);

        var mySortable = $(".sortable").nestedSortable('toArray', {
            attribute: 'data-item'
        });

        // console.log(mySortable);

        menusData = menusData + '&' + $.param({order: mySortable});

        $.ajax({
            url: ajaxurl,
            type: 'post',
            dataType: 'json',
            timeout: 20000,
            data: {
                action: 'samyar_update_menus',
                nonce: nonce,
                formData: menusData
            },
            success: function (response) {
                if (response.success) {
                    UIkit.notification({
                        message: kando_data.langs.successfully_saved,
                        status: 'success',
                        pos: 'bottom-center',
                        timeout: 5000
                    });
                } else {
                    UIkit.notification({
                        message: kando_data.langs.an_error_occurred,
                        status: 'danger',
                        pos: 'bottom-center',
                        timeout: 5000
                    });
                }
            },
            error: function () {
                UIkit.notification({
                    message: kando_data.langs.an_error_occurred,
                    status: 'danger',
                    pos: 'bottom-center',
                    timeout: 5000
                });
            },
            complete: function (data) {
                button.prop('disabled', false);
                loader.hide();
            }
        });
    });

    $(document).on("click", ".samyar-reset-default", function () {
        var button = $(this);
        // tinyMCE.triggerSave();
        // var button = $this.find('.uk-button');
        var loader = button.find('.loader');
        button.prop('disabled', true);
        loader.show();

        UIkit.modal.confirm(
            kando_data.langs.reset_confirmation_message, {
                labels: {
                    ok: kando_data.langs.yes,
                    cancel: kando_data.langs.cancel
                }
            }
        ).then(function () {


            $.ajax({
                url: ajaxurl,
                type: 'post',
                dataType: 'json',
                timeout: 20000,
                data: {
                    action: 'samyar_reset_menu',
                    nonce: nonce,
                },
                success: function (response) {
                    if (response.success === true) {
                        UIkit.notification({
                            message: kando_data.langs.successfully_restored,
                            status: 'success',
                            pos: 'bottom-center',
                            timeout: 5000
                        });
                        location.reload();
                    }
                },
                error: function () {
                    UIkit.notification({
                        message: kando_data.langs.an_error_occurred,
                        status: 'danger',
                        pos: 'bottom-center',
                        timeout: 5000
                    });
                },
                complete: function (data) {
                    button.prop('disabled', false);
                    loader.hide();
                }
            });

        }, function () {
            return false;
        });

        return false;
    });


    $(document).on("click", ".kando-unlock-cronjob", function () {
        var button = $(this);
        // tinyMCE.triggerSave();
        // var button = $this.find('.uk-button');
        var loader = button.find('.loader');
        button.prop('disabled', true);
        loader.show();

        var $key = $(this).data('key');

        UIkit.modal.confirm(
            kando_data.langs.unlock_cron_job_confirmation, {
                labels: {
                    ok: kando_data.langs.yes,
                    cancel: kando_data.langs.cancel
                }
            }
        ).then(function () {


            $.ajax({
                url: ajaxurl,
                type: 'post',
                dataType: 'json',
                timeout: 20000,
                data: {
                    action: 'kando_unlock_cronjob',
                    key: $key,
                    nonce: nonce,
                },
                success: function (response) {
                    if (response.success === true) {
                        UIkit.notification({
                            message: kando_data.langs.successfully_opened,
                            status: 'success',
                            pos: 'bottom-center',
                            timeout: 5000
                        });
                        location.reload();
                    } else {
                        UIkit.notification({
                            message: kando_data.langs.an_error_occurred,
                            status: 'danger',
                            pos: 'bottom-center',
                            timeout: 5000
                        });
                    }
                },
                error: function () {
                    UIkit.notification({
                        message: kando_data.langs.an_error_occurred,
                        status: 'danger',
                        pos: 'bottom-center',
                        timeout: 5000
                    });
                },
                complete: function (data) {
                    button.prop('disabled', false);
                    loader.hide();
                }
            });

        }, function () {
            return false;
        });


        return false;
    });

    $(document).on('click', '.show-backup-textarea', function (e) {

        e.preventDefault();
        var button = $(this);
        // tinyMCE.triggerSave();
        // var button = $this;
        // var loader = button.find('.loader');
        // button.prop('disabled', true);
        // loader.show();

        $.ajax({
            url: ajaxurl,
            type: 'post',
            dataType: 'json',
            timeout: 20000,
            data: {
                action: 'kando_get_settings_data',
                nonce: nonce,
            },
            beforeSend: function () {

                button.attr('disabled', 'disabled');
            },
            success: function (response) {
                if (response.success === true) {
                    $('#backup-data-text').val(JSON.stringify(response.data)).focus().select();
                    $('.backup-textarea').slideToggle();
                }

                button.attr('disabled', false);
            },
            error: function () {
                UIkit.notification({
                    message: kando_data.langs.an_error_occurred,
                    status: 'danger',
                    pos: 'bottom-center',
                    timeout: 5000
                });
                button.attr('disabled', false);
            },
            complete: function (data) {
                button.attr('disabled', false);
                // loader.hide();
            }
        });


    });


    $(document).on('click', '.show-import-textarea', function (e) {
        $('.import-textarea').slideToggle();
    });


    $(document).on('click', '#kando_import_btn', function (e) {

        e.preventDefault();
        var button = $(this);
        var jsonData = $("#import-data-text").val();

        if (jsonData == "") {
            UIkit.notification({
                message: kando_data.langs.please_enter_backup_info,
                status: 'danger',
                pos: 'bottom-center',
                timeout: 5000
            });
            return;
        }

        try {
            var jsonObject = $.parseJSON(jsonData);
            console.log("رشته JSON معتبر است.");
            console.log(jsonObject);
        } catch (error) {
            UIkit.notification({
                message: kando_data.langs.invalid_json_message,
                status: 'danger',
                pos: 'bottom-center',
                timeout: 5000
            });
            return;
        }

        var data = JSON.parse(jsonData.replace(/&lt;/g, '<').replace(/&gt;/g, '>'))

        // console.log(data);
        // tinyMCE.triggerSave();
        // var button = $this;
        // var loader = button.find('.loader');
        // button.prop('disabled', true);
        // loader.show();

        $.ajax({
            url: ajaxurl,
            type: 'post',
            dataType: 'json',
            timeout: 20000,
            data: {
                action: 'kando_import_options_data',
                nonce: nonce,
                formData: data
            },
            beforeSend: function () {
                button.attr('disabled', 'disabled');
            },
            success: function (response) {
                if (response.success === true) {
                    $('#backup-data-text').val(JSON.stringify(response.data)).focus().select();
                    UIkit.notification({
                        message: response.data.message,
                        status: 'success',
                        pos: 'bottom-center',
                        timeout: 5000
                    });
                    location.reload();
                }

                button.attr('disabled', false);
            },
            error: function () {
                UIkit.notification({
                    message: kando_data.langs.an_error_occurred,
                    status: 'danger',
                    pos: 'bottom-center',
                    timeout: 5000
                });
                button.attr('disabled', false);
            },
            complete: function (data) {
                button.attr('disabled', false);
                // loader.hide();
            }
        });


    });


    $(document).on('click', '.show-import-file', function (e) {
        $('.import-file').slideToggle();
    });


    $(document).on('change', '.ajax-switch', function () {
        var $this = $(this);
        var item_id = $this.attr('data-id');
        var type = $this.attr('data-type');
        var status = $this.is(':checked');

        $.ajax({
            url: ajaxurl,
            type: 'post',
            data: {
                action: type,
                item_id: item_id,
                // type: type,
                status: status,
            },
            success: function (response) {
                if (response.success === true) {
                    UIkit.notification({
                        message: response.data,
                        status: 'success',
                        pos: 'bottom-center',
                        timeout: 5000
                    });
                } else {
                    UIkit.notification({
                        message: response.data,
                        status: 'danger',
                        pos: 'bottom-center',
                        timeout: 5000
                    });
                }
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


    $(document).on('click', '#kando_import_file_btn', function (e) {

        e.preventDefault();
        var button = $(this);


        // فایلی که کاربر انتخاب می‌کند را بگیرید
        var file = $("#import-file")[0].files[0];

        // اطلاعات فرم را بسازید و فایل را به آن اضافه کنید
        var formData = new FormData();
        formData.append('file', file);
        formData.append('action', 'kando_import_options_data');
        formData.append('nonce', nonce);
        // tinyMCE.triggerSave();
        // var button = $this;
        // var loader = button.find('.loader');
        // button.prop('disabled', true);
        // loader.show();


        $.ajax({
            url: ajaxurl,
            type: 'post',
            contentType: false,
            cache: false,
            processData: false,
            data: formData,
            beforeSend: function () {
                button.attr('disabled', 'disabled');
            },
            success: function (response) {
                if (response.success === true) {
                    $('#backup-data-text').val(JSON.stringify(response.data)).focus().select();
                    $('.backup-textarea').slideToggle();
                }

                button.attr('disabled', false);
            },
            error: function () {
                UIkit.notification({
                    message: kando_data.langs.an_error_occurred,
                    status: 'danger',
                    pos: 'bottom-center',
                    timeout: 5000
                });
                button.attr('disabled', false);
            },
            complete: function (data) {
                button.attr('disabled', false);
                // loader.hide();
            }
        });


    });


    $(document).on('click', '.select_price_type', function (e) {
        console.log(e);
    })

    // تابع برای به روزرسانی نمایش فیلدها
    function updatePriceFields(selectElement) {
        var $select = $(selectElement);
        var $row = $select.closest('tr');
        var selectedValue = $select.val();
        console.log(selectedValue);
        // پیدا کردن divهای مربوطه با دقت بیشتر
        var $percentDiv = $row.find('div.uk-inline').first(); // div درصد
        var $currencyDiv = $row.find('div.uk-inline').last(); // div قیمت

        if (selectedValue === 'discount' || selectedValue === 'add') {
            $percentDiv.removeClass('uk-hidden');
            $currencyDiv.addClass('uk-hidden');
        } else { // fixed
            $percentDiv.addClass('uk-hidden');
            $currencyDiv.removeClass('uk-hidden');
        }
    }

    // ثبت رویداد change برای تمام selectها
    $(document).on('change', 'select[name^="price_type"]', function () {
        updatePriceFields(this);
    });

    // اعمال اولیه برای تمام selectها
    $('select[name^="price_type"]').each(function () {
        updatePriceFields(this);
    });

    // برای اطمینان از اجرا بعد از بارگذاری کامل DOM
    $(window).on('load', function () {
        $('select[name^="price_type"]').each(function () {
            updatePriceFields(this);
        });
    });


    $(document).on('click', '#enable_tfa_button, #disable_tfa_button', function (e) {

        var button = $(this);
        var spinner = button.find('.spinner');
        var action = button.attr('id') === 'enable_tfa_button' ? 'enable' : 'disable';

        // نمایش اسپینر و غیرفعال کردن دکمه
        spinner.show();
        button.prop('disabled', true);

        // نمایش بخش تنظیمات
        $('#tfa_settings_row').show();
        $('#tfa_action').val(action);

        // ارسال درخواست AJAX برای ارسال کد تأیید
        $.post(ajaxurl, {
            action: 'send_tfa_verification',
            user_id: $('[name="user_id"]').val(),
            method: $('#tfa_verification_method').val(),
            tfa_action: action
        }, function (response) {
            // مخفی کردن اسپینر و فعال کردن دکمه
            spinner.hide();
            button.prop('disabled', false);

            if (response.success) {
                $('#tfa_settings_container').find('.notice').remove();
                $('#tfa_settings_container').prepend(
                    '<div class="notice notice-success"><p>کد تأیید با موفقیت ارسال شد.</p></div>'
                );
                $('.tfa_verify_code_tr').show()
            } else {
                $('#tfa_settings_container').find('.notice').remove();
                $('#tfa_settings_container').prepend(
                    '<div class="notice notice-error"><p>خطا در ارسال کد تأیید: ' + response.data.message + '</p></div>'
                );
            }
        }).fail(function () {
            // مخفی کردن اسپینر و فعال کردن دکمه
            spinner.hide();
            button.prop('disabled', false);

            $('#tfa_settings_container').find('.notice').remove();
            $('#tfa_settings_container').prepend(
                '<div class="notice notice-error"><p>خطا در ارتباط با سرور</p></div>'
            );
        });
    });


    //database manager
    // Master checkbox functionality
    $('#samyar-master-checkbox').change(function() {
        $('.table-checkbox').prop('checked', $(this).prop('checked'));
    });

    // Truncate button click handler
    $('#samyar-truncate-btn').click(function() {
        const selectedTables = $('.table-checkbox:checked').map(function() {
            return $(this).val();
        }).get();

        if (selectedTables.length === 0) {
            showMessage('لطفاً حداقل یک جدول را انتخاب کنید', 'warning');
            return;
        }

        UIkit.modal('#samyar-auth-modal').show();
    });

    // Confirm truncate button handler
    $('#samyar-confirm-truncate').click(function() {
        const $btn = $(this);
        const password = $('#samyar-admin-password').val();
        const userId = kando_data.current_user_id;
        const selectedTables = $('.table-checkbox:checked').map(function() {
            return $(this).val();
        }).get();

        if (!password) {
            showMessage('لطفاً رمز عبور را وارد کنید', 'warning');
            return;
        }

        // Show loading state
        $btn.prop('disabled', true);
        $btn.find('.btn-text').text('در حال بررسی...');
        $btn.find('.btn-spinner').show();

        // Verify admin password
        $.ajax({
            url: ajaxurl,
            method: 'POST',
            dataType: 'json',
            data: {
                action: 'samyar_verify_wp_admin',
                password: password,
                user_id: userId,
                nonce: kando_data.db_manager_nonce
            },
            success: function(response) {
                if (response.success) {
                    showMessage(
                        response.data,
                        'success'
                    );

                    truncateTables(selectedTables, $btn);
                } else {
                    showMessage(response.data, 'danger');
                    $('#samyar-admin-password').val('').focus();
                }
            },
            error: function() {
                showMessage('خطا در ارتباط با سرور', 'danger');
            },
            complete: function() {
                $btn.prop('disabled', false);
                $btn.find('.btn-text').text('تایید و پاکسازی');
                $btn.find('.btn-spinner').hide();
            }
        });
    });

    // Function to truncate tables
    function truncateTables(tables, $btn) {
        $btn.prop('disabled', true);
        $btn.find('.btn-text').text('در حال پاکسازی...');
        $btn.find('.btn-spinner').show();

        $.ajax({
            url: ajaxurl,
            method: 'POST',
            dataType: 'json',
            data: {
                action: 'samyar_truncate_tables',
                tables: tables,
                nonce: kando_data.db_manager_nonce
            },
            success: function(response) {
                if (response.success) {
                    showMessage(
                        'پاکسازی با موفقیت انجام شد. ' +
                        Object.keys(response.data.results).length + ' جدول پردازش شدند.',
                        'success'
                    );

                    // Refresh table counts
                    tables.forEach(table => {
                        $(`.table-checkbox[value="${table}"]`).closest('tr')
                            .find('td:last').text('0');
                    });

                    UIkit.modal('#samyar-auth-modal').hide();
                    $('#samyar-admin-password').val('');
                } else {
                    showMessage(response.data, 'danger');
                }
            },
            error: function() {
                showMessage('خطا در انجام عملیات', 'danger');
            },
            complete: function() {
                $btn.prop('disabled', false);
                $btn.find('.btn-text').text('تایید و پاکسازی');
                $btn.find('.btn-spinner').hide();
            }
        });
    }

    // Function to show messages
    function showMessage(message, type) {

        UIkit.notification({
            message: message,
            status: type,
            pos: 'bottom-center',
            timeout: 3000
        });

    }

});

