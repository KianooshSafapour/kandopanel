"use strict";

// Class definition
var KTCreateAccount = function () {
    // Elements
    var modal;
    var modalEl;

    var stepper;
    var form;
    var formSubmitButton;
    var formContinueButton;

    // Variables
    var stepperObj;
    var validations = [];

    // Private Functions
    var initStepper = function () {
        // Initialize Stepper
        stepperObj = new KTStepper(stepper);

        // Stepper change event
        stepperObj.on('kt.stepper.changed', function (stepper) {
            if (stepperObj.getCurrentStepIndex() === 5) {
                formSubmitButton.classList.remove('d-none');
                formSubmitButton.classList.add('d-inline-block');
                formContinueButton.classList.add('d-none');
            } else if (stepperObj.getCurrentStepIndex() === 6) {
                formSubmitButton.classList.add('d-none');
                formContinueButton.classList.add('d-none');
            } else {
                formSubmitButton.classList.remove('d-inline-block');
                formSubmitButton.classList.remove('d-none');
                formContinueButton.classList.remove('d-none');
            }
        });

        // Validation before going to next page
        stepperObj.on('kt.stepper.next', function (stepper) {


            // Validate form before change stepper step

            var validator = validations[stepper.getCurrentStepIndex() - 1]; // get validator for currnt step

            if (validator) {
                validator.validate().then(function (status) {


                    if (status == 'Valid') {
                        stepper.goNext();

                        KTUtil.scrollTop();
                    } else {
                        Swal.fire({
                            text: "لطفا خطاها رو برطرف و ادامه دهید",
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "حله",
                            customClass: {
                                confirmButton: "btn btn-light"
                            }
                        }).then(function () {
                            KTUtil.scrollTop();
                        });
                    }
                });
            } else {
                stepper.goNext();

                KTUtil.scrollTop();
            }
        });

        // Prev event
        stepperObj.on('kt.stepper.previous', function (stepper) {


            stepper.goPrevious();
            KTUtil.scrollTop();
        });
    }

    var handleForm = function () {
        formSubmitButton.addEventListener('click', function (e) {
            // Validate form before change stepper step
            // var validator = validations[3]; // get validator for last form


            // Prevent default button action
            e.preventDefault();

            // Disable button to avoid multiple click
            formSubmitButton.disabled = true;

            // Show loading indication
            formSubmitButton.setAttribute('data-kt-indicator', 'on');

            $.ajax({
                url: price_convertor_params.ajaxurl,
                type: 'post',
                data: {data: $(form).serialize(), action: 'price_convertor_save_settings', wpnonce: price_convertor_params.wpnonce},
                beforeSend: function () {
                    // $form.find('.field-error').remove();
                    // $form.find('input').removeClass('is-invalid');
                },
                success: function (response) {
                    if (response.success){ // اگر مشکلی وجود نداشت به اطلاعات کاربر درست بود
                        // do_convertor(1);
                        // progress.css({width: "100%"});
                        // counter.text(count);
                        // remaining.text(0);

                        // Hide loading indication
                        formSubmitButton.removeAttribute('data-kt-indicator');

                        // Enable button
                        formSubmitButton.disabled = false;

                        stepperObj.goNext();
                    }else{
                        Swal.fire({
                            text: response.data,
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "حله",
                            customClass: {
                                confirmButton: "btn btn-light"
                            }
                        }).then(function () {
                            // Enable button
                            formSubmitButton.disabled = false;
                            // Hide loading indication
                            formSubmitButton.removeAttribute('data-kt-indicator');
                        });
                    }
                }
            });

            //end

            /*
            // Simulate form submission
            setTimeout(function() {
                // Hide loading indication
                formSubmitButton.removeAttribute('data-kt-indicator');

                // Enable button
                formSubmitButton.disabled = false;

                stepperObj.goNext();
            }, 2000);
            */


        });

    }


    function do_convertor(page) {

        var wrapper = $('.convertor-step');
        //start
        var counter = wrapper.find('.count');//نشان دهنده تعداد سرویس های اپدیت شده
        var remaining = wrapper.find('.remaining');
        var count = wrapper.find('.total_services').text();
        var progress = wrapper.find('.progress-bar');
        var limit = 20;//محدودیت در هر بار بررسی
        var pages = Math.ceil(count / limit);//محاسبه تعداد صفحات


        $.ajax({
            url: price_convertor_params.ajaxurl,
            type: 'post',
            data: {page: page, action: 'price_convertor_price_calculator', wpnonce: price_convertor_params.wpnonce},
            beforeSend: function () {

            },
            success: function (response) {
                if (typeof response.success !== "undefined" && response.success) { // اگر مشکلی وجود نداشت به اطلاعات کاربر درست بود

                    if (response.data.page_done < pages) {//اگر تعداد انجام شده از تعداد کل صفحات کمتذ بود ادامه بده
                        progress.css({width: (response.data.page_done * limit) * 100 / count + "%"});
                        counter.text(response.data.page_done * limit);
                        remaining.text(count - (response.data.page_done * limit));
                        do_convertor(response.data.page_done + 1);
                    } else {

                        progress.css({width: "100%"});
                        counter.text(count);
                        remaining.text(0);

                        // Hide loading indication
                        formSubmitButton.removeAttribute('data-kt-indicator');

                        // Enable button
                        formSubmitButton.disabled = false;

                        stepperObj.goNext();
                    }

                } else {

                }
            }
            // });
        });
    }

    var initValidation = function () {
        // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
        // Step 1
        validations.push(FormValidation.formValidation(
            form,
            {
                fields: {
                    base_currency: {
                        validators: {
                            notEmpty: {
                                message: 'لطفا ارز مورد نظر را انتخاب نمایید'
                            }
                        }
                    }
                },
                plugins: {
                    trigger: new FormValidation.plugins.Trigger(),
                    bootstrap: new FormValidation.plugins.Bootstrap5({
                        rowSelector: '.fv-row',
                        eleInvalidClass: '',
                        eleValidClass: ''
                    })
                }
            }
        ));

        // Step 2
        validations.push(undefined);

        // Step 3
        validations.push(FormValidation.formValidation(
            form,
            {
                fields: {
                    'public-profit-fix': {
                        validators: {
                            callback: {
                                message: 'لطفا حداقل یکی از فیلدهای نرخ عمومی را پر کنید',
                                callback: function (input) {
                                    var profitFix = form.querySelector('[name="public-profit-fix"]').value;
                                    var profitPercent = form.querySelector('[name="public-profit-percent"]').value;
                                    return profitFix.trim() !== '' || profitPercent.trim() !== '';
                                }
                            }
                        }
                    },
                    'public-profit-percent': {
                        validators: {
                            callback: {
                                message: 'لطفا حداقل یکی از فیلدهای نرخ عمومی را پر کنید',
                                callback: function (input) {
                                    var profitFix = form.querySelector('[name="public-profit-fix"]').value;
                                    var profitPercent = form.querySelector('[name="public-profit-percent"]').value;
                                    return profitFix.trim() !== '' || profitPercent.trim() !== '';
                                }
                            }
                        }
                    },
                    'gold_discount': {
                        validators: {
                            notEmpty: {
                                message: 'میزان تخفیف برای بسته طلایی را وارد نمایید'
                            }
                        }
                    },
                    'silver_discount': {
                        validators: {
                            notEmpty: {
                                message: 'میزان تخفیف برای بسته نقره ای را وارد نمایید'
                            }
                        }
                    },
                    'bronze_discount': {
                        validators: {
                            notEmpty: {
                                message: 'میزان تخفیف برای بسته برنزی را وارد نمایید'
                            }
                        }
                    }
                },
                plugins: {
                    trigger: new FormValidation.plugins.Trigger(),
                    // Bootstrap Framework Integration
                    bootstrap: new FormValidation.plugins.Bootstrap5({
                        rowSelector: '.fv-row',
                        eleInvalidClass: '',
                        eleValidClass: ''
                    })
                }
            }
        ));
    }

    return {
        // Public Functions
        init: function () {
            // Elements
            modalEl = document.querySelector('#kt_modal_create_account');

            if (modalEl) {
                modal = new bootstrap.Modal(modalEl);
            }

            stepper = document.querySelector('#kt_create_account_stepper');

            if (!stepper) {
                return;
            }

            form = stepper.querySelector('#kando_price_settings_form');
            formSubmitButton = stepper.querySelector('[data-kt-stepper-action="submit"]');
            formContinueButton = stepper.querySelector('[data-kt-stepper-action="next"]');

            initStepper();
            initValidation();
            handleForm();
        }
    };
}();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    KTCreateAccount.init();
});