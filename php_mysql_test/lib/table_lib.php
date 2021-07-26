<?php
namespace table_lib;
require_once('./lib/database_lib.php');

use database_lib;

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
        "<form action='update_record.php' method='post'>" .
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
function get_registered_table($disp_data, $now_page, $focused_user)
{
    $registered_table = 
        "<table border='1'>" .
        get_common_table_header() .
        "<tbody>";
    foreach ($disp_data as $val) {
        $registered_table .= "<form action='index.php?page=" . $now_page . "' method='post'>";
        if ($focused_user != "" && $focused_user == $val['name']) {
            $registered_table .= "<tr bgcolor='yellow'>";
        } else {
            $registered_table .= "<tr>";
        }
        $registered_table .= 
            get_common_table_body($val['name'], $val['receipt_date'], $val['class'], $val['ticket'], $val['remarks'], true) .
            "<td class='non-border-td'><button class='update-button' type='submit'>更新する</button></td>" .
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
    $pagination = "";
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
        } elseif ($now_page == $max_page) {
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