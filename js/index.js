/*
* Immediately invoked function expression that self executes when the window is loaded
*/

(() => {
    /*
    * Function to get login data. It takes the id of the form control as parameter
    */
    let getFormData = (id) => {
        return document.getElementById(id).value;
    };

    /*
    * Function to return a user data object
    */
    let getUserDataObject = () => {
        return {
            username: getFormData('username'),
            password: getFormData('password')
        };
    };

    /*
    * Function to display error messages. It takes id of element and message to be displayed
    * as parameters
    */
    let displayErrorMessage = (id, message) => {
        var element = document.getElementById(id);
        element.innerHTML = message;
        element.style.color = 'red';
        element.style.fontFamily = 'Tahoma';
        element.style.fontWeight = 'bold';
        element.style.paddingLeft = '30px';
    };

    /*
    * This function will clear the login form when login is successful
    *
        let clearLoginForm = () => {
            document.getElementById('username').value = null;
            document.getElementById('password').value = null;
        };
     */

    /*
    * Login data will be validated and passed to login.php using ajax when login button is clicked
    */
   
    $('#username').keyup(function(event){
        if (event.keyCode === 13) {
            $('#server_login_button').click();
        }
    });
    $('#password').keyup(function(event){
        if (event.keyCode === 13) {
            $('#login_button').click();
        }
    });
    
    var btn_login = document.getElementById('login_button');
    if (btn_login) {
        btn_login.addEventListener('click', () => {
            var user = getUserDataObject();
            if (user.username !== "" && user.password !== "") {
                var form = document.getElementById('user_login_form');
                form.action = 'controllers/login.php';
                form.method = 'POST';
                form.submit();

            } else {
                // display some error message here
                displayErrorMessage('error_element', "No field should be empty!");
            }
        });  
    }
    
    /*
     * This method returns a data object of MySQL credentials
     */
    let getServerDataObject = () => {
        return {
            host: getFormData('host'),
            username: getFormData('server_username'),
            password: getFormData('server_password')
        };
    };
    
    $('#host').keyup(function(event){
        if (event.keyCode === 13) {
            $('#server_login_button').click();
        }
    });
    $('#server_username').keyup(function(event){
        if (event.keyCode === 13) {
            $('#server_login_button').click();
        }
    });
    $('#server_password').keyup(function(event){
        if (event.keyCode === 13) {
            $('#server_login_button').click();
        }
    });
    
    var server_button = document.getElementById('server_login_button');
    if(server_button) {
        server_button.addEventListener('click', (event) => {
            event.preventDefault();
            var data = getServerDataObject();
            if (data.host !== '' && data.username !== '') {
                var form = document.getElementById('mysql_form');
                form.action = 'controllers/server_login.php';
                form.method = 'POST';
                form.submit();
            } else {
                // display some error message here
                displayErrorMessage('error_element', "Host and Username fields must not be empty!");
            }
            
        });
    }
    
    var resetNote = document.getElementById('forgot_password_note');
    if (resetNote){
        resetNote.addEventListener('click', function() {
            document.getElementById('login_form').style.display = 'none';
            document.getElementById('reset_password_area').style.display = 'block';
        });
        
    }
    
    var cancelButton = document.getElementById('cancel_email_button');
    if (cancelButton) {
        cancelButton.addEventListener('click', function() {
            document.getElementById('login_form').style.display = 'block';
            document.getElementById('reset_password_area').style.display = 'none';
        });
    }
    
    var sendEmailButton = document.getElementById('send_email_button');
    if (sendEmailButton) {
        sendEmailButton.addEventListener('click', function() {
            if (document.getElementById('username_to_reset').value !== '') {
                var form = document.getElementById('send_email_password_form');
                form.action = 'controllers/change_password.php';
                form.method = 'POST';
                form.submit();
            } else {
                displayErrorMessage('username_error', 'Please provide your email!');
            }
        });
    }

})();