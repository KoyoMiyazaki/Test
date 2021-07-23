<?php
    // POSTで渡されたパラメータを変数に保存
    $name = $_POST['name'];

    try {
        $dsn = "mysql:host=mysql;dbname=sample;";
        $db = new PDO($dsn, 'root', 'pass');

        $sql = "DELETE FROM user WHERE name=:name;";
        $stmt = $db->prepare($sql);
        $params = array(':name' => $name);
        $stmt->execute($params);
    } catch (PDOException $e) {
        echo $e->getMessage();
        exit;
    }

    $url = "http://localhost/user_manager/index.php";
    header('Location: ' . $url, true, 301);