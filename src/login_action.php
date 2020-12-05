<?php
include_once('database/user_queries.php');

ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(-1);

session_start();

include_once "database/db_user.php";

if (!isset($_POST['name']) || !isset($_POST['pass'])) {
    header('Location: ' . 'login.php');
}
if (!checkPassword($_POST['name'], $_POST['pass'])) {
    header('Location: ' . 'login.php');
}
else {
    $_SESSION['user'] = $_POST['name'];
    header('Location: ' . 'index.php');
}