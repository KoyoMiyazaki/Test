<?php
    // POSTで渡されたパラメータを変数に保存
    $name = $_POST['name'];
    $receipt_date = $_POST['receipt_date'];
    $ticket = $_POST['ticket'];
    $remarks = $_POST['remarks'];
    $page_no = $_POST['page_no'];

    try {
        $dsn = "mysql:host=mysql;dbname=sample;";
        $db = new PDO($dsn, 'root', 'pass');

        $sql = "UPDATE data_table SET receipt_date=:receipt_date, ticket=:ticket, remarks=:remarks where name=:name and page_no=:page_no;";
        $stmt = $db->prepare($sql);
        $params = array(':name' => $name, 'receipt_date' => $receipt_date, ':ticket' => $ticket, ':remarks' => $remarks, ':page_no' => $page_no);
        $stmt->execute($params);
    } catch (PDOException $e) {
        echo $e->getMessage();
        exit;
    }

    $url = 'http://localhost/test.php';
    header('Location: ' . $url, true, 301);