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
    try {
        $dsn = "mysql:host=mysql;dbname=sample;";
        $db = new PDO($dsn, 'root', 'pass');

        $sql = "SELECT max(page_no) as max_page_no FROM data_table ;";
        
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);


        $data = array();

        $sql = "SELECT * FROM data_table WHERE page_no = :page_no;";
        $stmt = $db->prepare($sql);
        for($i = 1, $max = intval($result[0]["max_page_no"]); $i <= $max; $i++) {
            $params = array(':page_no' => $i);
            $stmt->execute($params);
            array_push($data, $stmt->fetchAll(PDO::FETCH_ASSOC));
            
        }

    } catch (PDOException $e) {
        echo $e->getMessage();
        exit;
    }
    var_dump(count($data) * count($data[0]));
?>

</body>
</html>