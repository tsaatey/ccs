<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once './CrudOperation.php';

if (!empty(filter_input(INPUT_POST, 'username'))) {
    $username = filter_input(INPUT_POST, 'username');
    
    $crud = new CrudOperation();
    $id = $crud->getBuyerId($username);
    
    if (!empty($id)) {
        if (!$crud->resetSecurityCheckHistory($id)) {
            echo 'internal_error';
        } else {
            echo 'unlock_sccuess';
        }
    } else {
        echo 'invalid_username';
    }
}
