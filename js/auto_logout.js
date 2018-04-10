/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var idleTime = 0;
$(document).ready(function () {
    setInterval(timerIncrement, 60000);
    $(this).mousemove(function(e) {
        idleTime = 0;
    });
    $(this).keypress(function(e) {
        idleTime = 0;
    });
    $(this).scroll(function(e){
        idleTime = 0;
    });
    $(this).keyup(function(e){
        idleTime = 0;
    });
});

function timerIncrement() {
    idleTime += 1;
    if (idleTime >= 20) {
        window.location.href = '../controllers/logout.php';
    }
}
