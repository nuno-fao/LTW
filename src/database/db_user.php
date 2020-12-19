<?php
include_once('../database/connection.php');

/**
 * @param $user user_name
 * @return return true if the user is already on the database
 */
function checkUser($user) {
    global $dbh;

    $stmt = $dbh->prepare('SELECT * FROM Users WHERE userName = ?');
    $stmt->execute(array($user));
    $length = count($stmt->fetchAll());
    return $length>0;
}

/**
 * @param $user username
 * @param $password
 * @return true if the the password matches the $user password
 */
function checkPassword($user, $password) {
    global $dbh;
    $stmt = $dbh->prepare('SELECT userName,password FROM Users WHERE userName = ?');
    $stmt->execute(array($user));
    $result = $stmt->fetchAll();
    if(count($result)>0)
        return password_verify($password,$result[0]['password']);
    else return false;
}

/**
 * @param $user user_name
 * @param $password  user plain text password
 * @param $email user email
 * @param $name user name
 */
function addUser($user, $password, $email, $name){
    global $dbh;
    $password = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $dbh->prepare('INSERT INTO Users(userName, password,Name, EmailAddress) VALUES(?,?,?,?)');
    $stmt->execute(array($user,$password,$name,$email));
}


/**
 * @param $user user_name
 * @param $newpass user new password(plain text)
 */
function editPassword($user, $newpass){
    global $dbh;
    $password = password_hash($newpass, PASSWORD_DEFAULT);
    $stmt = $dbh->prepare('UPDATE Users SET password = ? WHERE userName = ?');
    $stmt->execute(array($password,$user));
}