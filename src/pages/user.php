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
    $location = '<a href="main.php">main </a> > <a href="user.php?user='.$_GET["user"].'"> user_profile</a>';
    draw_header($location);
    echo '<div class="user_page">';
    draw_user_aside($_GET['user']);
    echo '</div>';
    draw_footer();
}
else {
    header('Location: ' . '../index.php');
}
?>
