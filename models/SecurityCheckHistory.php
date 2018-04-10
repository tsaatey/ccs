<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SecurityCheckHistory
 *
 * @author ARTLIB
 */
class SecurityCheckHistory {
    
    private $id;
    private $buyerId;
    private $suspiciousActivity;
    private $occurrence;
    
    public function __construct() {
        
    }
    
    public function getId() {
        return $this->id;
    }

    public function getBuyerId() {
        return $this->buyerId;
    }

    public function getSuspiciousActivity() {
        return $this->suspiciousActivity;
    }

    public function getOccurrence() {
        return $this->occurrence;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setBuyerId($buyerId) {
        $this->buyerId = $buyerId;
    }

    public function setSuspiciousActivity($suspiciousActivity) {
        $this->suspiciousActivity = $suspiciousActivity;
    }

    public function setOccurrence($occurrence) {
        $this->occurrence = $occurrence;
    }


}
