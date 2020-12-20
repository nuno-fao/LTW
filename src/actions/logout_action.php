<?php
include_once "../database/db_user.php";
ini_set('session.cookie_httponly', 1);

session_start();

session_destroy();
header('Location: ' . '../index.php');
