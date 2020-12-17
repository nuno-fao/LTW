<?php
include_once "../database/db_user.php";
include_once('../database/user_queries.php');
include_once("../pages/security_functions.php");
session_start();
if (!isset($_SESSION['csrf'])) {
    $_SESSION['csrf'] = generate_random_token();
}

class register_error{
    public $user = false;
    public $email = false;
    public $name = false;
    public $safety_error = false;

    function get_error($user,$email,$name){
        $this->user = $user;
        $this->email = $email;
        $this->name = $name;
    }
    function has_error(){
        return $this->user  || $this->email || $this->name;
    }
}

$error = new register_error();

$error->get_error(!isset($_POST['user']) || strlen($_POST['user']) == 0  , !isset($_POST['e_address']) || strlen($_POST['e_address']) == 0 , !isset($_POST['name']) || strlen($_POST['name']) == 0);

if(!isset($_SESSION['user'])){
    $error = true;
}
if ( !preg_match ("/^[a-z0-9_-]+$/", $_POST['user'])) {
    //$error->c = $_POST['user'];
    $error->user = true;
}
if ( !preg_match ("/^[a-zA-Z@.0-9_-]+$/", $_POST['e_address'])) {
    $error->email = true;
}
if ( !preg_match("/^[A-Za-zÀ-ÖØ-öø-ÿ\s-]+$/", $_POST['name'])) {
    $error->name = true;
}
if ($_SESSION['csrf'] !== $_POST['csrf']) {
    $error->safety_error = true;
    die(json_encode($error));
}
if ($error->has_error()) {

}
else if (($_POST['user'] == $_SESSION['user'])    ||    ($_POST['user'] != $_SESSION['user'] && !checkUser($_POST['user']))) {
    edit_user($_POST['user'],$_POST['name'],$_POST['e_address']);
    $_SESSION['user'] = $_POST['user'];
}
else {
    $error->user = true;
}

echo json_encode($error);
