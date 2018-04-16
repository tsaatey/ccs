<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<ul id="nav">
    <li id="ceo_dashboard"><a href="#" class="selected" id="dashboard">Dashboard</a></li>
    <li id="ceo_transaction"><a class='dropdown-trigger' href='#' data-target='dropdown3' id="ceo_transaction_tab">Transactions</a></li>
    <li id="ceo_report"><a class='dropdown-trigger' href='#' data-target='dropdown2' id="ceo_report_tab">Report</a></li>
    <li id="ceo_card_application"><a href="#" id="ceo_card_application_tab">Register Card Holder</a></li>
    <li><a class='dropdown-trigger' href='#' data-target='dropdown1'>Basic Setup</a></li>
    <li id="ceo_account_settings"><a href="#" id="ceo_account_settings_tab">Account Settings</a></li>
</ul>

<!-- Dropdown Structure -->
<ul id='dropdown1' class='dropdown-content' style="background-color: #008975; font-size: 10px;">
    <li><a href="#!">Add CreditCard Company</a></li>
    <li><a href="#!">Add Security Question</a></li>
</ul>
<!-- Dropdown Structure -->
<ul id='dropdown2' class='dropdown-content' style="background-color: #008975; font-size: 10px;">
    <li><a href="#!">Specific</a></li>
    <li><a href="#!">General</a></li>
</ul>

<ul id='dropdown3' class='dropdown-content' style="background-color: #008975; font-size: 10px;">
    <li><a href="#!">All Transactions</a></li>
    <li><a href="#!">Time Bound Transaction</a></li>
</ul>