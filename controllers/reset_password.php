<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once 'CrudOperation.php';

if(!empty(filter_input(INPUT_POST, 'user_mail')) && !empty(filter_input(INPUT_POST, 'user_password'))) {
    $username = filter_input(INPUT_POST, 'user_mail');
    $password = filter_input(INPUT_POST, 'user_password');
        
    $crud = new CrudOperation();
    $account = new Account();
    
    $account->setUsername($username);
    $account->setPassword(sha1($password));
    
    
    if($crud->resetPassword($account)){
        $_SESSION['account_reset'] = 0;
        header("Location: ../views/home.php");
    }else {
        header("Location: ../views/home.php?account_error=1");
    }
} else {
    header("Location: ../views/home.php?empty_password=1");
}
