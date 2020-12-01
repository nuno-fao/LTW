<?php
include_once "database/db_user.php";

session_start();

$NAME = $_POST['name'];
$PASSWORD = $_POST['pass'];
if (!isset($NAME) || !isset($PASSWORD)) {
    header('Location: ' . 'register.php');
}
else if (!checkUser($NAME)) {
    addUser($NAME, $PASSWORD);
    $_SESSION['name'] = $_POST['name'];
    header('Location: ' . 'index.php');
}
else {
    header('Location: ' . 'register.php');
}
