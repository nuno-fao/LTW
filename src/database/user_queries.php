<?php
include_once('../database/connection.php');


function get_name(){
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

function get_user($user_name){
    global $dbh;
    $stmt = $dbh->prepare('SELECT * from Users Where userName=?');
    $stmt->execute(array($user_name));
    return  $stmt->fetchAll()[0];
}

function get_picture_path($user_name){
    global $dbh;
    $stmt = $dbh->prepare('SELECT picturePath from Users Where userName=?');
    $stmt->execute(array($user_name));
    return $stmt->fetchAll()[0]['picturePath'];
}

function get_user_animals($user_id){
    global $dbh;
    $stmt = $dbh->prepare('SELECT petId,name,size,color,location,state from Pets WHERE user=?');
    $stmt->execute(array($user_id));
    return $stmt->fetchAll();
}

function get_user_favourite_animals($username){
    global $dbh;
    $stmt = $dbh->prepare('select name,species,size,color,location,state,profilePic,pet,userName,user from Pets inner join (select user as f_user, pet from Favourites where user = ?) on pet = petId inner join (select userName,userId from Users) on userId = user;');
    $stmt->execute(array($username));
    return $stmt->fetchAll();
}


function get_user_by_ID($user_id){
    global $dbh;
    $stmt = $dbh->prepare('SELECT * from Users Where userId=?');
    $stmt->execute(array($user_id));
    return $stmt->fetchAll()[0];
}

function edit_user($user_name, $name, $email){
    global $dbh;
    $stmt = $dbh->prepare('UPDATE Users SET Name = ?,EmailAddress = ?,userName = ? WHERE userName = ?;');
    $stmt->execute(array($name,$email,$user_name,$_SESSION['user']));
}

function get_proposals($user_id, $pet_id){
    global $dbh;
    $stmt = $dbh->prepare('SELECT * from Proposals Where user=? and pet=?');
    $stmt->execute(array($user_id,$pet_id));
    $out = $stmt->fetchAll();
    if(count($out)==0)
        return null;
    return $out;
}

function get_proposals_for_pet($pet_id){
    global $dbh;
    $stmt = $dbh->prepare('SELECT * from Proposals Where pet=?');
    $stmt->execute(array($pet_id));
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

function get_proposals_for_user($user_id){
    global $dbh;
    $stmt = $dbh->prepare('SELECT * from Proposals Where user=?');
    $stmt->execute(array($user_id));
    $out = $stmt->fetchAll();
    if(count($out)==0)
        return null;
    return $out;
}

function get_questions_participated($user_id){
    global $dbh;
    $stmt = $dbh->prepare('SELECT DISTINCT questionId, questionTxt, pet FROM Questions LEFT JOIN Answers ON Answers.question = Questions.questionId WHERE Questions.user = ? OR Answers.author = ? ');
    $stmt->execute(array($user_id,$user_id));
    $out = $stmt->fetchAll();
    if(count($out)==0)
        return null;
    return $out;
}
