<?php
include_once('../database/user_queries.php');

ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(-1);

session_start();

class login_error{
    public $safety_error = false;
    public $pass=false;
    public $user=false;
}

$error = new login_error();
include_once "../database/db_user.php";

if (!isset($_POST['csrf']) || $_SESSION['csrf'] !== $_POST['csrf']) {
    $error->safety_error = true;
}

else if (!isset($_POST['name'])) {
    $error->user = true;
}
else if(!isset($_POST['pass'])){
    $error->pass = true;
}
else if(!checkUser($_POST['name'])){
    $error->user = true;
}
else if (!checkPassword($_POST['name'], $_POST['pass'])) {
    $error->pass = true;
}
else {
    session_regenerate_id(true);
    $_SESSION['user'] = $_POST['name'];
}
echo json_encode($error);