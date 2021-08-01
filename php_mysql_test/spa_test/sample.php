<?php

require_once('../lib/database_lib.php');

$num_target = intval($_POST["value"]) - 1;

if ($num_target == 0) {
    exit;
}

$num_user = database_lib\get_num_user();
$users = database_lib\get_users();
$target_user = $users[$num_target];
$changed_user = $users[$num_target-1];

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

$updated_users = database_lib\get_users();
$user_table =
    "<table border='1'>" .
    "<thead>" .
        "<tr>" .
            "<th>名前</th>" .
            "<th>順序</th>" .
        "</tr>" .
    "</thead>" .
    "<tbody>";

foreach ($updated_users as $user) {
    $user_table .=
        "<tr>" .
            "<td>" . $user["name"] . "</td>" .
            "<td>" . $user["primary_order"] . "</td>" .
        "</tr>";
}

$user_table .=
    "</tbody>" .
    "</table>";

echo $user_table;

// データ表示部
// echo "<p class='test'>" . $target_user["name"] . " " . $target_user["primary_order"] . "</p>";
// echo "<p class='test'>" . $changed_user["name"] . "</p>";

// echo "aaa";
// print json_encode("aaa");

// try {
//     $dsn = "mysql:host=mysql;dbname=sample;";
//     $db = new PDO($dsn, 'root', 'pass');

//     $sql = "SELECT * FROM user;";
//     $stmt = $db->prepare($sql);
//     $stmt->execute();
//     $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

//     foreach ($result as $user) {
//         $user_order_list[$user["name"]] = $user["primary_order"];
//     }

// } catch (PDOException $e) {
//     echo $e->getMessage();
//     exit;
// }

// // var_dump($result);
// // return $result[0]["name"];
// print json_encode($result[0]["name"]);