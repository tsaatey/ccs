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
<htm>
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
        <title>CCS Login</title>
    </head>
    <body>
        <nav class = "navbar navbar-inverse navbar-fixed-top">
            <div class = "container">
                <img class="navbar-brand navbar-static-top img-responsive" src="images/Credit-Card.png" id="ccs_image"/>
                <a class = "navbar-brand navbar-static-top" href = "#" id = "brand_name" style="color: #fff;">CreditCard Shield</a>
            </div>
        </nav>
        <div id = "background_div"></div>
        <div class = "container" id = "wrapper">
            <?php
            if (file_exists($filePath)) {
                ?>
                <div id = "login_form">
                    <div id = "user_login_text">
                        <p>User Login</p>
                    </div>
                    <div id = "centering">
                        <p id = "error_element" style="color: red; font-family: Tahoma; font-weight: bold; font-size: 18px;">
                            <?php
                            if (isset($_GET['wrong_username_password']) || isset($_GET['username_password_invalid']) || isset($_GET['invalid_email']) || isset($_GET['username=&password=&login_button='])) {
                                echo 'Invalid username or password!';
                            }
                            ?>
                        </p>

                        <form class = "form-horizontal" role ="form" id="user_login_form">
                            <div class = "form-group">
                                <label class = "control-label col-sm-2 col-sm-offset-2" for = "username">Username</label>
                                <div class = "col-md-6">
                                    <input type = "email" class = "form-control input-sm" name = "username" id="username" placeholder = "Username/email eg. rich@gmail.com"/>
                                </div>
                            </div>
                            <div class = "form-group" >
                                <label class = "control-label col-sm-2 col-sm-offset-2" for = "password" >Password</label>
                                <div class = "col-md-6">
                                    <input type = "password" class = "form-control input-sm" name = "password" id="password" placeholder = "Password"/>
                                </div>
                            </div>
                            <div class = "form-group" >
                                <div class = "col-sm-2 col-sm-offset-6">
                                    <button type = "submit" class = "form-control btn btn-default" name = "login_button" id = "login_button">Login</button>
                                </div>
                            </div>
                            <?php
                            if (isset($_SESSION['forgot_password']) && $_SESSION['forgot_password'] == 1) {
                                ?>
                                <div class = "form-group" >
                                    <div class = "col-sm-6 col-sm-offset-4 ">
                                        <p id="forgot_password_note">I have forgotten my password</p>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>

                        </form>
                    </div>
                </div>
                <?php
            } else {
                ?>   
                <div id = "server_form">
                    <div id = "server_login_text">
                        <p>Provide MySQL Credentials</p>
                    </div>
                    <div id = "server_centering">
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
                        <form class = "form-horizontal" role ="form" id = "mysql_form">
                            <div class = "form-group">
                                <label class = "control-label col-sm-2 col-sm-offset-2" for = "host">Host</label>
                                <div class = "col-md-6">
                                    <input type = "text" class = "form-control input-sm" name = "host" id="host" placeholder = "your MySQL server host eg. localhost"/>
                                </div>
                            </div>
                            <div class = "form-group">
                                <label class = "control-label col-sm-2 col-sm-offset-2" for = "server_username">Username</label>
                                <div class = "col-md-6">
                                    <input type = "text" class = "form-control input-sm" name = "server_username" id="server_username" placeholder = "your MySQL server username eg. root"/>
                                </div>
                            </div>
                            <div class = "form-group" >
                                <label class = "control-label col-sm-2 col-sm-offset-2" for = "server_password" >Password</label>
                                <div class = "col-md-6">
                                    <input type = "password" class = "form-control input-sm" name = "server_password" id="server_password" placeholder = "your MySQL server password"/>
                                </div>
                            </div>
                            <div class = "form-group" >
                                <div class = "col-sm-3 col-sm-offset-5">
                                    <button type = "submit" class = "form-control btn btn-default" name = "server_login_button" id = "server_login_button">Continue</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <?php
            }
            ?>
            <div id="reset_password_area">
                <div id = "password_reset_text">
                    <p>Provide Your Email Adrress</p>
                    <h5>An email will be sent to the address. Please check your mail</h5>
                </div>
                <div id="_password_reset_centering">
                    <h5 id="username_error"></h5>
                    <form class="form-horizontal" role="form" id="send_email_password_form">
                        <div class = "form-group">
                            <label class = "control-label col-sm-2 col-sm-offset-2" for = "username_to_reset">Email</label>
                            <div class = "col-md-6">
                                <input type = "email" class = "form-control input-sm" name = "username_to_reset" id="username_to_reset" placeholder = "Provide your email/username here"/>
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
    </body>
</html>