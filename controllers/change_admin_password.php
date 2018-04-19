<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once 'CrudOperation.php';

if(!empty(filter_input(INPUT_POST, 'new_admin_password'))) {
    $password = filter_input(INPUT_POST, 'new_admin_password');
        
    $crud = new CrudOperation();
    $account = new Account();
    
    $account->setUsername($_SESSION['username']);
    $account->setPassword(sha1($password));
    
    
    if($crud->resetPassword($account)){
        header("Location: ../views/dashboard.php");
    }else {
        header("Location: ../views/dashboard.php?account_error=1");
    }
} else {
    header("Location: ../views/dashboard.php?empty_password=1");
}