<?php
include_once('../templates/tpl_common.php');
include_once('../database/user_queries.php');
include_once('../templates/tpl_user_profile.php');
include_once('../database/db_user.php');
include_once('../templates/tpl_proposals.php');
include_once("security_functions.php");

session_start();
if (!isset($_SESSION['csrf'])) {
    $_SESSION['csrf'] = generate_random_token();
}

if(isset($_GET['user']) && checkUser($_GET['user']) ) {
    echo '<script src="../js/utils.js" defer></script>';
    echo '<input type="hidden" id="csrf" value='.$_SESSION['csrf'].'>';
    draw_head($_GET['user']." Page");
    draw_header();
    draw_user_aside($_GET['user']);
    draw_footer();
}
else {
    echo  "User Not Found";
}
?>
