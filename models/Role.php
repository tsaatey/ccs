<?php
/*
*
*/

class Role {

    private $id;
    private $rolename;

    public function __construct() {

    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getRolename() {
        return $this->rolename;
    }

    public function setRolename($rolename) {
        $this->rolename = $rolename;
    }
}