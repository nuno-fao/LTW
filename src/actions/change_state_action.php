<?php
include_once('../database/pet_queries.php');

session_start();


$error = false;
include_once "../database/db_user.php";

if (!isset($_POST['csrf']) || $_SESSION['csrf'] !== $_POST['csrf']) {
    $error = true;
}

else if (!isset($_POST['petId']) ||  !isset($_POST['new_state']) ) {
    $error = true;
}
else if(strlen($_POST['petId']) <=0 ||  strlen($_POST['new_state'])<=0){
    $error->pass = true;
}
else if(check_pet($_POST['petId'])){
    
    update_state($_POST['petId'],$_POST['new_state']);
    header('Location: ' . '../pages/animal_profile.php?pet_id=' . $_POST['petId']);
}

if($error){
    header('Location: ' . '../index.php');
}