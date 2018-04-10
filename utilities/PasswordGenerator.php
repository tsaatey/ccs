<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PasswordGenerator
 *
 * @author ARTLIB
 */

require_once '../vendor/autoload.php';

class PasswordGenerator {
    
    public function generatePassword() {
        $factory = new RandomLib\Factory;
        $generator = $factory->getGenerator(new SecurityLib\Strength(SecurityLib\Strength::MEDIUM));

        $passwordLength = 8; // Or more
        $randomPassword = $generator->generateString($passwordLength);

        return $randomPassword;
    }
}
