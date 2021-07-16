<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php
    try {
        $dsn = "mysql:host=mysql;dbname=sample;";
        $db = new PDO($dsn, 'root', 'pass');

        $sql = "SELECT * FROM test";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        // var_dump($result);
    } catch (PDOException $e) {
        echo $e->getMessage();
        exit;
    }
?>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>name</th>
            </tr>
        </thead>
        <tbody>
<?php
        foreach ($result as $user) {
            print "<tr>";
            print "<td>${user['id']}</td>";
            print "<td>${user['name']}</td>";
            print "</tr>";
        }
?>
        </tbody>
    </table>    
</body>
</html>

