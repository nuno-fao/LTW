<?php
include_once "database/animal_queries.php";
session_start();

if(isset($_SESSION['user']) && check_pet($_POST['petId'])){
    if(!check_pet_user_association($_SESSION['user'],$_POST['petId'])){
        add_pet_favourite($_SESSION['user'],$_POST['petId']);
    }
    else{
        remove_pet_favourite($_SESSION['user'],$_POST['petId']);
    }
    header('Location: ' . 'animal_profile.php?pet_id='.$_POST['petId']);
}
else{
    header('Location: ' . 'index.php');
}
