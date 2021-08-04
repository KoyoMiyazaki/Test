'use strict';

window.addEventListener("load", function() {
    // 実行したい処理
});

let result = document.querySelector('.result');
let registerButton = document.querySelector('#register-button');
let removeButtons = document.querySelectorAll('.remove-button');
let upButtons = document.querySelectorAll('.up-button');
let downButtons = document.querySelectorAll('.down-button');

// ユーザ登録
registerButton.addEventListener('click', function() {
    let form = registerButton.closest('tbody').querySelector('form');
    let xhr = new XMLHttpRequest();
    xhr.open('POST', 'register_user.php');
    xhr.onload = function() {
        result.innerHTML = xhr.response;
        window.location.reload();
    };
    xhr.send(new FormData(form));
});

// ユーザ削除
removeButtons.forEach((button) => {
    button.addEventListener('click', function() {
        // const content = onoffButton.nextElementSibling;
        let form = button.closest('td').previousElementSibling.previousElementSibling;
        let xhr = new XMLHttpRequest();
        xhr.open('POST', 'remove_user.php');
        xhr.onload = function() {
            result.innerHTML = xhr.response;
            window.location.reload();
        };
        xhr.send(new FormData(form));
    })
});

// 上ボタン(順序を上げる)
upButtons.forEach((button) => {
    button.addEventListener('click', function() {
        let form = button.closest('tr').querySelector('form');
        let xhr = new XMLHttpRequest();
        xhr.open('POST', 'up_primary_order.php');
        xhr.onload = function() {
            result.innerHTML = xhr.response;
            window.location.reload();
        };
        xhr.send(new FormData(form));
    })
});

// 下ボタン(順序を下げる)
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