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
        <script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
        <script src = "../js/jquery.min.js"></script>
        <!--Import Google Icon Font-->
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <!-- Compiled and minified CSS -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/css/materialize.min.css">

        <!-- Compiled and minified JavaScript -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/js/materialize.min.js"></script>

        <link href="../material-icons-0.2.1/iconfont/material-icons.css" rel="stylesheet" type="text/css"/>
        <link href="../node_modules/materialize-css/dist/css/materialize.min.css" rel="stylesheet" type="text/css" media="screen,projection"/>

        <style>
            tr, td{
                border: none;
            }

            .pergah-buttons{
                background-color: #688EB3;
            }

            .pergah-buttons:hover{
                background-color: #688EB3;
            }
            .pergah-buttons:selected{
                background-color: #688EB3;
            }
            .pergah-buttons:clicked{
                background-color: #688EB3;
            }

            .submit_button {
                width: 100%;
            }
        </style>
        <script>

        </script>
    </head>
    <body>
        <div class="row">
            <div class="col l3">
            </div>
            <div class="col l6">
                <div class="row">
                    <div class="col l12 m5">
                        <div class="card-panel">
                            <?php
                            $counter = 0;
                            while ($counter < 3) {
                                ?>
                                <table style="border-bottom: 1px solid #688EB3; border-radius: 5px;">
                                    <tr>
                                        <td style="width: 380px; height: 200px; border-right: 0px solid #000; background-color: #FAFAFA; padding-left: 5px;">
                                            <img src="../images/2018-Toyota-Corolla.png" alt="" width="360" height="170"/>
                                        </td>
                                        <td style="background-color: #F5F5F5;">
                                            <div>
                                                <table>
                                                    <tr>
                                                        <td colspan="2">
                                                            <p style="font-weight: bold; font-size: 25px; font-family: Tahoma; color: #688EB3;">Toyota Corolla</p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            Available Location
                                                        </td>
                                                        <td>
                                                            This car can be accessed at what location?
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            Price Per Day
                                                        </td>
                                                        <td>
                                                            $150.00
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            Fuel
                                                        </td>
                                                        <td>
                                                            Terms and conditions for fuel
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            Driver
                                                        </td>
                                                        <td>
                                                            Terms and conditions for driver
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                        </td>
                                                        <td>
                                                            <a class="waves-effect waves-light btn btn-large z-depth-3 modal-trigger pergah-buttons" href="#modal1">Rent this Car</a>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                                <?php
                                $counter += 1;
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col l3">
            </div>
        </div>

        <!-- Modal Structure -->
        <div id="modal1" class="modal modal-fixed-footer" style="width: 500px; height: 800px;">
            <div class="modal-content">
                <h5 style="color: #688EB3; font-weight: bold; text-align: center">Please Provide Us with Your Details</h5>
                <div class="row">
                    <form class="col s12" id="user_login_form">
                        <div class="row">
                            <div class="input-field col s12">
                                <i class="material-icons prefix">person</i>
                                <input id="fullname" type="text" name="fullname" class="validate">
                                <label for="fullname" style="color: #000;">Full Name</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12">
                                <i class="material-icons prefix">phone</i>
                                <input id="phone" type="text" name="phone" class="validate">
                                <label for="phone" style="color: #000;">Phone Number</label>
                            </div>  
                        </div>
                        <div class="row">
                            <div class="input-field col s12">
                                <i class="material-icons prefix">email</i>
                                <input id="email" type="email" name="email" class="validate">
                                <label for="username" style="color: #000;">Email Address</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12">
                                <i class="material-icons prefix">date_range</i>
                                <input id="pick_up_date" type="date" name="pick_up_date" class="validate">
                                <label for="pick_up_date" style="color: #000;">Pick-up Date</label>
                            </div>  
                        </div>
                        <div class="row">
                            <div class="input-field col s12">
                                <i class="material-icons prefix">add_location</i>
                                <input id="location" type="text" name="location" class="validate">
                                <label for="location" style="color: #000;">Current Address</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col m0"></div>
                            <div class="col l12 l12 modal_button">
                                <div class="input-field l12" style="padding-left: 40px;">
                                    <button class="btn btn-large submit_button waves-effect waves-light pergah-buttons z-depth-3" type="submit" name="login_button" id="login_button">complete
                                        <i class="material-icons right">send</i>
                                    </button>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <p style="text-align: center; font-style: italic; font-size: 14px;">The details you provide will help us at <a href="http://www.pergah.com" target="_blank">pergah.com</a> to identify you</p>
            </div>
        </div>
        <script>
            $(document).ready(function () {
                $('.modal').modal();
            });
            
            $(document).ready(function () {
                $('.datepicker').datepicker();
            });

        </script>

        <script src = "../js/jquery.min.js"></script>
        <script src="../node_modules/materialize-css/dist/js/materialize.min.js" type="text/javascript"></script>
    </body>
</html>