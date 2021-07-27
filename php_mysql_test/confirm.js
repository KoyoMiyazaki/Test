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

    // 削除ボタンのイベント追加
    const nowPage = document.getElementById('now-page').textContent;
    const removeButton = document.getElementById('remove-page-button');
    // console.log(nowPage);
    removeButton.onclick = () => {
        if (confirm(`${nowPage}ページを削除しますか？`)) {
            // 削除する(処理は無し)
        } else {
            // 削除しない
            return false;
        }
    }
});
