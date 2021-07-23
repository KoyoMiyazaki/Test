<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>アプリ | ユーザ管理画面</title>
    <script src="./confirm.js"></script>
</head>
<body>

<?php
    // 関数定義

    // テーブルのヘッダを返す
    function print_table_header()
    {
        $table_header = 
            "<th>名前</th>" .
            "<th>順番</th>";
        return $table_header;
    }
    
    // テーブルのボディ部を返す
    function print_table_body($name, $primary_order, $readonly)
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
    
        // userよりデータを取得
        $sql = "SELECT * FROM user;";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo $e->getMessage();
        exit;
    }
?>

    <?php var_dump($_POST); ?>
    <h1>ユーザ管理</h1>

<?php if (count($_POST) != 0 && $_POST['type'] == 'register'): ?>
    <h2>ユーザ新規登録</h2>
    <table border='1'>
    <thead>
        <tr>
            <?= print_table_header(); ?>
        </tr>
    </thead>
    <tbody>
        <form action='add_record.php' method='post'>
            <tr>
                <td><input type='text' name='name' value=''></td>
                <td><input type='number' name='primary_order' value=''></td>
                <td><button id='register-button' type='submit'>登録する</button></td>
            </tr>
        </form>
    </tbody>
    </table>

<?php elseif (count($_POST) != 0 && $_POST['type'] == 'update'): ?>
    <h2>ユーザ更新</h2>
    <table border='1'>
    <thead>
        <tr>
            <?= print_table_header(); ?>
        </tr>
    </thead>
    <tbody>
        <form action='add_record.php' method='post'>
            <tr>
                <td><input type='text' name='name' value=<?= $_POST['name'] ?>></td>
                <td><input type='number' name='primary_order' value=<?= $_POST['primary_order'] ?>></td>
                <td><button id='register-button' type='submit'>更新する</button></td>
            </tr>
        </form>
    </tbody>
    </table>

<?php endif; ?>

<!-- データをテーブル形式で表示する -->
    <h2>ユーザ一覧</h2>
    <table border='1'>
    <thead>
        <tr>
            <?= print_table_header(); ?>
        </tr>
    </thead>
    <tbody>
<?php foreach ($users as $user): ?>
        <tr>
            <td><input type='text' name='name' value=<?= $user['name'] ?> readonly></td>
            <td><input type='number' name='primary_order' value=<?= $user['primary_order'] ?> readonly></td>
            <td>
                <form action='index.php' method='post'>
                    <input type='hidden' name='name' value=<?= $user['name'] ?>>
                    <input type='hidden' name='primary_order' value=<?= $user['primary_order'] ?>>
                    <input type='hidden' name='type' value='update'>
                    <button id='update-button' type='submit'>更新</button>
                </form>
            </td>
            <td>
                <form action='#' method='post'>
                    <input type='hidden' name='name' value=<?= $user['name'] ?>>
                    <button id='remove-button' type='submit'>削除</button>
                </form>
            </td>
        </tr>
        </form>
<?php endforeach; ?>
    </tbody>
    </table>

    <form action='index.php' method='post'>
        <input type='hidden' name='type' value='register'>
        <button id='register-button' type='submit'>ユーザ登録</button>
    </form>
</body>
</html>