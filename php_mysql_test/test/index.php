<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>test</title>
</head>
<body>

<?php
    // 関数定義

    // 参照系のSQLを実行し、結果を返す
    function exec_reference_sql($sql, $params)
    {
        try {
            $dsn = "mysql:host=mysql;dbname=sample;";
            $db = new PDO($dsn, 'root', 'pass');
        
            $stmt = $db->prepare($sql);
            if ($params == "") {
                $stmt->execute();
            } else {
                $stmt->execute($params);
            }
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo $e->getMessage();
            exit;
        }
        return $result;
    }

    // ユーザ数取得
    function get_num_user()
    {
        $sql = "SELECT count(*) as total FROM user;";
        $result = exec_reference_sql($sql, "");
        return intval($result[0]["total"]);
    }

    // 全ユーザ取得
    function get_users()
    {
        $sql = "SELECT name FROM user;";
        $result = exec_reference_sql($sql, "");
        return $result;
    }

    function get_num_class_per_user($user_name, $class)
    {
        $sql = "SELECT count(*) as total FROM data_table WHERE name=:name AND class=:class;";
        $params = array(':name' => $user_name, ':class' => $class);
        $result = exec_reference_sql($sql, $params);
        return intval($result[0]["total"]);
    }

    function get_num_classes_per_user($user_name)
    {
        $sql = "SELECT count(*) as total FROM data_table WHERE name=:name";
        $params = array(':name' => $user_name);
        $result = exec_reference_sql($sql, $params);
        return intval($result[0]["total"]);
    }
?>

<!-- メイン処理 -->
<?php
    $num_user = get_num_user();
    $users = get_users();
    
?>

<h2>Test</h2>
<table border='1'>
<thead>
    <tr>
        <th>名前</th>
        <th>Aの数</th>
        <th>Bの数</th>
        <th>Cの数</th>
        <th>総数</th>
    </tr>
</thead>
<tbody>
<?php foreach ($users as $user): ?>
    <tr>
        <td><?= $user["name"] ?></td>
        <td><?= get_num_class_per_user($user["name"], "A") ?></td>
        <td><?= get_num_class_per_user($user["name"], "B") ?></td>
        <td><?= get_num_class_per_user($user["name"], "C") ?></td>
        <td><?= get_num_classes_per_user($user["name"]) ?></td>
    </tr>
<?php endforeach; ?>
</tbody>

</body>
</html>