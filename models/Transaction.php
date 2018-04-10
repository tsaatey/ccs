<?php
/*
*
*/

class Transaction {

    private $id;
    private $creditCardHolderId;
    private $creditCardNumber;
    private $vendorSite;
    private $amount;
    private $transactionDate;
    private $dateTime;

    public function __construct() {

    }

    public function getId() {
        return $this->id;
    }

    public function getCreditCardHolderId() {
        return $this->creditCardHolderId;
    }

    public function getCreditCardNumber() {
        return $this->creditCardNumber;
    }

    public function getVendorSite() {
        return $this->vendorSite;
    }

    public function getAmount() {
        return $this->amount;
    }

    public function getTransactionDate() {
        return $this->transactionDate;
    }

    public function getDateTime() {
        return $this->dateTime;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setCreditCardHolderId($creditCardHolderId) {
        $this->creditCardHolderId = $creditCardHolderId;
    }

    public function setCreditCardNumber($creditCardNumber) {
        $this->creditCardNumber = $creditCardNumber;
    }

    public function setVendorSite($vendorSite) {
        $this->vendorSite = $vendorSite;
    }

    public function setAmount($amount) {
        $this->amount = $amount;
    }

    public function setTransactionDate($transactionDate) {
        $this->transactionDate = $transactionDate;
    }

    public function setDateTime($dateTime) {
        $this->dateTime = $dateTime;
    }


}