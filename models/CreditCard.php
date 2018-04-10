<?php
/*
*
*/

class CreditCard {

    private $id;
    private $issuerId;
    private $holderId;
    private $issueDate;
    private $expiryDate;
    private $number;
    private $cvv;
    
    public function __construct() {
        
    }
    
    public function getId() {
        return $this->id;
    }

    public function getIssuerId() {
        return $this->issuerId;
    }

    public function getHolderId() {
        return $this->holderId;
    }

    public function getIssueDate() {
        return $this->issueDate;
    }

    public function getExpiryDate() {
        return $this->expiryDate;
    }

    public function getNumber() {
        return $this->number;
    }

    public function getCvv() {
        return $this->cvv;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setIssuerId($issuerId) {
        $this->issuerId = $issuerId;
    }

    public function setHolderId($holderId) {
        $this->holderId = $holderId;
    }

    public function setIssueDate($issueDate) {
        $this->issueDate = $issueDate;
    }

    public function setExpiryDate($expiryDate) {
        $this->expiryDate = $expiryDate;
    }

    public function setNumber($number) {
        $this->number = $number;
    }

    public function setCvv($cvv) {
        $this->cvv = $cvv;
    }


    
}