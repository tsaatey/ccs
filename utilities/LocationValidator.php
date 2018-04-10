<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of LocationValidator
 *
 * @author ARTLIB
 */
require_once './ClientLocation.php';
require_once '../controllers/CrudOperation.php';

class LocationValidator {
    
    public function __construct() {
        
    }
    
    public function isLocationValid($ipAddress) {
        $crud = new CrudOperation();
    }

}
