<?php
include_once "database/animal_queries.php";
include_once "database/user_queries.php";
session_start();


class add_pet_error
{
    public $safety_error = false;
    public $main_pic = false;
    public $other_pics = false;
    public $name = false;
    public $size = false;
    public $date = false;
    public $species = false;
    public $color = false;
    public $location = false;
    public $query = false;

    function add_error($name,$size,$date,$species,$color,$location){
        $this->name = !$name;
        $this->size = !$size;
        $this->date = !$date;
        $this->species = !$species;
        $this->color = !$color;
        $this->location = !$location;
    }
    function has_error(){
        return $this->name || $this->size || $this->date || $this->species || $this->color || $this->location;
    }
}

$error = new add_pet_error();

if ($_SESSION['csrf'] !== $_POST['csrf']) {
    $error->safety_error = true;
}

else if(count($_FILES)==0){
    $error->main_pic = true;
}
else if(isset($_POST['submit']) && isset($_SESSION['user'])) {
    $user = 0;
    $error->add_error(strlen($_POST['name'])>0,strlen($_POST['size'] ) > 0 ,strlen($_POST['dateofbirth']) > 0 ,strlen($_POST['species']) > 0 , strlen($_POST['color']) > 0 ,strlen($_POST['location']) > 0);
    if(!$error->has_error()){
        print_r($error->size);
        $main_pic = get_animal_profile_pic();
        if($main_pic['name'] == null){
            $error->main_pic = true;
        }
        else{
            $error_on_query = true;
            try {
                $specie = get_specie_id($_POST['species']);
                $user = getUser($_SESSION['user'])['userId'];
                $color = get_color_id($_POST['color']);
                $name_stripped = preg_replace ("/[^a-zA-Z\s]/", '', $_POST['name']);
                $location_stripped = preg_replace ("/[^a-zA-Z\s]/", '', $_POST['location']);
                $size_stripped = preg_replace ("/[^a-zA-Z0-9\s]/", '', $_POST['size']);
                if(!is_numeric($size_stripped)){
                    $error->size = true;
                }
                else{
                    $error_on_query = add_pet($name_stripped, $specie, $size_stripped, $color, $location_stripped, 1, $user, "nill".$user);

                    $pet_id = get_last_pet_id($user,$name_stripped);
                    if($pet_id == -1)
                    {
                        print_r("oooo");
                        $error->query = true;
                    }

                    else if(!add_animal_photo($pet_id,$main_pic,true)){
                        $error->main_pic = false;
                    }
                    else {
                        foreach ($_FILES as $file) {
                            if (add_animal_photo($pet_id, $file, false)) {
                                $error->other_pics = true;
                                break;
                            }
                        }
                    }
                }
            } catch (PDOException $er) {
                print_r($er);
                $error->query = true;
            }
        }
    }
    else{
        $error->main_pic = true;
    }
}
echo json_encode($error);

function add_animal_photo($pet_id,$picture,$is_main){
    $check = getimagesize($picture["tmp_name"]);
    if ($check !== false) {
        $file_name = "img/pet_pic" . $pet_id.uniqid();
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

function get_last_pet_id($user,$pet){
    $pets = get_pet($pet);
    print_r($pets);
    foreach ($pets as $Pet) {
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