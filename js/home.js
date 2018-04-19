/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

(() => {
    /*
     * All the scriots below controls the admin work area
     * @param {type} text
     * @returns {undefined}
     */
// method to display menu header
    let setHeader = (text) => {
        var h1 = document.getElementById('header_display');
        h1.innerHTML = text;
    };
    let displayClickedMenu = (id, displayMode) => {
        var element = document.getElementById(id);
        element.style.display = displayMode;
    };
    let displayInstructions = (id, text) => {
        var element = document.getElementById(id);
        element.innerHTML = text;
    };
    let getFormData = (id) => {
        return document.getElementById(id).value;
    };
    let getEmployeeDataObject = () => {
        return{
            firstname: getFormData('firstname'),
            lastname: getFormData('lastname'),
            dateOfBirth: getFormData('dob'),
            gender: getFormData('gender'),
            phone: getFormData('phone'),
            email: getFormData('email'),
            address: getFormData('address'),
            roleId: getFormData('roleId')
        };
    };
    var saveEmployeeButton = document.getElementById('save_employee');
    if (saveEmployeeButton) {
        saveEmployeeButton.addEventListener('click', () => {
            var employee = getEmployeeDataObject();
            if (employee.firstname !== '' && employee.lastname !== '' && employee.dateOfBirth !== '' && employee.phone !== '' && employee.email !== '' && employee.address !== '') {
//                var form = document.getElementById('add_user_form');
//                form.action = '../controllers/save_employee_data.php';
//                form.method = 'POST';
//                form.submit();

                swal({
                    title: "Uploading information...",
                    text: "Please wait",
                    imageUrl: "../images/ajax_loader_blue_64.gif",
                    showConfirmButton: false,
                    allowOutsideClick: false
                });
                $.ajax({
                    url: '../controllers/save_employee_data.php',
                    method: 'POST',
                    data: {firstname: employee.firstname, lastname: employee.lastname, gender: employee.gender, dob: employee.dateOfBirth, phone: employee.phone, email: employee.email, address: employee.address, roleId: employee.roleId},
                    complete: function (response) {
                        if (response.responseText === 'employee_saved') {
                            swal({
                                title: 'Success',
                                text: 'Employee saved!',
                                type: 'success'

                            });
                            setTimeout(function () {
                                location.reload(true);
                            }, 3000);
                        }

                        if (response.responseText === 'something_went_wrong') {
                            swal({
                                title: 'Error',
                                text: 'Internal error occured! Please try again',
                                type: 'error'

                            });
                        }

                        if (response.responseText === 'invalid_email') {
                            swal({
                                title: 'Validation Error',
                                text: 'The email address provided is not valid',
                                type: 'error'

                            });
                        }

                        if (response.responseText === 'empty_fields') {
                            swal({
                                title: 'Validation Error!',
                                text: 'All fields are required!',
                                type: 'error'

                            });
                        }
                    }
                });
            } else {
                swal({
                    title: 'Validation Error',
                    text: 'Provide values for all fields!',
                    type: 'error'

                });
            }
        });
    }

    let getAccountDetails = () => {
        return{
            password: getFormData('user_password'),
            confirmedPassword: getFormData('user_password_confirmed')
        };
    };
    var account_button = document.getElementById('create_account_button');
    if (account_button) {
        account_button.addEventListener('click', () => {
            var acc = getAccountDetails();
            if (acc.password !== '' && acc.confirmedPassword !== '') {
                if (acc.password === acc.confirmedPassword) {
                    if (validatePassword() === true) {
                        var form = document.getElementById('account_form');
                        form.action = '../controllers/create_account.php';
                        form.method = 'POST';
                        form.submit();
                    } else {
                        displayErrorMessage('create_account_error', 'Password must contain at least 6 characters, including UPPER/lower case and numbers');
                    }
                } else {
                    displayErrorMessage('create_account_error', 'Passwords do not match!');
                }
            } else {
                displayErrorMessage('create_account_error', 'Password fields must not be empty!');
            }
        });
    }

    /*
     * Function to display error messages. It takes id of element and message to be displayed
     * as parameters
     */
    let displayErrorMessage = (id, message) => {
        var element = document.getElementById(id);
        element.innerHTML = message;
        element.style.color = 'red';
        element.style.fontFamily = 'Tahoma';
        element.style.fontWeight = 'normal';
        element.style.paddingLeft = '30px';
    };

    /*
     * Function to validate passwords
     * Adopted from 'THE ART OF WEB'
     * www.the-art-of-web.com/javascript/validate-password/
     */
    let checkPassword = (password) => {
        var regularExpression = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}$/;
        return regularExpression.test(password);
    };

    let validatePassword = () => {
        var pass = getAccountDetails();
        if (!checkPassword(pass.password)) {
            return false;
        }
        return true;
    };

    let validateAdminPassword = () => {
        var pass = getNewAdminPassword();
        if (!checkPassword(pass.admin_password)) {
            return false;
        }
        return true;
    };

    var account_button = document.getElementById('reset_password_button');
    if (account_button) {
        account_button.addEventListener('click', () => {
            var acc = getAccountDetails();
            if (acc.password !== '' && acc.confirmedPassword !== '') {
                if (acc.password === acc.confirmedPassword) {
                    if (validatePassword() === true) {
                        var form = document.getElementById('reset_password_form');
                        form.action = '../controllers/reset_password.php';
                        form.method = 'POST';
                        form.submit();
                        $.ajax({
                            url: '../controllers/reset_password.php',
                            method: 'POST',
                            data: {username: document.getElementById('user_mail').value, password: acc.password},
                            complete: function (response) {
                                if (response.responseText === 'account_error') {
                                    swal({
                                        title: 'Action failed',
                                        text: 'Password could not be reset. Please try again!',
                                        type: 'error'
                                    });
                                }

                                if (response.responseText === 'empty_password') {
                                    displayErrorMessage('form_error', 'Please supply values for all fields!');
                                }
                            }
                        }).fail(
                                swal({
                                    title: 'Internal Error',
                                    text: 'Process failed! An internal error has occured',
                                    type: 'error'
                                })
                                );
                    } else {
                        displayErrorMessage('form_error', 'Password must contain at least 6 characters, including UPPER/lower case and numbers');
                    }
                } else {
                    displayErrorMessage('form_error', 'Passwords do not match!');
                }
            } else {
                displayErrorMessage('form_error', 'Password fields must not be empty!');
            }
        });
    }

    let getNewAdminPassword = () => {
        return{
            admin_password: getFormData('new_admin_password'),
            confirmed_admin_password: getFormData('new_admin_password_confirmed')
        };
    };
    var adminPasswordResetButton = document.getElementById('admin_reset_password_button');
    if (adminPasswordResetButton) {
        adminPasswordResetButton.addEventListener('click', () => {
            var acc = getNewAdminPassword();
            if (acc.admin_password !== '' && acc.confirmed_admin_password !== '') {
                if (acc.admin_password === acc.confirmed_admin_password) {
                    if (validateAdminPassword() === true) {
                        var form = document.getElementById('new_admin_password_form');
                        form.action = '../controllers/change_admin_password.php';
                        form.method = 'POST';
                        form.submit();
                    } else {
                        displayErrorMessage('some_error', 'Password must contain at least 6 characters, including UPPER/lower case and numbers');
                    }
                } else {
                    displayErrorMessage('some_error', 'Passwords do not match!');
                }
            } else {
                displayErrorMessage('some_error', 'Password fields must not be empty!');
            }

        });
    }

    let getCardHolderObject = () => {
        return {
            firstname: getFormData('firstname'),
            lastname: getFormData('lastname'),
            gender: getFormData('gender'),
            dob: getFormData('dob'),
            address: getFormData('address'),
            phone: getFormData('phone'),
            email: getFormData('email'),
            country: getFormData('country'),
            city: getFormData('city'),
            nameOfKin: getFormData('name_of_kin'),
            addressOfKin: getFormData('address_of_kin'),
            kinContact: getFormData('kin_contact'),
            secretQuestion: getFormData('secret_question'),
            secretAnswer: getFormData('secret_answer')
        };
    };
    var registerCardHolderButton = document.getElementById('create_card_holder_account_button');
    if (registerCardHolderButton) {
        registerCardHolderButton.addEventListener('click', function () {
            var holder_details = getCardHolderObject();
            if (holder_details.firstname !== ''
                    && holder_details.lastname !== ''
                    && holder_details.address !== ''
                    && holder_details.phone !== ''
                    && holder_details.email !== ''
                    && holder_details.nameOfKin !== ''
                    && holder_details.addressOfKin !== ''
                    && holder_details.dob !== ''
                    && holder_details.city !== ''
                    && holder_details.country !== ''
                    && holder_details.secretQuestion !== ''
                    && holder_details.kinContact !== ''
                    && holder_details.secretAnswer !== '') {
                // get form id and submit data
                var cardHolderForm = document.getElementById('card_holder_form');
                cardHolderForm.action = '../controllers/save_card_holder_data.php';
                cardHolderForm.method = 'POST';
                cardHolderForm.submit();
            } else {
                // display error message
                //displayErrorMessage('card_holder_form_error', 'Data cannot be submitted at this time. All fields are required!');
                swal({
                    title: 'Validation Error!',
                    text: 'All fields are required',
                    type: 'error'
                });
            }
        });
    }

    let getCreditCardDetails = () => {
        return {
            card_number: getFormData('credit_card_number'),
            issuedDate: getFormData('issued_date'),
            expiryDate: getFormData('expiry_date'),
            cvv_number: getFormData('cvv'),
            card_issuer: getFormData('card_issuer')
        };
    };
    var creditCardButton = document.getElementById('create_card_details_submit');
    if (creditCardButton) {
        creditCardButton.addEventListener('click', function () {
            var card_details = getCreditCardDetails();
            if (card_details.card_number !== '' && card_details.cvv_number !== '' && card_details.issuedDate !== '' && card_details.expiryDate !== '' && card_details.card_issuer !== '') {
                $.ajax({
                    url: '../controllers/save_credit_card_details.php',
                    method: 'POST',
                    data: {credit_card_number: card_details.card_number, cvv: card_details.cvv_number, issued_date: card_details.issuedDate, expiry_date: card_details.expiryDate, card_issuer: card_details.card_issuer},
                    complete: function (response) {
                        if (response.responseText === 'connection_error') {
                            swal({
                                title: 'Connection Error',
                                text: 'Make sure there is internet connectivity and try again',
                                type: 'info'
                            });
                        }

                        if (response.responseText === 'cvv_invalid') {
                            displayErrorMessage('credit_card_error', 'The CVV number you supplied is not a positive integer!');
                        }

                        if (response.responseText === 'card_number_invalid') {
                            displayErrorMessage('credit_card_error', 'The credit card number you supplied is not a positive integer!');
                        }

                        if (response.responseText === 'empty_card_fields') {
                            displayErrorMessage('credit_card_error', 'Data cannot be submitted at this time. All fields are required!');
                        }
                    }
                }).fail(
                        swal({
                            title: 'Error!',
                            text: 'An intenal error has occured',
                            type: 'error'
                        })
                        );
            } else {
                displayErrorMessage('credit_card_error', 'Data cannot be submitted at this time. All fields are required!');
            }
        });
    }


    var saveCardCompanyButton = document.getElementById('card_company_button');
    if (saveCardCompanyButton) {
        saveCardCompanyButton.addEventListener('click', function () {
            if (document.getElementById('card_company').value !== '') {
                if (document.getElementById('image').value !== '') {
                    // validate image
                    var imageExtension = $('#image').val().split('.').pop().toLowerCase();
                    if (jQuery.inArray(imageExtension, ['png', 'jpg', 'jpeg']) === -1) {
                        //invalid image
                        swal(
                                "Validation failed",
                                "Please uploaded image is not valid!.", // had a missing comma
                                "error"
                                );
                        $('#image').val('');
                    } else {
                        // all is well
                        swal({
                            title: "Uploading information...",
                            text: "Please wait",
                            imageUrl: "../images/ajax_loader_blue_64.gif",
                            showConfirmButton: false,
                            allowOutsideClick: false
                        });
                        var property = document.getElementById('image').files[0];
                        var company = document.getElementById('card_company').value;
                        var formData = new FormData();
                        formData.append("card_company", company);
                        formData.append("image", property);
                        $.ajax({
                            url: '../controllers/save_card_company.php',
                            method: 'POST',
                            data: formData,
                            contentType: false,
                            cache: false,
                            processData: false,
                            success: function (response) {
                                if (response === 'success') {
                                    swal({
                                        title: "Success!",
                                        text: 'Information uploaded!',
                                        type: 'success',
                                        showConfirmButton: false,
                                        timer: 2000
                                    });
                                    setTimeout(function () {
                                        $('#image1').val('');
                                        $('#card_company').val('');
                                    }, 2000);
                                } else if (response === 'database_error') {
                                    swal(
                                            "Error!",
                                            "Database error occured",
                                            "error"
                                            );
                                }
                            },
                            failure: function () {
                                swal(
                                        "Error!",
                                        "Information upload fails",
                                        "error"
                                        );
                            }
                        });
                    }
                } else {
                    // image is empty
                    swal(
                            "Validation failed",
                            "Please upload a company logo!.",
                            "error"
                            );
                }
            } else {
                // company name is empty
                swal(
                        "Validation failed",
                        "Please provide a company name!.",
                        "error"
                        );
            }
        });
    }


    var secretQuestionButton = document.getElementById('security_question_button');
    if (secretQuestionButton) {
        secretQuestionButton.addEventListener('click', function () {
            if (document.getElementById('security_question').value !== '') {
                // all is well
                swal({
                    title: "Saving question...",
                    text: "Please wait",
                    imageUrl: "../images/ajax_loader_blue_64.gif",
                    showConfirmButton: false,
                    allowOutsideClick: false
                });
                var question = document.getElementById('security_question').value;
                $.ajax({
                    url: '../controllers/save_security_question.php',
                    method: 'POST',
                    data: {question: question},
                    success: function (response) {
                        if (response === 'success') {
                            swal({
                                title: "Success!",
                                text: 'Information uploaded!',
                                type: 'success',
                                showConfirmButton: false,
                                timer: 2000
                            });
                            setTimeout(function () {
                                $('#security_question').val('');
                            }, 2000);
                        } else if (response === 'fail') {
                            swal({
                                title: 'Failed to save data',
                                text: 'A network error may have occured!',
                                type: 'error'
                            });
                        } else if (response === 'field_empty') {
                            swal({
                                title: 'Validation failed',
                                text: 'Please provide a question',
                                type: 'error'
                            });
                        }
                    }
                });
            } else {
                swal({
                    title: 'Validation failed',
                    text: 'Please provide a question',
                    type: 'error'
                });
            }
        });
    }

    var getSpecifiTransactionButton = document.getElementById('specific_transaction_button');
    if (getSpecifiTransactionButton) {
        getSpecifiTransactionButton.addEventListener('click', function () {
            if (document.getElementById('start_date').value !== '' && document.getElementById('end_date').value !== '') {
                start_date = document.getElementById('start_date').value;
                end_date = document.getElementById('end_date').value;
                $.ajax({
                    url: '../controllers/fetch_specific_transaction.php',
                    method: 'POST',
                    data: {start_date: start_date, end_date: end_date},
                    complete: function (response) {
                        $('#specific_transaction_area').html(response.responseText);
                    }
                });
            } else {
                displayErrorMessage('specific_transaction_error', 'Please provide start date and end date!');
            }
        });
    }
    
    let getSpecificReportQueryData = () => {
        return {
           card: getFormData('card'),
           startDate: getFormData('start_date'),
           endDate: getFormData('end_date')
        };
    };
    
    var specificCustomerTransactionReportButton = document.getElementById('specific_customer_report_button');
    if (specificCustomerTransactionReportButton) {
        specificCustomerTransactionReportButton.addEventListener('click', () => {
            var data = getSpecificReportQueryData();
            if (data.card !== '' && data.endDate !== '' && data.startDate !== '') {
                var form = document.getElementById('specific_report_form');
                form.action = '../controllers/get_specific_customer_report.php';
                form.method = 'POST';
                form.submit();
            } else {
                displayErrorMessage('specific_transaction_error', 'Please all fields are required!');
            }
        });
    }
    
    var multipleCustomerReportButton = document.getElementById('multiple_customer_report_button');
    if (multipleCustomerReportButton) {
        multipleCustomerReportButton.addEventListener('click', function () {
            var start_date = document.getElementById('start_date').value;
            var end_date = document.getElementById('end_date').value;
            if (start_date !== '' && end_date !== '') {
                var form = document.getElementById('multiple_report_form');
                form.action = '../controllers/multiple_report_request.php';
                form.method = 'POST',
                form.submit();
            } else {
                displayErrorMessage('specific_transaction_error', 'Please all fields are required!');
            }
        });
    }
    
    var unlockCardHolderAccount = document.getElementById('retrieve_card_holder_account_button');
    if (unlockCardHolderAccount) {
        unlockCardHolderAccount.addEventListener('click', function () {
            var username = document.getElementById('card_holder_username').value;
            if (username !== '') {
                $.ajax({
                    url: '../controllers/unlock_account.php',
                    method: 'POST',
                    data: {username: username},
                    complete: function (response) {
                        if (response.responseText === 'invalid_username') {
                            displayErrorMessage('some_error', 'Username provided does not exist in the system!');
                        }
                        
                        if (response.responseText === 'internal_error') {
                            swal({
                               title: 'Internal Error!',
                               text: 'An internal error has occured. Please try again',
                               type: 'error'
                            });
                        }
                    }
                });
            } else {
                displayErrorMessage('some_error', 'Please provide a username!');
            }
        });
    }
    

})();

