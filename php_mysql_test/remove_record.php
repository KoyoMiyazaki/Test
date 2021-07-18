<?php
    $page_no = $_POST["page_no"];
    try {
        $dsn = "mysql:host=mysql;dbname=sample;";
        $db = new PDO($dsn, 'root', 'pass');

        // page_noのデータを全削除
        $sql = "DELETE FROM data_table WHERE page_no=:page_no;";
        // $sql = "UPDATE data_table SET page_no=page_no+1;";
        $stmt = $db->prepare($sql);
        $params = array(':page_no' => $page_no);
        $stmt->execute($params);

        // 最大ページ数を取得
        $sql = "SELECT max(page_no) as max_page_no FROM data_table;";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $max_page = intval($result[0]["max_page_no"]);

        // データのpage_noを更新
        $sql = "UPDATE data_table SET page_no=page_no-1 WHERE page_no=:page_no;";
        $stmt = $db->prepare($sql);
        for ($i = $page_no + 1; $i <= $max_page; $i++) {
            $params = array(':page_no' => $i);
            $stmt->execute($params);
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
        exit;
    }

    $url = 'http://localhost/test.php';
    header('Location: ' . $url, true, 301);