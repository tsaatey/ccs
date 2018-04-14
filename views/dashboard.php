<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once '../controllers/CrudOperation.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <!--Import Google Icon Font-->
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <!--Import materialize.css-->
        <link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>

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
        <title>Dashboard</title>
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
                        <li><a href="#!"><i class="material-icons left">person</i><?php echo $_SESSION['firstname'] ?></a>/li>
                        <li><a href="../controllers/logout.php">Logout</a></li>
                    </ul>
                    <?php
                }
                ?>

            </div>
        </nav>
        <!-- Side bar navigator -->
        <div class="row">
            <div class="col l2">
                <ul id="slide-out" class="sidenav sidenav-fixed">
                    <div class="sidebar sticky">
                        <ul id="nav">
                            <li id="admin_dashboard"><a href="#" class="selected" id="dashboard">Dashboard</a></li>
                            <li id="admin_add_user"><a href="../pages/add_user.php" id="admin_new_user" target="content-area">Add User</a></li>
                            <li id="delete_user"><a href="../pages/delete_user.php" target="content-area" id="user_delete">Delete User</a></li>
                            <li id="account_reset"><a href="#" id="reset_account">Reset User Account</a></li>
                            <li id="change_admin"><a href="#" id="change_admin_pass">Change Admin Password</a></li>
                        </ul>
                    </div>
                </ul>
                <a href="#" data-target="slide-out" class="sidenav-trigger"><i class="material-icons">menu</i></a>
            </div>
            <div class="col l8">
                <div class="row">
                    <div class="row">
                        <div class="col l1">
                        </div>
                        <div class="col l10" id="cont">
                            <div id="iframe-top"></div>
                            <iframe name="content-area" id="content-area" frameborder="0"></iframe>
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
                                    $crud = new CrudOperation();
                                    $crud->retriveUserInfo();
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
                <li><a class="btn-floating red" href="../pages/add_user.php" target="content-area"><i class="material-icons">add</i></a></li>
                <li><a class="btn-floating yellow darken-1"><i class="material-icons">delete</i></a></li>
                <li><a class="btn-floating green"><i class="material-icons">restore</i></a></li>
                <li><a class="btn-floating blue"><i class="material-icons">change_history</i></a></li>
            </ul>
        </div>

        <script>
            $(document).ready(function () {
                $('.sidenav').sidenav();
            });

            $(document).ready(function () {
                $('.fixed-action-btn').floatingActionButton();
            });
        </script>

        <script src = "../js/jquery.min.js"></script>  
        <script src="../js/dashboard.js" type="text/javascript"></script>
        <script defer src="../js/fontawesome-all.js"></script>
        <script src="../node_modules/materialize-css/dist/js/materialize.min.js" type="text/javascript"></script>

    </body>
</html>

