<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once 'CrudOperation.php';

if (!empty(filter_input(INPUT_POST, 'employeeId')) && !empty(filter_input(INPUT_POST, 'username'))) {
    $id = filter_input(INPUT_POST, 'employeeId');
    $username = filter_input(INPUT_POST, 'username');
    
    $employee = new Employee();
    $employee->setId($id);
    
    $account = new Account();
    $account->setUsername($username);
    
    $crud = new CrudOperation();
    $crud->deleteEmployee($employee);
    $crud->deleteAccount($account);
    
    echo json_encode(array('success' => true));
}