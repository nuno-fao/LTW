<?php
include_once('../database/connection.php');

function checkUser($user) {
    global $dbh;

    $stmt = $dbh->prepare('SELECT * FROM Users WHERE userName = ?');
    $stmt->execute(array($user));
    $length = count($stmt->fetchAll());
    return $length>0;
}

function checkPassword($user,$password) {
    global $dbh;
    $stmt = $dbh->prepare('SELECT userName,password FROM Users WHERE userName = ?');
    $stmt->execute(array($user));
    $result = $stmt->fetchAll();
    if(count($result)>0)
        return password_verify($password,$result[0]['password']);
    else return false;
}

function addUser($user,$password,$email,$name){
    global $dbh;
    $password = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $dbh->prepare('INSERT INTO Users(userName, password,Name, EmailAddress) VALUES(?,?,?,?)');
    $stmt->execute(array($user,$password,$name,$email));
}

function editPassword($user,$newpass){
    global $dbh;
    $password = password_hash($newpass, PASSWORD_DEFAULT);
    $stmt = $dbh->prepare('UPDATE Users SET password = ? WHERE userName = ?');
    $stmt->execute(array($password,$user));
}