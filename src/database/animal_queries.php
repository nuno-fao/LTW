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
    $stmt = $dbh->prepare('SELECT path from Photos where pet = ? ORDER BY path DESC');
    $stmt->execute(array($petId));
    return $stmt->fetchAll()[0]["path"];
}

function get_species(){
    global $dbh;
    $stmt = $dbh->prepare('SELECT specie from Species ');
    $stmt->execute(array());
    return $stmt->fetchAll();
}