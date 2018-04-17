<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once 'CrudOperation.php';

if (!empty(filter_input(INPUT_POST, 'firstname')) && !empty(filter_input(INPUT_POST, 'lastname')) && !empty(filter_input(INPUT_POST, 'phone')) && !empty(filter_input(INPUT_POST, 'email')) && !empty(filter_input(INPUT_POST, 'address')) && !empty(filter_input(INPUT_POST, 'name_of_kin')) && !empty(filter_input(INPUT_POST, 'address_of_kin')) && !empty(filter_input(INPUT_POST, 'kin_contact')) && !empty(filter_input(INPUT_POST, 'secret_answer'))) {

    $email = filter_input(INPUT_POST, 'email');

    // validate email
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // email is correct, go ahead and save data
        $crud = new CrudOperation();

        $creditCardHolderId = $crud->getCardHolderId();
        $secretId = $crud->getSecretId();

        $firstname = filter_input(INPUT_POST, 'firstname');
        $lastname = filter_input(INPUT_POST, 'lastname');
        $cardHolderPhone = filter_input(INPUT_POST, 'phone');
        $cardHolderAddress = filter_input(INPUT_POST, 'address');
        $cardHolderGender = filter_input(INPUT_POST, 'gender');
        $cardHolderDob = filter_input(INPUT_POST, 'dob');
        $country = filter_input(INPUT_POST, 'country');
        $city = filter_input(INPUT_POST, 'city');
        $nameOfKin = filter_input(INPUT_POST, 'name_of_kin');
        $addressOfKin = filter_input(INPUT_POST, 'address_of_kin');
        $phoneOfKin = filter_input(INPUT_POST, 'kin_contact');
        $secretQuestion = filter_input(INPUT_POST, 'secret_question');
        $secretAnswer = filter_input(INPUT_POST, 'secret_answer');

        $cardHolder = new CreditCardHolder();
        $secret = new Secret();

        $date = new DateTime($cardHolderDob);
        $formattedDate = $date->format('Y-m-d');

        $cardHolder->setId($creditCardHolderId);
        $cardHolder->setFirstname($firstname);
        $cardHolder->setLastname($lastname);
        $cardHolder->setDateOfBirth($formattedDate);
        $cardHolder->setGender($cardHolderGender);
        $cardHolder->setAddress($cardHolderAddress);
        $cardHolder->setEmail($email);
        $cardHolder->setPhone($cardHolderPhone);
        $cardHolder->setCountry($country);
        $cardHolder->setCity($city);
        $cardHolder->setNextOfKin($nameOfKin);
        $cardHolder->setAddressOfKin($addressOfKin);
        $cardHolder->setPhoneOfKin($phoneOfKin);
        $cardHolder->setSecretId($secretId);
        $cardHolder->setRoleId(3);

        $secret->setId($secretId);
        $secret->setQuestion_id($secretQuestion);
        $secret->setAnswer($secretAnswer);

        if ($crud->saveSecretAnswer($secret)) {
            if ($crud->registerCardHolder($cardHolder)) {
                $_SESSION['card_holder_id'] = $creditCardHolderId;
                $_SESSION['card_holder_account_in_progress'] = 1;
                $_SESSION['card_holder_name'] = $firstname . " " . $lastname;
                $_SESSION['card_holder_username'] = $email;
                $_SESSION['wrong_card_holder_email'] = 0;
                $_SESSION['card_holder_fields_empty'] = 0;

                header("Location: ../views/home.php");
            }
        } else {
            
        }
    } else {
        // email is wrong, redirect to home and report error
        $_SESSION['wrong_card_holder_email'] = 1;
        header("Location: ../views/home.php");
    }
} else {
    $_SESSION['card_holder_fields_empty'] = 1;
    header("Location: ../views/home.php");
}

