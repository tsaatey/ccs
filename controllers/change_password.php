<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once 'CrudOperation.php';
require_once 'SendEmail.php';
require_once '../utilities/PasswordGenerator.php';

if (!empty(filter_input(INPUT_POST, 'username_to_reset'))) {
    $username = filter_input(INPUT_POST, 'username_to_reset');

    if (filter_var($username, FILTER_VALIDATE_EMAIL)) {
        $crud = new CrudOperation();
        $account = new Account();
        $util = new PasswordGenerator();
        $password = $util->generatePassword();
        $mailSubject = "New login password";
        $messageBody = "Dear customer, this is your new password. Use it to login";
        $sendMail = new SendEmail($username, $password, $mailSubject, $messageBody);

        if ($crud->isUsernameValid($username)) {
            if ($sendMail->sendPassword()) {
                $account->setPassword(sha1($password));
                $account->setUsername($username);
                $crud->resetCustomerPassword($account);
                $_SESSION['forgot_password'] = 0;
                $_SESSION['email_sent'] = 1;
                $_SESSION['connection_error'] = 0;
                $_SESSION['email_does_not_exist'] = 0;
                $_SESSION['invalid_email'] = 0;
                $_SESSION['email_field_empty'] = 0;
                
                header("Location: ../index.php");
            } else {
                $_SESSION['connection_error'] = 1;
                header("Location: ../index.php");
            }
        } else {
            $_SESSION['email_does_not_exist'] = 1;
            header("Location: ../index.php");
        }
    } else {
        $_SESSION['invalid_email'] = 1;
        header("Location: ../index.php");
    }
} else {
    $_SESSION['email_field_empty'] = 1;
    header("Location: ../index.php");
}