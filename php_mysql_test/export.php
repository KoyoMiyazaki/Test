<?php

require_once('./lib/database_lib.php');

function generate_csv($fullpath) {
    $sql = "SELECT * FROM data_table;";
    $result = database_lib\exec_reference_sql($sql, "");

    $res = fopen($fullpath, 'w');
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

function download_csv($fullpath)
{
    $filename = basename($fullpath);
    header('Content-Type: text/csv');
    header('Content-Length: ' . filesize($fullpath));
    header('Content-Disposition: attachment; filename=' . $filename);
    readfile($fullpath);
}

function terminate_csv($fullpath)
{
    unlink($fullpath);
}

$now_date = new DateTime('now');
$now_date->setTimeZone(new DateTimeZone('Asia/Tokyo'));

$filename_base = "export";
$filename_suffix = "_" . $now_date->format('Y') . $now_date->format('m') . $now_date->format('d');
$filename_extension = ".csv";
$filename = $filename_base . $filename_suffix . $filename_extension;
$directory_base = "/var/www/html/";
$fullpath = $directory_base . $filename;

generate_csv($fullpath);
download_csv($fullpath);
terminate_csv($fullpath);