<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>データ更新ページ</title>
</head>
<body>
<?php
    var_dump($_POST);
    // try {
    //     $dsn = "mysql:host=mysql;dbname=sample;";
    //     $db = new PDO($dsn, 'root', 'pass');

    //     $nowDate = date('Y-m-d');
    //     $sql = "INSERT INTO data_table (name, receipt_date, ticket, remarks, page_no) VALUES (:name, :receipt_date, :ticket, :remarks, :page_no);";
 
    //     $stmt = $db->prepare($sql);

    //     for ($i = 0; $i < 10; $i++) {
    //         for ($j = 0; $j < 7; $j++) {
    //             $params = array(':name' => $users[$j], 'receipt_date' => $nowDate, ':ticket' => $tickets[$j], ':remarks' => '', ':page_no' => $i+1);
    //             $stmt->execute($params);
    //         }
    //     }
    // } catch (PDOException $e) {
    //     echo $e->getMessage();
    //     exit;
    // }
?>


</body>
</html>