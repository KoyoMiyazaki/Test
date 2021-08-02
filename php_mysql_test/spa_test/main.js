'use strict';

window.addEventListener("load", function() {
    // 実行したい処理
    console.log(new Date());
 });

var result = document.querySelector('.result');

var upButtons = document.querySelectorAll('.up-button');
// console.log(upButtons[0].closest('.card').querySelector('.card-text').textContent);

upButtons.forEach((button) => {
    button.addEventListener('click', function() {
        var form = button.closest('tr').querySelector('form');
        // var form = document.querySelector('form');
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'sample.php');
        xhr.onload = function() {
            result.innerHTML = xhr.response;
            window.location.reload();
        };
        xhr.send(new FormData(form));
    })
});