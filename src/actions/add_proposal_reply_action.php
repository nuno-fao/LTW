<?php
include_once "../database/pet_queries.php";
include_once "../database/user_queries.php";

session_start();

$error = false;

if ($_SESSION['csrf'] !== $_POST['csrf']) {
    $error = true;
}
else if(accepted_proposals($_POST['petId']) > 0 && $_POST['reply']=="a"){
    $error = true;
}
else if(isset($_SESSION['user']) && check_pet($_POST['petId'])){
    $pet = get_animal_data($_POST['petId']);
    $user = getUser($_SESSION['user']);
    if($_POST['reply']=="a"){
        set_proposal_state($pet['petId'],$_POST['proposal_id'],1);
    }
    else if($_POST['reply']=="r"){
        set_proposal_state($pet['petId'],$_POST['proposal_id'],2);
    }
    else{
        $error = true;
    }
}
else{
    $error = true;
}
echo json_encode($error);
