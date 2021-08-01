<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        require_once('./lib/database_lib.php');
        require_once('./lib/table_lib.php');

        define('MAX', '7');

        // function sort_by_primary($a, $b) {
        //     $user_order = $GLOBALS["user_order_list"];
        //     if ($user_order[$a["name"]] === $user_order[$b["name"]]) {
        //         return 0;
        //     }
        //     return ($user_order[$a["name"]] < $user_order[$b["name"]]) ? -1 : 1;
        // }

        global $user_order_list;
        $user_order_list = database_lib\get_user_order_list();
        
        $table_data = database_lib\get_table_data();
        $num_table_data = count($table_data) * count($table_data[0]);
        $max_page = ceil($num_table_data / MAX);
        $active_page = table_lib\get_active_page($table_data);

        if (!isset($_GET['page'])) {
            // $now_page = 1;
            $now_page = $active_page;
        } else {
            $now_page = intval($_GET['page']);
        }
        
        $start_page_no = $now_page - 1;
        $disp_data = $table_data[$start_page_no];

        echo "<h3>ソート前</h3>";
        foreach ($disp_data as $user) {
            echo "<p>" . $user["name"] . "</p>";
        }

        usort($disp_data, 'database_lib\sort_by_primary');

        echo "<h3>ソート後</h3>";
        foreach ($disp_data as $user) {
            echo "<p>" . $user["name"] . "</p>";
        }
    ?>
</body>
</html>