<?php
namespace database_lib;

use PDO;

// 参照系のSQLを実行し、結果を返す
function exec_reference_sql($sql, $params)
{
    try {
        // Todo: 接続先DBの情報、ユーザ、パスワードをハードコーディングしない
        $dsn = "mysql:host=mysql;dbname=sample;";
        $db = new PDO($dsn, 'root', 'pass');
    
        $stmt = $db->prepare($sql);
        if ($params == "") {
            $stmt->execute();
        } else {
            $stmt->execute($params);
        }
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo $e->getMessage();
        exit;
    }
    return $result;
}

// data_table
// data_tableよりデータを取得
function get_table_data()
{
    $user_data = array();

    // 最大ページ数を取得
    $sql = "SELECT max(page_no) as max_page_no FROM data_table;";
    $result = exec_reference_sql($sql, "");
    $max_page_no = intval($result[0]["max_page_no"]);

    // data_tableよりデータを取得
    $sql = "SELECT * FROM data_table WHERE page_no = :page_no;";
    for($i = 1; $i <= $max_page_no; $i++) {
        $params = array(':page_no' => $i);
        $result = exec_reference_sql($sql, $params);
        array_push($user_data, $result);
    }

    return $user_data;
}

// user
// ユーザ数取得
function get_num_user()
{
    $sql = "SELECT count(*) as total FROM user;";
    $result = exec_reference_sql($sql, "");
    return intval($result[0]["total"]);
}

// 全ユーザ取得
function get_users()
{
    $sql = "SELECT * FROM user;";
    $result = exec_reference_sql($sql, "");
    return $result;
}

function get_num_class_per_user($user_name, $class)
{
    $sql = "SELECT count(*) as total FROM data_table WHERE name=:name AND class=:class;";
    $params = array(':name' => $user_name, ':class' => $class);
    $result = exec_reference_sql($sql, $params);
    return intval($result[0]["total"]);
}

function get_num_classes_per_user($user_name)
{
    $sql = "SELECT count(*) as total FROM data_table WHERE name=:name";
    $params = array(':name' => $user_name);
    $result = exec_reference_sql($sql, $params);
    return intval($result[0]["total"]);
}

// データエクスポート
function export_data_table()
{
    
}

// 

function sort_by_primary($a, $b) {
    $user_order = $GLOBALS["user_order_list"];
    if ($user_order[$a["name"]] === $user_order[$b["name"]]) {
        return 0;
    }
    return ($user_order[$a["name"]] < $user_order[$b["name"]]) ? -1 : 1;
}

function get_user_order_list()
{
    $user_order_list = array();
    try {
        $dsn = "mysql:host=mysql;dbname=sample;";
        $db = new PDO($dsn, 'root', 'pass');

        $sql = "SELECT * FROM user;";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($result as $user) {
            $user_order_list[$user["name"]] = $user["primary_order"];
        }

    } catch (PDOException $e) {
        echo $e->getMessage();
        exit;
    }

    return $user_order_list;
}