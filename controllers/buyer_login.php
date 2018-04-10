<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once '../controllers/CrudOperation.php';

if (!empty(filter_input(INPUT_POST, 'username')) && !empty(filter_input(INPUT_POST, 'password'))) {
    $username = filter_input(INPUT_POST, 'username');
    $password = filter_input(INPUT_POST, 'password');
    
    $crud = new CrudOperation();
    $account = new Account();
    
    if (filter_var($username, FILTER_VALIDATE_EMAIL)) {
        $account->setUsername($username);
        $account->setPassword(sha1($password));
        if ($crud->loginToBuy($account)){
            $_SESSION['buyer_email'] = $username;
            echo 'login_success';
        } else {
            echo 'login_failed';
        }
    } else {
        echo 'invalid_email';
    }
} else {
    echo 'empty_fields';
}
