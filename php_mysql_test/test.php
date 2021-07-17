<?php
define('MAX', '7');

try {
    $dsn = "mysql:host=mysql;dbname=sample;";
    $db = new PDO($dsn, 'root', 'pass');

    $sql = "SELECT * FROM data_table ;";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $test_data = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo $e->getMessage();
    exit;
}

// $test_data = array(
//     array('name' => 'bob', 'date' => '2021/06/01', 'ticket_no' => 'AAA', 'remarks' => ''),
//     array('name' => 'alice', 'date' => '2021/06/02', 'ticket_no' => 'AAB', 'remarks' => ''),
//     array('name' => 'tom', 'date' => '2021/06/03', 'ticket_no' => 'AAC', 'remarks' => ''),
//     array('name' => 'henry', 'date' => '2021/06/04', 'ticket_no' => 'AAD', 'remarks' => ''),
//     array('name' => 'kim', 'date' => '2021/06/05', 'ticket_no' => 'AAE', 'remarks' => ''),
//     array('name' => 'emily', 'date' => '2021/06/06', 'ticket_no' => 'AAF', 'remarks' => ''),
//     array('name' => 'sandy', 'date' => '2021/06/07', 'ticket_no' => 'AAG', 'remarks' => ''),

//     array('name' => 'bob', 'date' => '2021/06/01', 'ticket_no' => 'AAA', 'remarks' => ''),
//     array('name' => 'alice', 'date' => '2021/06/02', 'ticket_no' => 'AAB', 'remarks' => ''),
//     array('name' => 'tom', 'date' => '2021/06/03', 'ticket_no' => 'AAC', 'remarks' => ''),
//     array('name' => 'henry', 'date' => '2021/06/04', 'ticket_no' => 'AAD', 'remarks' => ''),
//     array('name' => 'kim', 'date' => '2021/06/05', 'ticket_no' => 'AAE', 'remarks' => ''),
//     array('name' => 'emily', 'date' => '2021/06/06', 'ticket_no' => 'AAF', 'remarks' => ''),
//     array('name' => 'sandy', 'date' => '2021/06/07', 'ticket_no' => 'AAG', 'remarks' => ''),

//     array('name' => 'bob', 'date' => '2021/06/01', 'ticket_no' => 'AAA', 'remarks' => ''),
//     array('name' => 'alice', 'date' => '2021/06/02', 'ticket_no' => 'AAB', 'remarks' => ''),
//     array('name' => 'tom', 'date' => '2021/06/03', 'ticket_no' => 'AAC', 'remarks' => ''),
//     array('name' => 'henry', 'date' => '2021/06/04', 'ticket_no' => 'AAD', 'remarks' => ''),
//     array('name' => 'kim', 'date' => '2021/06/05', 'ticket_no' => 'AAE', 'remarks' => ''),
//     array('name' => 'emily', 'date' => '2021/06/06', 'ticket_no' => 'AAF', 'remarks' => ''),
//     array('name' => 'sandy', 'date' => '2021/06/07', 'ticket_no' => 'AAG', 'remarks' => ''),

//     array('name' => 'bob', 'date' => '2021/06/01', 'ticket_no' => 'AAA', 'remarks' => ''),
//     array('name' => 'alice', 'date' => '2021/06/02', 'ticket_no' => 'AAB', 'remarks' => ''),
//     array('name' => 'tom', 'date' => '2021/06/03', 'ticket_no' => 'AAC', 'remarks' => ''),
//     array('name' => 'henry', 'date' => '2021/06/04', 'ticket_no' => 'AAD', 'remarks' => ''),
//     array('name' => 'kim', 'date' => '2021/06/05', 'ticket_no' => 'AAE', 'remarks' => ''),
//     array('name' => 'emily', 'date' => '2021/06/06', 'ticket_no' => 'AAF', 'remarks' => ''),
//     array('name' => 'sandy', 'date' => '2021/06/07', 'ticket_no' => 'AAG', 'remarks' => ''),

//     array('name' => 'bob', 'date' => '2021/06/01', 'ticket_no' => 'AAA', 'remarks' => ''),
//     array('name' => 'alice', 'date' => '2021/06/02', 'ticket_no' => 'AAB', 'remarks' => ''),
//     array('name' => 'tom', 'date' => '2021/06/03', 'ticket_no' => 'AAC', 'remarks' => ''),
//     array('name' => 'henry', 'date' => '2021/06/04', 'ticket_no' => 'AAD', 'remarks' => ''),
//     array('name' => 'kim', 'date' => '2021/06/05', 'ticket_no' => 'AAE', 'remarks' => ''),
//     array('name' => 'emily', 'date' => '2021/06/06', 'ticket_no' => 'AAF', 'remarks' => ''),
//     array('name' => 'sandy', 'date' => '2021/06/07', 'ticket_no' => 'AAG', 'remarks' => ''),

//     array('name' => 'bob', 'date' => '2021/06/01', 'ticket_no' => 'AAA', 'remarks' => ''),
//     array('name' => 'alice', 'date' => '2021/06/02', 'ticket_no' => 'AAB', 'remarks' => ''),
//     array('name' => 'tom', 'date' => '2021/06/03', 'ticket_no' => 'AAC', 'remarks' => ''),
//     array('name' => 'henry', 'date' => '2021/06/04', 'ticket_no' => 'AAD', 'remarks' => ''),
//     array('name' => 'kim', 'date' => '2021/06/05', 'ticket_no' => 'AAE', 'remarks' => ''),
//     array('name' => 'emily', 'date' => '2021/06/06', 'ticket_no' => 'AAF', 'remarks' => ''),
//     array('name' => 'sandy', 'date' => '2021/06/07', 'ticket_no' => 'AAG', 'remarks' => ''),

