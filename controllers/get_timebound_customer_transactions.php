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
}
?>
<!DOCTYPE html>
<html>
    <head>
        <!--Import Google Icon Font-->
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <!--Let browser know website is optimized for mobile-->
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <script src = "../js/jquery.min.js"></script>
        <link href="../node_modules/materialize-css/dist/css/materialize.min.css" rel="stylesheet" type="text/css" media="screen,projection"/>
        <link href="../css/dashboard.css" rel="stylesheet" type="text/css"/>

        <style>
            .user_doc{
                width: 960px;
                margin: 0 auto;
            }

            .index_buttons{
                width: 64%;
                background-color: #008975;
            }
        </style>

    </head>
    <body>
        <div class="row user_doc">
            <div class="row">
                <?php
                $crud = new CrudOperation();
                $crud->timeBoundTransactions($_SESSION['username'], $formattedStartDate, $formattedendDate);
                ?>
            </div>
        </div>


        <script src = "../js/jquery.min.js"></script> 
        <script src="../node_modules/materialize-css/dist/js/materialize.min.js" type="text/javascript"></script>

    </body>
</html>