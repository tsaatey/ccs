<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'CrudOperation.php';



if (!empty(filter_input(INPUT_POST, 'firstname')) && !empty(filter_input(INPUT_POST, 'lastname')) && !empty(filter_input(INPUT_POST, 'dob')) && !empty(filter_input(INPUT_POST, 'phone')) && !empty(filter_input(INPUT_POST, 'address'))) {
    $employee = new Employee();
    $crud = new CrudOperation();
    $id = $crud->getEmployeeId();
    $firstname = filter_input(INPUT_POST, 'firstname');
    $lastname = filter_input(INPUT_POST, 'lastname');
    $gender = filter_input(INPUT_POST, 'gender');
    $dateOfBirth = filter_input(INPUT_POST, 'dob');
    $phone = filter_input(INPUT_POST, 'phone');
    $email = filter_input(INPUT_POST, 'email');
    $address = filter_input(INPUT_POST, 'address');
    $roleId = filter_input(INPUT_POST, 'roleId');

    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $employee->setId($id);
        $employee->setFirstname($firstname);
        $employee->setLastname($lastname);
        $employee->setGender($gender);
        $employee->setDateOfBirth($dateOfBirth);
        $employee->setPhone($phone);
        $employee->setEmail($email);
        $employee->setAddress($address);
        $employee->setRoleId($roleId);

        if ($crud->insertEmployee($employee)) {
            $_SESSION['user_mail'] = $email;
            $_SESSION['user_role'] = $roleId;
            $_SESSION['setup_account'] = 1;
            //echo 'employee_saved';
            header("Location: ../views/dashboard.php");
            exit();
        } else {
            echo 'something_went_wrong';
        }
    } else {
        echo 'invalid_email';
    }
} else {
    echo 'empty_fields';
}

