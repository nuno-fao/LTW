<?php
include_once "../database/pet_queries.php";
include_once "../database/user_queries.php";

session_start();

class edit_pet_reply
{
    public $safety_error = false;
    public $main_pic = false;
    public $other_pics = false;
    public $name = false;
    public $size = false;
    public $species = false;
    public $color = false;
    public $location = false;
    public $query = false;
    public $gender = false;
    public $pet_id = null;

    function edit_error($name,$size,$species,$color,$location,$gender){
        $this->name = !$name;
        $this->size = !$size;
        $this->species = !$species;
        $this->color = !$color;
        $this->location = !$location;
        $this->gender = !$gender;
    }
    function has_error(){
        return $this->name || $this->size|| $this->species || $this->color || $this->location;
    }
}

$reply = new edit_pet_reply();

$pet = get_pet_data($_POST['pet_id']);
$user = get_user($_SESSION['user']);
if ($pet['user'] != $user['userId']) {
    $reply->safety_error = true;
}
else if ($_SESSION['csrf'] !== $_POST['csrf']) {
    $reply->safety_error = true;
}
else if(isset($_POST['submit']) && isset($_SESSION['user'])) {

    $user = 0;
    $reply->edit_error(isset($_POST['name']),strlen($_POST['size'] ) > 0 ,strlen($_POST['species']) > 0 , strlen($_POST['color']) > 0 ,strlen($_POST['location']) > 0,strlen($_POST['gender']) > 0);
    if(!$reply->has_error()){
        $main_pic = get_animal_profile_pic();
        $error_on_query = true;
        try {
            $specie = get_specie_id($_POST['species']);
            $user = get_user($_SESSION['user'])['userId'];
            $color = get_color_id($_POST['color']);

            if (strlen($_POST['name'])>0 && !preg_match ("/^[A-Za-zÀ-ÖØ-öø-ÿ\s-]+$/", $_POST['name'])) {
                $reply->name = true;
            }
            else {
                $name_stripped = preg_replace ("/[^A-Za-zÀ-ÖØ-öø-ÿ\s-]/", '', $_POST['name']);
                $location_stripped = preg_replace ("/[^A-Za-zÀ-ÖØ-öø-ÿ\s()-]/", '', $_POST['location']);
                $size_stripped = preg_replace ("/[^0-9\s-]/", '', $_POST['size']);
                $gender = null;
                if($_POST['gender']=='female'){
                    $gender = 'f';
                }
                elseif ($_POST['gender'] == male){
                    $gender = 'm';
                }
                else{
                    echo json_encode($reply);
                    die();
                }
                $pet_id = null;
                if (!is_numeric($size_stripped)) {
                    $reply->size = true;
                } else {
                    $pet_id = $_POST['pet_id'];
                    $error_on_query = edit_pet($name_stripped, $specie, $size_stripped, $color, $location_stripped, 1,$gender,$pet_id);
                    if($main_pic)
                        edit_animal_photo($pet_id, $main_pic, true);
                    foreach ($_FILES as $file) {
                        if (!edit_animal_photo($pet_id, $file, false)) {
                            $reply->other_pics = true;
                            break;
                        }
                    }

                }
                $reply->pet_id = $pet_id;
            }
        } catch (PDOException $er) {
            print_r($er);
            $reply->query = true;
        }
    }
}
echo json_encode($reply);

function edit_animal_photo($pet_id,$picture,$is_main){
    //$check = getimagesize($picture["tmp_name"]);
    $photo = imagecreatefromjpeg($picture['tmp_name']);
    if($photo === false)
        $photo = imagecreatefrompng($picture['tmp_name']);
    if($photo === false)
        $photo = imagecreatefromgif($picture['tmp_name']);
    if ($photo === false)
        return false;


    $file_name = "../img/pet_pic" . $pet_id.uniqid();

    $width = imagesx($photo);
    $height = imagesy($photo);
    $square = min($width,$height);

    $pic  = imagecreatetruecolor(400,400);
    imagecopyresized(
        $pic,
        $photo,
        0,
        0,
        ($width>$square)?($width-$square)/2:0,
        ($height>$square)?($height-$square)/2:0,
        400,
        400,
        $square,
        $square);
    imagejpeg($pic,$file_name);

    $photo_id = add_pet_photo_to_db($file_name, $pet_id);
    if($is_main) {
        change_pet_photo_id($pet_id, $photo_id);
    }
    return true;
}

function get_last_pet_id($user,$pet){
    $pets = get_pet($pet);
    foreach ($pets as $Pet) {
        if ($Pet['user'] == $user && $Pet['profilePic'] == "nill".$user) {
            return $Pet['petId'];
        }
    }
    return -1;
}

function get_animal_profile_pic(){
    $photo = $_FILES['picture'];
    if($photo == null)
        return null;
    unset($_FILES['picture']);
    return $photo;
}