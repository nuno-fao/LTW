<?php
include('templates/tpl_common.php');
include('templates/tpl_register.php');

session_start();

draw_head();
draw_header();
draw_register();
draw_footer();
//login_register_action();