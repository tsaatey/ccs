/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

(function () {

    /*
     * 
     */
    let getFormData = (id) => {
        return document.getElementById(id).value;
    };

    /*
     * 
     */
    let getBillingDataObject = () => {
        return{
            cardnumber: getFormData('cardnumber'),
            securitycode: getFormData('cvvnumber'),
            expirydate: getFormData('expiry_date'),
            amount: getFormData('amount')
        };
    };

    /*
     * 
     */
    var submitButton = document.getElementById('transaction_submit');
    if (submitButton) {
        submitButton.addEventListener('click', function (e) {
            e.preventDefault();
            var data = getBillingDataObject();
            if (data.cardnumber !== '' && data.securitycode !== '' && data.expirydate !== '' && data.amount !== '') {
                swal({
                    title: "Processing transaction...",
                    text: "Please wait",
                    imageUrl: "../images/ajax_loader_blue_64.gif",
                    showConfirmButton: false,
                    allowOutsideClick: false
                });
                $.ajax({
                    url: '../controllers/process_transaction.php',
                    method: "POST",
                    data: {cardnumber: data.cardnumber, securitycode: data.securitycode, expirydate: data.expirydate, amount: data.amount},
                    dataType: 'json',
                    complete: function (response) {
                        console.log(response);
                        if (response.responseText === 'transaction_processed') {
                            swal({
                                title: "Success!",
                                text: 'Your transaction is successful',
                                type: 'success',
                                showConfirmButton: false,
                                timer: 9000
                            });
                            setTimeout(function () {
                                location.reload();
                                $('#notification_div').css('display', 'inline-block');
                                $('#notification_area').css('display', 'none');
                            }, 2000);
                        } else if (response.responseText === 'transaction_failed') {
                            swal(
                                    "Internal Error",
                                    "Oops, transaction processing failed!.",
                                    "error"
                                    );
                        } else if (response.responseText === 'empty_fields') {
                            swal(
                                    "Validation failed",
                                    "All fields are required!.",
                                    "error"
                                    );
                        } else if (response.responseText === 'wrong_number_format') {
                            swal(
                                    "Internal Error",
                                    "Please amount must be a number!.",
                                    "error"
                                    );
                        } else if (response.responseText === 'client_not_loggedin') {
                            swal(
                                    "Login",
                                    "Please you must login to do this!.",
                                    "error"
                                    );
                        } else if (response.responseText === 'invalid_date') {
                            swal(
                                    "Date Error!",
                                    "Date provided is in invalid format. Must be Year-month-day in numbers",
                                    "error"
                                    );
                        } else if (response.responseText === 'invalid_card') {
                            swal(
                                    "Invalid Card!",
                                    "Some credit card information provided is not valid!",
                                    "error"
                                    );
                        } else if (response.responseText === 'network_error') {
                            swal(
                                    "Network Error!",
                                    "There is no network connectivity! Check your internet connection",
                                    "error"
                                    );
                        } else if (response.responseText === 'all_is_well') {
                            swal(
                                    "No Previous Location!",
                                    "No previous location record found",
                                    "success"
                                    );
                        } else if (response.responseText === 'location_does_not_have_a_match' || response.responseText === 'suspicious_activity') {
                            // display security check page
                            swal(
                                    "Account Verification!",
                                    "Please verify your account to continue",
                                    "warning"
                                    );
                            setTimeout(function () {
                                location.reload();
                            }, 3000);

                        } else if (response.responseText === 'credit_card_expired') {
                            swal(
                                    "Stopped!",
                                    "Credit card has expired",
                                    "error"
                                    );
                        } else if (response.responseText === 'account_suspended') {
                            swal(
                                    "Account Suspended!",
                                    "This account has been suspended because a suspicious activity was detected. Please contact customer support",
                                    "info"
                                    );
                        }

                    }
                });
            } else {
                swal(
                        "Validation failed",
                        "Please all fields are required!",
                        "error"
                        );
            }


        });
    }

    /*
     * 
     */
    var globalTimeout = null;
    $('#cardnumber').on('keyup focus', function () {
        if (globalTimeout !== null) {
            clearTimeout(globalTimeout);
        }
        var number_card = document.getElementById('cardnumber').value;
        if (number_card !== '') {
            globalTimeout = setTimeout(function () {
                globalTimeout = null;
                //ajax code
                $.ajax({
                    url: '../controllers/search_logo.php',
                    method: "POST",
                    data: {card_number: number_card},
                    beforeSend: function () {
                        $('#logo').remove('#text_display');
                        $('#logo').html('<img src="../images/ajax_loader_blue_48.gif" width="60" height="32" alt="no_logo"/>');
                    },
                    complete: function (response) {
                        if (response !== 'NaN') {
                            // response comes as an object. responseText is the key to the image itself inside the object
                            $('#logo').html('<img src="data:image/png;base64,' + response.responseText + '" width="60" height="32" alt="no_logo" />');
                        }
                    }
                });

            }, 1500);
        }

    });

    /*
     * 
     */
    var buyLoginButton = document.getElementById('buyer_login_button');
    if (buyLoginButton) {
        buyLoginButton.addEventListener('click', function () {
            if (document.getElementById('buyer_username').value !== '' && document.getElementById('buyer_password').value !== '') {
                swal({
                    title: "You are being logged in...",
                    text: "Please wait",
                    imageUrl: "../images/ajax_loader_blue_64.gif",
                    showConfirmButton: false,
                    allowOutsideClick: false
                });
                var username = document.getElementById('buyer_username').value;
                var password = document.getElementById('buyer_password').value;
                $.ajax({
                    url: '../controllers/buyer_login.php',
                    method: 'POST',
                    data: {username: username, password: password},
                    complete: function (response) {
                        if (response.responseText === 'invalid_email') {
                            swal(
                                    "Validation failed",
                                    "Provided email is not valid!",
                                    "error"
                                    );
                        }

                        if (response.responseText === 'empty_fields') {
                            swal(
                                    "Validation failed",
                                    "Username and password required!",
                                    "error"
                                    );
                        }

                        if (response.responseText === 'login_success') {
                            setTimeout(function () {
                                window.location.reload(true);
                            }, 1000);

                        }

                        if (response.responseText === 'login_failed') {
                            swal(
                                    "Login failed!",
                                    "Username or password is not correct!.",
                                    "error"
                                    );
                        }
                    }
                });
            } else {
                swal(
                        "Validation failed",
                        "Username and password required!",
                        "error"
                        );
            }
        });
    }

    /*
     * 
     */
    var securityButton = document.getElementById('confirm_button');
    if (securityButton) {
        securityButton.addEventListener('click', function () {
            if (document.getElementById('phone_number').value !== '' && document.getElementById('secret_answer').value !== '' && document.getElementById('next_kin').value !== '') {
                swal({
                    title: "Checking...",
                    text: "Please wait",
                    imageUrl: "../images/ajax_loader_blue_64.gif",
                    showConfirmButton: false,
                    allowOutsideClick: false
                });
                var phone = document.getElementById('phone_number').value;
                var answer = document.getElementById('secret_answer').value;
                var kin = document.getElementById('next_kin').value;

                $.ajax({
                    url: '../controllers/security_check.php',
                    method: 'POST',
                    data: {phone: phone, answer: answer, kin: kin},
                    complete: function (response) {
                        console.log(response);
                        if (response.responseText === 'security_check_passed') {
                            swal({
                                title: "Security Check Passed!",
                                text: 'Your transaction will now be processed',
                                type: 'success',
                                showConfirmButton: false,
                                timer: 2000
                            });

                            setTimeout(function () {
                                location.reload();
                            }, 2000);
                        }

                        if (response.responseText === 'security_check_failed') {
                            swal(
                                    "Security Check Failed!",
                                    "Your transaction cannot be processed because you have failed the security check test!",
                                    "error"
                                    );
                        }

                        if (response.responseText === 'empty_fields') {
                            swal(
                                    "Validation Failed!",
                                    "All fields are required!",
                                    "error"
                                    );
                        }

                        if (response.responseText === 'transaction_failed') {
                            swal(
                                    "Transaction failed!",
                                    "Please something went wrong! Try again",
                                    "error"
                                    );
                        }

                        if (response.responseText === 'connection_error') {
                            swal(
                                    "Connection Error!",
                                    "Please connect to the internet",
                                    "error"
                                    );
                        }

                        if (response.responseText === 'cannot_reset') {
                            swal(
                                    "Error!",
                                    "Internal error occured. Please try again",
                                    "error"
                                    );
                        }
                    }
                });

            } else {
                swal(
                        "Validation failed",
                        "All fields are required!",
                        "error"
                        );
            }
        });
    }

    /*
     * 
     */
    var cancelSecurityCheckButton = document.getElementById('abort_button');
    if (cancelSecurityCheckButton) {
        cancelSecurityCheckButton.addEventListener('click', function () {
            $('#notification_div').css('display', 'inline-block');
            $('#notification_area').css('display', 'none');
        });
    }
    
    var resetButton = document.getElementById('button_cancel');
    if (resetButton) {
        resetButton.addEventListener('click', function () {
            window.location.reload(true);
        });
    }



})();



