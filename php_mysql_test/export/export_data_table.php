<?php
    try {
        $dsn = "mysql:host=mysql;dbname=sample;";
        $db = new PDO($dsn, 'root', 'pass');

        $sql = "SELECT * FROM data_table
            INTO OUTFILE '/var/backups/bk.csv'
            FIELDS TERMINATED BY ','
            OPTIONALLY ENCLOSED BY '\"'";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
    } catch (PDOException $e) {
        echo $e->getMessage();
        exit;
    }