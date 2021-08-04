document.addEventListener("DOMContentLoaded", function() {
    
    // 登録ボタンのイベント追加
    const registerButton = document.getElementById('register-button');
    if (registerButton !== null) { // 登録ボタンが表示されている(nullでない)場合
        registerButton.onclick = () => {
            if (confirm("登録しますか？")) {
                // 登録する(処理は無し)
            } else {
                // 登録しない
                return false;
            }
        }
    }

    // ページ追加ボタンのイベント追加
    const addPageButton = document.getElementById('add-page-button');
    addPageButton.onclick = () => {
        if (confirm(`新しいページを追加しますか？`)) {
            // 削除する(処理は無し)
        } else {
            // 削除しない
            return false;
        }
    }

    // ページ削除ボタンのイベント追加
    const nowPage = document.getElementById('now-page').textContent;
    const removePageButton = document.getElementById('remove-page-button');
    removePageButton.onclick = () => {
        if (confirm(`${nowPage}ページを削除しますか？`)) {
            // 削除する(処理は無し)
        } else {
            // 削除しない
            return false;
        }
    }

    
    // onoffButton.onclick = () => {
    //     var target = document.getElementsByClassName('how-to-use')[0];
    //     target.classList.toggle('off');
    // }

    const onoffButton = document.getElementById('on-off-button');
    onoffButton.onclick = () => {
        const content = onoffButton.nextElementSibling;
        onoffButton.classList.toggle("is-active");
        content.classList.toggle("is-open");
    }
});
