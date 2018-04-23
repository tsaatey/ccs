<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once '../controllers/GenerateReport.php';

if (!empty(filter_input(INPUT_POST, 'start_date')) && !empty(filter_input(INPUT_POST, 'end_date'))) {
    $startDate = filter_input(INPUT_POST, 'start_date');
    $endDate = filter_input(INPUT_POST, 'end_date');
    
    $date1 = new DateTime($startDate);
    $formattedStartDate = $date1->format('Y-m-d');
    
    $date2 = new DateTime($endDate);
    $formattedendDate = $date2->format('Y-m-d');
    
    $report = new GenerateReport('L');
    $report->getSpecificTransactionReport($formattedStartDate, $formattedendDate);
    
}
