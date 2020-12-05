<?php
    include_once('templates/tpl_common.php');
    include_once('templates/tpl_animal_profile.php');

    session_start();

    draw_head();
    draw_header();
    draw_animal_aside($_GET['pet_id']);
    draw_footer();

?>