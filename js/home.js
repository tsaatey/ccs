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

    // method to show add user form
    var addUser = document.getElementById('add_user');
    if (addUser) {
        addUser.addEventListener('click', () => {
            setHeader('Add User');
            displayClickedMenu('delete_user_area', 'none');
            displayClickedMenu('add_user_area', 'block');
            displayClickedMenu('account_reset_area', 'none');
            displayClickedMenu('dashboard_area', 'none');
            displayClickedMenu('change_admin_password', 'none');
            $('#change_admin').removeClass('selected');
            $("#dashboard").removeClass('selected');
            $('#new_user').addClass('selected');
            $('#user_delete').removeClass('selected');
            $('#reset_account').removeClass('selected');
            $('#change_admin_pass').removeClass('selected');
        });
    };

    var addUser = document.getElementById('delete_user');
    if (addUser) {
        addUser.addEventListener('click', () => {
            setHeader('Delete User');
            displayClickedMenu('delete_user_area', 'block');
            displayClickedMenu('add_user_area', 'none');
            displayClickedMenu('account_reset_area', 'none');
            displayClickedMenu('dashboard_area', 'none');
            displayClickedMenu('change_admin_password', 'none');
            $('#change_admin').removeClass('selected');
            $("#dashboard").removeClass('selected');
            $('#new_user').removeClass('selected');
            $('#user_delete').addClass('selected');
            $('#reset_account').removeClass('selected');
            $('#change_admin_pass').removeClass('selected');
        });
    }
    ;

    var addUser = document.getElementById('account_reset');
    if (addUser) {
        addUser.addEventListener('click', () => {
            setHeader('Reset User Account');
            displayClickedMenu('delete_user_area', 'none');
            displayClickedMenu('add_user_area', 'none');
            displayClickedMenu('account_reset_area', 'block');
            displayClickedMenu('dashboard_area', 'none');
            displayClickedMenu('change_admin_password', 'none');
            $('#change_admin').removeClass('selected');
            $("#dashboard").removeClass('selected');
            $('#new_user').removeClass('selected');
            $('#user_delete').removeClass('selected');
            $('#reset_account').addClass('selected');
            $('#change_admin_pass').removeClass('selected');
        });
    }
    ;

    var addUser = document.getElementById('admin_dashboard');
    if (addUser) {
        addUser.addEventListener('click', () => {
            setHeader('Dashboard');
            displayClickedMenu('delete_user_area', 'none');
            displayClickedMenu('add_user_area', 'none');
            displayClickedMenu('account_reset_area', 'none');
            displayClickedMenu('dashboard_area', 'block');
            displayClickedMenu('change_admin_password', 'none');
            displayInstructions('dashboard_activity_heading', 'Users');
            $('#change_admin').removeClass('selected');
            $("#dashboard").addClass('selected');
            $('#new_user').removeClass('selected');
            $('#user_delete').removeClass('selected');
            $('#reset_account').removeClass('selected');
            $('#change_admin_pass').removeClass('selected');

        });
    }
    ;

    var resetAdminPassword = document.getElementById('change_admin');
    if (resetAdminPassword) {
        resetAdminPassword.addEventListener('click', function () {
            setHeader('Change Admin Passowrd');
            displayClickedMenu('delete_user_area', 'none');
            displayClickedMenu('add_user_area', 'none');
            displayClickedMenu('account_reset_area', 'none');
            displayClickedMenu('dashboard_area', 'none');
            displayClickedMenu('change_admin_password', 'block');
            $("#dashboard").removeClass('selected');
            $('#new_user').removeClass('selected');
            $('#user_delete').removeClass('selected');
            $('#reset_account').removeClass('selected');
            $('#change_admin_pass').addClass('selected');
        });
    }

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
            phone: getFormData('phone'),
            email: getFormData('email'),
            address: getFormData('address')
        };
    };

    var saveEmployeeButton = document.getElementById('save_employee');
    if (saveEmployeeButton) {
        saveEmployeeButton.addEventListener('click', () => {
            var employee = getEmployeeDataObject();
            if (employee.firstname !== '' && employee.lastname !== '' && employee.dateOfBirth !== '' && employee.phone !== '' && employee.email !== '' && employee.address !== '') {
                var form = document.getElementById('employee_form');
                form.action = '../controllers/save_employee_data.php';
                form.method = 'POST';
                form.submit();
            } else {
                swal({
                    title: 'Validation Error',
                    text: 'All fields are required!',
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

    /*
     * All the scripts below controls the CEO home page
     */
    var transaction = document.getElementById('ceo_transaction');
    if (transaction) {
        transaction.addEventListener('click', function () {
            setHeader('Current Transactions');
            displayClickedMenu('ceo_report_area', 'none');
            displayClickedMenu('ceo_card_application_area', 'none');
            displayClickedMenu('ceo_account_settings_area', 'none');
            displayClickedMenu('dashboard_area', 'none');
            displayClickedMenu('ceo_transactions_area', 'block');
            displayClickedMenu('ceo_card_company_area', 'none');
            displayClickedMenu('ceo_questions_area', 'none');
            $("#dashboard").removeClass('selected');
            $('#ceo_report_tab').removeClass('selected');
            $('#ceo_card_application_tab').removeClass('selected');
            $('#ceo_account_settings_tab').removeClass('selected');
            $('#ceo_transaction_tab').addClass('selected');
            $('#ceo_basic_setup_tab').removeClass('selected');

        });
    }

    var report = document.getElementById('ceo_report');
    if (report) {
        report.addEventListener('click', function () {
            setHeader('Transaction Report');
            displayClickedMenu('ceo_report_area', 'block');
            displayClickedMenu('ceo_card_application_area', 'none');
            displayClickedMenu('ceo_account_settings_area', 'none');
            displayClickedMenu('dashboard_area', 'none');
            displayClickedMenu('ceo_transactions_area', 'none');
            displayClickedMenu('ceo_card_company_area', 'none');
            displayClickedMenu('ceo_questions_area', 'none');
            $("#dashboard").removeClass('selected');
            $('#ceo_report_tab').addClass('selected');
            $('#ceo_card_application_tab').removeClass('selected');
            $('#ceo_account_settings_tab').removeClass('selected');
            $('#ceo_transaction_tab').removeClass('selected');
            $('#ceo_basic_setup_tab').removeClass('selected');

        });
    }

    var dashboard = document.getElementById('ceo_dashboard');
    if (dashboard) {
        dashboard.addEventListener('click', function () {
            setHeader('Dashboard');
            displayClickedMenu('ceo_report_area', 'none');
            displayClickedMenu('ceo_card_application_area', 'none');
            displayClickedMenu('ceo_account_settings_area', 'none');
            displayClickedMenu('dashboard_area', 'block');
            displayClickedMenu('ceo_transactions_area', 'none');
            displayClickedMenu('ceo_card_company_area', 'none');
            displayClickedMenu('ceo_questions_area', 'none');
            $("#dashboard").addClass('selected');
            $('#ceo_report_tab').removeClass('selected');
            $('#ceo_card_application_tab').removeClass('selected');
            $('#ceo_account_settings_tab').removeClass('selected');
            $('#ceo_transaction_tab').removeClass('selected');
            $('#ceo_basic_setup_tab').removeClass('selected');

        });
    }

    var cardApplication = document.getElementById('ceo_card_application');
    if (cardApplication) {
        cardApplication.addEventListener('click', function () {
            setHeader('Card Application');
            displayClickedMenu('ceo_report_area', 'none');
            displayClickedMenu('ceo_card_application_area', 'block');
            displayClickedMenu('ceo_account_settings_area', 'none');
            displayClickedMenu('dashboard_area', 'none');
            displayClickedMenu('ceo_transactions_area', 'none');
            displayClickedMenu('ceo_card_company_area', 'none');
            displayClickedMenu('ceo_questions_area', 'none');
            $("#dashboard").removeClass('selected');
            $('#ceo_report_tab').removeClass('selected');
            $('#ceo_card_application_tab').addClass('selected');
            $('#ceo_account_settings_tab').removeClass('selected');
            $('#ceo_transaction_tab').removeClass('selected');
            $('#ceo_basic_setup_tab').removeClass('selected');

        });
    }

    var account_settings = document.getElementById('ceo_account_settings');
    if (account_settings) {
        account_settings.addEventListener('click', function () {
            setHeader('Account Settings');
            displayClickedMenu('ceo_report_area', 'none');
            displayClickedMenu('ceo_card_application_area', 'none');
            displayClickedMenu('ceo_account_settings_area', 'block');
            displayClickedMenu('dashboard_area', 'none');
            displayClickedMenu('ceo_transactions_area', 'none');
            displayClickedMenu('ceo_card_company_area', 'none');
            displayClickedMenu('ceo_questions_area', 'none');
            $("#dashboard").removeClass('selected');
            $('#ceo_report_tab').removeClass('selected');
            $('#ceo_card_application_tab').removeClass('selected');
            $('#ceo_account_settings_tab').addClass('selected');
            $('#ceo_transaction_tab').removeClass('selected');
            $('#ceo_basic_setup_tab').removeClass('selected');

        });
    }

    /*
     * All codes below controls the employee home page
     */
    var employee_report = document.getElementById('employee_report');
    if (employee_report) {
        employee_report.addEventListener('click', function () {
            setHeader('Transaction Report');
            displayClickedMenu('employee_report_area', 'block');
            displayClickedMenu('employee_card_application_area', 'none');
            displayClickedMenu('dashboard_area', 'none');
            displayClickedMenu('employee_transactions_area', 'none');
            $("#dashboard").removeClass('selected');
            $('#employee_report_tab').addClass('selected');
            $('#employee_card_application_tab').removeClass('selected');
            $('#employee_transaction_tab').removeClass('selected');
        });
    }

    var dashboard = document.getElementById('employee_dashboard');
    if (dashboard) {
        dashboard.addEventListener('click', function () {
            setHeader('Dashboard');
            displayClickedMenu('employee_report_area', 'none');
            displayClickedMenu('employee_card_application_area', 'none');
            displayClickedMenu('dashboard_area', 'block');
            displayClickedMenu('employee_transactions_area', 'none');
            $("#dashboard").addClass('selected');
            $('#employee_report_tab').removeClass('selected');
            $('#employee_card_application_tab').removeClass('selected');
            $('#employee_transaction_tab').removeClass('selected');
        });
    }

    var cardApp = document.getElementById('employee_card_application');
    if (cardApp) {
        cardApp.addEventListener('click', function () {
            setHeader('Card Holder Registration');
            displayClickedMenu('employee_report_area', 'none');
            displayClickedMenu('employee_card_application_area', 'block');
            displayClickedMenu('dashboard_area', 'none');
            displayClickedMenu('employee_transactions_area', 'none');
            $("#dashboard").removeClass('selected');
            $('#employee_report_tab').removeClass('selected');
            $('#employee_card_application_tab').addClass('selected');
            $('#employee_transaction_tab').removeClass('selected');
        });
    }

    var transaction = document.getElementById('employee_transaction');
    if (transaction) {
        transaction.addEventListener('click', function () {
            setHeader('Current Transactions');
            displayClickedMenu('employee_report_area', 'none');
            displayClickedMenu('employee_card_application_area', 'none');
            displayClickedMenu('dashboard_area', 'none');
            displayClickedMenu('employee_transactions_area', 'block');
            $("#dashboard").removeClass('selected');
            $('#employee_report_tab').removeClass('selected');
            $('#employee_card_application_tab').removeClass('selected');
            $('#employee_transaction_tab').addClass('selected');
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
                    && holder_details.kinContact !== ''
                    && holder_details.secretAnswer !== '') {
                // get form id and submit data
                var cardHolderForm = document.getElementById('card_holder_form');
                cardHolderForm.action = '../controllers/save_card_holder_data.php';
                cardHolderForm.method = 'POST';
                cardHolderForm.submit();

            } else {
                // display error message
                displayErrorMessage('card_holder_form_error', 'Data cannot be submitted at this time. All fields are required!');
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
            if (card_details.card_number !== '' && card_details.cvv_number !== '') {
                var creditCardForm = document.getElementById('credit_form');
                creditCardForm.action = '../controllers/save_credit_card_details.php';
                creditCardForm.method = 'POST';
                creditCardForm.submit();

            } else {
                displayErrorMessage('credit_card_error', 'Data cannot be submitted at this time. All fields are required!');
            }
        });
    }

    var counter = 0;
    var setupdisplay = document.getElementById('ceo_basic_setup');
    if (setupdisplay) {
        setupdisplay.addEventListener('click', function () {
            counter += 1;
            setHeader('Basic Setup');
            displayClickedMenu('ceo_report_area', 'none');
            displayClickedMenu('ceo_card_application_area', 'none');
            displayClickedMenu('ceo_account_settings_area', 'none');
            displayClickedMenu('dashboard_area', 'none');
            displayClickedMenu('ceo_transactions_area', 'none');
            displayClickedMenu('ceo_card_company_area', 'none');
            displayClickedMenu('ceo_report_area', 'none');
            $("#dashboard").removeClass('selected');
            $('#ceo_report_tab').removeClass('selected');
            $('#ceo_card_application_tab').removeClass('selected');
            $('#ceo_account_settings_tab').removeClass('selected');
            $('#ceo_transaction_tab').removeClass('selected');
            $('#ceo_basic_setup_tab').addClass('selected');

            if (counter === 1) {
                $('#ceo_add_card_company').css('display', 'block');
                $('#ceo_add_questions').css('display', 'block');
            } else if (counter === 2) {
                $('#ceo_add_card_company').css('display', 'none');
                $('#ceo_add_questions').css('display', 'none');
                setHeader('Dashboard');
                displayClickedMenu('dashboard_area', 'block');
                counter = 0;
            }

        });
    }

    var addCardCompany = document.getElementById('ceo_add_card_company');
    if (addCardCompany) {
        addCardCompany.addEventListener('click', function () {
            setHeader('Basic Setup');
            displayClickedMenu('ceo_card_company_area', 'block');
            displayClickedMenu('ceo_report_area', 'none');
            displayClickedMenu('ceo_card_application_area', 'none');
            displayClickedMenu('ceo_account_settings_area', 'none');
            displayClickedMenu('dashboard_area', 'none');
            displayClickedMenu('ceo_transactions_area', 'none');
            displayClickedMenu('ceo_questions_area', 'none');
        });
    }

    var securityQuestion = document.getElementById('ceo_add_questions');
    if (securityQuestion) {
        securityQuestion.addEventListener('click', function () {
            setHeader('Basic Setup');
            displayClickedMenu('ceo_card_company_area', 'none');
            displayClickedMenu('ceo_report_area', 'none');
            displayClickedMenu('ceo_card_application_area', 'none');
            displayClickedMenu('ceo_account_settings_area', 'none');
            displayClickedMenu('dashboard_area', 'none');
            displayClickedMenu('ceo_transactions_area', 'none');
            displayClickedMenu('ceo_questions_area', 'block');
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
                                        $('#image').val('');
                                        $('#card_company').val('');
                                    }, 2000);

                                } else if (response === 'database_error'){
                                    swal(
                                            "Error!",
                                            "Database error occured", // had a missing comma
                                            "error"
                                            );
                                }
                            },
                            failure: function () {
                                swal(
                                        "Error!",
                                        "Information upload fails", // had a missing comma
                                        "error"
                                        );
                            }
                        });
                    }
                } else {
                    // image is empty
                    swal(
                            "Validation failed",
                            "Please upload a company logo!.", // had a missing comma
                            "error"
                            );
                }
            } else {
                // company name is empty
                swal(
                        "Validation failed",
                        "Please provide a company name!.", // had a missing comma
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




})();

