<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>アプリ | メイン画面</title>
    <link rel="stylesheet" href="style.css">
    <script src="./confirm.js"></script>
</head>
<body>

<?php
    // ライブラリ読み込み
    require_once('./lib/common_lib.php');
    require_once('./lib/database_lib.php');
    require_once('./lib/table_lib.php');

    // 定数定義
    define('MAX', '7'); // Todo: userテーブルから取得する

    // 変数設定
    global $user_order_list;// 追加
    $user_order_list = database_lib\get_user_order_list();// 追加

    $table_data = database_lib\get_table_data();
    $num_table_data = count($table_data) * count($table_data[0]);
    $max_page = ceil($num_table_data / MAX);
    $active_page = table_lib\get_active_page($table_data);

    if (!isset($_GET['page'])) {
        // $now_page = 1;
        $now_page = $active_page;
    } else {
        $now_page = intval($_GET['page']);
    }
    
    $start_page_no = $now_page - 1;
    $disp_data = $table_data[$start_page_no];
    usort($disp_data, 'database_lib\sort_by_primary'); // 追加
?>
    <!-- ナビゲーションバー -->
    <div class="navbar">
    <div class="navbar-content">
    <h1>アプリ</h1>
    <ul>
        <li><a href="">統計情報</a></li>
        <li><a href="">ユーザ管理</a></li>
    </ul>
    </div>
    </div>

    <!-- フラッシュメッセージ -->
<?php
?>

    <!-- メイン部 -->
    <div class="container">

    <!-- ON/OFFエリア -->
    <h2>使い方</h2>
    <div class="how-to-use off">
        <ol>
            <li>a</li>
            <li>b</li>
            <li>c</li>
        </ol>
    </div>
    <button id="on-off-button">ON/OFF</button>

    

    <!-- データをテーブル形式で表示 -->
    <h2>登録情報一覧</h2>
    <?php if (count($_POST) != 0 && $_POST['name']): ?>
        <?= table_lib\get_registered_table($disp_data, $now_page, $active_page, $_POST['name']); ?>
    <?php else: ?>
        <?= table_lib\get_registered_table($disp_data, $now_page, $active_page, ""); ?>
    <?php endif; ?>

    <!-- ページネーション -->
    <div class="pagination">
        <?= table_lib\get_pagination($now_page, $max_page); ?>
    </div>

    <!-- ページ追加、削除ボタン -->
    <div class="page-buttons">
        <form action='data_table/add_page.php' method='post'>
            <p><button id='add-page-button' type='submit'>ページ追加</button></p>
        </form>
        
        <form action='data_table/remove_page.php' method='post'>
            <p><button id='remove-page-button' type='submit'>ページ削除</button></p>
            <input type='hidden' name='page_no' value=<?= $now_page ?>>
        </form>
    </div>
    
    <!-- ユーザ管理 -->
    <h2>ユーザ管理</h2>
    <?= table_lib\get_user_table(); ?>

    <!-- ユーザ管理 -->
    <h2>データエクスポート</h2>
    <div class="data-export">
        <div class="export-wrapper">
            <p>登録一覧情報</p>
            <form action='export/export_data_table.php' method='post'>
                <p><button id='export-data_table-button' type='submit'>エクスポート</button></p>
            </form>
        </div>
        <div class="export-wrapper">
            <p>ユーザ情報</p>
            <form action='#' method='post'>
                <p><button id='export-user-button' type='submit'>エクスポート</button></p>
            </form>
        </div>
    </div>

<?php
    // echo "<form action='add_testdata.php' method='post'>";
    // echo "<p><input type='submit' value='テストデータ追加'></p>";
    // echo "</form>";
    
    // echo "<form action='show_testdata.php' method='post'>";
    // echo "<p><input type='submit' value='テストデータ参照'></p>";
    // echo "</form>";
    
    // echo "<form action='show_userdata.php' method='post'>";
    // echo "<p><input type='submit' value='ユーザデータ参照'></p>";
    // echo "</form>";
?>
    </div>

    <!-- フッター -->
    <div class="footer">
    </div>
</body>
</html>