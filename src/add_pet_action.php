<?php
include_once "database/animal_queries.php";
include_once "database/user_queries.php";
session_start();

if(isset($_POST['submit']) && isset($_SESSION['user']) ) {
    $user = 0;
    try {
        $specie = get_specie_id($_POST['species']);
        $user = getUser($_SESSION['user'])['userId'];
        $color = get_color_id($_POST['color']);
        $error = add_pet($_POST['name'],$specie, $_POST['size'], $color, $_POST['location'], 1,$user , "nill");
        print_r($error);
    }
    catch (PDOException $er){
        print_r($er);
    }

    $pets = get_pet($_POST['name']);
    $petId = -1;
    print_r($pets);
    echo '<br>';
    foreach ($pets as $Pet){
        print_r(Array($Pet['user'],$user , $Pet['profilePic'],"nill"));
        echo '<br>';
        if($Pet['user']==$user && $Pet['profilePic']=="nill"){
            $petId =  $Pet['petId'];
            break;
        }
    }
    print_r($petId);
    echo '<br>';
    $check = getimagesize($_FILES["picture"]["tmp_name"]);
    if($check !== false) {

        $file_name ="img/pet_main_pic".$petId;
        if (move_uploaded_file($_FILES["picture"]["tmp_name"], $file_name)) {
            echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
            $photo_id = add_photo($file_name,$petId);
            change_photo_petid($petId,$photo_id);
            change_pet_photo_id($petId,$photo_id);
            header('Location: ' . 'index.php');
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}