//     array('name' => 'bob', 'date' => '2021/06/01', 'ticket_no' => 'AAA', 'remarks' => ''),
//     array('name' => 'alice', 'date' => '2021/06/02', 'ticket_no' => 'AAB', 'remarks' => ''),
//     array('name' => 'tom', 'date' => '2021/06/03', 'ticket_no' => 'AAC', 'remarks' => ''),
//     array('name' => 'henry', 'date' => '2021/06/04', 'ticket_no' => 'AAD', 'remarks' => ''),
//     array('name' => 'kim', 'date' => '2021/06/05', 'ticket_no' => 'AAE', 'remarks' => ''),
//     array('name' => 'emily', 'date' => '2021/06/06', 'ticket_no' => 'AAF', 'remarks' => ''),
//     array('name' => 'sandy', 'date' => '2021/06/07', 'ticket_no' => 'AAG', 'remarks' => ''),

//     array('name' => 'bob', 'date' => '2021/06/01', 'ticket_no' => 'AAA', 'remarks' => ''),
//     array('name' => 'alice', 'date' => '2021/06/02', 'ticket_no' => 'AAB', 'remarks' => ''),
//     array('name' => 'tom', 'date' => '2021/06/03', 'ticket_no' => 'AAC', 'remarks' => ''),
//     array('name' => 'henry', 'date' => '2021/06/04', 'ticket_no' => 'AAD', 'remarks' => ''),
//     array('name' => 'kim', 'date' => '2021/06/05', 'ticket_no' => 'AAE', 'remarks' => ''),
//     array('name' => 'emily', 'date' => '2021/06/06', 'ticket_no' => 'AAF', 'remarks' => ''),
//     array('name' => 'sandy', 'date' => '2021/06/07', 'ticket_no' => 'AAG', 'remarks' => ''),
// );

$data_num = count($test_data);

$max_page = ceil($data_num / MAX);

if(!isset($_GET['page_id'])) {
    $now = 1;
} else {
    $now = $_GET['page_id'];
}

$start_no = ($now - 1) * MAX;

$disp_data = array_slice($test_data, $start_no, MAX, true);

echo "<table border='1'>";
echo "<thead>";
echo "<tr>";
echo "<th>名前</th>";
echo "<th>日付</th>";
echo "<th>チケット番号</th>";
echo "<th>備考</th>";
echo "</tr>";
echo "</thead>";

echo "<tbody>";
foreach ($disp_data as $val) {
    echo "<form action='update_testdata.php' method='post'>";
    echo "<tr>";
    echo "<td><input type='text' name='name' value='" . $val['name'] . "' readonly></td>";
    echo "<td><input type='text' name='receipt_date' value='" . $val['receipt_date'] . "'></td>";
    echo "<td><input type='text' name='ticket_no' value='" . $val['ticket'] . "'></td>";
    echo "<td><input type='text' name='remarks' value='" . $val['remarks'] . "'></td>";
    echo "<input type='hidden' name='page_no' value='" . $val['page_no'] . "'>";
    echo "<td><input type='submit' value='更新'></td>";
    echo "</tr>";
    echo "</form>";
}
echo "</tbody>";
echo "</table>";

// ページネーション
if ($max_page >= 4) { // ページ数が4以上の場合
    if ($now != 1 && $now != $max_page) {
        echo "<a href='/test.php?page_id=1'>1</a>" . '  ';
        if ($now - 3 >= 1) {
            echo "...  ";
        }
        if ($now - 1 != 1) {
            echo "<a href='/test.php?page_id=" . ($now-1) . "'>" . ($now-1) . "</a>" . '  ';
        }
        echo $now . '  ';
        if ($now + 1 != $max_page) {
            echo "<a href='/test.php?page_id=" . ($now+1) . "'>" . ($now+1) . "</a>" . '  ';
        }
        if ($now + 3 <= $max_page) {
            echo "...  ";
        }
        echo "<a href='/test.php?page_id=" . $max_page . "'>" . $max_page . "</a>" . '  ';
    } else if ($now == 1) {
        echo '1  ';
        echo "<a href='/test.php?page_id=2'>2</a>" . '  ';
        echo "...  ";
        echo "<a href='/test.php?page_id=" . $max_page . "'>" . $max_page . "</a>" . '  ';
    } else if ($now == $max_page) {
        echo "<a href='/test.php?page_id=1'>1</a>" . '  ';
        echo "...  ";
        echo "<a href='/test.php?page_id=" . ($max_page-1) . "'>" . ($max_page-1) . "</a>" . '  ';
        echo $max_page . '  ';
    }
} else { // ページ数が3以下の場合
    for($i = 1; $i <= $max_page; $i++) {
        if($i == $now) {
            echo $now . '  ';
        } else {
            echo "<a href='/test.php?page_id=" . $i . "'>" . $i . "</a>" . '  ';
        }
    }
}

echo "<form action='#' method='post'>";
echo "<p><input type='submit' value='ページ追加'></p>";
echo "</form>";

echo "<form action='#' method='post'>";
echo "<p><input type='submit' value='ページ削除'></p>";
echo "</form>";

echo "<form action='add_testdata.php' method='post'>";
echo "<p><input type='submit' value='テストデータ追加'></p>";
echo "</form>";

echo "<form action='show_testdata.php' method='post'>";
echo "<p><input type='submit' value='テストデータ参照'></p>";
echo "</form>";
