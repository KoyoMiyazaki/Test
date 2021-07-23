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

    // 更新ボタンのイベント追加
    const updateButton = document.getElementById('update-button');
    if (updateButton !== null) { // 登録ボタンが表示されている(nullでない)場合
        updateButton.onclick = () => {
            if (confirm("更新しますか？")) {
                // 登録する(処理は無し)
            } else {
                // 登録しない
                return false;
            }
        }
    }

    // 削除ボタンのイベント追加
    const nowPage = document.getElementById('now-page').textContent;
    const removeButton = document.getElementById('remove-button');
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
