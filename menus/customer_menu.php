<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<ul id="nav">
    <li><a href="#" class="selected" id="dashboard">Dashboard</a></li>
    <li><a class='dropdown-trigger' href='#' data-target='dropdown3'>Shopping History</a></li>
    <li id="customer_report_link"><a id = "customer_report_link_tab" href='../pages/specific_report.php' target="content-area">Report</a></li>
    <li id="my_account_link"><a id="my_account_link_tab" href="../pages/change_password.php" target="content-area">Account Settings</a></li>
</ul>

<!-- Dropdown Structure -->
<ul id='dropdown2' class='dropdown-content' style="background-color: #008975; font-size: 10px;">
    <li id="specific_report_link"><a id="specific_report_link_tab" href="../pages/specific_report.php" target="content-area">One Customer Transactions</a></li>
</ul>

<ul id='dropdown3' class='dropdown-content' style="background-color: #008975; font-size: 10px;">
    <li id = "all_transactions_link"><a id="all_transactions_link_tab" href="../pages/all_customer_transactions.php" target="content-area">All Shopping History</a></li>
    <li id="specific_transaction_link"><a id="specific_transaction_link_tab" href="../pages/customer_timebound_transaction.php" target="content-area">Time Bound Shopping History</a></li>
</ul>

