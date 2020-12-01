<?php
include_once('database/connection.php');

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
    return password_verify($password,$result[0]['password']);
}

function addUser($user,$password){
    global $dbh;
    $password = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $dbh->prepare('INSERT INTO Users(userName, password,Name, EmailAddress) VALUES(?,?,?,?)');
    $stmt->execute(array($user,$password,$user,$user));
}