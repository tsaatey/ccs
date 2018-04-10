<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once '../utilities/ClientLocation.php';

$ip = '41.215.171.217';
$ip1 = '154.160.6.59';

$location = new ClientLocation($ip);

print_r($location->getClientLocation());