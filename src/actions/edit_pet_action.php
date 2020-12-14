<?php
include_once "../database/db_user.php";
include_once('../database/user_queries.php');
include_once("../pages/security_functions.php");
session_start();
if (!isset($_SESSION['csrf'])) {
    $_SESSION['csrf'] = generate_random_token();
}
class register_error{
    public $name = false;
    public $size = false;
    public $color = false;
    public $safety_error = false;
    public $location = false;
    public $state = false;

    function get_error($name,$size,$color,$location,$safety,$state){
        $this->name = $name;
        $this->size = $size;
        $this->color = $color;
        $this->location = $location;
        $this->safety_error = $safety;
        $this->state = $state;
    }
    function has_error(){
        return $this->name || $this->size || $this->color || $this->location || $this->safety_error || $this->state;
    }
}

$error = new register_error();

$error->get_error(
    !isset($_POST['name']) || strlen($_POST['name']) == 0,
    !isset($_POST['size']) || strlen($_POST['size']) == 0,
    !isset($_POST['color']) || strlen($_POST['color']) == 0,
    !isset($_POST['location']) || strlen($_POST['location']) == 0,
    !isset($_POST['csrf']) || strlen($_POST['csrf']) == 0,
    !isset($_POST['state']) || strlen($_POST['state']) == 0
);

if(!isset($_SESSION['user'])){
    $error = true;
}
if ( !preg_match ("/^[a-zA-Z0-9_-]+$/", $_POST['name'])) {
    $error->name = true;
}
if ( !preg_match ("/^[a-zA-Z@.0-9_-]+$/", $_POST['e_address'])) {
    $error->email = true;
}
if ( !preg_match("/^[a-zA-Z\s-]+$/", $_POST['name'])) {
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
