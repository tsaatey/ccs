/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


function customConfirmDialog() {
    this.render = function (dialogMessage, operation, employeeId, username) {
        var winWidth = window.innerWidth;
        var winHeight = window.innerHeight;
        var dialogoverlay = document.getElementById('dialogoverlay');
        var dialogbox = document.getElementById('dialogbox');
        dialogoverlay.style.display = 'block';
        dialogoverlay.style.height = winHeight + 'px';
        dialogbox.style.left = (winWidth / 2) - (550 * 0.5) + 'px';
        dialogbox.style.top = '100px';
        dialogbox.style.display = 'block';

        document.getElementById('dialogboxhead').innerHTML = 'Confirmation Action Required!';
        document.getElementById('dialogboxbody').innerHTML = dialogMessage;
        document.getElementById('dialogboxfoot').innerHTML = '<button class = "btn btn-danger" onclick = "Confirm.yes(\'' + operation + '\',\'' + employeeId + '\',\''+username+'\')">Yes</button>&nbsp;&nbsp;<button class = "btn btn-default" onclick = "Confirm.no()">No</button>';
    };
};

customConfirmDialog.prototype.yes = (operation, employeeId, username) => {
    if (operation === 'delete_user') {
        // submit employeeId and username using ajax
        $.ajax({
                url: "../controllers/delete_employee.php",
                method: "POST",
                data: {employeeId: employeeId, username: username},
                dataType: "json",
                success: function (state) {
                    if (state.success === true) {
                        setTimeout(function() {
                            //location.reload();
                        }, 10);
                    }
                }
            });
    } 
    if (operation === 'reset_account') {
        // submit username using ajax
        $.ajax({
                url: "../controllers/reset_account.php",
                method: "POST",
                data: {username: username},
                dataType: "json",
                success: function (state) {
                    if (state.success === true) {
                        setTimeout(function() {
                            //location.reload();
                        }, 10);
                    }
                }
            });
    }
    document.getElementById('dialogoverlay').style.display = 'none';
    document.getElementById('dialogbox').style.display = 'none';
};

customConfirmDialog.prototype.no = () => {
    document.getElementById('dialogoverlay').style.display = 'none';
    document.getElementById('dialogbox').style.display = 'none';
};


var Confirm = new customConfirmDialog();

