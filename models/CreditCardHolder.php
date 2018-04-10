<?php
/*
*
*/

class CreditCardHolder {

    private $id;
    private $firstname;
    private $lastname;
    private $gender;
    private $dateOfBirth;
    private $country;
    private $city;
    private $address;
    private $phone;
    private $email;
    private $nextOfKin;
    private $addressOfKin;
    private $phoneOfKin;
    private $secretId;
    private $roleId;


    public function __construct() {

    }

    public function getId() {
        return $this->id;
    }

    public function getFirstname() {
        return $this->firstname;
    }

    public function getLastname() {
        return $this->lastname;
    }

    public function getGender() {
        return $this->gender;
    }

    public function getDateOfBirth() {
        return $this->dateOfBirth;
    }

    public function getCountry() {
        return $this->country;
    }

    public function getCity() {
        return $this->city;
    }

    public function getAddress() {
        return $this->address;
    }

    public function getPhone() {
        return $this->phone;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getNextOfKin() {
        return $this->nextOfKin;
    }

    public function getAddressOfKin() {
        return $this->addressOfKin;
    }

    public function getPhoneOfKin() {
        return $this->phoneOfKin;
    }

    public function getSecretId() {
        return $this->secretId;
    }

    public function getRoleId() {
        return $this->roleId;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setFirstname($firstname) {
        $this->firstname = $firstname;
    }

    public function setLastname($lastname) {
        $this->lastname = $lastname;
    }

    public function setGender($gender) {
        $this->gender = $gender;
    }

    public function setDateOfBirth($dateOfBirth) {
        $this->dateOfBirth = $dateOfBirth;
    }

    public function setCountry($country) {
        $this->country = $country;
    }

    public function setCity($city) {
        $this->city = $city;
    }

    public function setAddress($address) {
        $this->address = $address;
    }

    public function setPhone($phone) {
        $this->phone = $phone;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setNextOfKin($nextOfKin) {
        $this->nextOfKin = $nextOfKin;
    }

    public function setAddressOfKin($addressOfKin) {
        $this->addressOfKin = $addressOfKin;
    }

    public function setPhoneOfKin($phoneOfKin) {
        $this->phoneOfKin = $phoneOfKin;
    }

    public function setSecretId($secretId) {
        $this->secretId = $secretId;
    }

    public function setRoleId($roleId) {
        $this->roleId = $roleId;
    }


}