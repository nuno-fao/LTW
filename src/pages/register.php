<?php
include_once('../templates/tpl_common.php');
include_once('../templates/tpl_register.php');
include_once("security_functions.php");
session_start();
if (!isset($_SESSION['csrf'])) {
    $_SESSION['csrf'] = generate_random_token();
}

if(!isset($_SESSION['user'])){
    echo '<script src="../js/register.js" defer></script>';
    echo '<script src="../js/utils.js" defer></script>';
    draw_head("Register");
    $location = '<a href="main.php">main </a> > <a href="register.php"> register</a>';
    draw_header($location);
    draw_register();
    echo '</div>';
    draw_footer();
}
else{
    header('Location: ' . 'user.php?user='.$_SESSION['user']);
}