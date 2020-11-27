<?php
include_once "database/db_user.php";

function login_register_action($POST){
    $NAME = $POST['name'];
    $PASSWORD = $POST['pass'];
    if (!isset($NAME)) {
        header('Location: ' . $_COOKIE['lastPage']);
    }
    if ($POST['action'] === "login") {
        print_r(!checkPassword($NAME, $PASSWORD));
        if (!checkPassword($NAME, $PASSWORD)) {
            header('Location: ' . $_COOKIE['lastPage']);
        }
        $_SESSION['name'] = $NAME;
        header('Location: ' . $_COOKIE['lastPage']);
    } else if ($POST['action'] === "logout" && isset($_SESSION['name'])) {
        session_destroy();
        header('Location: ' . $_COOKIE['lastPage']);
    } else if ($POST['action'] === "register") {
        if (!checkUser($NAME)) {
            addUser($NAME, $POST['password']);
        }
        header('Location: ' . $_COOKIE['lastPage']);
    } else {
        header('Location: ' . $_COOKIE['lastPage']);
    }
}
