<?php

require_once('./lib/my_lib.php');

$user_name = $_POST["name"];

// ユーザ削除
try {
    $dsn = "mysql:host=mysql;dbname=sample;";
    $db = new PDO($dsn, 'root', 'pass');

    $sql = "DELETE FROM user WHERE name=:name;";
    $stmt = $db->prepare($sql);
    $params = array(':name' => $user_name);
    $stmt->execute($params);
} catch (PDOException $e) {
    echo $e->getMessage();
    exit;
}

// テーブル表示
$user_table = my_lib\get_user_table();

echo $user_table;