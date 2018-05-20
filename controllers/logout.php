<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once 'CrudOperation.php';

if ($_SESSION['setup_account'] == 1 || $_SESSION['card_holder_account_in_progress'] == 1) {
    $_SESSION['account_setup_required'] = 1;
    header("Location: ../views/dashboard.php");
} else {
    $crud = new CrudOperation();
    $crud->logUserActivity($_SESSION['userId'], 'Logged out');
    session_destroy();
    header("Location: ../index.php");
}






