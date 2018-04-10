<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'CrudOperation.php';
if (!empty($_SESSION['suspicious_activity']) && $_SESSION['suspicious_activity'] == 1) {
    $_SESSION['suspicious_activity_in_progress'] = 1;
    header("Location: ../views/buy.php");
} else {
    session_destroy();
    header("Location: ../views/buy.php");
}



