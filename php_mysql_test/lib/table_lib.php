<?php
namespace table_lib;
require_once('./lib/database_lib.php');

use database_lib;

// 
function get_active_page($table_data)
{
    $num_page = count($table_data);
    $num_row = count($table_data[0]);
    $active_page_flag = false;

    for ($i = $num_page; $i >= 1; $i--) {
        for ($j = 0; $j < $num_row; $j++) {
            if ($table_data[$i-1][$j]["ticket"] == "") {
                $active_page_flag = true;
            }
        }
        if ($active_page_flag == true) {
            return $i;
        }
    }
    return 1;
}

function get_active_row($page_data)
{
    $num_row = count($page_data);
    for ($i = 1; $i <= $num_row; $i++) {
        if ($page_data[$i-1]["ticket"] == "") {
            return $i;
        }
    }
}

// テーブルの共通のヘッダを返す
function get_common_table_header()
{
    $table_header = 
        "<thead>" .
            "<tr>" .
                "<th>名前</th>" .
                "<th>日付</th>".
                "<th>クラス</th>" .
                "<th>チケット番号</th>" .
                "<th>備考</th>" .
            "</tr>" .
        "</thead>";
    return $table_header;
}

// テーブルの共通のボディ部を返す
function get_common_table_body($name, $receipt_date, $class, $ticket, $remarks, $readonly)
{
    $classes = array("A", "B", "C");
    $table_body = "<td><input type='text' name='name' value='" . $name . "' readonly></td>";
    if ($readonly == true) {
        $table_body .=
            "<td><input type='date' name='receipt_date' value='" . $receipt_date . "' readonly></td>" .
            "<td>" .
            "<select name='class'>" .
            "<option value='" . $class . "'>" . $class . "</option>" .
            "</select>" .
            "</td>" .
            "<td><input type='text' name='ticket' value='" . $ticket . "' readonly></td>" .
            "<td><input type='text' name='remarks' value='" . $remarks . "' readonly></td>";
    } else {
        $table_body .= 
            "<td><input type='date' name='receipt_date' value='" . $receipt_date . "'></td>" .
            "<td>" .
            "<select name='class'>" .
            "<option value=''></option>";
        for ($i = 0, $num_class = count($classes); $i < $num_class; $i++) {
            if ($classes[$i] == $class) {
                $table_body .= "<option value='" . $classes[$i] . "' selected>" . $classes[$i] . "</option>";
            } else {
                $table_body .= "<option value='" . $classes[$i] . "'>" . $classes[$i] . "</option>";
            }
        }
        $table_body .= 
            "</select>" .
            "</td>" .
            "<td><input type='text' name='ticket' value='" . $ticket . "'></td>" .
            "<td><input type='text' name='remarks' value='" . $remarks . "'></td>";
    }
    return $table_body;
}

// 登録欄のHTMLタグを返却する
function get_register_table($name, $receipt_date, $class, $ticket, $remarks, $page_no)
{
    $register_table = 
        "<table border='1'>" .
        get_common_table_header() .
        "<tbody>" .
        "<form action='data_table/update_record.php' method='post'>" .
        "<tr>".
        get_common_table_body($name, $receipt_date, $class, $ticket, $remarks, false) .
        "<input type='hidden' name='page_no' value=" . $page_no . ">" .
        "<td class='non-border-td'><button id='register-button' type='submit'>登録する</button></td>" .
        "</tr>" .
        "</form>" .
        "</tbody>" .
        "</table>";
    
    return $register_table;
}

// 登録一覧のHTMLタグを返却する
function get_registered_table($disp_data, $now_page, $active_page, $focused_user)
{
    $registered_table = 
        "<table border='1'>" .
        get_common_table_header() .
        "<tbody>";
    foreach ($disp_data as $index => $val) {
        if ($focused_user != "") { // 登録欄が表示されている場合
            if ($focused_user == $val['name']) {
                $registered_table .= "<form action='data_table/update_record.php' method='post'>";
                $registered_table .= "<tr bgcolor='yellow'>"; // 編集中の行を強調表示
            } else {
                $registered_table .= "<form action='index.php?page=" . $now_page . "' method='post'>";
                $registered_table .= "<tr>";
            }
        } else { // 登録欄が表示されていない場合
            $registered_table .= "<form action='index.php?page=" . $now_page . "' method='post'>";
            if ($now_page == $active_page) {
                $active_row = get_active_row($disp_data);
                if ($index == $active_row - 1) {
                    $registered_table .= "<tr bgcolor='red'>"; // アクティブな行を強調表示
                } else {
                    $registered_table .= "<tr>";
                }
            } else {
                $registered_table .= "<tr>";
            }
            
        }

        if ($focused_user != "" && $focused_user == $val['name']) {
            $registered_table .=
                get_common_table_body($val['name'], $val['receipt_date'], $val['class'], $val['ticket'], $val['remarks'], false) .
                "<td class='non-border-td'><button id='register-button' type='submit'>登録</button></td>";
        } else {
            $registered_table .=
                get_common_table_body($val['name'], $val['receipt_date'], $val['class'], $val['ticket'], $val['remarks'], true) .
                "<td class='non-border-td'><button class='update-button' type='submit'>更新</button></td>";
        }
        $registered_table .= 
            "<input type='hidden' name='page_no' value=" . $val['page_no'] . ">" .
            "</tr>" .
            "</form>";
    }
    $registered_table .= 
        "</tbody>" .
        "</table>";

    return $registered_table;
}

