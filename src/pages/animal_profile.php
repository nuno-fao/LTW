<?php
include_once('../templates/tpl_common.php');
include_once('../templates/tpl_animal_profile.php');
include_once('../database/pet_queries.php');
include_once('../templates/tpl_proposals.php');
include_once("security_functions.php");

session_start();
if (!isset($_SESSION['csrf'])) {
    $_SESSION['csrf'] = generate_random_token();
}

if(isset($_GET['pet_id']) && check_pet($_GET['pet_id'])) {
    echo '<script src="../js/utils.js" defer></script>';
    echo '<script src="../js/favourites.js" defer></script>';
    echo '<script src="../js/reply.js" defer></script>';
    echo '<input type="hidden" id="csrf" value='.$_SESSION['csrf'].'>';
    $animal_data = get_animal_data($_GET['pet_id']);
    draw_head($animal_data['name']." Page");
    draw_header();
    echo "<section id='animal_profile_body'>";
    draw_animal_aside($_GET['pet_id']);
    draw_animal_profile($_GET['pet_id']);
    draw_animal_comments($_GET['pet_id']);

    $user_name = get_user_by_ID($animal_data['user'])['userName'];

    if(isset($_SESSION['user'])) {
        if ($user_name == $_SESSION['user']) {
            draw_proposals(null, $animal_data['petId']);
        } else {
            draw_proposals($_SESSION['user'], $animal_data['petId']);
        }
    }
    echo '</section>';
    draw_footer();
}
else{
    header('Location: ' . '../index.php');
}

?>