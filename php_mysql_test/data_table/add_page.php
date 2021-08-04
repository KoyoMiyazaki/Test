<?php
    try {
        $dsn = "mysql:host=mysql;dbname=sample;";
        $db = new PDO($dsn, 'root', 'pass');

        $sql = "UPDATE data_table SET page_no=page_no+1;";
        $stmt = $db->prepare($sql);
        $stmt->execute();

        $users = ['bob', 'alice', 'tom', 'henry', 'kim', 'emily', 'sandy'];
        $sql = "INSERT INTO data_table (name, page_no) VALUES (:name, 1);";
        $stmt = $db->prepare($sql);
        foreach ($users as $user) {
            $params = array(':name' => $user);
            $stmt->execute($params);
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
        exit;
    }

    $_SESSION["message_type"] = "success";
    $url = 'http://localhost/index.php';
    header('Location: ' . $url, true, 301);