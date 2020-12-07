<?php
include_once('templates/tpl_common.php');
include_once('templates/tpl_animal_profile.php');
include_once('database/animal_queries.php');

//session_start();

if(isset($_GET['pet_id']) && check_pet($_GET['pet_id'])) {

    draw_head(get_animal_data($_GET['pet_id'])['name']." Page");
    draw_header();
    draw_animal_aside($_GET['pet_id']);
    draw_animal_profile($_GET['pet_id']);
    draw_footer();
}
else{
    header('Location: ' . 'index.php');
}

?>