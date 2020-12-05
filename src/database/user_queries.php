<?php
include_once('database/connection.php');

function getName(){
    if(isset($_SESSION['user'])){
        global $dbh;
        $stmt = $dbh->prepare('SELECT userId, Name, EmailAddress from Users Where userName=?');
        $stmt->execute(array($_SESSION['user']));
        $user = $stmt->fetchAll()[0];
        $_COOKIE['name']=$user['Name'];
        $_COOKIE['email']=$user['EmailAddress'];
        $_SESSION['userID']=$user['userId'];
    }
}

function getUser($user){
    global $dbh;
    $stmt = $dbh->prepare('SELECT userId, Name, EmailAddress from Users Where userName=?');
    $stmt->execute(array($user));
    return  $stmt->fetchAll()[0];
}

function getPicturePath($user){
    global $dbh;
    $stmt = $dbh->prepare('SELECT picturePath from Users Where userName=?');
    $stmt->execute(array($user));
    return $stmt->fetchAll()[0]['picturePath'];
}

function getUserAnimals($userId){
    global $dbh;
    $stmt = $dbh->prepare('SELECT petId,name,size,color,location from Pets WHERE user=?');
    $stmt->execute(array($userId));
    return $stmt->fetchAll();
}


function get_user_by_ID($userId){
    global $dbh;
    $stmt = $dbh->prepare('SELECT * from Users Where userId=?');
    $stmt->execute(array($userId));
    return $stmt->fetchAll()[0];
}