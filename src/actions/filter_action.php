<?php
include_once "../database/pet_queries.php";


// $error = false;

$error = getAllAnimals();

// if ($_SESSION['csrf'] !== $_POST['csrf']) {
//     $error = true;
// }
// else if(isset($_SESSION['user']) && check_pet($_POST['petId'])){
//     if(!check_pet_user_association($_SESSION['user'],$_POST['petId'])){
//         add_pet_favourite($_SESSION['user'],$_POST['petId']);
//     }
//     else{
//         remove_pet_favourite($_SESSION['user'],$_POST['petId']);
//     }
// }
// else{
//     $error = true;
// }
echo json_encode($error);
