<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once './CrudOperation.php';

if (!empty(filter_input(INPUT_POST, 'start_date')) && !empty(filter_input(INPUT_POST, 'end_date'))) {
    $startDate = filter_input(INPUT_POST, 'start_date');
    $endDate = filter_input(INPUT_POST, 'end_date');
    
    $date = new DateTime($startDate);
    $formattedStartDate = $date->format('Y-m-d');
    
    $date1 = new DateTime($endDate);
    $formattedendDate = $date1->format('Y-m-d');
    
    $crud = new CrudOperation();
    
    $result = $crud->fetchSpecificTransactions($formattedStartDate, $formattedendDate);
    echo $result;
    
}
