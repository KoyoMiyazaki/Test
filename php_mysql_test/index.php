<?php
namespace Userland {
    use PDO;
    define('MAX', '7');
    
    // 関数定義
    function print_table_header()
    {
        echo "<th>名前</th>";
        echo "<th>日付</th>";
        echo "<th>クラス</th>";
        echo "<th>チケット番号</th>";
        echo "<th>備考</th>";
    }
    
    function print_table_body($name, $receipt_date, $class, $ticket, $remarks, $readonly)
    {
        echo "<td><input type='text' name='name' value='" . $name . "' readonly></td>";
        if ($readonly == true) {
            echo "<td><input type='text' name='receipt_date' value='" . $receipt_date . "' readonly></td>";
            echo "<td><input type='text' name='class' value='" . $class . "' readonly></td>";
            echo "<td><input type='text' name='ticket' value='" . $ticket . "' readonly></td>";
            echo "<td><input type='text' name='remarks' value='" . $remarks . "' readonly></td>";
        } else {
            echo "<td><input type='text' name='receipt_date' value='" . $receipt_date . "'></td>";
            echo "<td>";
            echo "<select name='class'>";
            echo "<option value=''></option>";
            echo "<option value='A'>A</option>";
            echo "<option value='B'>B</option>";
            echo "<option value='C'>C</option>";
            echo "</select>";
            echo "</td>";
            echo "<td><input type='text' name='ticket' value='" . $ticket . "'></td>";
            echo "<td><input type='text' name='remarks' value='" . $remarks . "'></td>";
        }
    }
    
    try {
        $dsn = "mysql:host=mysql;dbname=sample;";
        $db = new PDO($dsn, 'root', 'pass');
    
        // 最大ページ数を取得
        $sql = "SELECT max(page_no) as max_page_no FROM data_table ;";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        // data_tableよりデータを取得
        $sql = "SELECT * FROM data_table WHERE page_no = :page_no;";
        $test_data = array();
        $stmt = $db->prepare($sql);
        for($i = 1, $max = intval($result[0]["max_page_no"]); $i <= $max; $i++) {
            $params = array(':page_no' => $i);
            $stmt->execute($params);
            array_push($test_data, $stmt->fetchAll(PDO::FETCH_ASSOC));
        }
    
    } catch (PDOException $e) {
        echo $e->getMessage();
        exit;
    }
    
    $data_num = count($test_data) * count($test_data[0]);
    $max_page = ceil($data_num / MAX);
    
    if(!isset($_GET['page'])) {
        $now_page = 1;
    } else {
        $now_page = $_GET['page'];
    }
    
    $start_no = $now_page - 1;
    $disp_data = $test_data[$start_no];
    
    // --- POST テスト ここから ---
    if (count($_POST) != 0) {
        echo "<h2>登録欄</h2>";
        echo "<table border='1'>";
        echo "<thead>";
        echo "<tr>";
        print_table_header();
        echo "</tr>";
        echo "</thead>";
    
        echo "<tbody>";
        echo "<form action='update_record.php' method='post'>";
        echo "<tr>";
        print_table_body($_POST['name'], $_POST['receipt_date'], $_POST['class'], $_POST['ticket'], $_POST['remarks'], false);
        echo "<input type='hidden' name='page_no' value='" . $_POST['page_no'] . "'>";
        echo "<td><button id='register-button' type='submit'>登録する</button></td>";
        echo "</tr>";
        echo "</form>";
        echo "</tbody>";
        echo "</table>";
    }
    
    // データをテーブル形式で表示する
    echo "<h2>登録情報一覧</h2>";
    echo "<table border='1'>";
    echo "<thead>";
    echo "<tr>";
    print_table_header();
    echo "</tr>";
    echo "</thead>";
    
    echo "<tbody>";
    foreach ($disp_data as $val) {
        echo "<form action='index.php?page=" . $now_page . "' method='post'>";
        if (count($_POST) != 0 && $_POST['name'] == $val['name']) {
            echo "<tr bgcolor='yellow'>";
        } else {
            echo "<tr>";
        }
        print_table_body($val['name'], $val['receipt_date'], $val['class'], $val['ticket'], $val['remarks'], true);
        echo "<td><input type='submit' value='更新する'></td>";
        echo "<input type='hidden' name='page_no' value='" . $val['page_no'] . "'>";
        echo "</tr>";
        echo "</form>";
    }
    echo "</tbody>";
    echo "</table>";
    
    // ページネーション
    if ($max_page >= 4) { // ページ数が4以上の場合
        if ($now_page != 1 && $now_page != $max_page) {
            echo "<a href='/index.php?page=1'>1</a>" . "  ";
            if ($now_page - 3 >= 1) {
                echo "<span>...  </span>";
            }
            if ($now_page - 1 != 1) {
                echo "<a href='/index.php?page=" . ($now_page-1) . "'>" . ($now_page-1) . "</a>" . "  ";
            }
            echo "<span id='now-page'>" . $now_page . "  </span>";
            if ($now_page + 1 != $max_page) {
                echo "<a href='/index.php?page=" . ($now_page+1) . "'>" . ($now_page+1) . "</a>" . "  ";
            }
            if ($now_page + 3 <= $max_page) {
                echo "<span>...  </span>";
            }
            echo "<a href='/index.php?page=" . $max_page . "'>" . $max_page . "</a>" . "  ";
        } else if ($now_page == 1) {
            echo "<span id='now-page'>1  </span>";
            echo "<a href='/index.php?page=2'>2</a>" . "  ";
            echo "<span>...  </span>";
            echo "<a href='/index.php?page=" . $max_page . "'>" . $max_page . "</a>" . "  ";
        } else if ($now_page == $max_page) {
            echo "<a href='/index.php?page=1'>1</a>" . "  ";
            echo "<span>...  </span>";
            echo "<a href='/index.php?page=" . ($max_page-1) . "'>" . ($max_page-1) . "</a>" . "  ";
            echo "<span id='now-page'>" . $max_page . "  </span>";
        }
    } else { // ページ数が3以下の場合
        for($i = 1; $i <= $max_page; $i++) {
            if($i == $now_page) {
                echo "<span id='now-page'>" . $now_page . "  </span>";
            } else {
                echo "<a href='/index.php?page=" . $i . "'>" . $i . "</a>" . "  ";
            }
        }
    }
    
    echo "<form action='add_record.php' method='post'>";
    echo "<p><input type='submit' value='ページ追加'></p>";
    echo "</form>";
    
    echo "<form action='remove_record.php' method='post'>";
    echo "<p><button id='remove-button' type='submit'>ページ削除</button></p>";
    echo "<input type='hidden' name='page_no' value='" . $now_page . "'>";
    echo "</form>";
    
    echo "<form action='add_testdata.php' method='post'>";
    echo "<p><input type='submit' value='テストデータ追加'></p>";
    echo "</form>";
    
    echo "<form action='show_testdata.php' method='post'>";
    echo "<p><input type='submit' value='テストデータ参照'></p>";
    echo "</form>";
    
    echo "<form action='show_userdata.php' method='post'>";
    echo "<p><input type='submit' value='ユーザデータ参照'></p>";
    echo "</form>";
}

?>