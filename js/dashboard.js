/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

(function () {

    var addUserLink = document.getElementById('admin_add_user');
    if (addUserLink) {
        addUserLink.addEventListener('click', function () {
            var iframe = document.getElementById('content-area');
            iframe.style.display = 'block';
            iframe.style.height = '900px';
            $('#dashboard').removeClass('selected');
            $('#user_delete').removeClass('selected');
            $('#admin_new_user').addClass('selected');
            $('#iframe-top').css('display', 'block');
            $('#user_display').css('display', 'none');
        });
    }
    
    var dashboardLink = document.getElementById('dashboard');
    if (dashboardLink) {
        dashboardLink.addEventListener('click', function () {
            var iframe = document.getElementById('content-area');
            iframe.style.display = 'none';
            iframe.style.height = '0px';
            $('#dashboard').addClass('selected');
            $('#admin_new_user').removeClass('selected');
            $('#user_delete').removeClass('selected');
            $('#iframe-top').css('display', 'none');
            $('#user_display').css('display', 'block');
        });
    }

    var deleteUserLink = document.getElementById('delete_user');
    if (deleteUserLink) {
        deleteUserLink.addEventListener('click', function () {
            var iframe = document.getElementById('content-area');
            iframe.style.display = 'block';
            iframe.style.height = '900px';
            $('#dashboard').removeClass('selected');
            $('#admin_new_user').removeClass('selected');
            $('#user_delete').addClass('selected');
            $('#iframe-top').css('display', 'block');
            $('#user_display').css('display', 'none');
        });
    }


})();


