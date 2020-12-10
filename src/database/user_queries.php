<?php
include_once('../database/connection.php');

ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(-1);

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

function getUser($username){
    global $dbh;
    $stmt = $dbh->prepare('SELECT * from Users Where userName=?');
    $stmt->execute(array($username));
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

function getUserFavouriteAnimals($username){
    global $dbh;
    $stmt = $dbh->prepare('select name,species,size,color,location,state,profilePic,pet,userName,user from Pets inner join (select user as f_user, pet from Favourites where user = ?) on pet = petId inner join (select userName,userId from Users) on userId = user;');
    $stmt->execute(array($username));
    return $stmt->fetchAll();
}


function get_user_by_ID($userId){
    global $dbh;
    $stmt = $dbh->prepare('SELECT * from Users Where userId=?');
    $stmt->execute(array($userId));
    return $stmt->fetchAll()[0];
}

function edit_user($user,$name,$email){
    global $dbh;
    $stmt = $dbh->prepare('UPDATE Users SET Name = ?,EmailAddress = ?,userName = ? WHERE userName = ?;');
    $stmt->execute(array($name,$email,$user,$_SESSION['user']));
}

function get_proposals($userId, $petId){
    global $dbh;
    $stmt = $dbh->prepare('SELECT * from Proposals Where user=? and pet=?');
    $stmt->execute(array($userId,$petId));
    $out = $stmt->fetchAll();
    if(count($out)==0)
        return null;
    return $out;
}

function get_proposals_for_pet($petId){
    global $dbh;
    $stmt = $dbh->prepare('SELECT * from Proposals Where pet=?');
    $stmt->execute(array($petId));
    $out = $stmt->fetchAll();
    if(count($out)==0)
        return null;
    return $out;
}

function add_proposal($user,$pet,$text){
    global $dbh;
    $stmt = $dbh->prepare('INSERT INTO Proposals(user, pet,text,state) VALUES(?,?,?,0)');
    return $stmt->execute(array($user,$pet,$text));
}


function set_proposal_state($pet,$proposal_id,$state){
    global $dbh;
    $stmt = $dbh->prepare('UPDATE Proposals SET state = ? WHERE pet=? and proposalId = ?;');
    $stmt->execute(array($state,$pet,$proposal_id));
}

function get_proposals_for_user($userId){
    global $dbh;
    $stmt = $dbh->prepare('SELECT * from Proposals Where user=?');
    $stmt->execute(array($userId));
    $out = $stmt->fetchAll();
    if(count($out)==0)
        return null;
    return $out;
}
