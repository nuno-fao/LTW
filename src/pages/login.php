<?php
include_once('../templates/tpl_common.php');
include_once('../templates/tpl_login.php');
include_once("security_functions.php");
session_start();
if (!isset($_SESSION['csrf'])) {
    $_SESSION['csrf'] = generate_random_token();
}

if(!isset($_SESSION['user'])){
    draw_head("Login");
    echo '<script src="../js/utils.js" defer></script>';
    echo '<script src="../js/login.js" defer></script>';
    $location = '<a href="main.php">main </a> > <a href="login.php"> login</a>';
    draw_header($location);
    draw_login();
    draw_footer();
}
else{
    header('Location: ' . 'user.php?user='.$_SESSION['user']);
}