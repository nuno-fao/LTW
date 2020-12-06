<?php
include_once('templates/tpl_common.php');
include_once('templates/tpl_animal_profile.php');

session_start();

if(isset($_GET['pet_id'])) {

    draw_head(get_animal_data($_GET['pet_id'])['name']." Page");
    draw_header();
    draw_animal_aside($_GET['pet_id']);
    draw_footer();
}

?>