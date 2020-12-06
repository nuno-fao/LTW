<?php
include_once('templates/tpl_common.php');
include_once('database/user_queries.php');
include_once('templates/tpl_user_profile.php');
include_once('database/db_user.php');

session_start();

if(isset($_GET['user']) && checkUser($_GET['user']) ) {
    draw_head($_GET['user']." Page");
    draw_header();
    draw_user_aside($_GET['user']);
    draw_footer();
}
else {
    echo  "User Not Found";
}
?>
