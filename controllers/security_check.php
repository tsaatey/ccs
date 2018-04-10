<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once '../utilities/ClientLocation.php';
require_once './CrudOperation.php';

if (!empty(filter_input(INPUT_POST, 'phone')) && !empty(filter_input(INPUT_POST, 'answer')) && !empty(filter_input(INPUT_POST, 'kin'))) {
    $phone = filter_input(INPUT_POST, 'phone');
    $answer = filter_input(INPUT_POST, 'answer');
    $kin = filter_input(INPUT_POST, 'kin');

    $crud = new CrudOperation();
    $util = new Utilities();
    $savedSecret = $crud->getSecretDetails($_SESSION['buyer_email']);
    $id = $crud->getBuyerId($_SESSION['buyer_email']);
    $checkParams = $crud->getSecurityCheckValues($id);
    $occurrence = $checkParams['occurrence'];
    $ip = '154.160.6.59';
    $ip1 = '41.215.171.217';

    if ($phone == $savedSecret['phone'] && $answer == $savedSecret['answer'] && $kin == $savedSecret['kin']) {
        // allow transaction and delete security check history
        $clientLocation = new ClientLocation($ip);
        $cli = $clientLocation->getClientLocation();

        if ($cli != null) {
            $country = $cli['country'];
            $region = $cli['region'];
            $city = $cli['city'];
            $longitude = $cli['longitude'];
            $latitude = $cli['latitude'];

            $vendorSite = $util->getVendorUrl();
            $transactionId = $crud->getTransactionId();
            date_default_timezone_set('Europe/London');
            $dateTime = new DateTime();
            $date_time = $dateTime->format('Y-m-d H:i:s');

            $transaction = new Transaction();
            $transactionLocation = new TransactionLocation();

            // set transation details
            $transaction->setId($transactionId);
            $transaction->setCreditCardHolderId($id);
            $transaction->setCreditCardNumber($_SESSION['card_number']);
            $transaction->setVendorSite($vendorSite);
            $transaction->setAmount($_SESSION['amount']);
            $transaction->setTransactionDate(date('Y-m-d'));
            $transaction->setDateTime($date_time);

            // set transaction location details
            $transactionLocation->setTransactionId($transactionId);
            $transactionLocation->setCountry($country);
            $transactionLocation->setRegion($region);
            $transactionLocation->setCity($city);
            $transactionLocation->setLongitude($longitude);
            $transactionLocation->setLatitude($latitude);

            // save data
            if ($crud->recordTransaction($transaction)) {
                if ($crud->recordTransactionLocation($transactionLocation)) {
                    if ($crud->resetSecurityCheckHistory($id)) {
                        $_SESSION['fullname'] = '';
                        $_SESSION['card_number'] = '';
                        $_SESSION['securitycode'] = '';
                        $_SESSION['expirydate'] = '';
                        $_SESSION['amount'] = '';
                        $_SESSION['suspicious_activity'] = 0;
                        $_SESSION['suspicious_activity_in_progress'] = 0;
                        echo 'security_check_passed';
                    } else {
                        echo 'cannot_reset';
                    }
                } else {
                    echo 'transaction_failed';
                }
            } else {
                echo 'transaction_failed';
            }
        } else {
            echo 'connection_error';
        }
    } else {
        // update occurrence value
        $occurrence += 1;
        $crud->updateOccurrenceValue($occurrence, $id);
        echo 'security_check_failed';
    }
} else {
    echo 'empty_fields';
}
