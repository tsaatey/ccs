<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once 'CrudOperation.php';
require_once '../utilities/Utilities.php';
require_once '../utilities/PasswordGenerator.php';
require_once 'SendEmail.php';


if (!empty(filter_input(INPUT_POST, 'credit_card_number')) && !empty(filter_input(INPUT_POST, 'issued_date')) && !empty(filter_input(INPUT_POST, 'expiry_date')) && !empty(filter_input(INPUT_POST, 'cvv'))) {

    $cardNumber = filter_input(INPUT_POST, 'credit_card_number');
    $cvv = filter_input(INPUT_POST, 'cvv');

    $util = new Utilities();

    if ($util->isInteger($cardNumber)) {
        if (filter_var($cvv, FILTER_VALIDATE_INT)) {
            $issuedDate = filter_input(INPUT_POST, 'issued_date');
            $expiryDate = filter_input(INPUT_POST, 'expiry_date');
            $company = filter_input(INPUT_POST, 'card_issuer');

            $creditCard = new CreditCard();
            $accout = new Account();
            $crud = new CrudOperation();
            $pGen = new PasswordGenerator();
            $password = $pGen->generatePassword();

            $receiver_address = $_SESSION['card_holder_username'];
            $mailSubject = 'Welcome To CreditCard Shield!';
            $messageBody = 'We are delighted you made the awesome choice to join us. '
                    . 'We will safeguard your credit card to make sure the only authorized transactions are made by you alone! '
                    . 'Please use your email as username. The password is: ';

            $mail = new SendEmail($receiver_address, $password, $mailSubject, $messageBody);
            
            $iddate = new DateTime($issuedDate);
            $formattedIssuerDate = $iddate->format('Y-m-d');
            
            $expDate = new DateTime($expiryDate);
            $formattedExpiryDate = $expDate->format('Y-m-d');

            $creditCard->setNumber($cardNumber);
            $creditCard->setIssueDate($formattedIssuerDate);
            $creditCard->setExpiryDate($formattedExpiryDate);
            $creditCard->setCvv($cvv);
            $creditCard->setIssuerId($company);
            $creditCard->setHolderId($_SESSION['card_holder_id']);

            $accout->setUsername($_SESSION['card_holder_username']);
            $accout->setPassword(sha1($password));
            $accout->setRoleId(3);

            if ($mail->sendPassword()) {
                if ($crud->saveCreditCardDetails($creditCard)) {
                    if ($crud->createAccount($accout)) {
                        $_SESSION['card_holder_account_in_progress'] = 0;
                        $_SESSION['card_holder_username'] = '';
                        $_SESSION['card_holder_username'] = '';
                        $_SESSION['customer_account_created'] = 1;
                        echo 'card_details_saved';
                    }
                }
            } else {
                echo 'connection_error';
            }
        } else {
            echo 'cvv_invalid';
        }
    } else {
        echo 'card_number_invalid';
    }
} else {
    echo 'empty_card_fields';
}