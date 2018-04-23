<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once '../utilities/ClientLocation.php';
require_once './CrudOperation.php';

if (
        !empty(filter_input(INPUT_POST, 'cardnumber')) &&
        !empty(filter_input(INPUT_POST, 'securitycode')) &&
        !empty(filter_input(INPUT_POST, 'expirydate')) &&
        !empty(filter_input(INPUT_POST, 'amount'))) {

    $card_number = filter_input(INPUT_POST, 'cardnumber');
    $securitycode = filter_input(INPUT_POST, 'securitycode');
    $expirydate = filter_input(INPUT_POST, 'expirydate');
    $amount = filter_input(INPUT_POST, 'amount');
    $ip = '154.160.6.59';
    $ip1 = '41.215.171.217';
    $ip2 = '154.160.22.225';
    
    $date = new DateTime($expirydate);
    $expirydate = $date->format('Y-m-d');
    
    $_SESSION['card_number'] = $card_number;
    $_SESSION['securitycode'] = $securitycode;
    $_SESSION['expirydate'] = $expirydate;
    $_SESSION['amount'] = $amount;

    if (!empty($_SESSION['card_holder_loggedin']) && $_SESSION['card_holder_loggedin'] == 1) {
        $crud = new CrudOperation();
        $util = new Utilities();
        $creditCard = new CreditCard();

        $creditCard->setNumber($card_number);
        $creditCard->setCvv($securitycode);
        $creditCard->setExpiryDate($expirydate);

        if ($util->isDateValid($expirydate)) {
            // date is in valid format
            if ($crud->isCardValid($creditCard)) {
                $currentDate = date('Y-m-d');
                $expirydate = new DateTime($expirydate);
                if ($currentDate < $expirydate) {
                    //credit card is valid
                    // lookup security check history

                    $id = $crud->getBuyerId($_SESSION['buyer_email']);
                    $checkParams = $crud->getSecurityCheckValues($id);
                    $suspicious_activity = $checkParams['suspicious_activity'];
                    $occurrence = $checkParams['occurrence'];

                    if ($suspicious_activity == 0) {
                        $previousLocation = $crud->getPreviousLocationDetails($card_number);
                        $locationCounter = 0;
                        if ($previousLocation != null) {
                            // client had previous transactions
                            $clientLocation = new ClientLocation($ip);
                            $cli = $clientLocation->getClientLocation();
                            if ($cli != null) {                                
                                foreach ($previousLocation as $pre) {
                                    if ($pre['country'] == $cli['country'] && $pre['region'] == $cli['region'] && $pre['city'] == $cli['city']) {
                                        // client's location falls within the pattern
                                        // increase location counter by 1
                                        $locationCounter += 1;
                                    }
                                }
                                if ($locationCounter > 0) {
                                    // client passes location check. goto next check
                                    $previousAmount = $crud->getLastTransactionAmount($card_number);
                                    $amount = doubleval($amount);
                                    if ($amount > $previousAmount) {
                                        // current amount is bigger than the last amount recorded.
                                        // calculate the percentage increase
                                        $difference = $amount - $previousAmount;
                                        $percentageIncrease = ($difference / $previousAmount) * 100;

                                        if ($percentageIncrease < 30) {
                                            // no suspicious acitivty detected, go ahead and record transaction

                                            $buyerId = $crud->getBuyerId($_SESSION['buyer_email']);
                                            $vendorSite = $util->getVendorUrl();
                                            $transactionId = $crud->getTransactionId();
                                            $loc = $clientLocation->getClientLocation();
                                            date_default_timezone_set('Europe/London');
                                            $dateTime = new DateTime();
                                            $date_time = $dateTime->format('Y-m-d H:i:s');


                                            $country = $cli['country'];
                                            $region = $cli['region'];
                                            $city = $cli['city'];
                                            $longitude = $cli['longitude'];
                                            $latitude = $cli['latitude'];

                                            $transaction = new Transaction();
                                            $transactionLocation = new TransactionLocation();

                                            // set transation details
                                            $transaction->setId($transactionId);
                                            $transaction->setCreditCardHolderId($buyerId);
                                            $transaction->setCreditCardNumber($card_number);
                                            $transaction->setVendorSite($vendorSite);
                                            $transaction->setAmount($amount);
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
                                                    $_SESSION['fullname'] = '';
                                                    $_SESSION['card_number'] = '';
                                                    $_SESSION['securitycode'] = '';
                                                    $_SESSION['expirydate'] = '';
                                                    $_SESSION['amount'] = '';
                                                    echo 'transaction_processed';
                                                } else {
                                                    echo 'transaction_failed';
                                                }
                                            } else {
                                                echo 'transaction_failed';
                                            }
                                        } else {
                                            // amount is suspicious, redirect to security page
                                            $sec = new SecurityCheckHistory();
                                            $sec->setSuspiciousActivity(1);
                                            $sec->setOccurrence(0);
                                            $sec->setBuyerId($id);

                                            $crud->recordSecurityCheckHistory($sec);
                                            $_SESSION['suspicious_activity'] = 1;
                                            echo 'suspicious_activity';
                                        }
                                    } else {
                                        // current amount is smaller than the last amount recorded
                                        // calculate the percentage decrease
                                        $difference = $previousAmount - $amount;
                                        $percentageDrecrease = ($difference / $previousAmount) * 100;

                                        if ($percentageDrecrease < 30) {
                                            // no suspicious acitivty detected, go ahead and record transaction

                                            $buyerId = $crud->getBuyerId($_SESSION['buyer_email']);
                                            $vendorSite = $util->getVendorUrl();
                                            $transactionId = $crud->getTransactionId();
                                            $loc = $clientLocation->getClientLocation();
                                            date_default_timezone_set('Europe/London');
                                            $dateTime = new DateTime();
                                            $date_time = $dateTime->format('Y-m-d H:i:s');


                                            $country = $cli['country'];
                                            $region = $cli['region'];
                                            $city = $cli['city'];
                                            $longitude = $cli['longitude'];
                                            $latitude = $cli['latitude'];

                                            $transaction = new Transaction();
                                            $transactionLocation = new TransactionLocation();

                                            // set transation details
                                            $transaction->setId($transactionId);
                                            $transaction->setCreditCardHolderId($buyerId);
                                            $transaction->setCreditCardNumber($card_number);
                                            $transaction->setVendorSite($vendorSite);
                                            $transaction->setAmount($amount);
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
                                                    $_SESSION['fullname'] = '';
                                                    $_SESSION['card_number'] = '';
                                                    $_SESSION['securitycode'] = '';
                                                    $_SESSION['expirydate'] = '';
                                                    $_SESSION['amount'] = '';
                                                    echo 'transaction_processed';
                                                } else {
                                                    echo 'transaction_failed';
                                                }
                                            } else {
                                                echo 'transaction_failed';
                                            }
                                        } else {
                                            // amount is suspicious, redirect to security page
                                            $sec = new SecurityCheckHistory();
                                            $sec->setSuspiciousActivity(1);
                                            $sec->setOccurrence(0);
                                            $sec->setBuyerId($id);

                                            $crud->recordSecurityCheckHistory($sec);
                                            $_SESSION['suspicious_activity'] = 1;
                                            echo 'suspicious_activity';
                                        }
                                    }
                                } else {
                                    $sec = new SecurityCheckHistory();
                                    $sec->setSuspiciousActivity(1);
                                    $sec->setOccurrence(0);
                                    $sec->setBuyerId($id);

                                    $crud->recordSecurityCheckHistory($sec);
                                    $_SESSION['suspicious_activity'] = 1;
                                    echo 'location_does_not_have_a_match';
                                }
                            } else {
                                // no connection available
                                echo 'network_error';
                            }
                        } else {
                            // no transaction for client yet. go ahead and save fresh data
                            $buyerId = $crud->getBuyerId($_SESSION['buyer_email']);
                            $vendorSite = $util->getVendorUrl();
                            $transactionId = $crud->getTransactionId();
                            $clientLocation = new ClientLocation($ip1);
                            $loc = $clientLocation->getClientLocation();
                            date_default_timezone_set('Europe/London');
                            $dateTime = new DateTime();
                            $date_time = $dateTime->format('Y-m-d H:i:s');

                            if ($loc != null) {
                                $country = $loc['country'];
                                $region = $loc['region'];
                                $city = $loc['city'];
                                $longitude = $loc['longitude'];
                                $latitude = $loc['latitude'];

                                $transaction = new Transaction();
                                $transactionLocation = new TransactionLocation();

                                // set transation details
                                $transaction->setId($transactionId);
                                $transaction->setCreditCardHolderId($buyerId);
                                $transaction->setCreditCardNumber($card_number);
                                $transaction->setVendorSite($vendorSite);
                                $transaction->setAmount($amount);
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
                                        $_SESSION['fullname'] = '';
                                        $_SESSION['card_number'] = '';
                                        $_SESSION['securitycode'] = '';
                                        $_SESSION['expirydate'] = '';
                                        $_SESSION['amount'] = '';
                                        echo 'transaction_processed';
                                    } else {
                                        echo 'transaction_failed';
                                    }
                                } else {
                                    echo 'transaction_failed';
                                }
                            } else {
                                echo 'network_error';
                            }
                        }
                    } else if ($suspicious_activity == 1 || $occurrence == 1 || $occurrence == 2) {
                        $_SESSION['suspicious_activity'] = 1;
                        echo 'suspicious_activity';
                    } else if ($occurrence == 3) {
                        echo 'account_suspended';
                    }
                } else {
                    echo 'credit_card_expired';
                }
            } else {
                echo 'invalid_card';
            }
        } else {
            echo 'invalid_date';
        }
    } else {
        echo 'client_not_loggedin';
    }
} else {
    echo 'empty_fields';
}    