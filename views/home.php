<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once '../controllers/CrudOperation.php';
require_once '../controllers/GenerateReport.php';
?>

<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="../css/home.css" rel="stylesheet"/>
        <link href="../css/font-awesome.min.css" rel="stylesheet"/>
        <link href = "../css/bootstrap.min.css" rel = "stylesheet" type = "text/css"/>
        <script src = "../js/jquery.min.js"></script>
        <script src="../js/customConfirmDialog.js"></script>
        <script src="../node_modules/sweetalert2/dist/sweetalert2.all.js" type="text/javascript"></script>
        <link href="../node_modules/sweetalert2/dist/sweetalert2.min.css" rel="stylesheet" type="text/css"/>
        <script src="../js/alerts.js" type="text/javascript"></script>
        <?php
        if (!isset($_SESSION['setup_account']) || $_SESSION['setup_account'] == 0) {
            ?>
            <script src="../js/auto_logout.js" type="text/javascript"></script>
            <?php
        }
        ?>

        <link href="../css/customConfirmDialog.css" rel="stylesheet" type="text/css"/>
        <script>

        </script>
        <title>CCS home</title>
    </head>
    <body>
        <div id="header">
            <div class="logo">
                <span><img src="../images/Credit-Card.png"/></span>
                <a href="#"><span style="text-decoration: none; color: #fff;">CreditCard Shield</span></a>
            </div>
            <?php
            if (!empty($_SESSION['roleId'])) {
                ?>
                <div class="logout">
                    <span class="glyphicon glyphicon-user"></span>
                    <span id="uname"><?php echo $_SESSION['firstname']; ?></span>
                    <span><a href="../controllers/logout.php"><span class="glyphicon glyphicon-log-out"></span>&nbsp;Logout</a></span>

                </div>
                <?php
            }
            ?>

        </div>
        <?php
        if (!empty($_SESSION['roleId'])) {
            if ($_SESSION['roleId'] == 1) {
                ?>
                <!-- Administrator's home page-->
                <div id="container">
                    <div class="sidebar sticky">
                        <ul id="nav">
                            <li id="admin_dashboard"><a href="#" class="selected" id="dashboard">Dashboard</a></li>
                            <li id="add_user"><a href="#" id="new_user">Add User</a></li>
                            <li id="delete_user"><a href="#" id="user_delete">Delete User</a></li>
                            <li id="account_reset"><a href="#" id="reset_account">Reset User Account</a></li>
                            <li id="change_admin"><a href="#" id="change_admin">Change Admin Password</a></li>
                        </ul>
                    </div>
                    <div class="content">
                        <h1 id="header_display">Dashboard</h1>
                        <div id="dashboard_area">
                            <div class="box" style="display: <?php
                            if (!empty($_SESSION['user_mail'])) {
                                echo 'block';
                            } else {
                                echo 'none';
                            }
                            ?>">
                                <div class="box-top" id="dashboard_activity_heading">Account Setup</div>
                                <div class="box-panel">
                                    <div id="hidden_form" style="display:">
                                        <p>Please Finish By Setting Up Your User Account</p>
                                        <form class="form-horizontal" role="form" id="account_form">
                                            <h5 id="form_error">
                                                <?php
                                                if (isset($_GET['account_error'])) {
                                                    echo 'Account could not be created. Something went wrong!';
                                                } else if (isset($_GET['empty_password'])) {
                                                    echo 'Password fields cannot be empty!';
                                                }
                                                ?>
                                            </h5>
                                            <h5 id="create_account_error"></h5>
                                            <table>
                                                <tr>
                                                    <td class="form_labels">
                                                        <label style="font-weight: normal; font-size: 16px;" for="user_mail">Username</label>
                                                    </td>
                                                    <td class="form_inputs">
                                                        <div class = "col-md-11">
                                                            <input type = "email" class = "form-control" value ="<?php echo $_SESSION['user_mail']; ?>" name = "user_mail" id="user_mail" readonly="true"/>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="form_labels">
                                                        <label style="font-weight: normal; font-size: 16px;" for="user_password">Password</label>
                                                    </td>
                                                    <td class="form_inputs">
                                                        <div class = "col-md-11">
                                                            <input type = "password" class = "form-control" name = "user_password" id="user_password"/>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="form_labels">
                                                        <label style="font-weight: normal; font-size: 16px;" for="user_password_confirmed">Confirm Password</label>
                                                    </td>
                                                    <td class="form_inputs">
                                                        <div class = "col-md-11">
                                                            <input type = "password" class = "form-control" name = "user_password_confirmed" id="user_password_confirmed"/>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="form_labels">
                                                    </td>
                                                    <td class="form_inputs">
                                                        <div class = "col-md-11">
                                                            <button type="button" class="btn btn-info form-control" name="create_account_button" id="create_account_button">Create Account</button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </table>
                                        </form>
                                    </div>
                                </div>
                                <p style="color: red; font-size: 18px;"><?php
                                    if (!empty($_SESSION['account_setup_required']) && $_SESSION['account_setup_required'] == 1) {
                                        echo 'Please you must finish account setup before you can logout!';
                                    }
                                    ?></p>
                            </div>
                            <div class="box">
                                <div class="box-top" >Users</div>
                                <div class="box-panel">
                                    <div class="table-responsive">
                                        <?php
                                        $crud = new CrudOperation();
                                        if (empty($_SESSION['user_mail'])) {
                                            $crud->retriveUserInfo();
                                        }
                                        ?>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div id="add_user_area">
                            <div class="box">
                                <div class="box-top" id="add_user_activity_heading"><?php
                                    if (!empty($_SESSION['user_mail'])) {
                                        echo 'Please go to dashboard and finish account setup!';
                                    } else {
                                        echo 'Please Fill the Form Below and Submit';
                                    }
                                    ?></div>
                                <div class="box-panel">
                                    <div style="display: <?php
                                    if (!empty($_SESSION['user_mail'])) {
                                        echo 'none';
                                    } else {
                                        echo 'block';
                                    }
                                    ?>">
                                        <form class = "form-horizontal" role ="form" id="employee_form">
                                            <h5 id="form_error" style="font-family: Tahoma; color: red;">
                                                <?php
                                                if (isset($_GET['something_went_wrong'])) {
                                                    echo 'Something went wrong. Please try again!';
                                                } else if (isset($_GET['empty_fileds'])) {
                                                    echo 'All fields must be filled!';
                                                } else if (isset($_GET['wrong_email'])) {
                                                    echo 'Email address is not valid!';
                                                }
                                                ?>
                                            </h5>
                                            <h5 id="add_user_error"></h5>
                                            <table>
                                                <tr>
                                                    <td class="form_labels">
                                                        <label style="font-weight: normal; font-size: 16px;" for="firstname">First name</label>
                                                    </td>
                                                    <td class="form_inputs">
                                                        <div class = "col-md-11">
                                                            <input type = "text" class = "form-control" name = "firstname" id="firstname" required/>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="form_labels">
                                                        <label style="font-weight: normal; font-size: 16px;" for="lastname">Last name</label>
                                                    </td>
                                                    <td class="form_inputs">
                                                        <div class = "col-md-11">
                                                            <input type = "text" class = "form-control" name = "lastname" id="lastname" required/>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="form_labels">
                                                        <label style="font-weight: normal; font-size: 16px;" for="gender">Gender</label>
                                                    </td>
                                                    <td class="form_inputs">
                                                        <div class = "col-md-11">
                                                            <select class="form-control" name="gender" id="gender">
                                                                <option value="M">Male</option>
                                                                <option value="F">Female</option>
                                                            </select>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="form_labels">
                                                        <label style="font-weight: normal; font-size: 16px;" for="dob">Date of Birth</label>
                                                    </td>
                                                    <td class="form_inputs">
                                                        <div class = "col-md-11">
                                                            <input type = "date" class = "form-control" name = "dob" id="dob" required/>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="form_labels">
                                                        <label style="font-weight: normal; font-size: 16px;" for="phone">Phone</label>
                                                    </td>
                                                    <td class="form_inputs">
                                                        <div class = "col-md-11">
                                                            <input type = "text" class = "form-control" name = "phone" id="phone" required/>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="form_labels">
                                                        <label style="font-weight: normal; font-size: 16px;" for="email">Email</label>
                                                    </td>
                                                    <td class="form_inputs">
                                                        <div class = "col-md-11">
                                                            <input type = "email" class = "form-control" name = "email" id="email" required/>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="form_labels">
                                                        <label style="font-weight: normal; font-size: 16px;" for="email">Role</label>
                                                    </td>
                                                    <td class="form_inputs">
                                                        <div class = "col-md-11">
                                                            <select class="form-control" name="roleId">
                                                                <option value="1">Administrator</option>
                                                                <option value="4">CEO</option>
                                                                <option value="2">Employee</option>
                                                            </select>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="form_labels">
                                                        <label style="font-weight: normal; font-size: 16px;" for="address">Address</label>
                                                    </td>
                                                    <td class="form_inputs">
                                                        <div class = "col-md-11">
                                                            <textarea rows="2" cols="3" class = "form-control" name="address" id="address"></textarea>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="form_labels">
                                                    </td>
                                                    <td class="form_inputs">
                                                        <div class = "col-md-11">
                                                            <button type="button" class="btn btn-info form-control" name="save_employee" id="save_employee">Submit</button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </table>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="delete_user_area">
                            <div class="box">
                                <div class="box-top" id="delete_user_activity_heading"><?php
                                    if (!empty($_SESSION['no_records']) && $_SESSION['no_records'] == 1) {
                                        echo 'No Records!';
                                    } else if (!empty($_SESSION['user_mail'])) {
                                        echo 'Please go to dashboard and finish account setup!';
                                    } else {
                                        echo 'Available users for deletion';
                                    }
                                    ?></div>
                                <div class="box-panel">
                                    <div class="table-responsive">
                                        <?php
                                        if (empty($_SESSION['user_mail'])) {
                                            $crud->displayEMployeeForDeletion();
                                        }
                                        ?>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div id="account_reset_area">
                            <div class="box">
                                <div class="box-top" id="account_reset_activity_heading"><?php
                                    if (!empty($_SESSION['no_records']) && $_SESSION['no_records'] == 1) {
                                        echo 'No Records!';
                                    } else if (!empty($_SESSION['user_mail'])) {
                                        echo 'Please go to dashboard and finish account setup!';
                                    } else {
                                        echo 'Select A User to Reset';
                                    }
                                    ?></div>
                                <div class="box-panel">
                                    <?php
                                    if (empty($_SESSION['user_mail'])) {
                                        $crud->displayAccountForReset();
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div id="change_admin_password">
                            <div class="box">
                                <div class="box-top" id="change_admin_password_activity_heading"><?php
                                    if (!empty($_SESSION['no_records']) && $_SESSION['no_records'] == 1) {
                                        echo 'No Records!';
                                    } else if (!empty($_SESSION['user_mail'])) {
                                        echo 'Please go to dashboard and finish account setup!';
                                    } else {
                                        echo 'Change Admin Password Here';
                                    }
                                    ?></div>
                                <div class="box-panel">
                                    <!-- display form to change password here -->
                                    <div id="hidden_form" style="display:">
                                        <p>Please set a new password</p>
                                        <form class="form-horizontal" role="form" id="new_admin_password_form">
                                            <h5 id="form_error">
                                                <?php
                                                if (isset($_GET['account_error'])) {
                                                    echo 'Account could not be created. Something went wrong!';
                                                } else if (isset($_GET['empty_password'])) {
                                                    echo 'Password fields cannot be empty!';
                                                }
                                                ?>
                                            </h5>
                                            <h5 id="some_error"></h5>
                                            <table>
                                                <tr>
                                                    <td class="form_labels admin">
                                                        <label style="font-weight: normal; font-size: 16px;" for="new_admin_password">New password</label>
                                                    </td>
                                                    <td class="form_inputs">
                                                        <div class = "col-md-11">
                                                            <input type = "password" class = "form-control" name = "new_admin_password" id="new_admin_password"/>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="form_labels">
                                                        <label style="font-weight: normal; font-size: 16px;" for="new_admin_password_confirmed">Confirm new password</label>
                                                    </td>
                                                    <td class="form_inputs">
                                                        <div class = "col-md-11">
                                                            <input type = "password" class = "form-control" name = "new_admin_password_confirmed" id="new_admin_password_confirmed"/>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="form_labels">
                                                    </td>
                                                    <td class="form_inputs">
                                                        <div class = "col-md-11">
                                                            <button type="button" class="btn btn-info form-control" name="admin_reset_password_button" id="admin_reset_password_button">Change Password</button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </table>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>          
                </div><!-- End of administrator's home page-->
                <?php
            } else if ($_SESSION['roleId'] == 2) {
                ?>
                <div id="container"><!--Employee's home page begins here -->
                    <div class="sidebar sticky">
                        <ul id="nav">
                            <li id="employee_dashboard"><a href="#" class="selected" id="dashboard">Dashboard</a></li>
                            <li id="employee_transaction"><a href="#" id="employee_transaction_tab">Transactions</a></li>
                            <li id="employee_report"><a href="#" id="employee_report_tab">Report</a></li>
                            <li id="employee_card_application"><a href="#" id="employee_card_application_tab">Register Card Holder</a></li>
                        </ul>
                    </div>
                    <div class="content">
                        <h1 id="header_display">Dashboard</h1>
                        <div id="dashboard_area">
                            <div class="box" style="display: <?php
                            if (!empty($_SESSION['account_reset']) && $_SESSION['account_reset'] == 1) {
                                echo 'block';
                            } else {
                                echo 'none';
                            }
                            ?>">
                                <div class="box-top" id="dashboard_activity_heading">We have detected that your password was recently reset to default. Please change it to make sure your account is secure</div>
                                <div class="box-panel">
                                    <div id="hidden_form" style="display:">
                                        <p>Please set a new password</p>
                                        <form class="form-horizontal" role="form" id="reset_password_form">
                                            <h5 id="form_error">
                                                <?php
                                                if (isset($_GET['account_error'])) {
                                                    echo 'Account could not be created. Something went wrong!';
                                                } else if (isset($_GET['empty_password'])) {
                                                    echo 'Password fields cannot be empty!';
                                                }
                                                ?>
                                            </h5>
                                            <table>
                                                <tr>
                                                    <td class="form_labels">
                                                        <label style="font-weight: normal; font-size: 16px;" for="user_mail">Username</label>
                                                    </td>
                                                    <td class="form_inputs">
                                                        <div class = "col-md-11">
                                                            <input type = "email" class = "form-control" value ="<?php echo $_SESSION['username']; ?>" name = "user_mail" id="user_mail" readonly="true"/>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="form_labels">
                                                        <label style="font-weight: normal; font-size: 16px;" for="user_password">Password</label>
                                                    </td>
                                                    <td class="form_inputs">
                                                        <div class = "col-md-11">
                                                            <input type = "password" class = "form-control" name = "user_password" id="user_password"/>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="form_labels">
                                                        <label style="font-weight: normal; font-size: 16px;" for="user_password_confirmed">Confirm Password</label>
                                                    </td>
                                                    <td class="form_inputs">
                                                        <div class = "col-md-11">
                                                            <input type = "password" class = "form-control" name = "user_password_confirmed" id="user_password_confirmed"/>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="form_labels">
                                                    </td>
                                                    <td class="form_inputs">
                                                        <div class = "col-md-11">
                                                            <button type="button" class="btn btn-info form-control" name="reset_password_button" id="reset_password_button">Change Password</button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </table>
                                        </form>
                                    </div>
                                </div>
                                <p style="color: red; font-size: 18px;"><?php
                                    if (!empty($_SESSION['account_setup_required']) && $_SESSION['account_setup_required'] == 1) {
                                        echo 'Please you must finish account setup before you can logout!';
                                    }
                                    ?></p>
                            </div>
                            <!-- Card Holder Account Continuation-->
                            <div class="box" style="display: <?php
                            if (isset($_SESSION['card_holder_account_in_progress']) && $_SESSION['card_holder_account_in_progress'] == 1) {
                                echo 'block';
                            } else {
                                echo 'none';
                            }
                            ?>">
                                <div class="box-top" id="dashboard_activity_heading">Complete the registration by supplying the credit card details</div>
                                <div class="box-panel">
                                    <h5>This account is being setup for <span style="font-weight: bold"><?php
                                            if (isset($_SESSION['card_holder_name']) && $_SESSION['card_holder_name']) {
                                                echo $_SESSION['card_holder_name'];
                                            } else {
                                                echo 'No one yet';
                                            }
                                            ?></span></h5>
                                    <h5 style="color: red; font-weight: bold;">
                                        <?php
                                        if (isset($_SESSION['cvv_invalid']) && $_SESSION['cvv_invalid'] == 1) {
                                            echo 'CVV number must be an a positive integer!';
                                        } else if (isset($_SESSION['card_number_invalid']) && $_SESSION['card_number_invalid'] == 1) {
                                            echo 'Credit number must be an positive integer!';
                                        } else if (isset($_SESSION['empty_card_fields']) && $_SESSION['empty_card_fields'] == 1) {
                                            echo 'All fields are required!';
                                        }
                                        ?>
                                    </h5>
                                    <h5 id="credit_card_error"></h5>
                                    <form class="form-horizontal" role="form" id="credit_form">
                                        <table>
                                            <tr>
                                                <td class="form_labels">
                                                    <label style="font-weight: normal; font-size: 16px;" for="credit_card_number">Card Number</label>
                                                </td>
                                                <td class="form_inputs">
                                                    <div class = "col-md-11">
                                                        <input type = "number" class = "form-control" name = "credit_card_number" id="credit_card_number"/>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="form_labels">
                                                    <label style="font-weight: normal; font-size: 16px;" for="issued_date">Date Issued</label>
                                                </td>
                                                <td class="form_inputs">
                                                    <div class = "col-md-11">
                                                        <input type = "date" class = "form-control" name = "issued_date" id="issued_date"/>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="form_labels">
                                                    <label style="font-weight: normal; font-size: 16px;" for="expiry_date">Expiry Date</label>
                                                </td>
                                                <td class="form_inputs">
                                                    <div class = "col-md-11">
                                                        <input type = "date" class = "form-control" name = "expiry_date" id="expiry_date"/>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="form_labels">
                                                    <label style="font-weight: normal; font-size: 16px;" for="cvv">CVV Number</label>
                                                </td>
                                                <td class="form_inputs">
                                                    <div class = "col-md-11">
                                                        <input type = "text" class = "form-control" name = "cvv" id="cvv"/>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="form_labels">
                                                    <label style="font-weight: normal; font-size: 16px;" for="card_issuer">Card Issuer</label>
                                                </td>
                                                <td class="form_inputs">
                                                    <div class = "col-md-11">
                                                        <select class = "form-control" name = "card_issuer" id="card_issuer">
                                                            <?php
                                                            $crud = new CrudOperation();
                                                            $issuers = $crud->fetchCardIssuers();
                                                            foreach ($issuers as $issuer) {
                                                                ?>
                                                                <option value="<?php echo $issuer['id']; ?>"><?php echo $issuer['company']; ?></option>
                                                                <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="form_labels">

                                                </td>
                                                <td class="form_inputs">
                                                    <div class = "col-md-11">
                                                        <button type="button" class="btn btn-info form-control" id="create_card_details_submit">Submit</button>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </form>
                                    <h4 style="color: red;">
                                        <?php
                                        if (isset($_SESSION['account_setup_required']) && $_SESSION['account_setup_required'] == 1) {
                                            echo "Please supply credit card details before you can logout!";
                                        }
                                        ?>
                                    </h4>
                                </div>
                            </div><!-- Card Holder account continuation finished here -->
                            <div class="box">
                                <div class="box-top" id="dashboard_activity_heading">Transactions</div>
                                <div class="box-panel">
                                    <?php
                                    $crud->displayAllTransactions();
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div id="employee_transactions_area">
                            <div class="box">
                                <div class="box-top" id="transactions_activity_heading">
                                    <?php
                                    if (isset($_SESSION['card_holder_account_in_progress']) && $_SESSION['card_holder_account_in_progress'] == 1) {
                                        echo 'Go to the dashboard and finish card holder account setup';
                                    } else {
                                        echo 'List of transactions for today';
                                    }
                                    ?>
                                </div> 
                                <div class="box-panel" style="display: 
                                <?php
                                if (isset($_SESSION['card_holder_account_in_progress']) && $_SESSION['card_holder_account_in_progress'] == 1) {
                                    echo 'none';
                                } else {
                                    echo 'block';
                                }
                                ?>

                                     ">
                                    List of transactions for the current day will be displayed here
                                </div>
                            </div>
                        </div>
                        <div id="employee_report_area">
                            <div class="box">
                                <div class="box-top" id="report_activity_heading">
                                    <?php
                                    if (isset($_SESSION['card_holder_account_in_progress']) && $_SESSION['card_holder_account_in_progress'] == 1) {
                                        echo 'Go to the dashboard and finish card holde account setup!';
                                    } else {
                                        echo 'Requested report';
                                    }
                                    ?>

                                </div>
                                <div class="box-panel" style="display: 
                                <?php
                                if (isset($_SESSION['card_holder_account_in_progress']) && $_SESSION['card_holder_account_in_progress'] == 1) {
                                    echo 'none';
                                } else {
                                    echo 'block';
                                }
                                ?>

                                     ">
                                         <?php
                                         $report = new GenerateReport("P");
                                         $report->getDailyTransactionReport();
                                         ?>
                                </div>
                            </div>
                        </div>
                        <div id="employee_card_application_area">
                            <div class="box">
                                <div class="box-top" id="create_card_activity_heading">
                                    <?php
                                    if (isset($_SESSION['card_holder_account_in_progress']) && $_SESSION['card_holder_account_in_progress'] == 1) {
                                        echo 'Please go to dashboard and finish account setup!';
                                    } else {
                                        echo 'Register a new card holder';
                                    }
                                    ?>
                                </div>
                                <div class="box-panel" style="display: 
                                <?php
                                if (isset($_SESSION['card_holder_account_in_progress']) && $_SESSION['card_holder_account_in_progress'] == 1) {
                                    echo 'none';
                                } else {
                                    echo 'block';
                                }
                                ?>
                                     ">
                                    <h4 id="card_holder_form_error"></h4>
                                    <h4>
                                        <?php
                                        if (isset($_SESSION['wrong_card_holder_email']) && $_SESSION['wrong_card_holder_email'] == 1) {
                                            echo 'The email address you provided is invalid!';
                                        } else if (isset($_SESSION['card_holder_fields_empty']) && $_SESSION['card_holder_fields_empty'] == 1) {
                                            echo 'An error occured! All fields are required';
                                        }
                                        ?>
                                    </h4>
                                    <form class = "form-horizontal" role ="form" id="card_holder_form">
                                        <input type="hidden" name="roleId" value="1"/>
                                        <table>
                                            <tr>
                                                <td class="form_labels">
                                                    <label style="font-weight: normal; font-size: 16px;" for="firstname">First name</label>
                                                </td>
                                                <td class="form_inputs">
                                                    <div class = "col-md-11">
                                                        <input type = "text" class = "form-control" name = "firstname" id="firstname" required/>
                                                    </div>
                                                </td>
                                                <td class="form_labels">
                                                    <label style="font-weight: normal; font-size: 16px;" for="name_of_kin">Next of Kin</label>
                                                </td>
                                                <td class="form_inputs">
                                                    <div class = "col-md-11">
                                                        <input type = "text" class = "form-control" name = "name_of_kin" id="name_of_kin" required/>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="form_labels">
                                                    <label style="font-weight: normal; font-size: 16px;" for="lastname">Last name</label>
                                                </td>
                                                <td class="form_inputs">
                                                    <div class = "col-md-11">
                                                        <input type = "text" class = "form-control" name = "lastname" id="lastname" required/>
                                                    </div>
                                                </td>
                                                <td class="form_labels">
                                                    <label style="font-weight: normal; font-size: 16px;" for="address_of_kin">Address of Kin</label>
                                                </td>
                                                <td class="form_inputs">
                                                    <div class = "col-md-11">
                                                        <textarea rows="2" cols="3" class = "form-control" name="address_of_kin" id="address_of_kin"></textarea>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="form_labels">
                                                    <label style="font-weight: normal; font-size: 16px;" for="gender">Gender</label>
                                                </td>
                                                <td class="form_inputs">
                                                    <div class = "col-md-11">
                                                        <select class="form-control" name="gender" id="gender">
                                                            <option value="M">Male</option>
                                                            <option value="F">Female</option>
                                                        </select>
                                                    </div>
                                                </td>
                                                <td class="form_labels">
                                                    <label style="font-weight: normal; font-size: 16px;" for="kin_contact">Next of Kin Contact</label>
                                                </td>
                                                <td class="form_inputs">
                                                    <div class = "col-md-11">
                                                        <input type = "text" class = "form-control" name = "kin_contact" id="kin_contact" required/>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="form_labels">
                                                    <label style="font-weight: normal; font-size: 16px;" for="dob">Date of Birth</label>
                                                </td>
                                                <td class="form_inputs">
                                                    <div class = "col-md-11">
                                                        <input type = "date" class = "form-control" name = "dob" id="dob" required/>
                                                    </div>
                                                </td>
                                                <td class="form_labels">
                                                    <label style="font-weight: normal; font-size: 16px;" for="secret_question">Secret question</label>
                                                </td>
                                                <td class="form_inputs">
                                                    <div class = "col-md-11">
                                                        <?php
                                                        $crud = new CrudOperation();
                                                        $results = $crud->fetchSecretQuestions();
                                                        ?>
                                                        <select class="form-control" name="secret_question" id="secret_question">
                                                            <?php
                                                            foreach ($results as $result) {
                                                                ?>
                                                                <option value="<?php echo $result['id'] ?>"><?php echo $result['question'] ?></option>
                                                                <?php
                                                                //echo $result['question'];
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </td>

                                            </tr>
                                            <tr>
                                                <td class="form_labels">
                                                    <label style="font-weight: normal; font-size: 16px;" for="country">Country</label>
                                                </td>
                                                <td class="form_inputs">
                                                    <div class = "col-md-11">
                                                        <select class="form-control" name="country" id="country">
                                                        </select>
                                                    </div>
                                                </td>
                                                <td class="form_labels">
                                                    <label style="font-weight: normal; font-size: 16px;" for="secret_answer">Answer</label>
                                                </td>
                                                <td class="form_inputs">
                                                    <div class = "col-md-11">
                                                        <input type = "text" class = "form-control" name = "secret_answer" id="secret_answer" required/>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="form_labels">
                                                    <label style="font-weight: normal; font-size: 16px;" for="city">City/Region</label>
                                                </td>
                                                <td class="form_inputs">
                                                    <div class = "col-md-11">
                                                        <select class="form-control" name="city" id="city">
                                                        </select>
                                                    </div>
                                                </td>
                                                <td class="form_labels">

                                                </td>
                                                <td class="form_inputs">
                                                    <div class = "col-md-11">
                                                        <button type="button" class="btn btn-info form-control" id="create_card_holder_account_button">Submit</button>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="form_labels">
                                                    <label style="font-weight: normal; font-size: 16px;" for="phone">Phone</label>
                                                </td>
                                                <td class="form_inputs">
                                                    <div class = "col-md-11">
                                                        <input type = "text" class = "form-control" name = "phone" id="phone" required/>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="form_labels">
                                                    <label style="font-weight: normal; font-size: 16px;" for="email">Email</label>
                                                </td>
                                                <td class="form_inputs">
                                                    <div class = "col-md-11">
                                                        <input type = "email" class = "form-control" name = "email" id="email" required/>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="form_labels">
                                                    <label style="font-weight: normal; font-size: 16px;" for="address">Address</label>
                                                </td>
                                                <td class="form_inputs">
                                                    <div class = "col-md-11">
                                                        <textarea rows="2" cols="3" class = "form-control" name="address" id="address"></textarea>
                                                    </div>
                                                </td>

                                            </tr>
                                            <tr>

                                            </tr>
                                        </table>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div> 
                    <?php
                    if (isset($_SESSION['customer_account_created']) && $_SESSION['customer_account_created'] == 1) {
                        ?>
                        <script type="text/javascript">
                            swal({
                                position: 'top-end',
                                type: 'success',
                                width: '36rem',
                                title: 'Card Holder Registration Successful!',
                                showConfirmButton: false,
                                timer: 3000
                            });
                        </script>
                        <?php
                    } else if (isset($_SESSION['connection_error']) && $_SESSION['connection_error'] == 1) {
                        ?>
                        <script type="text/javascript">
                            swal({
                                type: 'error',
                                width: '36rem',
                                title: 'Connection error!',
                                text: 'Please make sure there is internet connection',
                                showConfirmButton: false,
                                timer: 4000
                            });
                        </script>
                        <?php
                    }
                    ?>
                </div><!-- End of employee's home page-->
                <?php
            } else if ($_SESSION['roleId'] == 3) {
                ?>   
                <!-- Customer's home page starts here -->
                <div id="container">
                    <div class="sidebar sticky">
                        <ul id="nav">
                            <li id="customer_dashboard"><a href="#" class="selected" id="dashboard">Dashboard</a></li>
                            <li id="customer_transaction"><a href="#" id="c_shopping">Shopping History</a></li>
                            <li id="customer_report"><a href="#" id="c_report">Report</a></li>
                            <li id="customer_account_settings"><a href="#" id="c_account_settings">Account Settings</a></li>
                        </ul>
                    </div>
                    <div class="content">
                        <h1 id="header_display">Dashboard</h1>
                        <div id="dashboard_area">
                            <div class="box">
                                <div class="box-top" id="transactions_activity_heading">List of transactions for today</div>
                                <div class="box-panel">
                                    List of transactions for the current day will be displayed here
                                </div>
                            </div>
                        </div>
                        <div id="ceo_transactions_area">
                            <div class="box">
                                <div class="box-top" id="transactions_activity_heading">List of transactions for today</div>
                                <div class="box-panel">
                                    List of transactions for the current day will be displayed here
                                </div>
                            </div>
                        </div>
                        <div id="ceo_report_area">
                            <div class="box">
                                <div class="box-top" id="report_activity_heading">Requested Report</div>
                                <div class="box-panel">
                                    Generated report will be displayed here
                                </div>
                            </div>
                        </div>
                        <div id="ceo_account_settings_area">
                            <div class="box">
                                <div class="box-top" id="account_seetings_activity_heading">You can change your password here</div>
                                <div class="box-panel">
                                    Form will be displayed here for settings to be made
                                </div>
                            </div>
                        </div>
                    </div>          
                </div><!-- End of customer's home page-->
                <?php
            } else if ($_SESSION['roleId'] == 4) {
                ?>  
                <!-- CEO home page starts here -->
                <div id="container">
                    <div class="sidebar sticky">
                        <ul id="nav">
                            <li id="ceo_dashboard"><a href="#" class="selected" id="dashboard">Dashboard</a></li>
                            <li id="ceo_transaction"><a href="#" id="ceo_transaction_tab">Transactions</a></li>
                            <li id="ceo_report"><a href="#" id="ceo_report_tab">Report</a></li>
                            <li id="ceo_card_application"><a href="#" id="ceo_card_application_tab">Register Card Holder</a></li>
                            <li id="ceo_basic_setup"><a href="#" id="ceo_basic_setup_tab">Basic Setup</a></li>
                            <li id="ceo_add_card_company"><a href="#" id="ceo_add_card_company_tab">&nbsp;&nbsp;&nbsp;&nbsp;Add CreditCard Company</a></li>
                            <li id="ceo_add_questions"><a href="#" id="ceo_add_questions_tab">&nbsp;&nbsp;&nbsp;&nbsp;Add Security Question</a></li>
                            <li id="ceo_account_settings"><a href="#" id="ceo_account_settings_tab">Account Settings</a></li>
                        </ul>
                    </div>
                    <div class="content">
                        <h1 id="header_display">Dashboard</h1>
                        <div id="dashboard_area">
                            <div class="box" style="display: <?php
                            if (!empty($_SESSION['account_reset']) && $_SESSION['account_reset'] == 1) {
                                echo 'block';
                            } else {
                                echo 'none';
                            }
                            ?>">
                                <div class="box-top" id="dashboard_activity_heading">We have detected that your password was recently reset to default. Please change it to make sure your account is secure</div>
                                <div class="box-panel">
                                    <div id="hidden_form" style="display:">
                                        <p>Please set a new password</p>
                                        <form class="form-horizontal" role="form" id="reset_password_form">
                                            <h5 id="form_error">
                                                <?php
                                                if (isset($_GET['account_error'])) {
                                                    echo 'Account could not be created. Something went wrong!';
                                                } else if (isset($_GET['empty_password'])) {
                                                    echo 'Password fields cannot be empty!';
                                                }
                                                ?>
                                            </h5>
                                            <table>
                                                <tr>
                                                    <td class="form_labels">
                                                        <label style="font-weight: normal; font-size: 16px;" for="user_mail">Username</label>
                                                    </td>
                                                    <td class="form_inputs">
                                                        <div class = "col-md-11">
                                                            <input type = "email" class = "form-control" value ="<?php echo $_SESSION['username']; ?>" name = "user_mail" id="user_mail" readonly="true"/>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="form_labels">
                                                        <label style="font-weight: normal; font-size: 16px;" for="user_password">Password</label>
                                                    </td>
                                                    <td class="form_inputs">
                                                        <div class = "col-md-11">
                                                            <input type = "password" class = "form-control" name = "user_password" id="user_password"/>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="form_labels">
                                                        <label style="font-weight: normal; font-size: 16px;" for="user_password_confirmed">Confirm Password</label>
                                                    </td>
                                                    <td class="form_inputs">
                                                        <div class = "col-md-11">
                                                            <input type = "password" class = "form-control" name = "user_password_confirmed" id="user_password_confirmed"/>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="form_labels">
                                                    </td>
                                                    <td class="form_inputs">
                                                        <div class = "col-md-11">
                                                            <button type="button" class="btn btn-info form-control" name="reset_password_button" id="reset_password_button">Change Password</button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </table>
                                        </form>
                                    </div>
                                </div>
                                <p style="color: red; font-size: 18px;"><?php
                                    if (!empty($_SESSION['account_setup_required']) && $_SESSION['account_setup_required'] == 1) {
                                        echo 'Please you must finish account setup before you can logout!';
                                    }
                                    ?></p>
                            </div>
                            <!-- Card Holder Account Continuation-->
                            <div class="box" style="display: <?php
                            if (isset($_SESSION['card_holder_account_in_progress']) && $_SESSION['card_holder_account_in_progress'] == 1) {
                                echo 'block';
                            } else {
                                echo 'none';
                            }
                            ?>">
                                <div class="box-top" id="dashboard_activity_heading">Complete the registration by supplying the credit card details</div>
                                <div class="box-panel">
                                    <h5>This account is being setup for <span style="font-weight: bold"><?php
                                            if (isset($_SESSION['card_holder_name']) && $_SESSION['card_holder_name']) {
                                                echo $_SESSION['card_holder_name'];
                                            } else {
                                                echo 'No one yet';
                                            }
                                            ?></span></h5>
                                    <h5 style="color: red; font-weight: bold;">
                                        <?php
                                        if (isset($_SESSION['cvv_invalid']) && $_SESSION['cvv_invalid'] == 1) {
                                            echo 'CVV number must be a positive integer!';
                                        } else if (isset($_SESSION['card_number_invalid']) && $_SESSION['card_number_invalid'] == 1) {
                                            echo 'Credit number must be an positive integer!';
                                        } else if (isset($_SESSION['empty_card_fields']) && $_SESSION['empty_card_fields'] == 1) {
                                            echo 'All fields are required!';
                                        }
                                        ?>
                                    </h5>
                                    <h5 id="credit_card_error"></h5>
                                    <form class="form-horizontal" role="form" id="credit_form">
                                        <table>
                                            <tr>
                                                <td class="form_labels">
                                                    <label style="font-weight: normal; font-size: 16px;" for="credit_card_number">Card Number</label>
                                                </td>
                                                <td class="form_inputs">
                                                    <div class = "col-md-11">
                                                        <input type = "number" class = "form-control" name = "credit_card_number" id="credit_card_number"/>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="form_labels">
                                                    <label style="font-weight: normal; font-size: 16px;" for="issued_date">Date Issued</label>
                                                </td>
                                                <td class="form_inputs">
                                                    <div class = "col-md-11">
                                                        <input type = "date" class = "form-control" name = "issued_date" id="issued_date"/>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="form_labels">
                                                    <label style="font-weight: normal; font-size: 16px;" for="expiry_date">Expiry Date</label>
                                                </td>
                                                <td class="form_inputs">
                                                    <div class = "col-md-11">
                                                        <input type = "date" class = "form-control" name = "expiry_date" id="expiry_date"/>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="form_labels">
                                                    <label style="font-weight: normal; font-size: 16px;" for="cvv">CVV Number</label>
                                                </td>
                                                <td class="form_inputs">
                                                    <div class = "col-md-11">
                                                        <input type = "text" class = "form-control" name = "cvv" id="cvv"/>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="form_labels">
                                                    <label style="font-weight: normal; font-size: 16px;" for="card_issuer">Card Issuer</label>
                                                </td>
                                                <td class="form_inputs">
                                                    <div class = "col-md-11">
                                                        <select class = "form-control" name = "card_issuer" id="card_issuer">
                                                            <?php
                                                            $crud = new CrudOperation();
                                                            $issuers = $crud->fetchCardIssuers();
                                                            foreach ($issuers as $issuer) {
                                                                ?>
                                                                <option value="<?php echo $issuer['id']; ?>"><?php echo $issuer['company']; ?></option>
                                                                <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="form_labels">

                                                </td>
                                                <td class="form_inputs">
                                                    <div class = "col-md-11">
                                                        <button type="button" class="btn btn-info form-control" id="create_card_details_submit">Submit</button>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </form>
                                    <h4 style="color: red;">
                                        <?php
                                        if (isset($_SESSION['account_setup_required']) && $_SESSION['account_setup_required'] == 1) {
                                            echo "Please supply credit card details before you can logout!";
                                        }
                                        ?>
                                    </h4>
                                </div>
                            </div><!-- Card Holder account continuation finished here -->
                            <div class="box">
                                <div class="box-top" id="dashboard_activity_heading">Transactions</div>
                                <div class="box-panel">
                                    <?php
                                    $crud->displayAllTransactions();
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div id="ceo_transactions_area">
                            <div class="box">
                                <div class="box-top" id="transactions_activity_heading">
                                    <?php
                                    if (isset($_SESSION['card_holder_account_in_progress']) && $_SESSION['card_holder_account_in_progress'] == 1) {
                                        echo 'Go to the dashboard and finish card holder account setup!';
                                    } else {
                                        echo 'List of transactions for today';
                                    }
                                    ?>

                                </div>
                                <div class="box-panel" style="display: 
                                <?php
                                if (isset($_SESSION['card_holder_account_in_progress']) && $_SESSION['card_holder_account_in_progress'] == 1) {
                                    echo 'none';
                                } else {
                                    echo 'block';
                                }
                                ?>
                                     ">
                                         <?php
                                         $crud->displayTransactionsForToday();
                                         ?>
                                </div>
                            </div>
                        </div>
                        <div id="ceo_report_area">
                            <div class="box">
                                <div class="box-top" id="report_activity_heading">
                                    <?php
                                    if (isset($_SESSION['card_holder_account_in_progress']) && $_SESSION['card_holder_account_in_progress'] == 1) {
                                        echo 'GO to the dashboard and finish card holder account setup';
                                    } else {
                                        echo 'Requested Report';
                                    }
                                    ?>

                                </div>
                                <div class="box-panel" style="display: 
                                <?php
                                if (isset($_SESSION['card_holder_account_in_progress']) && $_SESSION['card_holder_account_in_progress'] == 1) {
                                    echo 'none';
                                } else {
                                    echo 'block';
                                }
                                ?>

                                     ">
                                    <?php 
                                        $report = new GenerateReport("P");
                                        $report->getDailyTransactionReport();
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div id="ceo_card_company_area">
                            <div class="box">
                                <div class="box-top" id="report_activity_heading">
                                    <?php
                                    if (isset($_SESSION['card_holder_account_in_progress']) && $_SESSION['card_holder_account_in_progress'] == 1) {
                                        echo 'Go to the dashboard and finish card holder account setup!';
                                    } else {
                                        echo 'Provide credit card types you support';
                                    }
                                    ?>
                                </div>
                                <div class="box-panel" style="display: 
                                <?php
                                if (isset($_SESSION['card_holder_account_in_progress']) && $_SESSION['card_holder_account_in_progress'] == 1) {
                                    echo 'none';
                                } else {
                                    echo 'block';
                                }
                                ?>
                                     ">
                                    <form role="form" id="company_form">
                                        <div class = "form-group" >
                                            <label style="font-weight:normal; font-size: 16px;">Credit Card Company</label>
                                            <div class = "col-md-3 input-group">
                                                <input type = "text" class = "form-control input-lg" name = "card_company" id="card_company" required/>
                                            </div>
                                        </div>
                                        <div class = "form-group" >
                                            <label style="font-weight:normal; font-size: 16px;">Credit Card Company Logo</label>
                                            <div class = "col-md-3 input-group">
                                                <input type = "file" class = "form-control input-lg" name = "image" id="image" required/>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class = "form-group col-xs-1" >
                                                <div class = "col-md-1 input-group">
                                                    <button type = "button" name="card_company_button" id="card_company_button" class = "btn btn-primary btn-lg"><span class="glyphicon glyphicon-upload"></span>&nbsp;Upload Info</button>
                                                </div>
                                            </div>
                                            <div class = "form-group col-xs-1" >
                                                <div class = "col-md-1 input-group col-lg-offset-12">
                                                    <button type = "reset" class = "btn btn-danger btn-lg"><span class="glyphicon glyphicon-remove"></span>&nbsp;Clear Info</button>
                                                </div>
                                            </div>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>
                        <div id="ceo_questions_area">
                            <div class="box">
                                <div class="box-top" id="report_activity_heading">
                                    <?php
                                    if (isset($_SESSION['card_holder_account_in_progress']) && $_SESSION['card_holder_account_in_progress'] == 1) {
                                        echo 'Go to the dashboard and finish card holder account setup!';
                                    } else {
                                        echo 'Provide security questions here';
                                    }
                                    ?>
                                </div>
                                <div class="box-panel" style="display: 
                                <?php
                                if (isset($_SESSION['card_holder_account_in_progress']) && $_SESSION['card_holder_account_in_progress'] == 1) {
                                    echo 'none';
                                } else {
                                    echo 'block';
                                }
                                ?>
                                     ">
                                    <form role="form" id="security_question_form">
                                        <div class = "form-group" >
                                            <label style="font-weight:normal; font-size: 16px;">Security Question</label>
                                            <div class = "col-md-3 input-group">
                                                <input type = "text" class = "form-control input-lg" name = "security_question" id="security_question" required/>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class = "form-group col-xs-1" >
                                                <div class = "col-md-1 input-group">
                                                    <button type = "button" name="security_question_button" id="security_question_button" class = "btn btn-primary btn-lg"><span class="glyphicon glyphicon-upload"></span>&nbsp;Upload Info</button>
                                                </div>
                                            </div>
                                            <div class = "form-group col-xs-1" >
                                                <div class = "col-md-1 input-group col-lg-offset-12">
                                                    <button type = "reset" class = "btn btn-danger btn-lg"><span class="glyphicon glyphicon-remove"></span>&nbsp;Clear Info</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div id="ceo_card_application_area">
                            <div class="box">
                                <div class="box-top" id="create_card_activity_heading">
                                    <?php
                                    if (isset($_SESSION['card_holder_account_in_progress']) && $_SESSION['card_holder_account_in_progress'] == 1) {
                                        echo 'Go to the dashboard and finish card holder account setup!';
                                    } else {
                                        echo 'Register a new card holder here';
                                    }
                                    ?>
                                </div>
                                <div class="box-panel" style="display: 
                                <?php
                                if (isset($_SESSION['card_holder_account_in_progress']) && $_SESSION['card_holder_account_in_progress'] == 1) {
                                    echo 'none';
                                } else {
                                    echo 'block';
                                }
                                ?>
                                     ">
                                    <h4 id="card_holder_form_error"></h4>
                                    <h4>
                                        <?php
                                        if (isset($_SESSION['wrong_card_holder_email']) && $_SESSION['wrong_card_holder_email'] == 1) {
                                            echo 'The email address you provided is invalid!';
                                        } else if (isset($_SESSION['card_holder_fields_empty']) && $_SESSION['card_holder_fields_empty'] == 1) {
                                            echo 'An error occured! All fields are required';
                                        }
                                        ?>
                                    </h4>
                                    <form class = "form-horizontal" role ="form" id="card_holder_form">
                                        <input type="hidden" name="roleId" value="1"/>
                                        <table>
                                            <tr>
                                                <td class="form_labels">
                                                    <label style="font-weight: normal; font-size: 16px;" for="firstname">First name</label>
                                                </td>
                                                <td class="form_inputs">
                                                    <div class = "col-md-11">
                                                        <input type = "text" class = "form-control" name = "firstname" id="firstname" required/>
                                                    </div>
                                                </td>
                                                <td class="form_labels">
                                                    <label style="font-weight: normal; font-size: 16px;" for="name_of_kin">Next of Kin</label>
                                                </td>
                                                <td class="form_inputs">
                                                    <div class = "col-md-11">
                                                        <input type = "text" class = "form-control" name = "name_of_kin" id="name_of_kin" required/>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="form_labels">
                                                    <label style="font-weight: normal; font-size: 16px;" for="lastname">Last name</label>
                                                </td>
                                                <td class="form_inputs">
                                                    <div class = "col-md-11">
                                                        <input type = "text" class = "form-control" name = "lastname" id="lastname" required/>
                                                    </div>
                                                </td>
                                                <td class="form_labels">
                                                    <label style="font-weight: normal; font-size: 16px;" for="address_of_kin">Address of Kin</label>
                                                </td>
                                                <td class="form_inputs">
                                                    <div class = "col-md-11">
                                                        <textarea rows="2" cols="3" class = "form-control" name="address_of_kin" id="address_of_kin"></textarea>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="form_labels">
                                                    <label style="font-weight: normal; font-size: 16px;" for="gender">Gender</label>
                                                </td>
                                                <td class="form_inputs">
                                                    <div class = "col-md-11">
                                                        <select class="form-control" name="gender" id="gender">
                                                            <option value="M">Male</option>
                                                            <option value="F">Female</option>
                                                        </select>
                                                    </div>
                                                </td>
                                                <td class="form_labels">
                                                    <label style="font-weight: normal; font-size: 16px;" for="kin_contact">Next of Kin Contact</label>
                                                </td>
                                                <td class="form_inputs">
                                                    <div class = "col-md-11">
                                                        <input type = "text" class = "form-control" name = "kin_contact" id="kin_contact" required/>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="form_labels">
                                                    <label style="font-weight: normal; font-size: 16px;" for="dob">Date of Birth</label>
                                                </td>
                                                <td class="form_inputs">
                                                    <div class = "col-md-11">
                                                        <input type = "date" class = "form-control" name = "dob" id="dob" required/>
                                                    </div>
                                                </td>
                                                <td class="form_labels">
                                                    <label style="font-weight: normal; font-size: 16px;" for="secret_question">Secret question</label>
                                                </td>
                                                <td class="form_inputs">
                                                    <div class = "col-md-11">
                                                        <?php
                                                        $crud = new CrudOperation();
                                                        $results = $crud->fetchSecretQuestions();
                                                        ?>
                                                        <select class="form-control" name="secret_question" id="secret_question">
                                                            <?php
                                                            foreach ($results as $result) {
                                                                ?>
                                                                <option value="<?php echo $result['id'] ?>"><?php echo $result['question'] ?></option>
                                                                <?php
                                                                //echo $result['question'];
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </td>

                                            </tr>
                                            <tr>
                                                <td class="form_labels">
                                                    <label style="font-weight: normal; font-size: 16px;" for="country">Country</label>
                                                </td>
                                                <td class="form_inputs">
                                                    <div class = "col-md-11">
                                                        <select class="form-control" name="country" id="country">
                                                        </select>
                                                    </div>
                                                </td>
                                                <td class="form_labels">
                                                    <label style="font-weight: normal; font-size: 16px;" for="secret_answer">Answer</label>
                                                </td>
                                                <td class="form_inputs">
                                                    <div class = "col-md-11">
                                                        <input type = "text" class = "form-control" name = "secret_answer" id="secret_answer" required/>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="form_labels">
                                                    <label style="font-weight: normal; font-size: 16px;" for="city">City/Region</label>
                                                </td>
                                                <td class="form_inputs">
                                                    <div class = "col-md-11">
                                                        <select class="form-control" name="city" id="city">
                                                        </select>
                                                    </div>
                                                </td>
                                                <td class="form_labels">

                                                </td>
                                                <td class="form_inputs">
                                                    <div class = "col-md-11">
                                                        <button type="button" class="btn btn-info form-control" id="create_card_holder_account_button">Submit</button>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="form_labels">
                                                    <label style="font-weight: normal; font-size: 16px;" for="phone">Phone</label>
                                                </td>
                                                <td class="form_inputs">
                                                    <div class = "col-md-11">
                                                        <input type = "text" class = "form-control" name = "phone" id="phone" required/>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="form_labels">
                                                    <label style="font-weight: normal; font-size: 16px;" for="email">Email</label>
                                                </td>
                                                <td class="form_inputs">
                                                    <div class = "col-md-11">
                                                        <input type = "email" class = "form-control" name = "email" id="email" required/>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="form_labels">
                                                    <label style="font-weight: normal; font-size: 16px;" for="address">Address</label>
                                                </td>
                                                <td class="form_inputs">
                                                    <div class = "col-md-11">
                                                        <textarea rows="2" cols="3" class = "form-control" name="address" id="address"></textarea>
                                                    </div>
                                                </td>

                                            </tr>
                                            <tr>

                                            </tr>
                                        </table>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div id="ceo_account_settings_area">
                            <div class="box">
                                <div class="box-top" id="account_seetings_activity_heading">You can change your password here</div>
                                <div class="box-panel">
                                    Form will be displayed here for settings to be made
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                    if (isset($_SESSION['customer_account_created']) && $_SESSION['customer_account_created'] == 1) {
                        ?>
                        <script type="text/javascript">
                            swal({
                                position: 'top-end',
                                type: 'success',
                                width: '36rem',
                                title: 'Card Holder Registration Successful!',
                                showConfirmButton: false,
                                timer: 3000
                            });
                        </script>
                        <?php
                    } else if (isset($_SESSION['connection_error']) && $_SESSION['connection_error'] == 1) {
                        ?>
                        <script type="text/javascript">
                            swal({
                                type: 'error',
                                width: '36rem',
                                title: 'Connection error!',
                                text: 'Please make sure there is internet connection',
                                showConfirmButton: false,
                                timer: 5000
                            });
                        </script>
                        <?php
                    }
                    ?>
                </div><!-- End of CEO's home page-->
                <?php
            }
            ?> 
            <?php
        } else {
            ?>
        <marquee behavior = "alternate"><h1> Dashboard is disabled. Please login </h1></marquee>
        <p><a href="../index.php">Click here login</a></p>
        <?php
    }
    ?>
    <div>
        <div id="dialogoverlay"></div>
        <div id="dialogbox">
            <div>
                <div id="dialogboxhead"></div>
                <div id="dialogboxbody"></div>
                <div id="dialogboxfoot"></div>
            </div>
        </div>
    </div>


    <script src = "../js/jquery.min.js"></script>
    <script src = "../js/bootstrap.min.js"></script>
    <script src = "../js/home.js"></script>
    <script src="../js/countries.js"></script>
    <script src="../js/cities.js"></script>
    <script defer src="../js/fontawesome-all.js"></script>


</body>
</html>

