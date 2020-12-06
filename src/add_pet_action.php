<?php
include_once "database/animal_queries.php";
include_once "database/user_queries.php";
session_start();


if(isset($_POST['submit']) && isset($_SESSION['user'])) {
    $user = 0;
    if(strlen($_POST['name'])>0 && strlen($_POST['size'] )> 0 && strlen($_POST['dateofbirth']) > 0 && strlen($_POST['species']) > 0 && strlen($_POST['color']) > 0 && strlen($_POST['location']) > 0){
        $main_pic = get_animal_profile_pic();
        if($main_pic['name'] == null){
            header('Location: ' . 'add_pet.php');
            return;
        }
        try {
            $specie = get_specie_id($_POST['species']);
            $user = getUser($_SESSION['user'])['userId'];
            $color = get_color_id($_POST['color']);
            $error = add_pet($_POST['name'], $specie, $_POST['size'], $color, $_POST['location'], 1, $user, "nill".$user);
        } catch (PDOException $er) {
            header('Location: ' . 'add_pet.php');
            return;
        }
        $pet_id = get_last_pet_id($user);
        if($pet_id == -1)
        {
            header('Location: ' . 'add_pet.php');
            return;
        }

        if(!add_animal_photo($pet_id,$main_pic,true)){
            header('Location: ' . 'add_pet.php');
            return;
        }
        foreach ($_FILES as $file){
            if(add_animal_photo($pet_id,$file,false)){
                header('Location: ' . 'add_pet.php');
                return;
            }
        }
        header('Location: ' . 'index.php');
        return;
    }
    else{
        header('Location: ' . 'add_pet.php');
        return;
    }
}

function add_animal_photo($pet_id,$picture,$is_main){
    $check = getimagesize($picture["tmp_name"]);
    if ($check !== false) {
        $file_name = "img/pet_main_pic" . $pet_id;
        if (move_uploaded_file($picture["tmp_name"], $file_name)) {
            $photo_id = add_animal_photo_to_db($file_name, $pet_id);
            if($is_main) {
                change_pet_photo_id($pet_id, $photo_id);
            }
            return true;
        } else {
            return false;
        }
    }
    return false;
}

function get_last_pet_id($user){
    $pets = get_pet($_POST['name']);
    $petId = -1;
    foreach ($pets as $Pet) {
        print_r(array($Pet['user'], $user, $Pet['profilePic'], "nill"));
        echo '<br>';
        if ($Pet['user'] == $user && $Pet['profilePic'] == "nill".$user) {
            return $Pet['petId'];
        }
    }
    return -1;
}

function get_animal_profile_pic(){
    $photo = $_FILES['picture'];
    unset($_FILES['picture']);
    return $photo;
}