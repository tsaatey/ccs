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
        <script src = "../js/jquery.min.js"></script>
        <script src="../node_modules/sweetalert2/dist/sweetalert2.all.js" type="text/javascript"></script>
        <link href="../node_modules/sweetalert2/dist/sweetalert2.min.css" rel="stylesheet" type="text/css"/>
        <link href="../material-icons-0.2.1/iconfont/material-icons.css" rel="stylesheet" type="text/css"/>
        <link href="../node_modules/materialize-css/dist/css/materialize.min.css" rel="stylesheet" type="text/css" media="screen,projection"/>
        <title>Billing portal</title>

        <style>

            .buy_buttons{
                width: 100%;
                background-color: #008975;
            }

            .spe_buttons{
                width: 87%;
                background-color: #008975;
            }
        </style>

    </head>
    <body>
        <!-- Header -->
        <nav class="">
            <div class="nav-wrapper navbar-fixed">
                <span><img src="../images/Credit-Card.png" width="50" id="ccs_image"/></span>
                <a href="#"><span id="brand_name" style="text-decoration: none; color: #ffffff; font-size: 25px;">CreditCard Shield</span></a>
                <?php
                if (!empty($_SESSION['card_holder_loggedin']) && $_SESSION['card_holder_loggedin'] == 1) {
                    ?>
                    <ul id="nav-mobile" class="right hide-on-med-and-down">
                        <li><a href="#!"><i class="material-icons left">person</i><?php echo $_SESSION['firstname'] ?></a></li>
                        <li><a href="../controllers/logout.php">Logout</a></li>
                    </ul>
                    <?php
                } else {
                    ?>
                    <ul id="nav-mobile" class="right hide-on-med-and-down">
                        <li><a class="modal-trigger" href="#modal1">Login</a></li>
                    </ul>
                    <?php
                }
                ?>

            </div>
        </nav>
        <div class="row">
            <div class="col l2"></div>
            <div class="col l8">
                <div class="row card-panel" style="height: 900px;">
                    <?php
                    if (isset($_SESSION['suspicious_activity_in_progress']) && $_SESSION['suspicious_activity_in_progress'] == 1) {
                        ?>
                        <h4 style="color: #8b1014">Please verify your account before you can log out</h4>
                        <?php
                    }
                    ?>
                    <h3>Billing Information</h3>
                    <div class="row box-top">
                        Provide your credit card information below
                    </div>
                    <div class="col l5" style="border: 1px solid #000; border-radius: 10px;">
                        <div class="row">
                            <div class="row col l12">
                                <div class="row form_top">
                                    <img src="../images/major.png" alt="" width="100%" height="100%"/>
                                </div>
                            </div>
                            <div class="row col l12">
                                <div class="row" style = "padding: 20px;">
                                    <form role="form" id="order_form">
                                        <div class = "row" >
                                            <div class = "input-field col s10">
                                                <i class="material-icons prefix">credit_card</i>
                                                <input type = "text" class = "validate" name = "cardnumber" value="<?php
                                                if (isset($_SESSION['card_number'])) {
                                                    echo $_SESSION['card_number'];
                                                }
                                                ?>"  id="cardnumber" <?php
                                                       if (!empty($_SESSION['suspicious_activity']) && $_SESSION['suspicious_activity'] == 1) {
                                                           echo 'readonly';
                                                       }
                                                       ?>  autofocus="true" required/>
                                                <label for="cardnumber" style="color: #000;">Credit card number</label>
                                                <span class="helper-text" data-error="Card number is required"></span>
                                            </div>
                                            <div class = "input-field col s2">
                                                <span id="logo" style="padding-top: 25px;">
                                                    <p id="text_display">logo</p>
                                                </span>
                                            </div>
                                        </div> 
                                        <div class="row">
                                            <div class = "input-field col s6" >
                                                <i class="material-icons prefix">person_pin_circled</i>
                                                <label style="color: #000" for="cvvnumber">Security code</label>
                                                <input type = "text" class = "validate" name = "cvvnumber" value="<?php
                                                if (isset($_SESSION['securitycode'])) {
                                                    echo $_SESSION['securitycode'];
                                                }
                                                ?>" id="cvvnumber" <?php
                                                       if (!empty($_SESSION['suspicious_activity']) && $_SESSION['suspicious_activity'] == 1) {
                                                           echo 'readonly';
                                                       }
                                                       ?>  maxlength="4" required/>
                                                <span class="helper-text" data-error="Security code is required"></span>
                                            </div>
                                            <div class = "input-field col s6" >
                                                <i class="material-icons prefix">date_range</i>
                                                <input type = "text" class = "datepicker validate" name = "expiry_date" value="<?php
                                                if (isset($_SESSION['expirydate'])) {
                                                    echo $_SESSION['expirydate'];
                                                }
                                                ?>" id="expiry_date" <?php
                                                       if (!empty($_SESSION['suspicious_activity']) && $_SESSION['suspicious_activity'] == 1) {
                                                           echo 'readonly';
                                                       }
                                                       ?> required/>
                                                <label for="expiry_date" style="color: #000">Expiry date</label>
                                                <span class="helper-text" data-error="Expiry date is required"></span>
                                            </div>
                                        </div>
                                        <div class = "row" >
                                            <div class = "input-field col s12">
                                                <i class="material-icons prefix">monetization_on</i>
                                                <label for="amount" style="color: #000;">Amount</label>
                                                <input type = "text" class = "validate" name = "amount" value="<?php
                                                if (isset($_SESSION['amount'])) {
                                                    echo $_SESSION['amount'];
                                                }
                                                ?>" id="amount" <?php
                                                       if (!empty($_SESSION['suspicious_activity']) && $_SESSION['suspicious_activity'] == 1) {
                                                           echo 'readonly';
                                                       }
                                                       ?>  required/>
                                                <span class="helper-text" data-error="Amount is required"></span>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class = "input-field col s6" >
                                                <button type = "button" class = "btn buy_buttons" name="transaction_submit" id="transaction_submit" <?php
                                                if (!empty($_SESSION['suspicious_activity']) && $_SESSION['suspicious_activity'] == 1) {
                                                    echo 'disabled';
                                                }
                                                ?>><span class="glyphicon glyphicon-check"></span>&nbsp;Submit</button>
                                            </div>
                                            <div class = "input-field col s6" >
                                                <button type = "button" class = "btn buy_buttons" name="button_cancel" id="button_cancel" <?php
                                                if (!empty($_SESSION['suspicious_activity']) && $_SESSION['suspicious_activity'] == 1) {
                                                    echo 'disabled';
                                                }
                                                ?>><span class="glyphicon glyphicon-stop"></span>&nbsp;Cancel</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col l2"></div>
                    <?php
                    if (!empty($_SESSION['suspicious_activity']) && $_SESSION['suspicious_activity'] == 1) {
                        ?>
                        <div class="col l5" style="border: 1px solid #000; border-radius: 10px;">
                            <div class="row">
                                <div class="col l12">
                                    <div class="row form_top">
                                        <div class="col l7">
                                            <div class="row">
                                                <div class="col l6">
                                                    <img src="../images/padlock-1.png" alt="" width="50%" height="85%" style="margin-top: 4px;"/>
                                                </div>
                                                <div class="col l6">
                                                    <span style="line-height: 45px;">Security Check</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col l5">
                                            <p class="flash" style="font-family: cursive; font-size: 18px; font-weight: bold; color: red;">Transaction pending!!!</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col l12">
                                    <div class="row" style = "padding: 20px;">
                                        <em>Some text</em>
                                        <form class="" role="form">
                                            <div class = "row" >
                                                <div class = "input-field col l12">
                                                    <i class="material-icons prefix">phone</i>
                                                    <label for="phone_number" style="color: #000">Your phone number</label>
                                                    <input type = "text" class = "validate" name = "phone_number" id="phone_number" required/>
                                                </div>
                                            </div>
                                            <div class = "row" >
                                                <div class = "input-field col l12">
                                                    <i class="material-icons prefix">edit</i>
                                                    <label for="secret_answer" style="color: #000;">Answer to secret question</label>
                                                    <input type = "text" class = "validate" name = "secret_answer" id="secret_answer" required/>
                                                </div>
                                            </div>
                                            <div class = "row" >
                                                <div class = "input-field col l12">
                                                    <i class="material-icons prefix">edit</i>
                                                    <label for="next_kin" style="color: #000;">Next of Kin</label>
                                                    <input type = "text" class = "validate" name = "next_kin" id="next_kin" required/>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="input-field l7" style="padding-left: 50px;">
                                                    <button class="btn spe_buttons z-depth-3 btn-large waves-effect waves-light" type="button" name="confirm_button" id="confirm_button">Confirm
                                                        <i class="material-icons right">send</i>
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
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
            <div class="col l2"></div>
        </div>
        <!-- Modal Structure -->
        <div id="modal1" class="modal modal-fixed-footer" style="width: 500px;">
            <div class="modal-content">
                <h5 style="color: #688EB3; font-weight: bold; text-align: center">Please Provide Your Account Details</h5>
                <div class="row">
                    <form class="col s12" id="user_login_form">
                        <div class="row">
                            <div class="input-field col s12">
                                <i class="material-icons prefix">person</i>
                                <input id="buyer_username" type="email" name="buyer_username" class="validate">
                                <label for="buyer_username" style="color: #000;">Username</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12">
                                <i class="material-icons prefix">person_pin_circle</i>
                                <input id="buyer_password" type="password" name="buyer_password" class="validate">
                                <label for="buyer_password" style="color: #000;">Password</label>
                            </div>  
                        </div>
                        <div class="row">
                            <div class="col m0"></div>
                            <div class="col l12 l12 modal_button">
                                <div class="input-field l12" style="padding-left: 40px;">
                                    <button class="btn btn-large submit_button waves-effect waves-light buy_buttons z-depth-3" type="button" name="buyer_login_button" id="buyer_login_button">Login
                                        <i class="material-icons right">lock_open</i>
                                    </button>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <p style="text-align: center; font-style: italic; font-size: 14px;">Please login in order for us to identify you</p>
            </div>
        </div>
        <script>
            $(document).ready(function () {
                $('.datepicker').datepicker();
            });
        </script>
        <script>
            $(document).ready(function () {
                $('.modal').modal();
            });
        </script>

        <script src = "../js/jquery.min.js"></script>
        <script src = "../js/bootstrap.min.js"></script>
        <script defer src="../js/fontawesome-all.js"></script>
        <script src="../js/buy.js" type="text/javascript"></script>
        <script src="../node_modules/materialize-css/dist/js/materialize.min.js" type="text/javascript"></script>
    </body>
</html>