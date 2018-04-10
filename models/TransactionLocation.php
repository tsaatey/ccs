<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TransactionLocation
 *
 * @author ARTLIB
 */
class TransactionLocation {
    
    private $id;
    private $transactionId;
    private $country;
    private $region;
    private $city;
    private $longitude;
    private $latitude;
    
    public function __construct() {
        
    }
    
    public function getId() {
        return $this->id;
    }

    public function getTransactionId() {
        return $this->transactionId;
    }

    public function getCountry() {
        return $this->country;
    }

    public function getRegion() {
        return $this->region;
    }

    public function getCity() {
        return $this->city;
    }

    public function getLongitude() {
        return $this->longitude;
    }

    public function getLatitude() {
        return $this->latitude;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setTransactionId($transactionId) {
        $this->transactionId = $transactionId;
    }

    public function setCountry($country) {
        $this->country = $country;
    }

    public function setRegion($region) {
        $this->region = $region;
    }

    public function setCity($city) {
        $this->city = $city;
    }

    public function setLongitude($longitude) {
        $this->longitude = $longitude;
    }

    public function setLatitude($latitude) {
        $this->latitude = $latitude;
    }

}
