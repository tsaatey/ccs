<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once '../controllers/CrudOperation.php';
//session_destroy();
?>
<!DOCTYPE html>
<html>
    <head>
        <!--Import Google Icon Font-->
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

        <!--Let browser know website is optimized for mobile-->
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

        <script src = "../js/jquery.min.js"></script>
        <script src="../js/customConfirmDialog.js"></script>
        <script src="../node_modules/sweetalert2/dist/sweetalert2.all.js" type="text/javascript"></script>
        <link href="../node_modules/sweetalert2/dist/sweetalert2.min.css" rel="stylesheet" type="text/css"/>
        <script src="../js/alerts.js" type="text/javascript"></script>
        <link href="../material-icons-0.2.1/iconfont/material-icons.css" rel="stylesheet" type="text/css"/>
        <link href="../node_modules/materialize-css/dist/css/materialize.min.css" rel="stylesheet" type="text/css" media="screen,projection"/>
        <link href="../css/dashboard.css" rel="stylesheet" type="text/css"/>
        <?php
        if (!isset($_SESSION['setup_account']) || $_SESSION['setup_account'] == 0) {
            ?>
            <script src="../js/auto_logout.js" type="text/javascript"></script>
            <?php
        }
        ?>
        <title>Dashboard</title>
        <script>
            function resizeIframe(obj) {
                obj.style.height = obj.contentWindow.document.body.scrollHeight + 100 + 'px';
            }
            $('iframe').height($('iframe').contents().outerHeight());
        </script>
        <style>
            body {
                height: auto;
                overflow: auto;
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
                if (!empty($_SESSION['roleId'])) {
                    ?>
                    <ul id="nav-mobile" class="right hide-on-med-and-down">
                        <li><a href="#!"><i class="material-icons left">person</i><?php echo $_SESSION['firstname'] ?></a></li>
                        <li><a href="../controllers/logout.php">Logout</a></li>
                    </ul>
                    <?php
                }
                ?>

            </div>
        </nav>
        <?php
        if (!empty($_SESSION['roleId'])) {
            ?>
            <!-- Side bar navigator -->
            <div class="row">
                <div class="col l2">
                    <ul id="slide-out" class="sidenav sidenav-fixed">
                        <div class="sidebar sticky">
                            <?php
                            if (!empty($_SESSION['roleId'])) {
                                if (empty($_SESSION['user_mail'])) {
                                    if ($_SESSION['roleId'] == 1) {

                                        require_once '../menus/admin_menu.php';
                                    }

                                    if ($_SESSION['roleId'] == 2) {
                                        if (empty($_SESSION['card_holder_account_in_progress'])) {
                                            require_once '../menus/employee_menu.php';
                                        }
                                    }

                                    if ($_SESSION['roleId'] == 3) {
                                        require_once '../menus/customer_menu.php';
                                    }

                                    if ($_SESSION['roleId'] == 4) {
                                        if (empty($_SESSION['card_holder_account_in_progress'])) {
                                            require_once '../menus/ceo_menu.php';
                                        }
                                    }
                                }
                            }
                            ?>
                        </div>
                    </ul>
                </div>
                <div class="col l8">
                    <div class="row">
                        <div class="row">
                            <div class="col l1">
                            </div>
                            <div class="col l10" id="cont">
                                <div id="iframe-top"></div>
                                <?php
                                if (empty($_SESSION['card_holder_account_in_progress']) || empty($_SESSION['user_mail'])) {
                                    ?>
                                    <iframe name="content-area" id="content-area" frameborder="0" onload="resizeIframe(this)"></iframe>
                                    <?php
                                }
                                ?>
                            </div>
                            <div class="col l1">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col l1"></div>
                            <div class="col l10">
                                <div class="col l12 m5">
                                    <div class="card-panel" id="user_display">
                                        <?php
                                        if (!empty($_SESSION['user_mail'])) {
                                            require_once '../pages/account_setup.php';
                                        } else {
                                            if ($_SESSION['roleId'] == 1) {
                                                $crud = new CrudOperation();
                                                $crud->retriveUserInfo();
                                            }

                                            if ($_SESSION['roleId'] == 4) {
                                                if (isset($_SESSION['card_holder_account_in_progress']) && $_SESSION['card_holder_account_in_progress'] == 1) {
                                                    require_once '../pages/credit_card_account.php';
                                                } else {
                                                    if (!empty($_SESSION['account_reset']) && $_SESSION['account_reset'] == 1) {
                                                        require_once '../pages/set_new_password.php';
                                                    }
                                                    $crud = new CrudOperation();
                                                    $crud->displayTransactionsForToday();
                                                }
                                            }

                                            if ($_SESSION['roleId'] == 2) {
                                                if (isset($_SESSION['card_holder_account_in_progress']) && $_SESSION['card_holder_account_in_progress'] == 1) {
                                                    require_once '../pages/credit_card_account.php';
                                                } else {
                                                    if (!empty($_SESSION['account_reset']) && $_SESSION['account_reset'] == 1) {
                                                        require_once '../pages/set_new_password.php';
                                                    }
                                                    $crud = new CrudOperation();
                                                    $crud->displayTransactionsForToday();
                                                }
                                            }

                                            if ($_SESSION['roleId'] == 3) {
                                                $crud = new CrudOperation();
                                                $crud->displayCustomerTransactionsForToday($_SESSION['username']);
                                            }
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col l1"></div>
                        </div>
                    </div>
                </div>
                <div class="col l2">
                </div>
            </div>
            <!-- Floating action button -->
            <div class="fixed-action-btn">
                <a class="btn-floating btn-large">
                    <i class="large material-icons">mode_edit</i>
                </a>
                <ul>
                    <?php
                    if ($_SESSION['roleId'] == 1) {
                        ?>
                        <li id="floating_admin_add_user"><a id="floating_admin_new_user" class="btn-floating red" href="../pages/add_user.php" target="content-area"><i class="material-icons">add</i></a></li>
                        <li id="floating_delete_user"><a id="floating_user_delete" class="btn-floating yellow darken-1" href="../pages/delete_user.php" target="content-area"><i class="material-icons">delete</i></a></li>
                        <li id="floating_reset_account"><a id="floating_reset_account" class="btn-floating green" href="../pages/reset_account.php" target="content-area"><i class="material-icons">restore</i></a></li>
                        <li id="floating_change_admin"><a id="floating_change_admin_pass" class="btn-floating blue" href="../pages/change_password.php" target="content-area"><i class="material-icons">change_history</i></a></li>
                        <?php
                    } else if ($_SESSION['roleId'] == 2) {
                        ?>
                        <li id="floating_card_application"><a class="btn-floating red" href="../pages/register_card_holder.php" target="content-area"><i class="material-icons">add</i></a></li>
                        <?php
                    } else if ($_SESSION['roleId'] == 3) {
                        ?>
                        <li id="floating_my_account"><a id="floating_change_admin_pass" class="btn-floating blue" href="../pages/change_password.php" target="content-area"><i class="material-icons">change_history</i></a></li>
                        <?php
                    } else if ($_SESSION['roleId'] == 4) {
                        ?>
                        <li id="floating_card_application"><a class="btn-floating red" href="../pages/register_card_holder.php" target="content-area"><i class="material-icons">add</i></a></li>
                        <?php
                        }
                        ?>

                </ul>
            </div>
            <?php
        } else {
            ?>
        <marquee behavior = "alternate"><h1> Dashboard is disabled. Please login </h1></marquee>
        <p><a href="../index.php">Click here login</a></p>
        <?php
    }
    ?>


    <script>
        $(document).ready(function () {
            $('.sidenav').sidenav();
        });

        $(document).ready(function () {
            $('.fixed-action-btn').floatingActionButton();
        });

        $(document).ready(function () {
            $('.collapsible').collapsible();
        });

        $(document).ready(function () {
            $('.dropdown-trigger').dropdown();
        });
    </script>

    <script src = "../js/jquery.min.js"></script>  
    <script src="../js/dashboard.js" type="text/javascript"></script>
    <script defer src="../js/fontawesome-all.js"></script>
    <script src="../node_modules/materialize-css/dist/js/materialize.min.js" type="text/javascript"></script>

</body>
</html>

