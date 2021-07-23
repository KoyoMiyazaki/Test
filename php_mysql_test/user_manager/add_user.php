<?php
    // POSTで渡されたパラメータを変数に保存
    $name = $_POST['name'];
    $primary_order = intval($_POST['primary_order']);

    try {
        $dsn = "mysql:host=mysql;dbname=sample;";
        $db = new PDO($dsn, 'root', 'pass');

        $sql = "INSERT INTO user (name, primary_order) VALUES (:name, :primary_order);";
        $stmt = $db->prepare($sql);
        $params = array(':name' => $name, ':primary_order' => $primary_order);
        $stmt->execute($params);
    } catch (PDOException $e) {
        echo $e->getMessage();
        exit;
    }

    $url = "http://localhost/user_manager/index.php";
    header('Location: ' . $url, true, 301);