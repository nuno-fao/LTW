<?php
include_once "../database/db_user.php";
include_once('../database/user_queries.php');
include_once("security_functions.php");
session_start();
if (!isset($_SESSION['csrf'])) {
    $_SESSION['csrf'] = generate_random_token();
}

$USER = $_POST['user'];
$EMAIL = $_POST['e_address'];
$NAME = $_POST['name'];

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

$error->get_error(!isset($USER) || strlen($USER) == 0 , !isset($PASSWORD) || strlen($PASSWORD) < 8 , !isset($EMAIL) || strlen($EMAIL) == 0 , !isset($NAME) || strlen($NAME) == 0);


if ( !preg_match ("/^[a-zA-Z0-9]+$/", $USER)) {
    $error->user = "invalid_user";
}
else if ( !preg_match ("/^[a-zA-Z@.0-9_-]+$/", $EMAIL)) {
    $error->email = true;
}
else if ( !preg_match ("/^[a-zA-Z\s-]+$/", $NAME)) {
    $error->name = true;
}
else if ($_SESSION['csrf'] !== $_POST['csrf']) {
    $error->safety_error = true;
}
else if ($error->has_error()) {

}
else if (!checkUser($USER)) {
    edit_user($USER,$EMAIL,$NAME);
    $_SESSION['user'] = $_POST['user'];
}
else {
    $error->user = "user_in_use";
}

echo json_encode($error);
