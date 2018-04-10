<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Secret
 *
 * @author ESTHER
 */
class Secret {
    
    private $id;
    private $question_id;
    private $answer;
    
    function __construct() {
        
    }
    
    function getId() {
        return $this->id;
    }

    function getQuestion_id() {
        return $this->question_id;
    }

    function getAnswer() {
        return $this->answer;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setQuestion_id($question_id) {
        $this->question_id = $question_id;
    }

    function setAnswer($answer) {
        $this->answer = $answer;
    }

}
