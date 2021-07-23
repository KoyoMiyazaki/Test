<?php
    // POSTで渡されたパラメータを変数に保存
    $updated_name = $_POST['updated_name'];
    $updated_primary_order = intval($_POST['updated_primary_order']);
    $name = $_POST['name'];

    try {
        $dsn = "mysql:host=mysql;dbname=sample;";
        $db = new PDO($dsn, 'root', 'pass');

        $sql = "UPDATE user SET name=:updated_name, primary_order=:updated_primary_order WHERE name=:name;";
        $stmt = $db->prepare($sql);
        $params = array(':updated_name' => $updated_name, ':updated_primary_order' => $updated_primary_order, ':name' => $name);
        $stmt->execute($params);
    } catch (PDOException $e) {
        echo $e->getMessage();
        exit;
    }

    $url = "http://localhost/user_manager/index.php";
    header('Location: ' . $url, true, 301);