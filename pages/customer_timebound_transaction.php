<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<!DOCTYPE html>
<html>
    <head>
        <!--Import Google Icon Font-->
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <!--Let browser know website is optimized for mobile-->
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

        <script src = "../js/jquery.min.js"></script>
        <link href="../material-icons-0.2.1/iconfont/material-icons.css" rel="stylesheet" type="text/css"/>
        <link href="../node_modules/materialize-css/dist/css/materialize.min.css" rel="stylesheet" type="text/css" media="screen,projection"/>
        <link href="../css/dashboard.css" rel="stylesheet" type="text/css"/>
        <script src="../node_modules/sweetalert2/dist/sweetalert2.all.js" type="text/javascript"></script>
        <link href="../node_modules/sweetalert2/dist/sweetalert2.min.css" rel="stylesheet" type="text/css"/>
        <script src="../js/alerts.js" type="text/javascript"></script>

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
            <h4 style="color: #008975;">Please select range for the transaction report</h4>
            <h6 id="specific_transaction_error"></h6>
            <form class="col s12" id="specific_timebound_transaction">
                <div class="row">
                    <div class="row">
                        <div class="input-field col s8">
                            <i class="material-icons prefix">date_range</i>
                            <input id="start_date" type="text" name="start_date" class="datepicker validate">
                            <label for="start_date" style="color: #000;">Start date</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s8">
                            <i class="material-icons prefix">date_range</i>
                            <input id="end_date" type="text" name="end_date" class="datepicker validate">
                            <label for="end_date" style="color: #000;">End date</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field l8" style="padding-left: 40px;">
                            <button class="btn index_buttons z-depth-3 btn-large waves-effect waves-light" type="button" name="timebound_transaction_button" id="timebound_transaction_button">Get Your Transactions
                                <i class="material-icons right">send</i>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        
        <script>
            $(document).ready(function () {
                $('.datepicker').datepicker();

            });
        </script>
        
        <script src = "../js/jquery.min.js"></script> 
        <script src="../js/customer_timebound.js" type="text/javascript"></script>
        <script src="../js/home.js"></script>
        <script src="../node_modules/materialize-css/dist/js/materialize.min.js" type="text/javascript"></script>
        <script src="../node_modules/materialize-css/js/datepicker.js" type="text/javascript"></script>
    </body>
</html>

