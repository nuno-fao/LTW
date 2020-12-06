<?php
include_once('templates/tpl_common.php');
include_once('templates/tpl_register.php');

session_start();

if(!isset($_SESSION['user'])){
    draw_head("Register");
    draw_header();
    draw_register();
    draw_footer();
}
else{
    header('Location: ' . 'user.php?user='.$_SESSION['user']);
}