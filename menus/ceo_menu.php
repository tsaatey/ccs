<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<ul id="nav">
    <li><a href="#" class="selected" id="dashboard">Dashboard</a></li>
    <li><a class='dropdown-trigger' href='#' data-target='dropdown3'>Transactions</a></li>
    <li><a class='dropdown-trigger' href='#' data-target='dropdown2'>Report</a></li>
    <li id="card_application"><a id="card_application_tab" href="../pages/register_card_holder.php" target="content-area">Register Card Holder</a></li>
    <li><a class='dropdown-trigger' href='#' data-target='dropdown1'>Basic Setup</a></li>
    <li><a class='dropdown-trigger' href='#' data-target='dropdown4'>Account Settings</a></li>
</ul>

<!-- Dropdown Structure -->
<ul id='dropdown1' class='dropdown-content' style="background-color: #008975; font-size: 10px;">
    <li id="ceo_add_card_company"><a id="ceo_add_card_company_tab" href="../pages/add_card_company.php" target="content-area">Add CreditCard Company</a></li>
    <li id="ceo_add_questions"><a id="ceo_add_questions_tab" href="../pages/add_secret_question.php" target="content-area">Add Secret Question</a></li>
</ul>
<!-- Dropdown Structure -->
<ul id='dropdown2' class='dropdown-content' style="background-color: #008975; font-size: 10px;">
    <li id="specific_report_link"><a id="specific_report_link_tab" href="../pages/specific_report.php" target="content-area">One Customer Transactions</a></li>
    <li id="multiple_report_link"><a id="multiple_report_link_tab" href="../pages/multiple_transactions_report.php" target="content-area">Multiple Customer Transactions</a></li>
    <li id="registerd_card_holders_link"><a id="registerd_card_holders_link_tab" href="../pages/card_holders.php" target="content-area">Registered Card Holders</a></li>
</ul>

<ul id='dropdown3' class='dropdown-content' style="background-color: #008975; font-size: 10px;">
    <li id = "all_transactions_link"><a id="all_transactions_link_tab" href="../pages/all_transactions.php" target="content-area">All Transactions</a></li>
    <li id="specific_transaction_link"><a id="specific_transaction_link_tab" href="../pages/specific_transaction.php" target="content-area">Time Bound Transaction</a></li>
</ul>

<ul id='dropdown4' class='dropdown-content' style="background-color: #008975; font-size: 10px;">
    <li id = "retrieve_card_holder_account_link"><a id="retrieve_card_holder_account_link_tab" href="../pages/unlock_card_holder_account.php" target="content-area">Unlock Card Holder Account</a></li>
    <li id="my_account_link"><a id="my_account_link_tab" href="../pages/change_password.php" target="content-area">Change My Password</a></li>
</ul>

