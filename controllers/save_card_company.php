<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'CrudOperation.php';

if (!empty(filter_input(INPUT_POST, 'card_company'))) {
    $company = filter_input(INPUT_POST, 'card_company');
    $imageName = $_FILES['image']['name'];
    $image = file_get_contents($_FILES['image']['tmp_name']);
    //$finalImage = base64_encode($image);
    
    $crud = new CrudOperation();
    
    $issuer = new CreditCardIssuer();
    $issuer->setCompany($company);
    $issuer->setImage($image);
    
    if ($crud->saveCreditCardIssuerInfo($issuer)) {
        echo 'success';
    } else {
        echo 'database_error';
    }
}



