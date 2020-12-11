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
    draw_header();
    draw_register();
    echo '</div>';
    draw_footer();
}
else{
    header('Location: ' . 'user.php?user='.$_SESSION['user']);
}