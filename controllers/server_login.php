<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'DatabaseEntities.php';
require_once '../utilities/Utilities.php';

$host = '';
$username = '';
$password = '';

if (!empty(filter_input(INPUT_POST, 'host')) && !empty(filter_input(INPUT_POST, 'server_username'))) {
    $host = filter_input(INPUT_POST, 'host');
    $username = filter_input(INPUT_POST, 'server_username');
    $password = filter_input(INPUT_POST, 'server_password');

    try {
        $entities = new DatabaseEntities($host, $username, $password);
        $connection = $entities->connectToMysqlServer();
        if (is_object($connection) && $connection !== false) {
            $test = $entities->executeDummyQuery($connection);
            if ($test == true) {
                // save credentials to file  
                $util = new Utilities();
                $util->saveDatabaseCredentials($host, $username, $password);
                $util->saveComputername(gethostname());
                
                // check if database exist. run query to create if it does not exist
                $database = $entities->isDatabaseExists($host, $username, $password);
                if (!$database) {
                    // run query to create database
                    $entities->executeSQL();
                    header("Location: ../index.php");
                } else{
                    header('Location: ../index.php');
                }
            } else {
                
                // Username is not correct
                // redirect to index.php
                header("Location: ../index.php?wrong_username=1");
            }
        }  
                 
    } catch (Exception $ex) {
        header("Location: ../index.php?wrong_credentials=1");
    }
}





