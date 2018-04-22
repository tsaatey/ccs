<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once 'CrudOperation.php';

if(!empty(filter_input(INPUT_POST, 'username')) && !empty(filter_input(INPUT_POST, 'password'))) {
    $username = filter_input(INPUT_POST, 'username');
    $password = filter_input(INPUT_POST, 'password');
    $roleId = $_SESSION['user_role'];
    
    $crud = new CrudOperation();
    $account = new Account();
    
    $account->setUsername($username);
    $account->setPassword(sha1($password));
    $account->setRoleId($roleId);
    
    if($crud->createAccount($account)){
        $_SESSION['user_mail'] = ''; 
        $_SESSION['setup_account'] = 0;
        echo 'account_created';
    }else {
        echo 'account_error';
    }
} else {
    echo 'empty_password';
}
