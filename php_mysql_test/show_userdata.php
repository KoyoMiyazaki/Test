<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ユーザデータ参照ページ</title>
</head>
<body>
<?php
    global $user_order;
    $user_order = array();
    try {
        $dsn = "mysql:host=mysql;dbname=sample;";
        $db = new PDO($dsn, 'root', 'pass');

        $sql = "SELECT * FROM user;";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($result as $user) {
            $user_order[$user["name"]] = $user["primary_order"];
        }

        // data_tableよりデータを取得
        $sql = "SELECT * FROM data_table WHERE page_no = :page_no;";
        $test_data = array();
        $stmt = $db->prepare($sql);
        for($i = 1, $max = 7; $i <= $max; $i++) {
            $params = array(':page_no' => $i);
            $stmt->execute($params);
            array_push($test_data, $stmt->fetchAll(PDO::FETCH_ASSOC));
        }
        

    } catch (PDOException $e) {
        echo $e->getMessage();
        exit;
    }
    $disp_data = $test_data[0];
    echo "<h3>ソート前</h3>";
    foreach ($disp_data as $user) {
        echo "<p>" . $user["name"] . "</p>";
    }
    function sort_by_primary($a, $b) {
        $user_order = $GLOBALS["user_order"];
        if ($user_order[$a["name"]] === $user_order[$b["name"]]) {
            return 0;
        }
        return ($user_order[$a["name"]] < $user_order[$b["name"]]) ? -1 : 1;
    }

    usort($disp_data, 'sort_by_primary');
    echo "<h3>ソート後</h3>";
    foreach ($disp_data as $user) {
        echo "<p>" . $user["name"] . "</p>";
    }
?>

</body>
</html>