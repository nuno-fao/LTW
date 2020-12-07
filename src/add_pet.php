<?php
include_once('templates/tpl_common.php');
include_once ("templates/tpl_add_pet.php");

session_start();
draw_head("Add Pet");
draw_header();
if(isset($_SESSION['user'])){
    draw_add_pet();
}
else{
    header('Location: ' . 'login.php');
}
draw_footer();
?>
