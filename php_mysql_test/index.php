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
    // 定数定義
    define('MAX', '7'); // Todo: userテーブルから取得する
?>

<?php
    // 関数定義

    // テーブルのヘッダを返す
    function print_table_header()
    {
        $table_header = "<th>名前</th>" .
            "<th>日付</th>".
            "<th>クラス</th>" .
            "<th>チケット番号</th>" .
            "<th>備考</th>";
        return $table_header;
    }
    
    // テーブルのボディ部を返す
    function print_table_body($name, $receipt_date, $class, $ticket, $remarks, $readonly)
    {
        $table_body = "<td><input type='text' name='name' value='" . $name . "' readonly></td>";
        if ($readonly == true) {
            $table_body = $table_body .
                // "<td><input type='text' name='receipt_date' value='" . $receipt_date . "' readonly></td>" .
                "<td><input type='date' name='receipt_date' value='" . $receipt_date . "' readonly></td>" .
                "<td><input type='text' name='class' value='" . $class . "' readonly></td>" .
                "<td><input type='text' name='ticket' value='" . $ticket . "' readonly></td>" .
                "<td><input type='text' name='remarks' value='" . $remarks . "' readonly></td>";
        } else {
            $table_body = $table_body .
                // "<td><input type='text' name='receipt_date' value='" . $receipt_date . "'></td>" .
                "<td><input type='date' name='receipt_date' value='" . $receipt_date . "'></td>" .
                "<td>" .
                "<select name='class'>" .
                "<option value=''></option>" .
                "<option value='A'>A</option>" .
                "<option value='B'>B</option>" .
                "<option value='C'>C</option>" .
                "</select>" .
                "</td>" .
                "<td><input type='text' name='ticket' value='" . $ticket . "'></td>" .
                "<td><input type='text' name='remarks' value='" . $remarks . "'></td>";
        }
        return $table_body;
    }
?>

<!-- DB処理 -->
<?php
    try {
        // Todo: 接続先DBの情報、ユーザ、パスワードをハードコーディングしない
        $dsn = "mysql:host=mysql;dbname=sample;";
        $db = new PDO($dsn, 'root', 'pass');
    
        // 最大ページ数を取得
        $sql = "SELECT max(page_no) as max_page_no FROM data_table ;";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        // data_tableよりデータを取得
        $sql = "SELECT * FROM data_table WHERE page_no = :page_no;";
        $user_data = array();
        $stmt = $db->prepare($sql);
        for($i = 1, $max = intval($result[0]["max_page_no"]); $i <= $max; $i++) {
            $params = array(':page_no' => $i);
            $stmt->execute($params);
            array_push($user_data, $stmt->fetchAll(PDO::FETCH_ASSOC));
        }
    
    } catch (PDOException $e) {
        echo $e->getMessage();
        exit;
    }

    $num_user_data = count($user_data) * count($user_data[0]);
    $max_page = ceil($num_user_data / MAX);
    
    if (!isset($_GET['page'])) {
        $now_page = 1;
    } else {
        $now_page = intval($_GET['page']);
    }
    
    $start_no = $now_page - 1;
    $disp_data = $user_data[$start_no];
?>

<div class="navbar">
    <div class="navbar-content">
        <h1>アプリ</h1>
        <ul>
            <li><a href="">統計情報</a></li>
            <li><a href="">ユーザ管理</a></li>
        </ul>
    </div>
</div>

<div class="container">
<!-- 登録欄を表示(POSTされている場合) -->
<?php if (count($_POST) != 0): ?>
    <h2>登録欄</h2>
    <table border='1'>
    <thead>
        <tr>
            <?= print_table_header(); ?>
        </tr>
    </thead>
    <tbody>
        <form action='update_record.php' method='post'>
        <tr>
            <?php if ($_POST["receipt_date"] == ""): ?>
                <?= print_table_body($_POST['name'], date("Y-m-d"), $_POST['class'], $_POST['ticket'], $_POST['remarks'], false); ?>
            <?php else: ?>
                <?= print_table_body($_POST['name'], $_POST['receipt_date'], $_POST['class'], $_POST['ticket'], $_POST['remarks'], false); ?>
            <?php endif; ?>
            <input type='hidden' name='page_no' value=<?= $_POST['page_no'] ?>>
            <td class='non-border-td'><button id='register-button' type='submit'>登録する</button></td>
        </tr>
        </form>
    </tbody>
    </table>
<?php endif; ?>

<!-- データをテーブル形式で表示する -->
    <h2>登録情報一覧</h2>
    <table border='1'>
    <thead>
        <tr>
            <?= print_table_header(); ?>
        </tr>
    </thead>
    <tbody>
<?php foreach ($disp_data as $val): ?>
        <form action='index.php?page=<?= $now_page ?>' method='post'>
        <?php if (count($_POST) != 0 && $_POST['name'] == $val['name']): ?>
            <tr bgcolor='yellow'>
        <?php else: ?>
            <tr>
        <?php endif; ?>
                <?= print_table_body($val['name'], $val['receipt_date'], $val['class'], $val['ticket'], $val['remarks'], true); ?>
                <td class="non-border-td"><button class='update-button' type='submit'>更新する</button></td>
                <input type='hidden' name='page_no' value=<?= $val['page_no'] ?>>
            </tr>
        </form>
<?php endforeach; ?>
    </tbody>
    </table>

<!-- ページネーション -->
    <div class="pagination">
    <?php if ($max_page >= 4): ?> <!-- ページ数が4以上の場合 -->
        <?php if ($now_page != 1 && $now_page != $max_page): ?>
            <span><a href='/index.php?page=1'>1</a>  </span>
            <?php if ($now_page - 3 >= 1) echo "<span>...  </span>"; ?>
            <?php if ($now_page - 1 != 1) echo "<span><a href='/index.php?page=" . ($now_page-1) . "'>" . ($now_page-1) . "</a>  </span>"; ?>
            <span id='now-page'><?= $now_page ?>  </span>
            <?php if ($now_page + 1 != $max_page) echo "<span><a href='/index.php?page=" . ($now_page+1) . "'>" . ($now_page+1) . "</a>  </span>"; ?>
            <?php if ($now_page + 3 <= $max_page) echo "<span>...  </span>"; ?>
            <span><a href='/index.php?page=<?= $max_page ?>'><?= $max_page ?></a>  </span>
        <?php elseif ($now_page == 1): ?>
            <span id='now-page'>1  </span>
            <span><a href='/index.php?page=2'>2</a>  </span>
            <span>...  </span>
            <span><a href='/index.php?page=<?= $max_page ?>'><?= $max_page ?></a>  </span>
        <?php elseif ($now_page == $max_page): ?>
            <span><a href='/index.php?page=1'>1</a>  </span>
            <span>...  </span>
            <span><a href='/index.php?page=<?= ($max_page-1) ?>'><?= ($max_page-1) ?></a>  </span>
            <span id='now-page'><?= $max_page ?></span>
        <?php endif; ?>
    <?php else: ?> <!-- ページ数が3以下の場合 -->
        <?php
        for ($i = 1; $i <= $max_page; $i++) {
            if ($i == $now_page) {
                echo "<span id='now-page'>" . $now_page . "  </span>";
            } else {
                echo "<span><a href='/index.php?page=" . $i . "'>" . $i . "</a>  </span>";
            }
        }
        ?>
    <?php endif; ?>
    <span class="pseudo-span"></span>
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
    <p>ユーザ管理はこちらから</p>

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

<div class="footer">
</div>
</body>
</html>