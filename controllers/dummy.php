<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$dateOfBirth = filter_input(INPUT_POST, 'dob');
$date = new DateTime($dateOfBirth);
$formattedDate = $date->format('Y-m-d');

echo $formattedDate;

?>
<!DOCTYPE html>
<html>
    <head>
        <!--Import Google Icon Font-->
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <!--Let browser know website is optimized for mobile-->
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

        <script src = "../js/jquery.min.js"></script>
        <script src="../node_modules/sweetalert2/dist/sweetalert2.all.js" type="text/javascript"></script>
        <link href="../node_modules/sweetalert2/dist/sweetalert2.min.css" rel="stylesheet" type="text/css"/>
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
            <form class="col s12" name="add_user_form" id="add_user_form" action="dummy.php" method="post">
                
                <div class="row">
                    <div class="input-field col s8">
                        <i class="material-icons prefix">date_range</i>
                        <input id="dob" type="text" name="dob" class="datepicker validate">
                        <label for="dob" style="color: #000;">Date of Birth</label>
                    </div>  
                </div>
                <div class="row">
                    <div class="input-field l8" style="padding-left: 40px;">
                        <button class="btn index_buttons z-depth-3 btn-large waves-effect waves-light" type="submit" name="test_button" id="test_button">Create User
                            <i class="material-icons right">send</i>
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <script>
            $(document).ready(function () {
                $('select').formSelect();
            });
            $(document).ready(function () {
                $('.datepicker').datepicker();

            });
                
        </script>


        <script src = "../js/jquery.min.js"></script> 
        <script src="../js/home.js"></script>
        <script src="../node_modules/materialize-css/dist/js/materialize.min.js" type="text/javascript"></script>
        <script src="../node_modules/materialize-css/js/datepicker.js" type="text/javascript"></script>
    </body>
</html>


