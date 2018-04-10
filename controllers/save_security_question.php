<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'CrudOperation.php';

if (!empty(filter_input(INPUT_POST, 'question'))) {
    $question = filter_input(INPUT_POST, 'question');
    
    $crud = new CrudOperation();
    $secretQuestion = new SecretQuestion();
    $secretQuestion->setQuestion($question);
    
    if ($crud->saveSecurityQuestion($secretQuestion)) {
        echo 'success';
    } else {
        echo 'fail';
    }
} else {
    echo 'field_empty';
}

