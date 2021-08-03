<?php

namespace my_lib;

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

function get_user_registration()
{
    $user_registration =
    "<table border='1'>" .
    "<thead>" .
        "<tr>" .
            "<th>名前</th>" .
        "</tr>" .
    "</thead>" .
    "<tbody>" .
        "<tr>" .
        "<form>" .
            "<td><input type='text' name='name'></td>" .
        "</form>" .
            "<td class='non-border-td'>" .
                "<button id='register-button'>登録</button>" .
            "</td>" .
        "</tr>" .
    "</tbody>" .
    "</table>";
    
    return $user_registration;
}

function get_user_table()
{
    $users = get_users();
    $user_table =
    "<table border='1'>" .
    "<thead>" .
        "<tr>" .
            "<th>順序</th>" .
            "<th>名前</th>" .
        "</tr>" .
    "</thead>" .
    "<tbody>";

    foreach ($users as $user) {
        $user_table .=
            "<tr>" .
                "<td>" . $user["primary_order"] . "</td>" .
                "<td class='wide-td'>" . $user["name"] . "</td>" .
                "<form>" .
                    "<input type='hidden' name='primary_order' value='" . $user["primary_order"] . "'>" .
                "</form>" .
                "<td class='non-border-td'>" .
                    "<div class='up-down-button'>" .
                        "<button class='up-button'>↑</button>" .
                        "<button class='down-button'>↓</button>" .
                    "</div>" .
                "</td>" .
                
                "<form>" .
                "<td class='non-border-td'>" .
                    "<button>編集</button>" .
                "</td>" .
                "</form>" .
                "<form>" .
                "<td class='non-border-td'>" .
                    "<button>削除</button>" .
                "</td>" .
                "</form>" .
            "</tr>";
    }

    $user_table .=
        "</tbody>" .
        "</table>";

    return $user_table;
}