<?php
include_once "database/db_user.php";
include_once('database/user_queries.php');

session_start();

$USER = $_POST['user'];
$PASSWORD = $_POST['pass'];
$EMAIL = $_POST['e_address'];
$NAME = $_POST['name'];
if (!isset($USER) || strlen($USER) == 0 || !isset($PASSWORD) || strlen($PASSWORD) < 8 || !isset($EMAIL) || strlen($EMAIL) == 0 || !isset($NAME) || strlen($NAME) == 0) {
    header('Location: ' . 'register.php');
}
else if (!checkUser($USER)) {
    addUser($USER, $PASSWORD,$EMAIL,$NAME);
    $_SESSION['user'] = $_POST['user'];
    header('Location: ' . 'index.php');
}
else {
    header('Location: ' . 'register.php');
}
