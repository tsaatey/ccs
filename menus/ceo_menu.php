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
    <li id="ceo_card_application"><a href="../pages/register_card_holder.php" target="content-area" id="ceo_card_application_tab">Register Card Holder</a></li>
    <li><a class='dropdown-trigger' href='#' data-target='dropdown1'>Basic Setup</a></li>
    <li id="ceo_account_settings"><a href="#" id="ceo_account_settings_tab">Account Settings</a></li>
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

