<?php
include_once('../templates/tpl_common.php');
include_once('../templates/tpl_main.php');
include_once("security_functions.php");
session_start();
if (!isset($_SESSION['csrf'])) {
    $_SESSION['csrf'] = generate_random_token();
}

draw_head("Main Page");
draw_header();
draw_aside();
draw_animal_profiles();
draw_footer();
?>
