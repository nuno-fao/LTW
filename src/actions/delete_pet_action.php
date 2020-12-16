<?php
include_once "../database/db_user.php";
include_once('../database/user_queries.php');
include_once('../database/pet_queries.php');
include_once("../pages/security_functions.php");
session_start();

/*ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);*/

if (!isset($_SESSION['csrf'])) {
    $_SESSION['csrf'] = generate_random_token();
}

if($_SESSION['csrf'] == $_POST['csrf']) {
    if (isset($_SESSION['user']) && strlen($_SESSION['user']) > 0) {
        if (isset($_POST['pet_id'])) {
            $pet = get_animal_data($_POST['pet_id']);
            $user = getUser($_SESSION['user']);
            if ($pet['user'] == $user['userId']) {
                $photos_paths = get_animal_photos($pet['petId']);
                foreach ($photos_paths as $photo_path){
                    unlink($photo_path['path']);
                }
                remove_pet($pet['petId']);
            }
        }
    }
}
header('Location: ' . '../index.php');
