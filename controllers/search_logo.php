<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'CrudOperation.php';

if (!empty(filter_input(INPUT_POST, 'card_number'))) {
    $crud = new CrudOperation();
    $card = new CreditCard();
    $util = new Utilities();
    
    $number = filter_input(INPUT_POST, 'card_number');
    //$number = '4242424242424242';
    if ($util->isInteger($number)) {
        $image;
        $card->setNumber($number);
        $response = $crud->getCardIssuerLogo($card);
        if ($response != 'no_result') {
            foreach($response as $res) {
                $image = $res['image'];
            }
            header("Content-type: image/png");
            echo base64_encode($image);
        } else {
            echo 'No result';
        }
        
    } else {
        echo 'NaN';
    } 
      
} else {
    
}