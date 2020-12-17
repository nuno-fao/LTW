<?php
include_once('../templates/tpl_common.php');
include_once('../templates/tpl_edit_pet.php');
include_once("security_functions.php");
include_once '../database/pet_queries.php';


session_start();
if (!isset($_SESSION['csrf'])) {
    $_SESSION['csrf'] = generate_random_token();
}
if(isset($_POST['pet_id']) && check_pet($_POST['pet_id'])) {
    echo '<script src="../js/utils.js" defer></script>';
    echo '<script src="../js/edit_pet.js" defer></script>';
    echo '<input type="hidden" id="csrf" value='.$_SESSION['csrf'].'>';
    $animal_data = get_pet_data($_POST['pet_id']);
    draw_head($animal_data['name']." Edit Page");
    draw_header();
    draw_edit_pet($_POST['pet_id']);
    draw_footer();
}
else{
    header('Location: ' . '../index.php');
}

?>