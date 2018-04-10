<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ClientLocation
 *
 * @author ARTLIB
 */
require_once 'Utilities.php';
require_once 'IP2LocationAPI.php';

class ClientLocation {

    private $apiKey1;
    private $apiKey2;
    private $apiKey3;
    private $package;
    private $useSSL;
    private $ip;

    public function __construct($ip = '') {
        $this->apiKey1 = '7C36A935C3';
        $this->apiKey2 = 'demo';
        $this->apiKey3 = '2D9B7C76BA';
        $this->package = 'WS5';
        $this->useSSL = false;
        $this->ip = $ip;
    }

    public function getClientLocation() {
        $location = new IP2LocationAPI($this->apiKey3, $this->package, $this->useSSL);
        $util = new Utilities();

        if ($this->ip == '') {
            $this->ip = $util->getClientIpAddress();
        }

        if ($location->query($this->ip) == true) {
            return array(
                'country' => $location->countryName,
                'region' => $location->regionName,
                'city' => $location->cityName,
                'latitude' => $location->latitude,
                'longitude' => $location->longitude
            );
        } else {
            return null;
        }
    }

}
