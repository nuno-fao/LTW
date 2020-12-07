<?php
include_once('templates/tpl_common.php');
include_once('templates/tpl_login.php');

session_start();

if(!isset($_SESSION['user'])){
    draw_head("Login");
    draw_header();
    draw_login();
    draw_footer();
    ?>
    login: nunation<br>
    password: 12345678<br>
    <?php
}
else{
    header('Location: ' . 'user.php?user='.$_SESSION['user']);
}