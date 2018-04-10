
function displayConfirmAlert(alertHeader, operation, employeeId, username, text, buttonText) {
    swal({
        title: '' + alertHeader,
        text: ""+text,
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, '+buttonText+'!',
        cancelButtonText: 'No, cancel!',
        confirmButtonClass: 'btn btn-success',
        cancelButtonClass: 'btn btn-danger',
        buttonsStyling: true,
        reverseButtons: false,
        focusCancel: true,
        showCloseButton: true,
        showLoaderOnConfirm: true,
        preConfirm: function () {
            return new Promise(function (resolve) {
                setTimeout(function () {
                    resolve();
                }, 2000);
            });
        },
        allowOutsideClick: false
    }).then((result) => {
        if (result.value) {
            if (operation === 'delete_user') {
                $.ajax({
                    url: "../controllers/delete_employee.php",
                    method: "POST",
                    data: {employeeId: employeeId, username: username},
                    dataType: "json",
                    success: function (state) {
                        if (state.success === true) {
                            swal(
                                    'Deleted!',
                                    'User has been deleted!',
                                    'success'
                                    );
                            setTimeout(function () {
                                location.reload();
                            }, 3000);
                        }
                    },
                    failure: function () {
                        swal(
                                "Internal Error",
                                "Oops, deteletion failed!.", // had a missing comma
                                "error"
                                );
                    }
                });
            }else if (operation === 'reset_account') {
                $.ajax({
                    url: "../controllers/reset_account.php",
                    method: "POST",
                    data: {username: username},
                    dataType: "json",
                    success: function (state) {
                        if (state.success === true) {
                            swal(
                                    'Changed!',
                                    'Password has been reset to default!',
                                    'success'
                                    );
                            setTimeout(function () {
                                location.reload();
                            }, 3000);
                        }
                    },
                    failure: function () {
                        swal(
                                "Internal Error",
                                "Oops, account reset failed!.", // had a missing comma
                                "error"
                                );
                    }
                });
            }
        } else if (result.dismiss === swal.DismissReason.cancel && operation === 'delete_user') {
            swal(
                    "Cancelled",
                    "Deletion cancelled",
                    "error"
                    );
        } else if (result.dismiss === swal.DismissReason.cancel && operation === 'reset_account') {
            swal(
                    "Cancelled",
                    "Account reset cancelled",
                    "error"
                    );
        } 

    });
}


