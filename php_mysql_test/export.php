<?php

require_once('./lib/database_lib.php');

function generate_csv() {
    $sql = "SELECT * FROM data_table;";
    $result = database_lib\exec_reference_sql($sql, "");

    $filename = '/var/www/html/aaa.csv';

    $res = fopen($filename, 'w');
    if ($res === FALSE) {
        throw new Exception('ファイルの書き込みに失敗しました。');
    }

    // // 項目名先に出力
    // // $header = ["id", "name", "email", "password"];
    // // fputcsv($res, $header);

    // ループしながら出力
    foreach($result as $dataInfo) {
        // 文字コード変換。エクセルで開けるようにする
        mb_convert_variables('SJIS', 'UTF-8', $dataInfo);

        // ファイルに書き出しをする
        fputcsv($res, $dataInfo);
    }

    // ファイルを閉じる
    fclose($res);
}

function download()
{
    $filename = 'aaa.csv';
    $fullpath = '/var/www/html/aaa.csv';
    header('Content-Type: text/csv');
    header('Content-Length: ' . filesize($fullpath));
    header('Content-Disposition: attachment; filename=' . $filename);
    readfile($fullpath);
}

generate_csv();
download();