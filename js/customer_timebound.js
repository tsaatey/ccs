/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
(function () {

    var button = document.getElementById('timebound_transaction_button');
    if (button) {
        button.addEventListener('click', function () {
            if (document.getElementById('start_date').value !== '' && document.getElementById('end_date').value !== '') {
                start_date = document.getElementById('start_date').value;
                end_date = document.getElementById('end_date').value;
                var form = document.getElementById('specific_timebound_transaction');
                form.action = '../controllers/get_timebound_customer_transactions.php';
                form.method = 'POST';
                form.submit();
            } else {
                //displayErrorMessage('specific_transaction_error', 'Please provide start date and end date!');
                swal({
                   title: 'Validation Error',
                   text: 'Please provide start date and end date',
                   type: 'error'
                });
            }
        });
    }


})();

