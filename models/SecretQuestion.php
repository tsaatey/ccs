<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SecretQuestion
 *
 * @author ESTHER
 */
class SecretQuestion {
    
    private $id;
    private $question;
    
    function __construct() {
        
    }
    
    function getId() {
        return $this->id;
    }

    function getQuestion() {
        return $this->question;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setQuestion($question) {
        $this->question = $question;
    }

}
