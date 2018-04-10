<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once 'CrudOperation.php';

if (!empty(filter_input(INPUT_POST, 'username'))) {
    $username = filter_input(INPUT_POST, 'username');
    
    $account = new Account();
    $crud = new CrudOperation();
    
    $account->setUsername($username);
    
    if ($crud->updateAccount($account)) {
        echo json_encode(array("success" => true));
    } else {
        echo json_encode(array("success" => false));
    }
}

