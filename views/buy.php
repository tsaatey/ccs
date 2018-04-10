<?php
session_start();
?>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
        <meta http-equiv="Pragma" content="no-cache" />
        <meta http-equiv="Expires" content="0" />
        <link href="../css/font-awesome.min.css" rel="stylesheet"/>
        <link href = "../css/bootstrap.min.css" rel = "stylesheet" type = "text/css"/>
        <link href="../css/buy.css" rel="stylesheet" type="text/css"/>
        <script src="../node_modules/sweetalert2/dist/sweetalert2.all.js" type="text/javascript"></script>
        <link href="../node_modules/sweetalert2/dist/sweetalert2.min.css" rel="stylesheet" type="text/css"/>
        <link href="../material-icons-0.2.1/css/material-icons.min.css" rel="stylesheet" type="text/css"/>
        <link href="../node_modules/materialize-css/dist/css/materialize.min.css" rel="stylesheet" type="text/css" media="screen,projection"/>
        <title>Billing portal</title>
    </head>
    <body>
        <div id="header">
            <div class="logo">
                <span><img src="../images/Credit-Card.png"/></span>
                <a href="#"><span style="text-decoration: none; color: #fff;">CreditCard Shield</span></a>
            </div>
            <?php
            if (!empty($_SESSION['card_holder_loggedin']) && $_SESSION['card_holder_loggedin'] == 1) {
                ?>
                <div class="logout">
                    <span class="glyphicon glyphicon-user"></span>
                    <span id="uname"><?php echo $_SESSION['firstname']; ?></span>
                    <span><a href="../controllers/buyer_logout.php"><span class="glyphicon glyphicon-log-out"></span>&nbsp;Logout</a></span>

                </div>
                <?php
            } else {
                ?>
                <div id="customer_login">
                    <form class="form-horizontal" role="form" id="buy_form">
                        <table>
                            <tr>
                                <td><input class = "form-control" type="email" name="buyer_username" id="buyer_username" placeholder="Enter your username" required="true"/></td>
                                <td><input class = "form-control" type="password" name="buyer_password" id="buyer_password" placeholder="Enter your password" required="true"/></td>
                                <td><button class="btn btn-default" type="button" name="buyer_login_button" id="buyer_login_button">Login</button></td>
                            </tr>
                        </table>
                    </form>
                </div>
                <?php
            }
            ?>
        </div>
        <div id="container">
            <div id="content">
                <h2 id="header_display">Billing Information</h2>
                <div class="box">
                    <div class="box-top" id="transactions_activity_heading">
                        Please provide your credit card details for billing.
                        All your information is safe and secure with us.
                    </div>
                    <div class="box-panel">
                        <div id="billing_area">
                            <div class="form_top">
                                <img src="../images/major.png" alt="" width="100%" height="100%"/>
                            </div>
                            <div style="margin-left: 13%; height: 85%;">
                                <form role="form" id="order_form">
                                    <div class = "form-group" >
                                        <label style="font-weight:normal; font-size: 16px;">Full name</label>
                                        <div class = "col-md-10 input-group">
                                            <input type = "text" class = "form-control input-lg" name = "fullname" value="<?php
                                            if (isset($_SESSION['fullname'])) {
                                                echo $_SESSION['fullname'];
                                            }
                                            ?>" id="fullname" <?php
                                                   if (!empty($_SESSION['suspicious_activity']) && $_SESSION['suspicious_activity'] == 1) {
                                                       echo 'readonly';
                                                   }
                                                   ?> required/>
                                        </div>
                                    </div> 
                                    <div class = "form-group" >
                                        <label style="font-weight:normal; font-size: 16px;">Card number</label>
                                        <div class = "col-md-10 input-group">
                                            <input type = "text" class = "form-control input-lg" name = "cardnumber" value="<?php
                                            if (isset($_SESSION['card_number'])) {
                                                echo $_SESSION['card_number'];
                                            }
                                            ?>"  id="cardnumber" <?php
                                                   if (!empty($_SESSION['suspicious_activity']) && $_SESSION['suspicious_activity'] == 1) {
                                                       echo 'readonly';
                                                   }
                                                   ?>  autofocus="true" required/>
                                            <span class="input-group-addon" id="logo">
                                                <p id="text_display">logo</p>
                                            </span>
                                        </div>
                                    </div> 
                                    <div class="row">
                                        <div class = "form-group col-xs-5" >
                                            <label style="font-weight:normal; font-size: 16px;">Security code</label>
                                            <div class = "col-lg-12 input-group">
                                                <input type = "text" class = "form-control input-lg" name = "cvvnumber" value="<?php
                                                if (isset($_SESSION['securitycode'])) {
                                                    echo $_SESSION['securitycode'];
                                                }
                                                ?>" id="cvvnumber" <?php
                                                       if (!empty($_SESSION['suspicious_activity']) && $_SESSION['suspicious_activity'] == 1) {
                                                           echo 'readonly';
                                                       }
                                                       ?>  maxlength="4" required/>
                                            </div>
                                        </div>
                                        <div class = "form-group col-xs-5" >
                                            <label style="font-weight:normal; font-size: 16px;">Expiry date</label>
                                            <div class = "col-lg-12 col-md-offset-0 input-group">
                                                <input type = "text" class = "form-control input-lg" name = "expiry_date" value="<?php
                                                if (isset($_SESSION['expirydate'])) {
                                                    echo $_SESSION['expirydate'];
                                                }
                                                ?>" id="expiry_date" <?php
                                                       if (!empty($_SESSION['suspicious_activity']) && $_SESSION['suspicious_activity'] == 1) {
                                                           echo 'readonly';
                                                       }
                                                       ?>  placeholder="YYY-MM-DD" required/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class = "form-group" >
                                        <label style="font-weight:normal; font-size: 16px;">Amount</label>
                                        <div class = "col-md-10 input-group">
                                            <input type = "text" class = "form-control input-lg" name = "amount" value="<?php
                                            if (isset($_SESSION['amount'])) {
                                                echo $_SESSION['amount'];
                                            }
                                            ?>" id="amount" <?php
                                                   if (!empty($_SESSION['suspicious_activity']) && $_SESSION['suspicious_activity'] == 1) {
                                                       echo 'readonly';
                                                   }
                                                   ?>  required/>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class = "form-group col-xs-5" >
                                            <div class = "col-md-12 input-group">
                                                <button type = "button" class = "btn btn-success btn-lg" name="transaction_submit" id="transaction_submit" <?php
                                                if (!empty($_SESSION['suspicious_activity']) && $_SESSION['suspicious_activity'] == 1) {
                                                    echo 'disabled';
                                                }
                                                ?>><span class="glyphicon glyphicon-check"></span>&nbsp;Submit</button>
                                            </div>
                                        </div>
                                        <div class = "form-group col-xs-5" >
                                            <div class = "col-md-12 col-lg-offset-3 input-group">
                                                <button type = "reset" class = "btn btn-danger btn-lg" name="button_cancel" id="button_cancel" <?php
                                                if (!empty($_SESSION['suspicious_activity']) && $_SESSION['suspicious_activity'] == 1) {
                                                    echo 'disabled';
                                                }
                                                ?>><span class="glyphicon glyphicon-stop"></span>&nbsp;Cancel</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <?php
                        if (!empty($_SESSION['suspicious_activity']) && $_SESSION['suspicious_activity'] == 1) {
                            ?>
                            <div id="notification_area">
                                <div id="security_div">
                                    <div class="form_top">
                                        <div style="display: inline-block; width: 50%; height: 100%; border-right: 1px solid #000;">
                                            <img src="../images/padlock-1.png" alt="" width="50%" height="85%" style="margin-top: 4px;"/>
                                            <span style="line-height: 5px;">Security Check</span>
                                        </div>
                                        <div style="display: inline-block; width: 48%; height: 100%;">
                                            <p class="flash" style="font-family: cursive; font-size: 18px; font-weight: bold; color: red;">Transaction pending!!!</p>
                                        </div>
                                    </div>
                                    <em>Suspicious transaction detected! Please prove it is you!</em>
                                    <div style="margin-left: 13%; margin-top: 2%; height: 80%;">
                                        <form class="" role="form">
                                            <div class = "form-group" >
                                                <label style="font-weight:normal; font-size: 16px;">Your phone number</label>
                                                <div class = "col-md-10 input-group">
                                                    <input type = "text" class = "form-control input-lg" name = "phone_number" id="phone_number" required/>
                                                </div>
                                            </div>
                                            <div class = "form-group" >
                                                <label style="font-weight:normal; font-size: 16px;">Answer to secret question</label>
                                                <div class = "col-md-10 input-group">
                                                    <input type = "text" class = "form-control input-lg" name = "secret_answer" id="secret_answer" required/>
                                                </div>
                                            </div>
                                            <div class = "form-group" >
                                                <label style="font-weight:normal; font-size: 16px;">Next of Kin</label>
                                                <div class = "col-md-10 input-group">
                                                    <input type = "text" class = "form-control input-lg" name = "next_kin" id="next_kin" required/>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class = "form-group col-xs-5" >
                                                    <div class = "col-md-12 input-group">
                                                        <button type = "button" class = "btn btn-success btn-lg" name="confirm_button" id="confirm_button"><span class="glyphicon glyphicon-check"></span>&nbsp;Confirm</button>
                                                    </div>
                                                </div>
                                                <div class = "form-group col-xs-5" >
                                                    <div class = "col-md-12 col-lg-offset-3 input-group">
                                                        <button type = "button" class = "btn btn-danger btn-lg" name="abort_button" id="abort_button"><span class="glyphicon glyphicon-stop"></span>&nbsp;Abort</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>

                                </div>
                            </div>
                            <?php
                        } else {
                            ?>
                            <div id="notification_div">
                                <p>CreditCard Shield, Your Number One Reliable SHIELD On The Internet!<p>
                                <p>Just do your shopping and let us worry about your security<p>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>

        <?php
        if (isset($_SESSION['suspicious_activity_in_progress']) && $_SESSION['suspicious_activity_in_progress'] == 1) {
            ?>
            <script>
                swal({
                    position: 'top-end',
                    type: 'error',
                    width: '36rem',
                    title: 'Please verify your account before you can logout',
                    showConfirmButton: false,
                    timer: 3000
                });
            </script>
            <?php
        }
        ?>

        <script src = "../js/jquery.min.js"></script>
        <script src = "../js/bootstrap.min.js"></script>
        <script defer src="../js/fontawesome-all.js"></script>
        <script src="../js/buy.js" type="text/javascript"></script>
        <script src="../node_modules/materialize-css/dist/js/materialize.min.js" type="text/javascript"></script>
    </body>
</html>