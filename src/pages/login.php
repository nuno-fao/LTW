<?php
include_once('../templates/tpl_common.php');
include_once('../templates/tpl_login.php');
include_once("security_functions.php");
session_start();
if (!isset($_SESSION['csrf'])) {
    $_SESSION['csrf'] = generate_random_token();
}

if(!isset($_SESSION['user'])){
    echo '<script src="../js/utils.js" defer></script>';
    echo '<script src="../js/login.js" defer></script>';
    draw_head("Login");
    draw_header();
    draw_login();
    echo '</div>';
    draw_footer();
    ?>
    login: default_user<br>
    password: 12345678<br>
    <?php
}
else{
    header('Location: ' . 'user.php?user='.$_SESSION['user']);
}