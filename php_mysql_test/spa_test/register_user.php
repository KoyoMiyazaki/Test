<?php

require_once('./lib/my_lib.php');

$user_name = $_POST["name"];

if ($user_name == "") {
    $user_table = my_lib\get_user_table();
    echo $user_table;
    exit;
}

$num_user = my_lib\get_num_user();
$user_primary_order = $num_user + 1;

// データ更新
try {
    $dsn = "mysql:host=mysql;dbname=sample;";
    $db = new PDO($dsn, 'root', 'pass');

    $sql = "INSERT INTO user (name, primary_order) VALUES (:name, :primary_order);";
    $stmt = $db->prepare($sql);
    $params = array(':name' => $user_name, ':primary_order' => $user_primary_order);
    $stmt->execute($params);
} catch (PDOException $e) {
    echo $e->getMessage();
    exit;
}

// テーブル表示
$user_table = my_lib\get_user_table();

echo $user_table;