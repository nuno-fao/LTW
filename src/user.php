<?php
    include_once('templates/tpl_common.php');
    include_once('database/user_queries.php');
    include_once('templates/tpl_user_profile.php');

    session_start();

    draw_head();
    draw_header();
    draw_user_aside();
    draw_footer();
?>
