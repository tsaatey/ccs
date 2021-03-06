<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

?>
<!DOCTYPE html>
<html>
    <head>
        <!--Import Google Icon Font-->
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <!--Let browser know website is optimized for mobile-->
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

        <script src = "../js/jquery.min.js"></script>
        <link href="../material-icons-0.2.1/iconfont/material-icons.css" rel="stylesheet" type="text/css"/>
        <link href="../node_modules/materialize-css/dist/css/materialize.min.css" rel="stylesheet" type="text/css" media="screen,projection"/>
        <link href="../css/dashboard.css" rel="stylesheet" type="text/css"/>
        <script src="../node_modules/sweetalert2/dist/sweetalert2.all.js" type="text/javascript"></script>
        <link href="../node_modules/sweetalert2/dist/sweetalert2.min.css" rel="stylesheet" type="text/css"/>
        <script src="../js/alerts.js" type="text/javascript"></script>

        <style>
            .user_doc{
                width: 960px;
                margin: 0 auto;
            }

            .index_buttons{
                width: 64%;
                background-color: #008975;
            }
        </style>

    </head>
    <body>
        <div class="row user_doc">
            <h6 style="color: #008975; font-weight: bold">We have detected that your password was recently reset to default. Please change it to make sure your account is secured</h6>
            <form class="col s12" id="new_admin_password_form">
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
                <div class="row">
                    <div class="input-field col s8">
                        <i class="material-icons prefix">person_circled</i>
                        <input id="user_mail" type="email" name="user_mail" value="<?php echo $_SESSION['username']; ?>" readonly="true" class="validate">
                        <label for="user_mail" style="color: #000;">Username</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s8">
                        <i class="material-icons prefix">person_pin_circled</i>
                        <input id="user_password" type="password" name="user_password" class="validate">
                        <label for="user_password" style="color: #000;">Password</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s8">
                        <i class="material-icons prefix">person_pin_circled</i>
                        <input id="user_password_confirmed" type="password" name="user_password_confirmed" class="validate">
                        <label for="user_password_confirmed" style="color: #000;">Confirm password</label>
                    </div>  
                </div>
                <div class="row">
                    <div class="input-field l8" style="padding-left: 40px;">
                        <button class="btn index_buttons z-depth-3 btn-large waves-effect waves-light" type="button" name="reset_password_button" id="reset_password_button">Change Password
                            <i class="material-icons right">send</i>
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <script src = "../js/jquery.min.js"></script> 
        <script src="../js/home.js"></script>
        <script src="../node_modules/materialize-css/dist/js/materialize.min.js" type="text/javascript"></script>
    </body>
</html>


