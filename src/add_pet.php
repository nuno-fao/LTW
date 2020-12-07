<?php
include_once('templates/tpl_common.php');
include_once ("templates/tpl_add_pet.php");
include_once ("security_functions.php");
session_start();
if (!isset($_SESSION['csrf'])) {
    $_SESSION['csrf'] = generate_random_token();
}

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
