jQuery(document).ready(function ($) {

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
                if (response.result === true) {
                    UIkit.notification({
                        message: "با موفقیت ذخیره شد",
                        status: 'success',
                        pos: 'bottom-center',
                        timeout: 5000
                    });
                }
            },
            error: function () {
                UIkit.notification({
                    message: "خطایی رخ داده است",
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
                    message: "خطایی رخ داده است",
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
                    $('#user_sync_stat').append('تعداد کاربران ثبت شده(موفقیت آمیز): ' + response.data.count);
                    $('#user_sync_stat').append('<br>');
                    $('#user_sync_stat').append('تعداد کاربران ثبت نشده(دارای خطا): ' + response.data.error_count);
                    $('#user_sync_stat').append('<br>');
                    $('#user_sync_stat').show();

                    $('#user_sync_errors').append(' خطاها: ' + '<br>');
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
                    $('#user_sync_stat').append('تعداد ارائه دهندگان ثبت شده(موفقیت آمیز): ' + response.data.count_api_provider);
                    $('#user_sync_stat').append('<br>');
                    $('#user_sync_stat').append('تعداد دسته های ثبت شده(موفقیت آمیز): ' + response.data.count_category);
                    $('#user_sync_stat').append('<br>');
                    $('#user_sync_stat').append('تعداد سرویس های ثبت شده(موفقیت آمیز): ' + response.data.count_category);
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
        // loader.show();
        $.ajax({
            url: ajaxurl,
            type: 'post',
            data: {
                action: 'kando_set_start_order_id',
                start: start,
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

        UIkit.modal.confirm('آیا از حذف این اطلاعات مطمئن هستید؟ در صورت حذف، قابل بازگشت نخواهد بود.', {labels: {ok: 'بله پاک کن', cancel: 'منصرف شدم'}}).then(function () {
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
        var remains = $('#samyar-'+type+'-remains-day').val();

        if(remains===""){
            UIkit.notification({
                message: "لطفا مقدار روز برای باقی مانده رو وارد نمایید",
                status: 'danger',
                pos: 'bottom-center',
                timeout: 5000
            });
            return false;
        }


        UIkit.modal.confirm('آیا از حذف اطلاعات '+remains+' روز اخیر مطمئن هستید؟ در صورت حذف، قابل بازگشت نخواهد بود.', {labels: {ok: 'بله پاک کن', cancel: 'منصرف شدم'}}).then(function () {

            $.ajax({
                url: ajaxurl,
                type: 'post',
                data: {
                    action: 'kando_remove_minor_data',
                    type: type,
                    remains: remains,
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

    //کپی پیوند
    $(document).on('click', '.CopyToClipBoard', function (event) {
        event.preventDefault();

        var $temp = $("<input>");
        $("body").append($temp);
        $temp.val($(this).attr('href')).select();
        document.execCommand("copy");
        $temp.remove();

        UIkit.notification({
            message: 'لینک با موفقیت کپی شد',
            status: 'success',
            pos: 'bottom-center',
            timeout: 5000
        });
    });

    $('.samyar-sortable').sortable();

    $(document).on('click', '.samyar-actions .remove', function () {
        $(this).parentsUntil('.samyar-itemm').remove();
    });

    $(document).on('click', '.samyar-new-wheel-item', function (e) {
        e.preventDefault();
        var $this = $(this);
        var $key = Math.floor((Math.random() * 1000000000));

        var $html = '<div class="uk-card uk-card-default uk-card-hover uk-card-body" style="margin: 15px 0;"><div class="samyar-social-network-item samyar-item uk-margin">';
        $html += '<div class="samyar-actions"><span class="remove" uk-icon="close" uk-tooltip="title: حذف"></span></div>';
        $html += '<div class="uk-margin-small"><label class="uk-form-label">عنوان نمایشی</label><input type="text" class="uk-input" name="kando-wheel[' + $key + '][title]" value="" placeholder="عنوان نمایشی"></div>';
        $html += '<div class="uk-margin-small"><label class="uk-form-label">پیام برنده شدن</label><input type="text" class="uk-input" name="kando-wheel[' + $key + '][message]" value="" placeholder="پیام برنده شدن"></div>';
        $html += '<div class="uk-margin-small"><label class="uk-form-label">مقدار</label><input type="text" class="uk-input" name="kando-wheel[' + $key + '][amount]" value="" placeholder="مقدار"></div>';
        $html += '<div class="uk-margin-small"><label class="uk-form-label">نوع هدیه</label><div uk-form-custom="target: > * > span:first-child"><select name="kando-wheel[' + $key + '][type]"><option value="IRT">'+kando_base_rate_text(kando_data.base_rate)+'</option><option value="CHANCE">شانس</option></select> <button class="uk-button uk-button-default" type="button" tabindex="-1"> <span></span><span uk-icon="icon: chevron-down"></span></button></div></div>';
        $html += '<div class="uk-margin-small"><label class="uk-form-label">رنگ</label><div uk-form-custom="target: > * > span:first-child"><select name="kando-wheel[' + $key + '][color]" class="kando-wheel-color"><option value="3579AE">3579AE</option><option value="835AC4">835AC4</option><option value="B35B9F">B35B9F</option><option value="D94A83">D94A83</option> <option value="F4796D">F4796D</option> <option value="F3974C">F3974C</option> <option value="FFBA4F">FFBA4F</option> <option value="F3DA35">F3DA35</option> <option value="AAD066">AAD066</option> <option value="3BAD61">3BAD61</option> <option value="57C4A4">57C4A4</option> <option value="43B9D1">43B9D1</option></select> <button class="uk-button uk-button-default" type="button" tabindex="-1"> <span></span><span uk-icon="icon: chevron-down"></span></button></div></div>';
        $html += '</div></div>';
        $this.before($html);
    });

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


    $('.post-type-kando_coupon').find('input#title').after(
        '<a href="#" class="button generate-coupon-code">ساخت کد تخفیف</a>'
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

                    if(type == "show-user-price"){//اگر برای نرخ دلخواه بود

                        // var data = $(".kando-select2").find(':selected').data('custom-attribute');
                        var selectedOption = $($(this).select2("data").element[0]);
                        var current_price = selectedOption.data("current-price");
                        current_price = Intl.NumberFormat('fa-IR', {}).format(current_price);

                        var user_price = selectedOption.data("user-price");
                        user_price = Intl.NumberFormat('fa-IR', {}).format(user_price);

                        var service_id = selectedOption.val();
                        var service_name = selectedOption.text();

                        const user_price_html = ({url, img, title}) => `<tr class="service-${service_id}"><td title="شناسه">${service_id}</td><td title="عنوان">${service_name}</td><td title="قیمت فعلی">${current_price} ${kando_base_rate_text(kando_data.base_rate)}</td><td title="قیمت برای این کاربر"><div class="uk-inline"> <span class="uk-form-icon uk-form-icon-flip">${kando_base_rate_text(kando_data.base_rate)}</span><input style="border-radius: 5px !important;" class="uk-input uk-form-width-small" type="text" name="user-price[${service_id}]" placeholder="مبلغ سرویس" value="${user_price}"></div></td><td title="حذف"><button class="uk-button uk-button-default user-price-delete" data-service="${service_id}" style="padding: 8px 8px 0px 8px;line-height: 28px;"><span uk-icon="trash"></span></button></td></tr>`;

                        if ($('#kando-user-price-modal .uk-modal-body table.user-price').find('tr.service-' + service_id).length===0) {//بهش گفتم که اگر در جدول پیدا نشد اضافه کن

                            $('#kando-user-price-modal .uk-modal-body table.user-price tbody ').append([
                                {url: '/foo', img: 'foo.png', title: 'Foo item'},
                            ].map(user_price_html).join(''));

                        }else{
                            UIkit.notification({
                                message: 'این سرویس را قبلا اضافه کرده اید',
                                status: 'warning',
                                pos: 'bottom-center',
                                timeout: 5000
                            });

                        }

                    }else{//اگر برای غیر فعالسازی سرویس برای کاربر خاص بود

                        // var data = $(".kando-select2").find(':selected').data('custom-attribute');
                        var selectedOption = $($(this).select2("data").element[0]);

                        var service_id = selectedOption.val();
                        var service_name = selectedOption.text();

                        const user_price_html = ({url, img, title}) => `<tr class="service-${service_id}"><td title="شناسه">${service_id}</td><td title="عنوان">${service_name}</td><td title="حذف"><button class="uk-button uk-button-default user-disable-service-delete" data-service="${service_id}" style="padding: 8px 8px 0px 8px;line-height: 28px;"><span uk-icon="trash"></span></button></td><input type="hidden" name="disable-services[${service_id}]"></tr>`;

                        if ($('#kando-user-price-modal .uk-modal-body table.user-disable-service').find('tr.service-' + service_id).length===0) {//بهش گفتم که اگر در جدول پیدا نشد اضافه کن

                            $('#kando-user-price-modal .uk-modal-body table.user-disable-service tbody ').append([
                                {url: '/foo', img: 'foo.png', title: 'Foo item'},
                            ].map(user_price_html).join(''));

                        }else{
                            UIkit.notification({
                                message: 'این سرویس را قبلا اضافه کرده اید',
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
    var issortable = document.getElementsByClassName('sortable');
    if (issortable.length > 0) {
        $('.sortable').nestedSortable({
            handle: 'div',
            listType: "ul",
            items: 'li',
            toleranceElement: '> div'
        });
    }

    //add icon popup
    $(document).click(function() {
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

            $('li.'+$action+" input.icon-text").val(event.iconpickerValue);

            /* event.iconpickerValue */
        });

        return false;
    })

    $(".menu-status [type=checkbox]").on("change", function (e) {
        var $endpoint = $(this).parent().data('endpoint');
        var $status = $(this).is(':checked');

        if($status==false){
            $('li.'+$endpoint).addClass('opacity6');
        }else{
            $('li.'+$endpoint).removeClass('opacity6');
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
                        message: "با موفقیت ذخیره شد",
                        status: 'success',
                        pos: 'bottom-center',
                        timeout: 5000
                    });
                } else {
                    UIkit.notification({
                        message: "خطایی رخ داده است",
                        status: 'danger',
                        pos: 'bottom-center',
                        timeout: 5000
                    });
                }
            },
            error: function () {
                UIkit.notification({
                    message: "خطایی رخ داده است",
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

        UIkit.modal.confirm('آیا از بازگردانی به حالت اولیه مطمئن هستید؟', {labels: {ok: 'بله', cancel: 'منصرف شدم'}}).then(function () {


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
                            message: "با موفقیت بازگردانی شد",
                            status: 'success',
                            pos: 'bottom-center',
                            timeout: 5000
                        });
                        location.reload();
                    }
                },
                error: function () {
                    UIkit.notification({
                        message: "خطایی رخ داده است",
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

        UIkit.modal.confirm('آیا از باز کردن قفل کرون جاب مطمئن هستید؟(اگر باز شد کرون جاب می تواند یک بار دیگر اجرا شود)', {labels: {ok: 'بله', cancel: 'منصرف شدم'}}).then(function () {


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
                            message: "با موفقیت باز شد",
                            status: 'success',
                            pos: 'bottom-center',
                            timeout: 5000
                        });
                        location.reload();
                    }else{
                        UIkit.notification({
                            message: "خطایی رخ داده است",
                            status: 'danger',
                            pos: 'bottom-center',
                            timeout: 5000
                        });
                    }
                },
                error: function () {
                    UIkit.notification({
                        message: "خطایی رخ داده است",
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
                    $('#backup-data-text').val(JSON.stringify( response.data ) ).focus().select();
                    $('.backup-textarea').slideToggle();
                }

                button.attr('disabled', false);
            },
            error: function () {
                UIkit.notification({
                    message: "خطایی رخ داده است",
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

        if(jsonData==""){
            UIkit.notification({
                message: "لطفا اطلاعات بک آپ را در مکان مربوطه وارد کنید",
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
                message: "رشته JSON نامعتبر است.",
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
                    $('#backup-data-text').val(JSON.stringify( response.data ) ).focus().select();
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
                    message: "خطایی رخ داده است",
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
                    $('#backup-data-text').val(JSON.stringify( response.data ) ).focus().select();
                    $('.backup-textarea').slideToggle();
                }

                button.attr('disabled', false);
            },
            error: function () {
                UIkit.notification({
                    message: "خطایی رخ داده است",
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
});

