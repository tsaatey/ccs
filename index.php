<?php
require_once 'utilities/Utilities.php';
$util = new Utilities();
$filePath = 'files/credentials.txt';
$hostFile = 'files/host.txt';
session_start();

if (file_exists($hostFile)) {
    $hostname = explode('\n', file_get_contents($hostFile));
    if ($hostname[0] != gethostname()) {
        unlink($filePath);
        unlink($hostFile);
    }
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href = "css/bootstrap.min.css" rel = "stylesheet" type = "text/css"/>
        <link href = "css/index.css" rel = "stylesheet" type = "text/css"/>
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"/>
        <script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
        <script defer src="js/fontawesome-all.js"></script>
        <script src="node_modules/sweetalert2/dist/sweetalert2.all.js" type="text/javascript"></script>
        <link href="node_modules/sweetalert2/dist/sweetalert2.min.css" rel="stylesheet" type="text/css"/>
        <link href="material-icons-0.2.1/iconfont/material-icons.css" rel="stylesheet" type="text/css"/>
        <link href="node_modules/materialize-css/dist/css/materialize.css" rel="stylesheet" type="text/css"/>
        <title>CCS Login</title>
    </head>
    <body>
        <nav>
            <div class="nav-wrapper">
                <span><img src="images/Credit-Card.png" width="50" id="ccs_image"/></span>
                <a href="#"><span style="text-decoration: none; color: #ffffff; font-size: 25px;">CreditCard Shield</span></a>
            </div>
        </nav>
        <div id = "background_div"></div>
        <div class = "container" id = "wrapper">
            <?php
            if (file_exists($filePath)) {
                ?>
                <div class="row card-panel" id="login_form">
                    <div class="card-title" id = "user_login_text">
                        <p>User Login</p>
                    </div>
                    <div class="col l12 m5" id="centering">
                        <div class="">
                            <p id = "error_element" style="color: red; font-family: Tahoma; font-weight: bold; font-size: 18px;">
                                <?php
                                if (isset($_GET['wrong_username_password']) || isset($_GET['username_password_invalid']) || isset($_GET['invalid_email']) || isset($_GET['username=&password=&login_button='])) {
                                    echo 'Invalid username or password!';
                                }
                                ?>
                            </p>
                            <div class="row">
                                <form class="col s12" id="user_login_form">
                                    <div class="row">
                                        <div class="input-field col s12">
                                            <i class="material-icons prefix">account_circle</i>
                                            <input id="username" type="text" name="username" class="validate">
                                            <label for="username" style="color: #ffffff;">Username</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s12">
                                            <i class="material-icons prefix">person_pin_circle</i>
                                            <input id="password" type="password" name="password" class="validate">
                                            <label for="password" style="color: #ffffff;">Password</label>
                                        </div>  
                                    </div>
                                    <div class="row">
                                        <div class="input-field l8" style="padding-left: 40px;">
                                            <button class="btn index_buttons btn-large waves-effect waves-light" type="submit" name="login_button" id="login_button">Login
                                                <i class="material-icons right">lock_open</i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="card-action">
                        <?php
                        if (isset($_SESSION['forgot_password']) && $_SESSION['forgot_password'] == 1) {
                            ?>
                            <a href="#" id="forgot_password_note">I have forgotten my password</a>
                            <?php
                        } else {
                            echo 'Login to access your account';
                        }
                        ?>
                    </div>
                </div>
                <?php
            } else {
                ?>   
                <div class="row card-panel" id = "server_form">
                    <div class="card-title" id = "server_login_text">
                        <p>Provide MySQL Credentials</p>
                    </div>
                    <div class="col l12 m5" id = "server_centering">
                        <p id="_error" style="color: red; font-family: Tahoma; font-weight: bold; font-size: 18px;">
                            <?php
                            if (isset($_GET['wrong_credentials'])) {
                                echo 'Wrong credentials. Try again!!!';
                            } else if (isset($_GET['wrong_username'])) {
                                echo 'Wrong credentials. Try again!!!';
                            } else if (isset($_GET['database_exists'])) {
                                echo 'Database already exists';
                            }
                            ?>
                        </p>
                        <p id = "error_element"></p>
                        <form class="col s12" id = "mysql_form">
                            <div class = "row">
                                <div class="input-field col s12">
                                    <i class="material-icons prefix">dns</i>
                                    <input id="host" type="text" name="host" class="validate">
                                    <label for="host" style="color: #ffffff;">MySQL Server host</label>
                                </div>
                            </div>
                            <div class = "row">
                                <div class="input-field col s12">
                                    <i class="material-icons prefix">person_circled</i>
                                    <input id="server_username" type="text" name="server_username" class="validate">
                                    <label for="server_username" style="color: #ffffff;">MySQL Server username</label>
                                </div>
                            </div>
                            <div class = "row">
                                <div class="input-field col s12">
                                    <i class="material-icons prefix">person_pin_circle</i>
                                    <input id="server_password" type="text" name="server_password" class="validate">
                                    <label for="server_password" style="color: #ffffff;">MySQL Server password</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col m0"></div>
                                <div class="input-field l8" style="padding-left: 40px;">
                                    <button class="btn index_buttons waves-effect btn-large waves-light" type="submit" name="server_login_button" id="server_login_button">Login to Server
                                        <i class="material-icons right">lock_open</i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <?php
            }
            ?>
            <div class="row card-panel" id="reset_password_area">
                <div class="card-title" id = "password_reset_text">
                    <p>Provide Your Email Adrress</p>
                    <h5>An email will be sent to the address. Please check your mail</h5>
                </div>
                <div id="_password_reset_centering">
                    <h5 id="username_error"></h5>
                    <form class="col s12" id="send_email_password_form">
                        <div class = "row">
                            <div class="input-field col s12">
                                <i class="material-icons prefix">person_pin_circle</i>
                                <input id="username_to_reset" type="email" name="username_to_reset" class="validate">
                                <label for="username_to_reset" style="color: #ffffff;">Email</label>
                            </div>
                        </div>
                        <div class = "form-group" >
                            <table>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td style="width: 300px;">
                                        <div class = "col-sm-5 col-sm-offset-9">
                                            <button type = "button" class = "form-control btn btn-default" name = "cancel_email_button" id = "cancel_email_button">Cancel</button>
                                        </div>
                                    </td>
                                    <td style="width: 300px;">
                                        <div class="col-sm-5 col-sm-offset-2">
                                            <button type = "button" class = "form-control btn btn-default" name = "send_email_button" id = "send_email_button">Submit</button>
                                        </div>

                                    </td>
                                </tr>
                            </table>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <?php
        if (isset($_SESSION['connection_error']) && $_SESSION['connection_error'] == 1) {
            ?>
            <script type="text/javascript">
                swal({
                    title: 'Error!',
                    text: 'Network failed! Email could not be sent',
                    type: 'error',
                    confirmButtonText: 'Close'
                });
            </script>
            <?php
        } else if (isset($_SESSION['email_sent']) && $_SESSION['email_sent'] == 1) {
            ?>
            <script type="text/javascript">
                swal({
                    title: 'Success!',
                    text: 'A new password has been sent to your mail. Use it to login',
                    type: 'success',
                    confirmButtonText: 'Close'
                });
            </script>
            <?php
        }
        ?>


        <script src = "js/jquery.min.js"></script>
        <script src = "js/index.js" type = "text/javascript"></script>
        <script src = "js/bootstrap.min.js"></script>
        <script src="node_modules/materialize-css/dist/js/materialize.min.js" type="text/javascript"></script>
    </body>
</html>