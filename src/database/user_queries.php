<?php
include_once('database/connection.php');

function getName(){
    print_r($_SESSION);
    if(isset($_SESSION['user'])){
        global $dbh;
        $stmt = $dbh->prepare('SELECT userID, Name, EmailAddress from Users Where userName=?');
        $stmt->execute(array($_SESSION['user']));
        $user = $stmt->fetchAll()[0];
        $_COOKIE['name']=$user['Name'];
        $_COOKIE['email']=$user['EmailAddress'];
        $_SESSION['userID']=$user['userID'];
    }
}

function getPicturePath(){
    if(isset($_SESSION['user'])){
        global $dbh;
        $stmt = $dbh->prepare('SELECT picturePath from Users Where userName=?');
        $stmt->execute(array($_SESSION['user']));
        return $user = $stmt->fetchAll()[0]['picturePath'];
    }
}