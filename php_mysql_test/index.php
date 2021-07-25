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
    require_once('./lib/database_lib.php');
    require_once('./lib/table_lib.php');

    // 定数定義
    define('MAX', '7'); // Todo: userテーブルから取得する

    // 変数設定
    $table_data = database_lib\get_table_data();
    $num_table_data = count($table_data) * count($table_data[0]);
    $max_page = ceil($num_table_data / MAX);
    
    if (!isset($_GET['page'])) {
        $now_page = 1;
    } else {
        $now_page = intval($_GET['page']);
    }
    
    $start_page_no = $now_page - 1;
    $disp_data = $table_data[$start_page_no];
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

    <!-- メイン部 -->
    <div class="container">

    <!-- 登録欄を表示(POSTされている場合) -->
<?php if (count($_POST) != 0): ?>
    <h2>登録欄</h2>
    <?php if ($_POST["receipt_date"] == ""): ?>
        <?= table_lib\get_register_table($_POST['name'], date("Y-m-d"), $_POST['class'], $_POST['ticket'], $_POST['remarks'], $_POST['page_no']); ?>
    <?php else: ?>
        <?= table_lib\get_register_table($_POST['name'], $_POST['receipt_date'], $_POST['class'], $_POST['ticket'], $_POST['remarks'], $_POST['page_no']); ?>
    <?php endif; ?>
<?php endif; ?>

    <!-- データをテーブル形式で表示 -->
    <h2>登録情報一覧</h2>
    <?php if (count($_POST) != 0 && $_POST['name']): ?>
        <?= table_lib\get_registered_table($disp_data, $now_page, $_POST['name']); ?>
    <?php else: ?>
        <?= table_lib\get_registered_table($disp_data, $now_page, ""); ?>
    <?php endif; ?>

    <!-- ページネーション -->
    <div class="pagination">
        <?= table_lib\get_pagination($now_page, $max_page); ?>
    </div>

    <div class="page-buttons">
        <form action='add_record.php' method='post'>
            <p><button id='add-button' type='submit'>ページ追加</button></p>
        </form>
        
        <form action='remove_record.php' method='post'>
            <p><button id='remove-button' type='submit'>ページ削除</button></p>
            <input type='hidden' name='page_no' value=<?= $now_page ?>>
        </form>
    </div>
    
    <!-- 統計情報確認 -->
    <h2>統計情報</h2>
    <div class="stats">
        <?= table_lib\get_stats_table(); ?>
    </div>

    <!-- ユーザ管理 -->
    <h2>ユーザ管理</h2>
    <p>ユーザ管理はこちらから</p>

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