<?php
include_once('templates/tpl_common.php');
include_once('templates/tpl_login.php');

session_start();

if(!isset($_SESSION['user'])){
    draw_head();
    draw_header();
    draw_login();
    draw_footer();
}
else{
    header('Location: ' . 'user.php?user='.$_SESSION['user']);
}