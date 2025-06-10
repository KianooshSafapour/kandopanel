jQuery(document).ready(function ($) {
    // Attach click event to the submit button
    $("#kt_sign_in_submit").click(function (e) {
        e.preventDefault();

        // Get values from the form
        const email = $('input[name^="log"]').val();
        const password = $('input[name^="pwd"]').val();

        // // Validate email and password
        // if (!validateEmail(email)) {
        //     displayError("Invalid email format");
        //     return;
        // }

        if (email.trim() === '') {
            displayError(kando_data.langs.username_is_required);
            return;
        }

        if (password.trim() === '') {
            displayError(kando_data.langs.password_is_required);
            return;
        }


        $(this).addClass('loading');

        // Send an AJAX request to WordPress
        $.ajax({
            url: kando_data.ajaxurl, // ajaxurl is a global variable in WordPress that contains the URL to admin-ajax.php
            type: "POST",
            data: $('#kt_sign_in_form').serialize(),
            success: function (response) {
                $("#kt_sign_in_submit").removeClass('loading');
                // Handle the response from the server
                if (response.success) {
                    // Successful login
                    displaySuccess(response.data.message);
                    setTimeout(function () {
                        window.location.replace(response.data.redirect);
                    }, 1000);
                } else {
                    if(kando_data.google_captcha_enable==="1"){
                        grecaptcha.reset();
                    }
                    // Login failed
                    displayError(response.data);
                }



            },
            error: function () {
                $("#kt_sign_in_submit").removeClass('loading');
                // Handle AJAX errors
                displayError(kando_data.langs.An_error_occurred);
            }
        });

    });

    $("#kt_sign_in_by_otp_submit").click(function (e) {
        e.preventDefault();

        // Get values from the form
        const mobile = $('input[name^="log"]').val();


        // // Validate email and password
        // if (!validateEmail(email)) {
        //     displayError("Invalid email format");
        //     return;
        // }

        if (mobile.trim() === '') {
            displayError(kando_data.langs.phone_number_is_required);
            return;
        }

        $(this).addClass('loading');

        var formDataArray = $('#kt_sign_in_form').serializeArray();
        formDataArray.push({name: 'otp', value: '1'});

        var serializedData = $.param(formDataArray);


        // Send an AJAX request to WordPress
        $.ajax({
            url: kando_data.ajaxurl, // ajaxurl is a global variable in WordPress that contains the URL to admin-ajax.php
            type: "POST",
            data: serializedData,
            success: function (response) {

                // Handle the response from the server
                if (response.success) {
                    // Successful login
                    displaySuccess(response.data.message);
                    setTimeout(function () {
                        window.location.replace(response.data.redirect);
                    }, 1000);
                } else {

                    if(kando_data.google_captcha_enable==="1"){
                        grecaptcha.reset();
                    }
                    // Login failed
                    displayError(response.data);

                    $('#kt_sign_in_by_otp_submit').removeClass('loading');
                }



            },
            error: function () {
                // Handle AJAX errors
                displayError(kando_data.langs.An_error_occurred);

                $('#kt_sign_in_by_otp_submit').removeClass('loading');
            }
        });

    });

    $("#kt_forget_send_verify_code_submit").click(function (e) {
        e.preventDefault();

        // Get values from the form
        const mobile = $('input[name^="mobile"]').val();


        // // Validate email and password
        // if (!validateEmail(email)) {
        //     displayError("Invalid email format");
        //     return;
        // }

        if (mobile.trim() === '') {
            displayError(kando_data.langs.phone_number_is_required);
            return;
        }

        $(this).addClass('loading');


        // Send an AJAX request to WordPress
        $.ajax({
            url: kando_data.ajaxurl, // ajaxurl is a global variable in WordPress that contains the URL to admin-ajax.php
            type: "POST",
            data: $('#kt_password_reset_by_mobile_form').serialize(),
            success: function (response) {

                // Handle the response from the server
                if (response.success) {
                    // Successful login
                    displaySuccess(response.data.message);
                    setTimeout(function () {
                        window.location.replace(response.data.redirect);
                    }, 1000);
                } else {

                    if(kando_data.google_captcha_enable==="1"){
                        grecaptcha.reset();
                    }
                    // Login failed
                    displayError(response.data);

                    $('#kt_forget_send_verify_code_submit').removeClass('loading');
                }



            },
            error: function () {
                // Handle AJAX errors
                displayError(kando_data.langs.An_error_occurred);

                $('#kt_forget_send_verify_code_submit').removeClass('loading');
            }
        });

    });

    $("#kt_verify_code_submit").click(function (e) {
        e.preventDefault();

        // Get values from the form
        const mobile = $('input[name^="log"]').val();


        // // Validate email and password
        // if (!validateEmail(email)) {
        //     displayError("Invalid email format");
        //     return;
        // }

        if (mobile.trim() === '') {
            displayError(kando_data.langs.phone_number_is_required);
            return;
        }

        $(this).addClass('loading');

        // Send an AJAX request to WordPress
        $.ajax({
            url: kando_data.ajaxurl, // ajaxurl is a global variable in WordPress that contains the URL to admin-ajax.php
            type: "POST",
            data: $('#kt_login_otp_form').serialize(),
            success: function (response) {

                // Handle the response from the server
                if (response.success) {
                    // Successful login
                    displaySuccess(response.data.message);
                    setTimeout(function () {
                        window.location.replace(response.data.redirect);
                    }, 1000);
                } else {

                    if(kando_data.google_captcha_enable==="1"){
                        grecaptcha.reset();
                    }
                    // Login failed
                    displayError(response.data);

                    $("#kt_verify_code_submit").removeClass('loading');
                }



            },
            error: function () {
                // Handle AJAX errors
                displayError(kando_data.langs.An_error_occurred);

                $("#kt_verify_code_submit").removeClass('loading');
            }
        });

    });

    $("#kt_forget_verify_code_submit").click(function (e) {
        e.preventDefault();

        // Get values from the form
        // const mobile = $('input[name^="log"]').val();


        // // Validate email and password
        // if (!validateEmail(email)) {
        //     displayError("Invalid email format");
        //     return;
        // }

        // if (mobile.trim() === '') {
        //     displayError(kando_data.langs.phone_number_is_required);
        //     return;
        // }

        $(this).addClass('loading');

        // Send an AJAX request to WordPress
        $.ajax({
            url: kando_data.ajaxurl, // ajaxurl is a global variable in WordPress that contains the URL to admin-ajax.php
            type: "POST",
            data: $('#kt_password_reset_by_mobile2_form').serialize(),
            success: function (response) {

                // Handle the response from the server
                if (response.success) {
                    // Successful login
                    displaySuccess(response.data.message);
                    setTimeout(function () {
                        window.location.replace(response.data.redirect);
                    }, 1000);
                } else {

                    if(kando_data.google_captcha_enable==="1"){
                        grecaptcha.reset();
                    }
                    // Login failed
                    displayError(response.data);

                    $("#kt_forget_verify_code_submit").removeClass('loading');
                }



            },
            error: function () {
                // Handle AJAX errors
                displayError(kando_data.langs.An_error_occurred);

                $("#kt_forget_verify_code_submit").removeClass('loading');
            }
        });

    });

    // Attach click event to the submit button
    $("#kt_sign_up_submit").click(function (e) {
        e.preventDefault();

        // Get values from the form
        const full_name = $('input[name^="full_name"]').val();
        // const phone_number = $('input[name^="phone_number"]').val();
        const email = $('input[name^="email"]').val();
        const password = $('input[name^="password"]').val();
        // const password_confirm = $('input[name^="password_confirm"]').val();

        if (full_name.trim() === '') {
            displayError(kando_data.langs.full_name_is_required);
            return;
        }

        if($('input[name^="phone_number"]').length !== 0){
            const phone_number = $('input[name^="phone_number"]').val();
            if (phone_number.trim() === '') {
                displayError(kando_data.langs.phone_number_is_required);
                return;
            }
        }


        if (email.trim() === '') {
            displayError(kando_data.langs.email_is_required);
            return;
        }

        // Validate email and password
        if (!validateEmail(email)) {
            displayError(kando_data.langs.invalid_email_format);
            return;
        }


        if (password.trim() === '') {
            displayError(kando_data.langs.password_is_required);
            return;
        }

        if (password.length < 6) {
            displayError(kando_data.langs.Password_6_characters);
            return;
        }

        // if (password_confirm.trim() === '') {
        //     displayError(kando_data.langs.password_confirm_is_required);
        //     return;
        // }



        // if (password !== password_confirm) {
        //     displayError(kando_data.langs.passwords_not_match);
        //     return;
        // }


        var isTocChecked = $('input[name="toc"]').prop('checked');
        if (!isTocChecked) {
            displayError(kando_data.langs.confirm_rules);
            return;
        }


        $(this).addClass('loading');

        // Send an AJAX request to WordPress
        $.ajax({
            url: kando_data.ajaxurl, // ajaxurl is a global variable in WordPress that contains the URL to admin-ajax.php
            type: "POST",
            data: $('#kt_sign_up_form').serialize(),
            success: function (response) {
                $("#kt_sign_up_submit").removeClass('loading');
                // Handle the response from the server
                if (response.success) {
                    // Successful login
                    displaySuccess(response.data.message);
                    setTimeout(function () {
                        window.location.replace(response.data.redirect);
                    }, 1000);
                } else {
                    if(kando_data.google_captcha_enable==="1"){
                        grecaptcha.reset();
                    }
                    // Login failed
                    displayError(response.data);
                }



            },
            error: function () {
                $("#kt_sign_up_submit").removeClass('loading');
                // Handle AJAX errors
                displayError(kando_data.langs.An_error_occurred);
            }
        });

    });

    $("#kt_password_reset_submit").click(function (e) {
        e.preventDefault();

        // Get values from the form
        const email = $('input[name^="email"]').val();


        // Validate email and password
        if (!validateEmail(email)) {
            displayError(kando_data.langs.invalid_email_format);
            return;
        }

        if (email.trim() === '') {
            displayError(kando_data.langs.email_is_required);
            return;
        }




        $(this).addClass('loading');

        // Send an AJAX request to WordPress
        $.ajax({
            url: kando_data.ajaxurl, // ajaxurl is a global variable in WordPress that contains the URL to admin-ajax.php
            type: "POST",
            data: $('#kt_password_reset_form').serialize(),
            success: function (response) {
                $("#kt_password_reset_submit").removeClass('loading');
                // Handle the response from the server
                if (response.success) {
                    // Successful login
                    displaySuccess(response.data);
                } else {
                    if(kando_data.google_captcha_enable==="1"){
                        grecaptcha.reset();
                    }
                    // Login failed
                    displayError(response.data);
                }



            },
            error: function () {
                $("#kt_password_reset_submit").removeClass('loading');
                // Handle AJAX errors
                displayError(kando_data.langs.An_error_occurred);
            }
        });

    });


    var $resendButton = $('#kt_repeat_submit');

    // Disable the button and start the countdown on page load
    $resendButton.prop('disabled', true);
    var countdown = 60;
    var timer = setInterval(function() {
        if (countdown > 0) {
            countdown--;
            $resendButton.find('.indicator-label').text(countdown + ' ثانیه تا ارسال مجدد');
        } else {
            clearInterval(timer);
            $resendButton.prop('disabled', false);
            $resendButton.find('.indicator-label').text('ارسال مجدد');
        }
    }, 1000);



    $('#kt_repeat_submit').on('click', function(e) {
        e.preventDefault();

        var $button = $(this);
        var mobile = $('input[name="mobile"]').val();

        // Disable the button
        $button.prop('disabled', true);

        // Send AJAX request to resend OTP
        $.ajax({
            url: kando_data.ajaxurl,
            type: 'POST',
            data: {
                action: 'resend_otp',
                mobile: mobile,
                nonce: kando_data.resend_otp_nonce
            },
            success: function(response) {
                if (response.success) {
                    // Start the countdown
                    var countdown = 60;
                    var timer = setInterval(function() {
                        if (countdown > 0) {
                            countdown--;
                            $button.find('.indicator-label').text(countdown + ' ثانیه تا ارسال مجدد');
                        } else {
                            clearInterval(timer);
                            $button.prop('disabled', false);
                            $button.find('.indicator-label').text('ارسال مجدد');
                        }
                    }, 1000);
                    displaySuccess(response.data);
                } else {
                    displayError(response.data);
                    $button.prop('disabled', false);
                }
            },
            error: function() {
                displayError('خطایی رخ داده است. لطفاً دوباره تلاش کنید.');
                $button.prop('disabled', false);
            }
        });
    });


    // Validate email function
    function validateEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }

    // Display error using SweetAlert2
    function displayError(message) {
        Swal.fire({
            html: message,
            icon: "error",
            buttonsStyling: false,
            confirmButtonText: kando_data.langs.ok,
            customClass: {
                confirmButton: "btn btn-primary"
            }
        });
    }

    // Display success message using SweetAlert2
    function displaySuccess(message) {
        Swal.fire({
            html: message,
            icon: "success",
            buttonsStyling: false,
            confirmButtonText: kando_data.langs.ok,
            customClass: {
                confirmButton: "btn btn-primary"
            }
        });
    }

    // Restricts input for the set of matched elements to the given inputFilter function.
    (function ($) {
        $.fn.inputFilter = function (callback, errMsg) {
            return this.on("input keydown keyup mousedown mouseup select contextmenu drop focusout", function (e) {
                if (callback(this.value)) {
                    // Accepted value
                    if (["keydown", "mousedown", "focusout"].indexOf(e.type) >= 0) {
                        $(this).removeClass("input-error");
                        this.setCustomValidity("");
                    }
                    this.oldValue = this.value;
                    this.oldSelectionStart = this.selectionStart;
                    this.oldSelectionEnd = this.selectionEnd;
                } else if (this.hasOwnProperty("oldValue")) {
                    // Rejected value - restore the previous one
                    $(this).addClass("input-error");
                    this.setCustomValidity(errMsg);
                    this.reportValidity();
                    this.value = this.oldValue;
                    this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
                } else {
                    // Rejected value - nothing to restore
                    this.value = "";
                }
            });
        };
    }(jQuery));


    $(function () {
        $(".otp").keydown(function (event) {


            var tabIndex = parseInt($(event.target).attr('tabindex'));

            if (event.which == 8 || event.which == 46) {

                if ($(this).val() == '') {
                    $(`.otp[tabindex='${tabIndex - 1}']`).focus();
                } else {
                    $(this).val('');
                }
                return;
            } else {
                var number = $(this).inputFilter(function (value) {
                    return /^\d*$/.test(value);    // Allow digits only, using a RegExp
                }, "تنها عدد وارد نمایید");

                if (number.val() == '') {
                    $(`.otp[tabindex='${tabIndex}']`).val(number.val());
                } else {
                    $(`.otp[tabindex='${tabIndex + 1}']`).focus();
                }

            }

            if (event.which == 13 || event.key === "Enter" || event.key === "enter" || event.key === "submit" || event.key === "Go" || event.key === "Submit" || event.key === "go") {
                $(event.target).closest("form").find('a.kt-verify-otp-code').click();
            }

        })


        $(".otp").keyup(function (event) {
            var index = $(event.target).closest("form").find(`.otp[tabindex='1']`).val().trim() + $(event.target).closest("form").find(`.otp[tabindex='2']`).val().trim() + $(event.target).closest("form").find(`.otp[tabindex='3']`).val().trim() + $(event.target).closest("form").find(`.otp[tabindex='4']`).val().trim() + $(event.target).closest("form").find(`.otp[tabindex='5']`).val().trim();
            if (index.length == 5) {
                $(event.target).closest("form").find('a.kt-verify-otp-code').click();
            }
        })
    });
});