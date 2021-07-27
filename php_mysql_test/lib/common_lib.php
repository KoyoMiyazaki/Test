<?php
namespace common_lib;

function flash($type, $message)
{
    // global $flash;
    @session_start();
    $_SESSION['flash'][$type] = $message;
    session_write_close();
    $flash[$type] = $message;

}