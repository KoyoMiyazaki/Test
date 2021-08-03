'use strict';

window.addEventListener("load", function() {
    // 実行したい処理
});

let result = document.querySelector('.result');
let registerButton = document.querySelector('#register-button');
let upButtons = document.querySelectorAll('.up-button');
let downButtons = document.querySelectorAll('.down-button');

registerButton.addEventListener('click', function() {
    let form = registerButton.closest('tbody').querySelector('form');
    console.log(form);
    let xhr = new XMLHttpRequest();
    xhr.open('POST', 'register_user.php');
    xhr.onload = function() {
        result.innerHTML = xhr.response;
        window.location.reload();
    };
    xhr.send(new FormData(form));
});

upButtons.forEach((button) => {
    button.addEventListener('click', function() {
        let form = button.closest('tr').querySelector('form');
        // let form = document.querySelector('form');
        let xhr = new XMLHttpRequest();
        xhr.open('POST', 'up_primary_order.php');
        xhr.onload = function() {
            result.innerHTML = xhr.response;
            window.location.reload();
        };
        xhr.send(new FormData(form));
    })
});

downButtons.forEach((button) => {
    button.addEventListener('click', function() {
        let form = button.closest('tr').querySelector('form');
        let xhr = new XMLHttpRequest();
        xhr.open('POST', 'down_primary_order.php');
        xhr.onload = function() {
            result.innerHTML = xhr.response;
            window.location.reload();
        };
        xhr.send(new FormData(form));
    })
});