// ページネーション用のHTMLタグを返却する
function get_pagination($now_page, $max_page) 
{
    $pagination = "<span>Newer</span>";
    if ($max_page >= 4) { // ページ数が4以上の場合
        if ($now_page != 1 && $now_page != $max_page) {
            $pagination .= "<span><a href='/index.php?page=1'>1</a>  </span>";
            if ($now_page - 3 >= 1) $pagination .= "<span>...  </span>";
            if ($now_page - 1 != 1) $pagination .= "<span><a href='/index.php?page=" . ($now_page-1) . "'>" . ($now_page-1) . "</a>  </span>";
            $pagination .= "<span id='now-page'>" . $now_page . "  </span>";
            if ($now_page + 1 != $max_page) $pagination .= "<span><a href='/index.php?page=" . ($now_page+1) . "'>" . ($now_page+1) . "</a>  </span>";
            if ($now_page + 3 <= $max_page) $pagination .= "<span>...  </span>";
            $pagination .= "<span><a href='/index.php?page=" . $max_page . "'>" . $max_page . "</a>  </span>";
        } elseif ($now_page == 1) {
            $pagination .= 
                "<span id='now-page'>1  </span>" .
                "<span><a href='/index.php?page=2'>2</a>  </span>" .
                "<span>...  </span>" .
                "<span><a href='/index.php?page=" . $max_page . "'>" . $max_page . "</a>  </span>";
        // } elseif ($now_page == $max_page) {
        } else {
            $pagination .= 
                "<span><a href='/index.php?page=1'>1</a>  </span>" .
                "<span>...  </span>" .
                "<span><a href='/index.php?page=" . ($max_page-1) . "'>" . ($max_page-1) . "</a>  </span>" .
                "<span id='now-page'>" . $max_page . "</span>";
        }
    } else { // ページ数が3以下の場合
        for ($i = 1; $i <= $max_page; $i++) {
            if ($i == $now_page) {
                $pagination .= "<span id='now-page'>" . $now_page . "  </span>";
            } else {
                $pagination .= "<span><a href='/index.php?page=" . $i . "'>" . $i . "</a>  </span>";
            }
        }
    }
    $pagination .= "<span>Older</span>";
    $pagination .= "<span class='pseudo-span'></span>";

    return $pagination;
}

// 統計情報用のHTMLタグを返却する
function get_stats_table()
{
    $users = database_lib\get_users();
    $stats_table = 
        "<table border='1'>" .
        "<thead>" .
            "<tr>" .
                "<th>名前</th>" .
                "<th>Aの数</th>" .
                "<th>Bの数</th>" .
                "<th>Cの数</th>" .
                "<th>総数</th>" .
            "</tr>" .
        "</thead>" .
        "<tbody>";
    foreach ($users as $user) {
        $stats_table .=
            "<tr>" .
                "<td>" . $user["name"] . "</td>" .
                "<td>" . database_lib\get_num_class_per_user($user["name"], "A") . "</td>" .
                "<td>" . database_lib\get_num_class_per_user($user["name"], "B") . "</td>" .
                "<td>" . database_lib\get_num_class_per_user($user["name"], "C") . "</td>" .
                "<td>" . database_lib\get_num_classes_per_user($user["name"]) . "</td>" .
            "</tr>";
    }
    $stats_table .= 
        "</tbody>" .
        "</table>";

    return $stats_table;
}

function get_user_table()
{
    $users = database_lib\get_users();
    $user_table =
        "<table border='1'>" .
        "<thead>" .
            "<tr>" .
                "<th>名前</th>" .
                "<th>順序</th>" .
            "</tr>" .
        "</thead>" .
        "<tbody>";
    
    foreach ($users as $user) {
        $user_table .=
            "<tr>" .
                "<td>" . $user["name"] . "</td>" .
                "<td>" . $user["primary_order"] . "</td>" .
            "</tr>";
    }

    $user_table .=
        "</tbody>" .
        "</table>";
    
    return $user_table;
}