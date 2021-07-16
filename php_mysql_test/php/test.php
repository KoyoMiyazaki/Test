<?php
define('MAX', '7');

$test_data = array(
    array('name' => 'bob', 'ticket_no' => 'AAA', 'remarks' => ''),
    array('name' => 'bob', 'ticket_no' => 'AAA', 'remarks' => ''),
);

$data_num = count($test_data);

$mas_page = ceil($data_num / MAX);

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
    echo "<tr>";
    echo "<td><input type='text' name='name' value='" . $val['name'] . "' readonly></td>";
    echo "<td><input type='text' name='date' value='" . $val['date'] . "'></td>";
    echo "<td><input type='text' name='ticket_no' value='" . $val['ticket_no'] . "'></td>";
    echo "<td><input type='text' name='remarks' value='" . $val['remarks'] . "'></td>";
    echo "</tr>";
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
        echo "<a href='/test.php?page_id=" . $now . "'>" . $now . "</a>" . '  ';
        if ($now + 1 != $max_page) {
            echo "<a href='/test.php?page_id=" . ($now+1) . "'>" . ($now+1) . "</a>" . '  ';
        }
        if ($now + 3 <= $max_page) {
            echo "...  ";
        }
        echo "<a href='/test.php?page_id=" . $max_page . "'>" . $max_page . "</a>" . '  ';
    } else if ($now == 1) {
        echo "<a href='/test.php?page_id=1'>1</a>" . '  ';
        echo "<a href='/test.php?page_id=2'>2</a>" . '  ';
        echo "...  ";
        echo "<a href='/test.php?page_id=" . $max_page . "'>" . $max_page . "</a>" . '  ';
    } else if ($now == $max_page) {
        echo "<a href='/test.php?page_id=1'>1</a>" . '  ';
        echo "...  ";
        echo "<a href='/test.php?page_id=" . ($max_page-1) . "'>" . ($max_page-1) . "</a>" . '  ';
        echo "<a href='/test.php?page_id=" . $max_page . "'>" . $max_page . "</a>" . '  ';
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