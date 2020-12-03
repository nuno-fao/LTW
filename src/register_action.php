<?php
include_once "database/db_user.php";

session_start();

$NAME = $_POST['name'];
$PASSWORD = $_POST['pass'];
print_r($NAME);
echo '<br>';
print_r($PASSWORD);
if (!isset($NAME) || !isset($PASSWORD)) {
    header('Location: ' . '../register.php');
}
else if (!checkUser($NAME)) {
    addUser($NAME, $PASSWORD);
    include_once "login_action.php";
}
else {
    header('Location: ' . '../register.php');
}
