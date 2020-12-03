<?php
    include_once('templates/tpl_common.php');
    include_once('database/user_queries.php');
    include_once('templates/tpl_user_profile.php');

    if(isset($_GET['user'])) {
        session_start();
        draw_head();
        draw_header();
        draw_user_aside($_GET['user']);
        draw_footer();
    }
    else {
       echo  "User Not Found";
}
?>
