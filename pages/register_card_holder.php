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

            body {
                height: auto;
                overflow: auto;
            }
        </style>

    </head>
    <body>
        <div class="row user_doc">
            <h4 style="color: #008975;">Register a new Card User Here</h4>
            <h4 id="card_holder_form_error"></h4>
            <h4>
                <?php
                if (isset($_SESSION['wrong_card_holder_email']) && $_SESSION['wrong_card_holder_email'] == 1) {
                    echo 'The email address you provided is invalid!';
                } else if (isset($_SESSION['card_holder_fields_empty']) && $_SESSION['card_holder_fields_empty'] == 1) {
                    echo 'An error occured! All fields are required';
                }
                ?>
            </h4>
            <form class="col s12" name="add_user_form" id="add_user_form">
                <div class="row">
                    <div class="input-field col s8">
                        <i class="material-icons prefix">person</i>
                        <input id="firstname" type="text" name="firstname" class="validate">
                        <label for="firstname" style="color: #000;">First name</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s8">
                        <i class="material-icons prefix">person</i>
                        <input id="lastname" type="text" name="lastname" class="validate">
                        <label for="lastname" style="color: #000;">Last name</label>
                    </div>  
                </div>
                <div class="row">
                    <div class="input-field col s8" style="margin-left: 40px; width: 600px;">
                        <select class="browser-default" name="gender" id="gender">
                            <option value="" disabled selected>Gender</option>
                            <option value="M">Male</option>
                            <option value="F">Female</option>
                        </select>
                    </div>  
                </div>
                <div class="row">
                    <div class="input-field col s8">
                        <i class="material-icons prefix">date_range</i>
                        <input id="dob" type="text" name="dob" class="datepicker validate">
                        <label for="dob" style="color: #000;">Date of Birth</label>
                    </div>  
                </div>
                <div class="row">
                    <div class="input-field col s8">
                        <i class="material-icons prefix">phone</i>
                        <input id="phone" type="text" name="phone" class="validate">
                        <label for="phone" style="color: #000;">Phone</label>
                    </div>  
                </div>
                <div class="row">
                    <div class="input-field col s8">
                        <i class="material-icons prefix">email</i>
                        <input id="email" type="email" name="email" class="validate">
                        <label for="email" style="color: #000;">Email</label>
                    </div>  
                </div>
                <div class="row">
                    <div class="input-field col s8" style="margin-left: 40px; width: 600px;">
                        <select class="browser-default" name="country" id="country">
                        </select>
                    </div>  
                </div>
                <div class="row">
                    <div class="input-field col s8">
                        <i class="material-icons prefix">add_location</i>
                        <input id="city" type="text" class="validate" name="city" list="city_list">
                        <datalist id="city_list"></datalist>
                        <label for="city" style="color: #000;">City</label>
                    </div>  
                </div>
                <div class="row">
                    <div class="input-field col s8">
                        <i class="material-icons prefix">add_location</i>
                        <textarea id="address" name="address" class="materialize-textarea"></textarea>
                        <label for="address" style="color: #000;">Card Holder's Address</label>
                    </div>  
                </div>
                <div class="row">
                    <div class="input-field col s8">
                        <i class="material-icons prefix">person_circled</i>
                        <input id="name_of_kin" type="text" name="name_of_kin" class="validate">
                        <label for="name_of_kin" style="color: #000;">Next of Kin</label>
                    </div>  
                </div>
                <div class="row">
                    <div class="input-field col s8">
                        <i class="material-icons prefix">add_location</i>
                        <textarea id="address_of_kin" name="address_of_kin" class="materialize-textarea"></textarea>
                        <label for="address_of_kin" style="color: #000;">Address of Kin</label>
                    </div>  
                </div>
                <div class="row">
                    <div class="input-field col s8">
                        <i class="material-icons prefix">phone</i>
                        <input id="kin_contact" type="text" name="kin_contact" class="validate">
                        <label for="kin_contact" style="color: #000;">Contact number of Kin</label>
                    </div>  
                </div>
                <div class="row">
                    <div class="input-field col s8" style="margin-left: 40px; width: 600px;">
                        <?php
                        $crud = new CrudOperation();
                        $results = $crud->fetchSecretQuestions();
                        ?>
                        <select class="browser-default" name="secret_question" id="secret_question">
                            <option value="" disabled selected>Secret Question</option>
                            <?php
                            foreach ($results as $result) {
                                ?>
                                <option value="<?php echo $result['id'] ?>"><?php echo $result['question'] ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>  
                </div>
                <div class="row">
                    <div class="input-field col s8">
                        <i class="material-icons prefix">edit_mode</i>
                        <input id="secret_answer" type="text" name="secret_answer" class="validate">
                        <label for="secret_answer" style="color: #000;">Answer to Secret Question</label>
                    </div>  
                </div>
                <div class="row">
                    <div class="input-field l8" style="padding-left: 40px;">
                        <button class="btn index_buttons z-depth-3 btn-large waves-effect waves-light" type="button" name="create_card_holder_account_button" id="create_card_holder_account_button">Register
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
        <script src="../js/countries.js" type="text/javascript"></script>
        <script src="../js/cities.js" type="text/javascript"></script>
        <script src="../node_modules/materialize-css/dist/js/materialize.min.js" type="text/javascript"></script>
    </body>
</html>



