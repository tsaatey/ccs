<?php
/*
*
*/

class CreditCardIssuer  {

    private $id;
    private $company;
    private $image;

    public function __construct(){

    }
    
    public function getId() {
        return $this->id;
    }

    public function getCompany() {
        return $this->company;
    }

    public function getImage() {
        return $this->image;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setCompany($company) {
        $this->company = $company;
    }

    public function setImage($image) {
        $this->image = $image;
    }




}