<?php
include_once "database/db_user.php";
include_once('database/user_queries.php');

session_start();

$NAME = $_POST['name'];
$PASSWORD = $_POST['pass'];
if (!isset($NAME) || !isset($PASSWORD)) {
    header('Location: ' . 'register.php');
}
else if (!checkUser($NAME)) {
    addUser($NAME, $PASSWORD);
    $_SESSION['user'] = $_POST['name'];
    header('Location: ' . 'index.php');
}
else {
    header('Location: ' . 'register.php');
}
