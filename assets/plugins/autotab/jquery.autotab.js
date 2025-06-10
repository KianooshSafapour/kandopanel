$(document).ready(function () {
    const loginController = {
        state: 1,
        otpstate: 1,
        emailState: 1,
        errorState: 0,
        offpageErrorState: 0,
        errorMessage: "",
        errorBoxSelector: "#errorBox",
        onPageErrorBoxSelector: "#onPageError",
        offPageErrorBoxSelector: "#offPageError",
        errorMessageSelector: "#errorMessage",
        offPageErrorMessageSelector: "#offPageErrorMessage",
        loginTogglerSelectorMobile: "#loginToggler.hidden-lg",
        loginTogglerSelectorDesktop: "#loginToggler:not(.hidden-lg)",
        loginBoxSelector: "#loginBox",
        otpMaskSelector: "#otpUsernameMask",
        otpUsernameSelector: "#otpUsername",
        continueButtonSelector: ".continue-button",
        emailSelector: "#Username",
        passwordSelector: "#Password",
        rememberSelector: "#RememberLogin",
        otpContinueButtonSelector: "#otpContinueButton",
        otpSubmitButtonSelector: "#otpSubmitButton",
        emailContinueButtonSelector: "#emailContinueButton",
        emailSubmitButtonSelector: "#emailSubmitButton",
        emailShowcaseSelector: "#emailShowcase",
        changeEmailSelector: "#changeEmail",
        emailLoginWrapperSelector: ".login-method.email-login",
        rescueSelector: '.rescue-link',
        type: "bama",
        focusSet: false,
        ready: false,
        currentFocus: null,
        otpFormValid: false,
        emailFormValid: false,
        emailValid: false,
        passwordValid: false,
        otpFormSelector: "#otpForm",
        emailFormSelector: "#emailForm",
        errorFadeTimeOut: 2500,
        errorAnimationDuration: 300,
        primaryActiveTimeout: null,
        secondaryActiveTimeout: null,
        tertiaryActiveTimeout: null,
        tertiaryActiveTime: 100,
        formSubmiited: false,
        setEmailState: () => {
            loginController.emailLoginWrapperElement().attr("data-emailstate", loginController.emailState);
            loginController.emailLoginWrapperElement().prop("data-emailstate", loginController.emailState);
            loginController.emailLoginWrapperElement().data("emailstate", loginController.emailState);
            loginController.loginBox().attr('data-emailstate', loginController.emailState);
            loginController.loginBox().prop("data-emailstate", loginController.emailState);
            loginController.loginBox().data("emailstate", loginController.emailState);
            loginController.setFocus();
        },
        setErrorState: (errStateOnPage, errStateOffPage) => {
            let prevErrStateOnPage = loginController.errorState;
            if (errStateOnPage !== undefined) {
                loginController.errorState = errStateOnPage;
            }
            if (errStateOffPage !== undefined) {
                loginController.offpageErrorState = errStateOffPage;
            }
            if (loginController.errorState === 1) {
                loginController.errorBoxElement().attr("data-errorstate", loginController.errorState);
                if (loginController.errorBoxElement().attr("data-erroffpage")) {
                    loginController.errorBoxElement().removeAttr("data-erroffpage");
                }
                if (loginController.errorBoxElement().attr("data-realerronpage")) {
                    loginController.errorBoxElement().removeAttr("data-realerronpage");
                }
                loginController.onPageErrorBoxElement().attr("data-erronpage", loginController.errorState);
                loginController.offPageErrorBoxElement().attr("data-erroffpage", loginController.offpageErrorState);
                loginController.errorBoxElement().prop("data-errorstate", loginController.errorState);
                if (loginController.errorBoxElement().prop("data-erroffpage")) {
                    loginController.errorBoxElement().removeProp("data-erroffpage");
                }
                if (loginController.errorBoxElement().prop("data-realerronpage")) {
                    loginController.errorBoxElement().removeProp("data-realerronpage");
                }
                loginController.onPageErrorBoxElement().prop("data-erronpage", loginController.errorState);
                loginController.offPageErrorBoxElement().prop("data-erroffpage", loginController.offpageErrorState);
                loginController.errorBoxElement().data("errorstate", loginController.errorState);
                if (loginController.errorBoxElement().data("erroffpage")) {
                    loginController.errorBoxElement().removeData("erroffpage");
                }
                if (loginController.errorBoxElement().data("realerronpage")) {
                    loginController.errorBoxElement().removeData("realerronpage");
                }
                loginController.onPageErrorBoxElement().data("erronpage", loginController.errorState);
                loginController.offPageErrorBoxElement().data("erroffpage", loginController.offpageErrorState);
            } else {
                if (loginController.offpageErrorState === 1) {
                    loginController.errorBoxElement().attr("data-realerronpage", prevErrStateOnPage);
                    loginController.errorBoxElement().attr("data-errorstate", loginController.offpageErrorState);
                    loginController.errorBoxElement().attr("data-erroffpage", loginController.offpageErrorState);
                    loginController.onPageErrorBoxElement().attr("data-erronpage", loginController.errorState);
                    loginController.offPageErrorBoxElement().attr("data-erroffpage", loginController.offpageErrorState);
                    loginController.errorBoxElement().prop("data-realerronpage", prevErrStateOnPage);
                    loginController.errorBoxElement().prop("data-errorstate", loginController.offpageErrorState);
                    loginController.errorBoxElement().prop("data-erroffpage", loginController.offpageErrorState);
                    loginController.onPageErrorBoxElement().prop("data-erronpage", loginController.errorState);
                    loginController.offPageErrorBoxElement().prop("data-erroffpage", loginController.offpageErrorState);
                    loginController.errorBoxElement().data("data-realerronpage", prevErrStateOnPage);
                    loginController.errorBoxElement().data("errorstate", loginController.offpageErrorState);
                    loginController.errorBoxElement().data("erroffpage", loginController.offpageErrorState);
                    loginController.onPageErrorBoxElement().data("erronpage", loginController.errorState);
                    loginController.offPageErrorBoxElement().data("erroffpage", loginController.offpageErrorState);
                } else {
                    loginController.errorBoxElement().attr("data-errorstate", loginController.errorState);
                    if (loginController.errorBoxElement().attr("data-erroffpage")) {
                        loginController.errorBoxElement().removeAttr("data-erroffpage");
                    }
                    if (loginController.errorBoxElement().attr("data-realerronpage")) {
                        loginController.errorBoxElement().removeAttr("data-realerronpage");
                    }
                    loginController.onPageErrorBoxElement().attr("data-erronpage", loginController.errorState);
                    loginController.offPageErrorBoxElement().attr("data-erroffpage", loginController.offpageErrorState);
                    loginController.errorBoxElement().prop("data-errorstate", loginController.errorState);
                    if (loginController.errorBoxElement().prop("data-erroffpage")) {
                        loginController.errorBoxElement().removeProp("data-erroffpage");
                    }
                    if (loginController.errorBoxElement().prop("data-realerronpage")) {
                        loginController.errorBoxElement().removeProp("data-realerronpage");
                    }
                    loginController.onPageErrorBoxElement().prop("data-erronpage", loginController.errorState);
                    loginController.offPageErrorBoxElement().prop("data-erroffpage", loginController.offpageErrorState);
                    loginController.errorBoxElement().data("errorstate", loginController.errorState);
                    if (loginController.errorBoxElement().data("erroffpage")) {
                        loginController.errorBoxElement().removeData("erroffpage");
                    }
                    if (loginController.errorBoxElement().data("realerronpage")) {
                        loginController.errorBoxElement().removeData("realerronpage");
                    }
                    loginController.onPageErrorBoxElement().data("erronpage", loginController.errorState);
                    loginController.offPageErrorBoxElement().data("erroffpage", loginController.offpageErrorState);
                }
            }
        },
        setOffPageErrorState: () => {
            if (typeof offpageerr_state !== 'undefined' && offpageerr_state == "1") {
                loginController.setErrorState(0, 1);
                loginController.onPageErrorBoxElement().css('display', 'none');
                if (loginController.tertiaryActiveTimeout !== null) {
                    clearTimeout(loginController.tertiaryActiveTimeout);
                }
                if (loginController.secondaryActiveTimeout !== null) {
                    clearTimeout(loginController.secondaryActiveTimeout);
                }
                if (loginController.primaryActiveTimeout !== null) {
                    clearTimeout(loginController.primaryActiveTimeout);
                }
                loginController.primaryActiveTimeout = setTimeout(() => {
                    loginController.setErrorState(0, 0);
                    loginController.secondaryActiveTimeout = setTimeout(() => {
                        loginController.offPageErrorMessageElement().text("");
                        loginController.tertiaryActiveTimeout = setTimeout(() => {
                            loginController.onPageErrorBoxElement().css('display', '');
                        }, loginController.tertiaryActiveTime);
                    }, loginController.errorAnimationDuration);
                }, loginController.errorFadeTimeOut);
            }
        },
        errorBoxElement: () => {
            return $(loginController.errorBoxSelector);
        },
        onPageErrorBoxElement: () => {
            return $(loginController.onPageErrorBoxSelector);
        },
        offPageErrorBoxElement: () => {
            return $(loginController.offPageErrorBoxSelector);
        },
        offPageErrorMessageElement: () => {
            return $(loginController.offPageErrorMessageSelector);
        },
        errorMessageELement: () => {
            return $(loginController.errorMessageSelector);
        },
        continueButtons: () => {
            return $(loginController.continueButtonSelector);
        },
        otpMaskElement: () => {
            return $(loginController.otpMaskSelector);
        },
        otpUsernameElement: () => {
            return $(loginController.otpUsernameSelector);
        },
        otpContinueButtonElement: () => {
            return $(loginController.otpContinueButtonSelector);
        },
        otpSubmitButtonElement: () => {
            return $(loginController.otpSubmitButtonSelector);
        },
        emailElement: () => {
            return $(loginController.emailSelector);
        },
        passwordElement: () => {
            return $(loginController.passwordSelector);
        },
        rememberElement: () => {
            return $(loginController.rememberSelector);
        },
        emailContinueButtonElement: () => {
            return $(loginController.emailContinueButtonSelector);
        },
        emailSubmitButtonElement: () => {
            return $(loginController.emailSubmitButtonSelector);
        },
        emailShowcaseElement: () => {
            return $(loginController.emailShowcaseSelector);
        },
        changeEmailElement: () => {
            return $(loginController.changeEmailSelector);
        },
        otpFormElement: () => {
            return $(loginController.otpFormSelector);
        },
        emailFormElement: () => {
            return $(loginController.emailFormSelector);
        },
        emailLoginWrapperElement: () => {
            return $(loginController.emailLoginWrapperSelector);
        },
        rescueElement: () => {
            return $(loginController.rescueSelector);
        },
        loginTogglerDesktop: () => {
            return $(loginController.loginTogglerSelectorDesktop);
        },
        loginTogglerMobile: () => {
            return $(loginController.loginTogglerSelectorMobile);
        },
        loginToggler: () => {
            if (window.innerWidth < 960) {
                return loginController.loginTogglerMobile();
            } else {
                return loginController.loginTogglerDesktop();
            }
        },
        loginBox: () => {
            return $(loginController.loginBoxSelector);
        },
        setLoginTogglerState: () => {
            loginController.loginBox().attr("data-state", loginController.state);
            loginController.loginBox().prop("data-state", loginController.state);
            loginController.loginBox().data("state", loginController.state);
        },
        setFocus: () => {
            if (loginController.currentFocus !== null) {
                loginController[loginController.currentFocus]().blur();
            }
            setTimeout(() => {
                if (loginController.state === 1) {
                    loginController.otpMaskElement().focus();
                    loginController.currentFocus = "otpMaskElement";
                    // if (loginController.otpstate === 1) {
                    // } else {
                    //     loginController.otpMaskElement().focus();
                    //     loginController.currentFocus = "otpMaskElement";
                    // }
                } else if (loginController.state === 2) {
                    if (loginController.emailState === 1) {
                        loginController.emailElement().focus();
                        loginController.currentFocus = "emailElement";
                    } else {
                        loginController.passwordElement().focus();
                        loginController.currentFocus = "passwordElement";
                    }
                }
            }, 100);
        },
        toggleLoginState: () => {
            if (loginController.ready === false) {
                if (sessionStorage.getItem('set_login_to_email') == 'true') {
                    loginController.state = parseInt(2);
                    sessionStorage.removeItem('set_login_to_email');
                    sessionStorage.removeItem('submitted_phone');
                    sessionStorage.removeItem('otp_submitted_phone');
                    sessionStorage.removeItem('change_phone_url');
                } else {
                    if (typeof login_state != "undefined" || login_state != null) {
                        loginController.state = parseInt(login_state);
                    } else {
                        loginController.state = loginController.state === 1 ? 2 : 1;
                    }
                }
                loginController.ready = true;
            } else {
                loginController.state = loginController.state === 1 ? 2 : 1;
            }
            loginController.setLoginTogglerState();
            loginController.setFocus();
        },
        toggleEmailState: () => {
            if (loginController.emailState === 2) {
                loginController.emailState = 1;
                loginController.setEmailState();
                loginController.emailElement().val("");
                loginController.passwordElement().val("");
                loginController.rememberElement().prop("checked", false);
                loginController.rememberElement().attr("checked", false);
                loginController.emailSubmitButtonElement().prop("disabled", true);
                loginController.emailSubmitButtonElement().attr("disabled", true);
                loginController.emailContinueButtonElement().prop("disabled", false);
                loginController.emailContinueButtonElement().attr("disabled", false);
                loginController.helpers.clearEmailShowCase();
                loginController.emailValid = false;
                loginController.passwordValid = false;
                loginController.emailFormValid = false;
            }
        },
        helpers: {
            numberKeyCodes: [44, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 96, 97, 98, 99, 100, 101, 102, 103, 104, 105],
            allowedSpecialCharKeyCodes: [46, 8, 37, 39, 35, 36, 9],
            persian: ["۰", "۱", "۲", "۳", "۴", "۵", "۶", "۷", "۸", "۹"],
            arabic: ["٠", "١", "٢", "٣", "٤", "٥", "٦", "٧", "٨", "٩"],
            english: ["0", "1", "2", "3", "4", "5", "6", "7", "8", "9"],
            ptCellNumber: /^(09)[0-9]*$/,
            ptEmail: /^\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/,
            toEnglish: input => {
                var inputstring = input;
                for (var i = 0; i < 10; i++) {
                    var regex = new RegExp(loginController.helpers.persian[i], 'g');
                    inputstring = inputstring.toString().replace(regex, loginController.helpers.english[i]);
                }
                return inputstring;
            },
            toPersian: input => {
                var inputstring = input;
                for (var i = 0; i < 10; i++) {
                    var regex = new RegExp(loginController.helpers.english[i], 'g');
                    inputstring = inputstring.toString().replace(regex, loginController.helpers.persian[i]);
                    var regex2 = new RegExp(loginController.helpers.arabic[i], 'g');
                    inputstring = inputstring.toString().replace(regex2, loginController.helpers.persian[i]);
                }
                return inputstring;
            },
            numbersOnly: event => {
                var legalKeyCode = (!event.shiftKey && !event.ctrlKey && !event.altKey) && ($.inArray(event.keyCode, loginController.helpers.allowedSpecialCharKeyCodes) >= 0 || $.inArray(event.keyCode, loginController.helpers.numberKeyCodes) >= 0);

                if (legalKeyCode === false)
                    event.preventDefault();
            },
            isNumberKey: evt => {
                var charCode = (evt.which) ? evt.which : evt.keyCode;
                if (charCode > 31 && (charCode < 48 || charCode > 57) && (charCode < 1776 || charCode > 1785))
                    return false;
                return true;
            },
            preventCCPDDEvent: selector => {
                $(selector).bind("cut copy paste drag drop", function (e) {
                    e.preventDefault();
                });
            },
            checkKeyPress: selector => {
                $(selector).keypress(function (e) {
                    return loginController.helpers.isNumberKey(e);
                });
            },
            handleEnterKeyPress: selector => {
                $(selector).keypress(function (e) {
                    if (e.keyCode === 13) {
                        e.preventDefault();
                        if (selector == loginController.otpMaskSelector) {
                            loginController.otpContinueButtonElement().click();
                        } else if (selector == loginController.emailSelector || selector == loginController.passwordSelector) {
                            loginController.emailContinueButtonElement().click();
                        }
                    }
                });
            },
            errorHandler: error => {
                if (error.length > 0) {
                    loginController.setErrorState(1, 0);
                    loginController.errorMessageELement().text(error);
                    if (loginController.secondaryActiveTimeout !== null) {
                        clearTimeout(loginController.secondaryActiveTimeout);
                    }
                    if (loginController.primaryActiveTimeout !== null) {
                        clearTimeout(loginController.primaryActiveTimeout);
                    }
                    loginController.primaryActiveTimeout = setTimeout(() => {
                        loginController.setErrorState(0, 0);
                        loginController.secondaryActiveTimeout = setTimeout(() => {
                            loginController.errorMessageELement().text("");
                        }, loginController.errorAnimationDuration);
                    }, loginController.errorFadeTimeOut);
                }
            },
            onInvalidOtpUsername: error => {
                loginController.otpContinueButtonElement().prop("disabled", false);
                loginController.otpContinueButtonElement().attr("disabled", false);
                loginController.otpSubmitButtonElement().prop("disabled", true);
                loginController.otpSubmitButtonElement().attr("disabled", true);
                loginController.otpMaskElement().focus();
                loginController.helpers.errorHandler(error);
            },
            onValidOtpUsername: () => {
                loginController.otpContinueButtonElement().prop("disabled", true);
                loginController.otpContinueButtonElement().attr("disabled", true);
                loginController.otpSubmitButtonElement().prop("disabled", false);
                loginController.otpSubmitButtonElement().attr("disabled", false);
                loginController.otpSubmitButtonElement().click();
            },
            onInvalidEmail: error => {
                loginController.emailContinueButtonElement().prop("disabled", false);
                loginController.emailContinueButtonElement().attr("disabled", false);
                loginController.emailSubmitButtonElement().prop("disabled", true);
                loginController.emailSubmitButtonElement().attr("disabled", true);
                loginController.emailElement().focus();
                loginController.helpers.errorHandler(error);
            },
            onValidEmail: () => {
                loginController.emailContinueButtonElement().prop("disabled", false);
                loginController.emailContinueButtonElement().attr("disabled", false);
                loginController.emailSubmitButtonElement().prop("disabled", true);
                loginController.emailSubmitButtonElement().attr("disabled", true);
                loginController.helpers.showCaseEmail();
                if (loginController.emailState != 2) {
                    loginController.emailState = 2;
                    loginController.setEmailState();
                }
                loginController.setFocus();
                // loginController.emailSubmitButtonElement().click();
            },
            showCaseEmail: () => {
                loginController.emailShowcaseElement().text(loginController.emailElement().val());
            },
            clearEmailShowCase: () => {
                loginController.emailShowcaseElement().text("");
            },
            onInvalidPassword: error => {
                loginController.emailContinueButtonElement().prop("disabled", false);
                loginController.emailContinueButtonElement().attr("disabled", false);
                loginController.emailSubmitButtonElement().prop("disabled", true);
                loginController.emailSubmitButtonElement().attr("disabled", true);
                loginController.passwordElement().focus();
                loginController.helpers.errorHandler(error);
            },
            onValidPassword: () => {
                loginController.emailContinueButtonElement().prop("disabled", true);
                loginController.emailContinueButtonElement().attr("disabled", true);
                loginController.emailSubmitButtonElement().prop("disabled", false);
                loginController.emailSubmitButtonElement().attr("disabled", false);
                loginController.emailSubmitButtonElement().click();
            },
            phoneNumberValidator: string => {
                if (string.trim().length < 11 || !loginController.helpers.ptCellNumber.test(string)) {
                    let message = "شماره موبایل نادرست است.";
                    let stringLength = string.trim().length;
                    if (stringLength < 11) {
                        if (stringLength > 2) {
                            message = "شماره موبایل را کامل وارد کنید.";
                        } else {
                            message = "شماره موبایل را وارد کنید.";
                        }
                    }
                    return {
                        valid: false,
                        message: message
                    };
                } else {
                    return {
                        valid: true
                    };
                }
            },
            emailValidator: string => {
                if (string.trim().length == 0 || !loginController.helpers.ptEmail.test(string) || string.indexOf('@') == -1) {
                    let message = "ایمیل نادرست است.";
                    let stringLength = string.trim().length;
                    let hasAt = string.indexOf('@') != -1;
                    if (stringLength == 0) {
                        message = "ایمیل را وارد کنید.";
                    } else if (!loginController.helpers.ptEmail.test(string)) {
                        message = "ایمیل نادرست است.";
                    } else if (!hasAt) {
                        message = "ایمیل نادرست است.";
                    }
                    return {
                        valid: false,
                        message: message
                    };
                } else {
                    return {
                        valid: true
                    };
                }
            },
            passwordValidator: string => {
                if (string.trim().length == 0) {
                    return {
                        valid: false,
                        message: "کلمه عبور را وارد کنید."
                    };
                } else {
                    return {
                        valid: true
                    };
                }
            },
            validateOtpUsername: () => {
                let result = loginController.helpers.phoneNumberValidator(loginController.otpUsernameElement().val());
                if (result.valid == true) {
                    loginController.helpers.onValidOtpUsername();
                } else {
                    loginController.helpers.onInvalidOtpUsername(result.message);
                }
            },
            validateEmail: () => {
                let result = loginController.helpers.emailValidator(loginController.emailElement().val());
                if (result.valid == true) {
                    loginController.helpers.onValidEmail();
                } else {
                    loginController.helpers.onInvalidEmail(result.message);
                }
            },
            validatePassword: () => {
                let result = loginController.helpers.passwordValidator(loginController.passwordElement().val());
                if (result.valid == true) {
                    loginController.helpers.onValidPassword();
                } else {
                    loginController.helpers.onInvalidPassword(result.message);
                }
            },
            setOtpFormValidStatus: () => {
                let result = loginController.helpers.phoneNumberValidator(loginController.otpUsernameElement().val());
                if (result.valid == true) {
                    loginController.otpFormValid = true;
                } else {
                    loginController.otpFormValid = false;
                }
            },
            setEmailFormValidStatus: () => {
                let emailValidationResult = loginController.helpers.emailValidator(loginController.emailElement().val());
                let passwordValidationResult = loginController.helpers.passwordValidator(loginController.passwordElement().val());
                if (emailValidationResult.valid == true && passwordValidationResult.valid == true) {
                    loginController.emailFormValid = true;
                    loginController.emailValid = true;
                    loginController.passwordValid = true;
                } else {
                    loginController.emailFormValid = false;
                    loginController.emailValid = emailValidationResult.valid;
                    loginController.passwordValid = passwordValidationResult.valid;
                }
            },
        },
        events: {
            loginToggler: () => {
                loginController.loginTogglerDesktop().click(() => {
                    loginController.toggleLoginState();
                });
                loginController.loginTogglerMobile().click(() => {
                    loginController.toggleLoginState();
                });
            },
            otpUsernameInput: () => {
                loginController.helpers.preventCCPDDEvent(loginController.otpMaskSelector);
                loginController.helpers.checkKeyPress(loginController.otpMaskSelector);
                loginController.helpers.handleEnterKeyPress(loginController.otpMaskSelector);
                loginController.otpMaskElement().on("input", function (e) {
                    if (loginController.type == "bama") {
                        loginController.otpMaskElement().val(loginController.helpers.toEnglish(loginController.otpMaskElement().val()));
                    } else {
                        loginController.otpMaskElement().val(loginController.helpers.toPersian(loginController.otpMaskElement().val()));
                    }
                    loginController.otpUsernameElement().val("09" + loginController.helpers.toEnglish(loginController.otpMaskElement().val()));
                    loginController.helpers.setOtpFormValidStatus();
                });
            },
            otpCountinueButton: () => {
                loginController.otpContinueButtonElement().click(() => {
                    loginController.helpers.validateOtpUsername();
                });
            },
            otpFormSubmit: () => {
                loginController.otpFormElement().submit((event) => {
                    if (loginController.otpFormValid == true) {
                        if (loginController.formSubmiited == false) {
                            loginController.formSubmiited = true;
                            sessionStorage.removeItem('otp_submitted_phone');
                            sessionStorage.setItem('change_phone_url', window.location.href);
                            sessionStorage.setItem('submitted_phone', loginController.otpUsernameElement().val());
                        } else {
                            event.preventDefault();
                        }
                    } else {
                        event.preventDefault();
                        loginController.helpers.onInvalidOtpUsername("شماره موبایل نادرست است.");
                    }
                });
            },
            emailInput: () => {
                loginController.helpers.handleEnterKeyPress(loginController.emailSelector);
                loginController.emailElement().on("input", function (e) {
                    loginController.helpers.setEmailFormValidStatus();
                });
            },
            changeEmail: () => {
                loginController.changeEmailElement().click(() => {
                    loginController.toggleEmailState();
                });
            },
            passwordInput: () => {
                loginController.helpers.handleEnterKeyPress(loginController.passwordSelector);
                loginController.passwordElement().on("input", function (e) {
                    loginController.helpers.setEmailFormValidStatus();
                });
            },
            emailContinueButton: () => {
                loginController.emailContinueButtonElement().click(() => {
                    if (loginController.emailState == 1) {
                        if (loginController.emailValid == false) {
                            loginController.helpers.validateEmail();
                        } else {
                            loginController.emailState = 2;
                            loginController.setEmailState();
                            loginController.helpers.showCaseEmail();
                        }
                    } else {
                        if (loginController.passwordValid == false) {
                            loginController.helpers.validatePassword();
                        } else {
                            if (loginController.formSubmiited == false) {
                                loginController.formSubmiited = true;
                                loginController.emailFormElement().submit();
                            }
                        }
                    }
                });
            },
            emailFormSubmit: () => {
                loginController.emailFormElement().submit((event) => {
                    if (loginController.emailFormValid == true) {
                        if (loginController.formSubmiited == false) {
                            loginController.formSubmiited = true;
                        }
                    } else {
                        if (loginController.emailState == 1) {
                            event.preventDefault();
                            if (loginController.emailValid == false) {
                                loginController.helpers.validateEmail();
                            } else {
                                loginController.emailState = 2;
                                loginController.setEmailState();
                                loginController.helpers.showCaseEmail();
                            }
                        } else {
                            if (loginController.passwordValid == false) {
                                loginController.helpers.validatePassword();
                            } else {
                                if (loginController.formSubmiited == false) {
                                    loginController.formSubmiited = true;
                                    // pwa.form.submit({
                                    //     "loading": {
                                    //         "show": true, //true
                                    //         "href": null,
                                    //         "targetloader": 'login',
                                    //         "forceNav": false, //true
                                    //         "isPageLink": false, //true
                                    //         "isTriggerPWA": true,
                                    //         "isJSLink": false
                                    //     }
                                    // });
                                    //loginController.emailFormElement().submit();
                                }
                            }
                        }
                    }
                });
            },
            rescueClick: () => {
                loginController.rescueElement().on('click', function (event) {
                    sessionStorage.removeItem('rescue_submitted_email');
                    sessionStorage.setItem('change_email_url', window.location.href);
                    sessionStorage.setItem('submitted_email', loginController.emailElement().val())
                })
            }
        },
        setEvents: () => {
            loginController.events.loginToggler();
            loginController.events.otpUsernameInput();
            loginController.events.otpCountinueButton();
            loginController.events.otpFormSubmit();
            loginController.events.emailInput();
            loginController.events.changeEmail();
            loginController.events.passwordInput();
            loginController.events.emailContinueButton();
            loginController.events.emailFormSubmit();
            loginController.events.rescueClick();
        },
        setType: () => {
            if (typeof login_type != "undefined" || login_type != null) {
                loginController.type = login_type;
            }
        },
        setState: () => {
            if (sessionStorage.getItem('set_login_to_email') == 'true') {
                loginController.state = parseInt(2);
            } else {
                if (typeof login_state != "undefined" || login_state != null) {
                    loginController.state = parseInt(login_state);
                }
            }
        },
        updateState: () => {
            loginController.setLoginTogglerState();
            // loginController.setFocus();
        },
        otp: {
            ignoreKeyUp: false,
            otpInputSelector: "#otpToken",
            txtOtp1Selector: "#txt-otp-1",
            txtOtp2Selector: "#txt-otp-2",
            txtOtp3Selector: "#txt-otp-3",
            txtOtp4Selector: "#txt-otp-4",
            txtOtp5Selector: "#txt-otp-5",
            otpFormSelector: "form",
            phoneShowCaseSelector: "#phoneShowcase",
            phoneShowCaseBoxSelector: ".input-set-phone-temp",
            changePhoneSelector: ".change-phone",
            changeStateToEmailSelector: "#changeStateToEmail",
            otpContinueButtonSelector: "#otpContinueButton",
            otpInputElement: () => {
                return $(loginController.otp.otpInputSelector);
            },
            txtOtp1Element: () => {
                return $(loginController.otp.txtOtp1Selector);
            },
            txtOtp1ElementVJS: () => {
                return document.querySelector(loginController.otp.txtOtp1Selector);
            },
            txtOtp2Element: () => {
                return $(loginController.otp.txtOtp2Selector);
            },
            txtOtp2ElementVJS: () => {
                return document.querySelector(loginController.otp.txtOtp2Selector);
            },
            txtOtp3Element: () => {
                return $(loginController.otp.txtOtp3Selector);
            },
            txtOtp3ElementVJS: () => {
                return document.querySelector(loginController.otp.txtOtp3Selector);
            },
            txtOtp4Element: () => {
                return $(loginController.otp.txtOtp4Selector);
            },
            txtOtp4ElementVJS: () => {
                return document.querySelector(loginController.otp.txtOtp4Selector);
            },
            txtOtp5Element: () => {
                return $(loginController.otp.txtOtp5Selector);
            },
            txtOtp5ElementVJS: () => {
                return document.querySelector(loginController.otp.txtOtp5Selector);
            },
            otpFormElement: () => {
                return $(loginController.otp.otpFormSelector);
            },
            phoneShowCaseElement: () => {
                return $(loginController.otp.phoneShowCaseSelector);
            },
            phoneShowCaseBox: () => {
                return $(loginController.otp.phoneShowCaseBoxSelector);
            },
            changePhoneElement: () => {
                return $(loginController.otp.changePhoneSelector);
            },
            changeStateToEmailElement: () => {
                return $(loginController.otp.changeStateToEmailSelector);
            },
            otpContinueButtonElement: () => {
                return $(loginController.otp.otpContinueButtonSelector);
            },
            helpers: {
                showPhoneShowCase: () => {
                    let phoneNumber
                    if (offpageerr_state == 1 || sessionStorage.getItem('otp_submitted_phone')) {
                        phoneNumber = sessionStorage.getItem('otp_submitted_phone');
                    } else {
                        phoneNumber = sessionStorage.getItem('submitted_phone');
                    }
                    if (phoneNumber != undefined) {
                        if (loginController.type != "bama") {
                            phoneNumber = loginController.helpers.toPersian(phoneNumber)
                        }
                        loginController.otp.phoneShowCaseElement().text(phoneNumber.toString());
                        loginController.otp.phoneShowCaseBox().css('display', 'grid');
                        //document.querySelector(loginController.otp.phoneShowCaseSelector).innerText = phoneNumber
                    }
                },
                otpEventHandler: event => {
                    var tabIndex = parseInt($(event.target).attr('tabindex'));
                    if (event.keyCode == 8 || event.keyCode == 46) {
                        if ($(event.target).val() == '') {
                            $(`.usercode[tabindex='${tabIndex - 1}']`).focus();
                        } else {
                            $(event.target).val('');
                        }
                        loginController.otp.helpers.fillOtpField();
                        return;
                    }
                    var char = function () {
                        return (event.data || event.key); //firefox wont have passedEvent.data so we catch passedEvent.key
                    };
                    char = parseInt(loginController.helpers.toEnglish(char())); // In our example = "a" first we convert all the catched input (numbers) to english numbers, then we convert them to int
                    if (parseInt($(event.target).val()) != char) {
                        $(event.target).val(char);
                    }
                    if (isFinite($(event.target).val())) {
                        loginController.otp.helpers.fillOtpField();
                        if (loginController.type == 'mashinchi') {
                            $(event.target).val(loginController.helpers.toPersian($(event.target).val()));
                        }
                        $(`.usercode[tabindex='${tabIndex + 1}']`).focus();
                        if (tabIndex == 4) {
                            $(event.target).blur();
                            loginController.otp.otpContinueButtonElement().focus();
                            // $('#enter-mobile-code-cta').focus();
                        }
                    } else {
                        loginController.otp.helpers.fillOtpField();
                        $(event.target).val('');
                    }
                },
                fillOtpField: () => {
                    let otp = loginController.otp.txtOtp1Element().val().trim() + loginController.otp.txtOtp2Element().val().trim() + loginController.otp.txtOtp3Element().val().trim() + loginController.otp.txtOtp4Element().val().trim();
                    loginController.otp.otpInputElement().val(loginController.helpers.toEnglish(otp));
                },
            },
            events: {
                txtOtpInputsOnTextInputEventHandler: () => {
                    loginController.otp.txtOtp1ElementVJS().addEventListener('textInput', function (event) {
                        loginController.otp.ignoreKeyUp = true;
                        loginController.otp.helpers.otpEventHandler(event);
                    });
                    loginController.otp.txtOtp2ElementVJS().addEventListener('textInput', function (event) {
                        loginController.otp.ignoreKeyUp = true;
                        loginController.otp.helpers.otpEventHandler(event);
                    });
                    loginController.otp.txtOtp3ElementVJS().addEventListener('textInput', function (event) {
                        loginController.otp.ignoreKeyUp = true;
                        loginController.otp.helpers.otpEventHandler(event);
                    });
                    loginController.otp.txtOtp4ElementVJS().addEventListener('textInput', function (event) {
                        loginController.otp.ignoreKeyUp = true;
                        loginController.otp.helpers.otpEventHandler(event);
                    });
                    loginController.otp.txtOtp5ElementVJS().addEventListener('textInput', function (event) {
                        loginController.otp.ignoreKeyUp = true;
                        loginController.otp.helpers.otpEventHandler(event);
                    });
                },
                txtOtpInputsOnKeyUpEventHandler: () => {
                    loginController.otp.txtOtp1ElementVJS().addEventListener('keyup', function (event) {
                        if (loginController.otp.ignoreKeyUp == false) {
                            loginController.otp.helpers.otpEventHandler(event);
                        }
                    });
                    loginController.otp.txtOtp2ElementVJS().addEventListener('keyup', function (event) {
                        if (loginController.otp.ignoreKeyUp == false) {
                            loginController.otp.helpers.otpEventHandler(event);
                        }
                    });
                    loginController.otp.txtOtp3ElementVJS().addEventListener('keyup', function (event) {
                        if (loginController.otp.ignoreKeyUp == false) {
                            loginController.otp.helpers.otpEventHandler(event);
                        }
                    });
                    loginController.otp.txtOtp4ElementVJS().addEventListener('keyup', function (event) {
                        if (loginController.otp.ignoreKeyUp == false) {
                            loginController.otp.helpers.otpEventHandler(event);
                        }
                    });
                    loginController.otp.txtOtp5ElementVJS().addEventListener('keyup', function (event) {
                        if (loginController.otp.ignoreKeyUp == false) {
                            loginController.otp.helpers.otpEventHandler(event);
                        }
                    });
                },
                txtOtpInputsOnKeyDownEventHandler: () => {
                    loginController.otp.txtOtp1Element().on('keydown', function (event) {
                        var tabIndex = parseInt($(event.target).attr('tabindex'));
                        if (event.keyCode == 8 || event.keyCode == 46) {
                            if ($(this).val() == '') {
                                $(`.usercode[tabindex='${tabIndex - 1}']`).focus();
                            } else {
                                $(this).val('');
                            }
                            return;
                        }
                        if (event.keyCode == 13 || event.key === "Enter" || event.key === "enter" || event.key === "submit" || event.key === "Go" || event.key === "Submit" || event.key === "go") {
                            event.preventDefault();
                            loginController.otp.otpContinueButtonElement().click();
                            // enterOtp();
                            //this is where you can enter code to fill the otpToken Field
                            return;
                        }
                    });
                    loginController.otp.txtOtp2Element().on('keydown', function (event) {
                        var tabIndex = parseInt($(event.target).attr('tabindex'));
                        if (event.keyCode == 8 || event.keyCode == 46) {
                            if ($(this).val() == '') {
                                $(`.usercode[tabindex='${tabIndex - 1}']`).focus();
                            } else {
                                $(this).val('');
                            }
                            return;
                        }
                        if (event.keyCode == 13 || event.key === "Enter" || event.key === "enter" || event.key === "submit" || event.key === "Go" || event.key === "Submit" || event.key === "go") {
                            event.preventDefault();
                            loginController.otp.otpContinueButtonElement().click();
                            // enterOtp();
                            //this is where you can enter code to fill the otpToken Field
                            return;
                        }
                    });
                    loginController.otp.txtOtp3Element().on('keydown', function (event) {
                        var tabIndex = parseInt($(event.target).attr('tabindex'));
                        if (event.keyCode == 8 || event.keyCode == 46) {
                            if ($(this).val() == '') {
                                $(`.usercode[tabindex='${tabIndex - 1}']`).focus();
                            } else {
                                $(this).val('');
                            }
                            return;
                        }
                        if (event.keyCode == 13 || event.key === "Enter" || event.key === "enter" || event.key === "submit" || event.key === "Go" || event.key === "Submit" || event.key === "go") {
                            event.preventDefault();
                            loginController.otp.otpContinueButtonElement().click();
                            // enterOtp();
                            //this is where you can enter code to fill the otpToken Field
                            return;
                        }
                    });
                    loginController.otp.txtOtp4Element().on('keydown', function (event) {
                        var tabIndex = parseInt($(event.target).attr('tabindex'));
                        if (event.keyCode == 8 || event.keyCode == 46) {
                            if ($(this).val() == '') {
                                $(`.usercode[tabindex='${tabIndex - 1}']`).focus();
                            } else {
                                $(this).val('');
                            }
                            return;
                        }
                        if (event.keyCode == 13 || event.key === "Enter" || event.key === "enter" || event.key === "submit" || event.key === "Go" || event.key === "Submit" || event.key === "go") {
                            event.preventDefault();
                            loginController.otp.otpContinueButtonElement().click();
                            // enterOtp();
                            //this is where you can enter code to fill the otpToken Field
                            return;
                        }
                    });
                    loginController.otp.txtOtp5Element().on('keydown', function (event) {
                        var tabIndex = parseInt($(event.target).attr('tabindex'));
                        if (event.keyCode == 8 || event.keyCode == 46) {
                            if ($(this).val() == '') {
                                $(`.usercode[tabindex='${tabIndex - 1}']`).focus();
                            } else {
                                $(this).val('');
                            }
                            return;
                        }
                        if (event.keyCode == 13 || event.key === "Enter" || event.key === "enter" || event.key === "submit" || event.key === "Go" || event.key === "Submit" || event.key === "go") {
                            event.preventDefault();
                            loginController.otp.otpContinueButtonElement().click();
                            // enterOtp();
                            //this is where you can enter code to fill the otpToken Field
                            return;
                        }
                    });
                },
                txtOtpInputsOnKeyPressEventHandler: () => {
                    loginController.otp.txtOtp1Element().keypress(function (e) {
                        return loginController.helpers.isNumberKey(e);
                    });
                    loginController.otp.txtOtp2Element().keypress(function (e) {
                        return loginController.helpers.isNumberKey(e);
                    });
                    loginController.otp.txtOtp3Element().keypress(function (e) {
                        return loginController.helpers.isNumberKey(e);
                    });
                    loginController.otp.txtOtp4Element().keypress(function (e) {
                        return loginController.helpers.isNumberKey(e);
                    });
                    loginController.otp.txtOtp5Element().keypress(function (e) {
                        return loginController.helpers.isNumberKey(e);
                    });
                },
                txtOtpInputsPreventCCPDD: () => {
                    loginController.otp.txtOtp1Element().bind("cut copy paste drag drop", function (e) {
                        e.preventDefault();
                    });
                    loginController.otp.txtOtp2Element().bind("cut copy paste drag drop", function (e) {
                        e.preventDefault();
                    });
                    loginController.otp.txtOtp3Element().bind("cut copy paste drag drop", function (e) {
                        e.preventDefault();
                    });
                    loginController.otp.txtOtp4Element().bind("cut copy paste drag drop", function (e) {
                        e.preventDefault();
                    });
                    loginController.otp.txtOtp5Element().bind("cut copy paste drag drop", function (e) {
                        e.preventDefault();
                    });
                },
                onChangePhoneClick: () => {
                    loginController.otp.changePhoneElement().on('click', function (event) {
                        sessionStorage.removeItem('submitted_phone');
                        window.location.href = sessionStorage.getItem('change_phone_url');
                    });
                    /*loginController.otp.*/
                },
                //onChangeStateToEmailClick: () => {
                //    loginController.otp.changeStateToEmailElement().on('click', function (event) {
                //        sessionStorage.setItem('set_login_to_email', true);
                //        window.location.href = sessionStorage.getItem('change_phone_url');
                //    });
                //},
                otpFormOnSubmitEventHandler: () => {
                    loginController.otp.otpFormElement().on('submit', function (event) {
                        if (!sessionStorage.getItem('otp_submitted_phone')) {
                            sessionStorage.setItem('otp_submitted_phone', sessionStorage.getItem('submitted_phone'));
                        }
                        sessionStorage.removeItem('submitted_phone');
                        if (loginController.formSubmiited != true) {
                            loginController.formSubmiited = true;
                        }
                    });
                },
                otpContinueButtonClickEventHandler: () => {
                    loginController.otp.otpContinueButtonElement().on('click', function (event) {
                        loginController.otp.helpers.fillOtpField();
                        if (loginController.otp.otpInputElement().val().length < 4 || loginController.otp.otpInputElement().val() == "") {
                            event.preventDefault();
                            let message = "کد امنیتی را کامل وارد نمایید.";
                            if (loginController.otp.otpInputElement().val().length == 0) {
                                message = "لطفا کد امنیتی را وارد نمایید.";
                            }
                            loginController.helpers.errorHandler(message);
                            return false;
                        } else {
                            if (loginController.formSubmiited != true) {
                                loginController.formSubmiited = true;
                                loginController.otp.otpFormElement().submit();
                            } else {
                                event.preventDefault();
                                return false;
                            }
                        }
                    });
                },
            },
            setEvents: () => {
                loginController.otp.events.txtOtpInputsOnTextInputEventHandler();
                loginController.otp.events.txtOtpInputsOnKeyUpEventHandler();
                loginController.otp.events.txtOtpInputsOnKeyDownEventHandler();
                loginController.otp.events.txtOtpInputsOnKeyPressEventHandler();
                loginController.otp.events.txtOtpInputsPreventCCPDD();
                loginController.otp.events.otpFormOnSubmitEventHandler();
                loginController.otp.events.otpContinueButtonClickEventHandler();
                loginController.otp.events.onChangePhoneClick();
                //loginController.otp.events.onChangeStateToEmailClick();
            },
            init: () => {
                loginController.otp.setEvents();
                loginController.otp.helpers.showPhoneShowCase();
            }
        },
        rescue: {
            formValid: false,
            formSubmitted: false,
            phoneMaskSelector: "input#cellNumberMask",
            phoneMaskElement: () => {
                return $(loginController.rescue.phoneMaskSelector);
            },
            formSelector: 'form',
            formElement: () => {
                return $(loginController.rescue.formSelector);
            },
            continueButtonSelector: 'input#emailContinueButton',
            continueButtonElement: () => {
                return $(loginController.rescue.continueButtonSelector);
            },
            submitButtonSelector: 'input#emailSubmitButton',
            submitButtonElement: () => {
                return $(loginController.rescue.submitButtonSelector);
            },
            phoneInputSelector: 'input#cellNumber',
            phoneInput: () => {
                return $(loginController.rescue.phoneInputSelector)
            },
            emailInputSelector: 'input#Email[name="Email"]',
            emailInputElement: () => {
                return $(loginController.rescue.emailInputSelector);
            },
            emailShowCaseSelector: '#emailShowcase',
            emailShowCaseElement: () => {
                return $(loginController.rescue.emailShowCaseSelector);
            },
            emailShowCaseBoxSelector: '.input-set-email-temp',
            emailShowCaseBox: () => {
                return $(loginController.rescue.emailShowCaseBoxSelector);
            },
            changeStateToPhoneSelector: '#changeStateToPhone',
            changeStateToPhoneElement: () => {
                return $(loginController.rescue.changeStateToPhoneSelector);
            },
            changeEmailSelector: '#changeEmail',
            changeEmailElement: () => {
                return $(loginController.rescue.changeEmailSelector);
            },
            helpers: {

                //phoneInput: () => {
                //    loginController.helpers.preventCCPDDEvent(loginController.rescue.phoneMaskSelector);
                //    loginController.helpers.checkKeyPress(loginController.rescue.phoneMaskSelector);
                //    loginController.helpers.handleEnterKeyPress(loginController.rescue.phoneMaskSelector);
                //    loginController.rescue.phoneMaskElement().on("input", function (e) {
                //        if (loginController.type == "bama") {
                //            loginController.rescue.phoneMaskElement().val(loginController.helpers.toEnglish(loginController.rescue.phoneMaskElement().val()));
                //        } else {
                //            loginController.rescue.phoneMaskElement().val(loginController.helpers.toPersian(loginController.rescue.phoneMaskElement().val()));
                //        }
                //        loginController.rescue.phoneInput().val("09" + loginController.helpers.toEnglish(loginController.rescue.phoneMaskElement().val()));
                //        loginController.rescue.helpers.setRescueFormValidat();
                //    });
                //},
                setRescueFormValidat: () => {
                    let result = loginController.helpers.phoneNumberValidator(loginController.rescue.phoneInput().val());
                    if (result.valid == true) {
                        loginController.rescue.formValid = true;
                    } else {
                        loginController.rescue.formValid = false;
                    }
                },
                setEmailAndShowCase: () => {
                    let email
                    if (offpageerr_state == 1 || sessionStorage.getItem('rescue_submitted_email')) {
                        email = sessionStorage.getItem('rescue_submitted_email');
                    } else {
                        email = sessionStorage.getItem('submitted_email');
                    }
                    if (email != undefined) {
                        loginController.rescue.emailInputElement().val(email);
                        loginController.rescue.emailShowCaseElement().text(email.toString());
                        loginController.rescue.emailShowCaseBox().css('display', 'grid');
                    }
                },
                validatePhone: () => {
                    let result = loginController.helpers.phoneNumberValidator(loginController.rescue.phoneInput().val());
                    if (result.valid == true) {
                        loginController.rescue.helpers.onValidPhone();
                    } else {
                        loginController.rescue.helpers.onInvalidPhone(result.message);
                    }
                },
                onInvalidPhone: error => {
                    loginController.rescue.submitButtonElement().prop("disabled", true);
                    loginController.rescue.submitButtonElement().attr("disabled", true);
                    loginController.rescue.phoneMaskElement().focus();
                    loginController.helpers.errorHandler(error);
                },
                onValidPhone: () => {
                    loginController.rescue.submitButtonElement().prop("disabled", false);
                    loginController.rescue.submitButtonElement().attr("disabled", false);
                    loginController.rescue.submitButtonElement().click();
                },
            },
            events: {
                continueButtonElementClick: () => {
                    loginController.rescue.continueButtonElement().click(() => {
                        loginController.rescue.helpers.validatePhone();
                    });
                },
                formSubmit: () => {
                    loginController.rescue.formElement().submit((event) => {
                        if (loginController.rescue.formValid == true) {
                            if (!sessionStorage.getItem('rescue_submitted_email')) {
                                sessionStorage.setItem('rescue_submitted_email', sessionStorage.getItem('submitted_email'));
                            }
                            sessionStorage.removeItem('submitted_email');
                            if (loginController.rescue.formSubmitted == false) {
                                loginController.rescue.formSubmitted = true;
                            }
                        } else {
                            event.preventDefault();
                            loginController.helpers.onInvalidOtpUsername("شماره موبایل نادرست است.");
                        }
                    });
                },
                phoneInput: () => {
                    loginController.helpers.preventCCPDDEvent(loginController.rescue.phoneMaskSelector);
                    loginController.helpers.checkKeyPress(loginController.rescue.phoneMaskSelector);
                    loginController.helpers.handleEnterKeyPress(loginController.rescue.phoneMaskSelector);
                    loginController.rescue.phoneMaskElement().on("input", function (e) {
                        if (loginController.type == "bama") {
                            loginController.rescue.phoneMaskElement().val(loginController.helpers.toEnglish(loginController.rescue.phoneMaskElement().val()));
                        } else {
                            loginController.rescue.phoneMaskElement().val(loginController.helpers.toPersian(loginController.rescue.phoneMaskElement().val()));
                        }
                        loginController.rescue.phoneInput().val("09" + loginController.helpers.toEnglish(loginController.rescue.phoneMaskElement().val()));
                        let result = loginController.helpers.phoneNumberValidator(loginController.rescue.phoneInput().val());
                        if (result.valid == true) {
                            loginController.rescue.formValid = true;
                        } else {
                            loginController.rescue.formValid = false;
                        }
                    });
                },
                changeEmailClick: () => {
                    loginController.rescue.changeEmailElement().click((event) => {
                        sessionStorage.removeItem('submitted_email');
                        sessionStorage.setItem('set_login_to_email', true);
                        window.location.href = sessionStorage.getItem('change_email_url');
                    })
                },
            },
            setEvents: () => {
                loginController.rescue.events.continueButtonElementClick();
                loginController.rescue.events.formSubmit();
                loginController.rescue.events.phoneInput();
                loginController.rescue.events.changeEmailClick();
            },
            init: () => {
                loginController.rescue.setEvents();
                loginController.rescue.helpers.setEmailAndShowCase();
            }
        },
        init: () => {
            if (typeof login_state != undefined) {
                let ls = parseInt(login_state);
                if (ls === 3) {
                    loginController.setType();
                    loginController.otp.init();
                    loginController.setOffPageErrorState();
                } else if (ls === 4) {
                    loginController.setType();
                    loginController.rescue.init();
                    loginController.setOffPageErrorState();
                } else {
                    loginController.setType();
                    loginController.setState();
                    loginController.setEvents();
                    loginController.toggleLoginState();
                    loginController.setOffPageErrorState();
                }
            }
        },
    };
    loginController.init();
});