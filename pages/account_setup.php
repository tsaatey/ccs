<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<div class="row user_doc">
    <h6 style="color: #008975; font-weight: bold">Please Finish By Setting Up Your User Account</h6>
    <form class="col s12" id="account_form">
        <h5 id="form_error">
            <?php
            if (isset($_GET['account_error'])) {
                echo 'Account could not be created. Something went wrong!';
            } else if (isset($_GET['empty_password'])) {
                echo 'Password fields cannot be empty!';
            }
            ?>
        </h5>
        <h5 id="create_account_error"></h5>
        <div class="row">
            <div class="input-field col s8">
                <i class="material-icons prefix">person_circled</i>
                <input id="user_mail" type="text" value ="<?php echo $_SESSION['user_mail']; ?>" name="user_mail" class="validate" readonly="true">
                <label for="user_mail" style="color: #000;">Username</label>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s8">
                <i class="material-icons prefix">person</i>
                <input id="user_password" type="password" name="user_password" class="validate">
                <label for="user_password" style="color: #000;">Password</label>
            </div>  
        </div>
        <div class="row">
            <div class="input-field col s8">
                <i class="material-icons prefix">person</i>
                <input id="user_password_confirmed" type="password" name="user_password_confirmed" class="validate">
                <label for="user_password_confirmed" style="color: #000;">Confirm password</label>
            </div>  
        </div>
        <div class="row">
            <div class="input-field l8" style="padding-left: 40px;">
                <button class="btn index_buttons z-depth-3 btn-large waves-effect waves-light" type="button" name="create_account_button" id="create_account_button">Create Account
                    <i class="material-icons right">send</i>
                </button>
            </div>
        </div>
    </form>
</div>

<script src="../js/home.js" type="text/javascript"></script>
