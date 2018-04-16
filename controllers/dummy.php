<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$firstname = filter_input(INPUT_POST, 'firstname');
$lastname = filter_input(INPUT_POST, 'lastname');
$gender = filter_input(INPUT_POST, 'gender');
$dateOfBirth = filter_input(INPUT_POST, 'dob');
$phone = filter_input(INPUT_POST, 'phone');
$email = filter_input(INPUT_POST, 'email');
$address = filter_input(INPUT_POST, 'address');
$roleId = filter_input(INPUT_POST, 'roleId');

echo 'Firstname: '.$firstname.'<br/>';
echo 'Lastname: '.$lastname.'<br/>';
echo 'Gender: '.$gender.'<br/>';
echo 'DOB: '.$dateOfBirth.'<br/>';
echo 'Phone: '.$phone.'<br/>';
echo 'Email: '.$email.'<br/>';
echo 'Address: '.$address.'<br/>';