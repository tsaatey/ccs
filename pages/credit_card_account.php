<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once '../controllers/CrudOperation.php';
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
            <h4 style="color: #008975;">Complete the registration by supplying the credit card details</h4>
            <h5 id="credit_card_error"></h5>
            <form class="col s12" name="add_user_form" id="add_user_form">
                <div class="row">
                    <div class="input-field col s8">
                        <i class="material-icons prefix">credit_card</i>
                        <input id="credit_card_number" type="number" name="credit_card_number" class="validate">
                        <label for="credit_card_number" style="color: #000;">Credit card number</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s8">
                        <i class="material-icons prefix">date_range</i>
                        <input id="issued_date" type="text" name="issued_date" class="datepicker validate">
                        <label for="issued_date" style="color: #000;">Date Issued</label>
                    </div>  
                </div>
                <div class="row">
                    <div class="input-field col s8">
                        <i class="material-icons prefix">date_range</i>
                        <input id="expiry_date" type="text" name="expiry_date" class="datepicker validate">
                        <label for="expiry_date" style="color: #000;">Expiry date</label>
                    </div>  
                </div>
                <div class="row">
                    <div class="input-field col s8">
                        <i class="material-icons prefix">credit_card</i>
                        <input id="cvv" type="number" name="cvv" class="validate">
                        <label for="cvv" style="color: #000;">CVV number</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s8" style="margin-left: 40px; width: 600px;">
                        <select class="browser-default" name="card_issuer" id="card_issuer">
                            <option value="" disabled selected>Card Issuer</option>
                            <?php
                            $crud = new CrudOperation();
                            $issuers = $crud->fetchCardIssuers();
                            foreach ($issuers as $issuer) {
                                ?>
                                <option value="<?php echo $issuer['id']; ?>"><?php echo $issuer['company']; ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>  
                </div>
                <div class="row">
                    <div class="input-field l8" style="padding-left: 40px;">
                        <button class="btn index_buttons z-depth-3 btn-large waves-effect waves-light" type="button" name="create_card_details_submit" id="create_card_details_submit">Submit
                            <i class="material-icons right">send</i>
                        </button>
                    </div>
                </div>
                <h4 style="color: red;">
                    <?php
                    if (isset($_SESSION['account_setup_required']) && $_SESSION['account_setup_required'] == 1) {
                        echo "Please supply credit card details before you can logout!";
                    }
                    ?>
                </h4>
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
