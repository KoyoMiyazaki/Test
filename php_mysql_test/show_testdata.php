<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>データ参照ページ</title>
</head>
<body>
<?php
    // $users = array(
    //     'bob', 'alice', 'tom', 'henry', 'kim', 'emily', 'sandy'
    // );
    // $tickets = array(
    //     'AAA', 'BBB', 'CCC', 'DDD', 'EEE', 'FFF', 'GGG'
    // );

    try {
        $dsn = "mysql:host=mysql;dbname=sample;";
        $db = new PDO($dsn, 'root', 'pass');

        $sql = "SELECT * FROM data_table ;";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo $e->getMessage();
        exit;
    }
    var_dump($result[0]["name"]);
?>

</body>
</html>