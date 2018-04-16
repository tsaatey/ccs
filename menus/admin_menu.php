<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<ul id="nav">
    <li id="admin_dashboard"><a href="#" class="selected" id="dashboard">Dashboard</a></li>
    <li id="admin_add_user"><a href=" <?php if (empty($_SESSION['user_mail'])){echo '../pages/add_user.php';}?>" id="admin_new_user" target="content-area">Add User</a></li>
    <li id="delete_user"><a href="<?php if (empty($_SESSION['user_mail'])){echo '../pages/delete_user.php';}?>" target="content-area" id="user_delete">Delete User</a></li>
    <li id="account_reset"><a href="<?php if (empty($_SESSION['user_mail'])){echo '../pages/reset_account.php';}?>" target="content-area" id="reset_account">Reset User Account</a></li>
    <li id="change_admin"><a href="<?php if (empty($_SESSION['user_mail'])){echo '../pages/change_password.php';}?>" target="content-area" id="change_admin_pass">Change Admin Password</a></li>
</ul>
