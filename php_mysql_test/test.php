<?php
function flash($type, $message)
{
    global $flash;
    $_SESSION['flash'][$type] = $message;
    $flash[$type] = $message;
}
?>

<?php
 
@session_start();
$flash = isset($_SESSION['flash']) ? $_SESSION['flash'] : array();
unset($_SESSION['flash']);

flash('error', 'ログインエラーですね！ もう一度お試しください。');

foreach(array('default', 'error', 'warning') as $key) {
    if(strlen(@$flash[$key])){
        ?>
            <div class="flash flash-<?php echo $key ?>">
                <?php echo $flash[$key] ?>
            </div>
        <?php
    }
}

