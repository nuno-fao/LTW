<?php
include_once('database/connection.php');

function getAnimals($name,$species,$size,$color,$location,$state,$user,$first_elem,$length){
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    $name_sql = '((? is NULL) <> (NULL is not NULL))';
    $species_sql = '((? is NULL) <> (NULL is not NULL))';
    $size_sql = '((? is NULL) <> (NULL is not NULL))';
    $color_sql = '((? is NULL) <> (NULL is not NULL))';
    $location_sql = '((? is NULL) <> (NULL is not NULL))';
    $state_sql = '((? is NULL) <> (NULL is not NULL))';
    $user_sql = '((? is NULL) <> (NULL is not NULL))';
    if($name!=null){
        $name_sql = '(name = ?)';
    }
    if($size!=null){
        $size_sql = '(size = ?)';
    }
    if($color!=null){
        $color_sql = '(color = ?)';
    }
    if($location!=null){
        $location_sql = '(location = ?)';
    }
    global $dbh;
    $stmt = $dbh->prepare('SELECT petId,name,size,color,location,user from Pets 
        where '.$name_sql.' and '.$size_sql.' and '.$color_sql.' and '.$location_sql.' and '.$user_sql.' LIMIT ? OFFSET ?');
    $stmt->execute(array($name,$size,$color,$location,$user,$length,$first_elem));
    return $stmt->fetchAll();
}

function get_animal_photo($petId){
    global $dbh;
    $stmt = $dbh->prepare('SELECT path from Photos join Pets on Photos.photoId = Pets.profilePic where pet = ? ORDER BY path DESC');
    $stmt->execute(array($petId));
    return $stmt->fetchAll()[0]["path"];
}

function get_species(){
    global $dbh;
    $stmt = $dbh->prepare('SELECT specie from Species ');
    $stmt->execute(array());
    return $stmt->fetchAll();
}
function get_specie_id($specie){
    global $dbh;
    $stmt = $dbh->prepare('SELECT specieId from Species where specie=?');
    $stmt->execute(array($specie));
    return $stmt->fetchAll()[0]['specieId'];
}
function get_color_id($color){
    global $dbh;
    $stmt = $dbh->prepare('SELECT color from Colors where color=?');
    $stmt->execute(array($color));
    return $stmt->fetchAll()[0]['color'];
}

function get_colors(){
    global $dbh;
    $stmt = $dbh->prepare('SELECT color from Colors ');
    $stmt->execute(array());
    return $stmt->fetchAll();
}

function get_animal_data($animal){
    global $dbh;
    $stmt = $dbh->prepare('SELECT * from Pets where petId=?');
    $stmt->execute(array($animal));
    return $stmt->fetchAll()[0];
}

function get_animal_photos($animal){
    global $dbh;
    $stmt = $dbh->prepare('SELECT path from Photos where pet=?');
    $stmt->execute(array($animal));
    return $stmt->fetchAll();
}

function get_state_description($state){
    global $dbh;
    $stmt = $dbh->prepare('SELECT state from PetState where petStetId=?');
    $stmt->execute(array($state));
    return $stmt->fetchAll()[0];
}

function add_pet($name,$species,$size,$color,$location,$state,$user,$profilePic){
    global $dbh;
    $stmt = $dbh->prepare('INSERT INTO Pets(name, species,size, color,location,state,user,profilePic) VALUES(?,?,?,?,?,?,?,?)');
    return $stmt->execute(array($name,$species,$size,$color,$location,$state,$user,$profilePic));
}

function get_pet($name){
    global $dbh;
    $stmt = $dbh->prepare('SELECT * from Pets where name=?');
    $stmt->execute(array($name));
    return $stmt->fetchAll();
}

function add_photo($photo_path,$pet){
    global $dbh;
    $stmt = $dbh->prepare('INSERT INTO Photos(path,pet) VALUES(?,?)');
    $stmt->execute(array($photo_path,$pet));

    $stmt = $dbh->prepare('SELECT photoid from Photos where path=?');
    $stmt->execute(array($photo_path));
    return $stmt->fetchAll()[0]['photoId'];
}

function change_photo_petid($petId, $photo_id){
    global $dbh;
    print_r('UPDATE Photos SET pet = '.$petId.' WHERE photoId = '.$photo_id.';');
    echo '<br>';
    $stmt = $dbh->prepare('UPDATE Photos SET pet = ? WHERE photoId = ?;');
    return $stmt->execute(array($petId,$photo_id));
}

function change_pet_photo_id($petId, $photo_id){
    global $dbh;
    print_r('UPDATE Pets SET profilePic = '.$photo_id.' WHERE petId = '.$petId.';');
    echo '<br>';
    $stmt = $dbh->prepare('UPDATE Pets SET profilePic = ? WHERE petId = ?;');
    return $stmt->execute(array($photo_id,$petId));
}
