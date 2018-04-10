<?php

require_once '../models/Account.php';
require_once 'CrudOperation.php';

if (!empty(filter_input(INPUT_POST, 'username')) && !empty(filter_input(INPUT_POST, 'password'))) {
    $username = filter_input(INPUT_POST, 'username');
    $password = filter_input(INPUT_POST, 'password');

    if (filter_var($username, FILTER_VALIDATE_EMAIL)) {
        $account = new Account();
        $account->setUsername($username);
        $account->setPassword(sha1($password));

        $login = new CrudOperation();
        $login->userLogin($account);
    } else {
        header("Location: ../index.php?invalid_email=1");
    }
}