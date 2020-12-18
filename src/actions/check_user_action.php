<?php
include_once "../database/db_user.php";
include_once('../database/user_queries.php');
include_once("../pages/security_functions.php");
session_start();
if(!isset($_POST['user']) || strlen($_POST['user'])==0){
    echo json_encode(true);
    die();
}
$USER = $_POST['user'];
echo json_encode(checkUser($USER));

