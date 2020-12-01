<?php
include_once('database/connection.php');

function getAnimals($name,$species,$size,$color,$location,$state,$user){
    $name_sql = '(? or True)';
    $species_sql = '(? or True)';
    $size_sql = '(? or True)';
    $color_sql = '(? or True)';
    $location_sql = '(? or True)';
    $state_sql = '(? or True)';
    $user_sql = '(? or True)';
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
        where '.$name_sql.' and '.$size_sql.' and '.$color_sql.' and '.$location_sql.' and '.$user_sql);
    $stmt->execute(array($name,$size,$color,$location,$user));
    return $stmt->fetchAll();
}

function get_animal_photo($petId){
    global $dbh;
    $stmt = $dbh->prepare('SELECT path from Photos where pet = ?');
    $stmt->execute(array($petId));
    return $stmt->fetchAll()[0]["path"];
}
