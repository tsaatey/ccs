<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once 'CrudOperation.php';

if(!empty(filter_input(INPUT_POST, 'password'))) {
    $password = filter_input(INPUT_POST, 'password');
        
    $crud = new CrudOperation();
    $account = new Account();
    
    $account->setUsername($_SESSION['username']);
    $account->setPassword(sha1($password));
    
    
    if($crud->resetPassword($account)){
        echo 'password_changed';
    }else {
        echo 'account_error';
    }
} else {
    echo 'empty_password';
}