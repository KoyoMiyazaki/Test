'use strict';

var result = document.querySelector('.result');

var upButtons = document.querySelectorAll('.up-button');
// console.log(upButtons[0].closest('.card').querySelector('.card-text').textContent);

upButtons.forEach((button) => {
    // console.log(button.closest('.card').querySelector('.card-text').textContent);
    button.addEventListener('click', function() {
        var form = button.closest('.buttons').querySelector('form');
        // var form = document.querySelector('form');
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'sample.php');
        xhr.onload = function() {
            result.innerHTML = xhr.response;
        };
        xhr.send(new FormData(form));
    })
});