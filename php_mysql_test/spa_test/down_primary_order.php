<?php

require_once('./lib/my_lib.php');

$num_target = intval($_POST["primary_order"]) - 1;
$max_primary_order = my_lib\get_num_user() - 1;

if ($num_target == $max_primary_order) {
    $user_table = my_lib\get_user_table();
    echo $user_table;
    exit;
}

$num_user = my_lib\get_num_user();
$users = my_lib\get_users();
$target_user = $users[$num_target];
$changed_user = $users[$num_target+1];

// データ更新
try {
    $dsn = "mysql:host=mysql;dbname=sample;";
    $db = new PDO($dsn, 'root', 'pass');

    $sql = "UPDATE user SET primary_order=:primary_order WHERE name=:name;";
    $stmt = $db->prepare($sql);

    $params = array(':name' => $target_user["name"], ':primary_order' => 999);
    $stmt->execute($params);

    $params = array(':name' => $changed_user["name"], ':primary_order' => intval($target_user["primary_order"]));
    $stmt->execute($params);

    $params = array(':name' => $target_user["name"], ':primary_order' => intval($changed_user["primary_order"]));
    $stmt->execute($params);
} catch (PDOException $e) {
    echo $e->getMessage();
    exit;
}

// テーブル表示
$user_table = my_lib\get_user_table();

echo $user_table;