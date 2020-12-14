<?php
session_start();

class edit_pass_error{
    public $safety_error = false;
    public $oldpass=false;
    public $newpass=false;
    public $confirm=false;
}

$error = new edit_pass_error();
include_once "../database/db_user.php";

if (!isset($_POST['csrf']) || $_SESSION['csrf'] !== $_POST['csrf'] || !checkUser($_POST['name'])) {
    $error->safety_error = true;
}

else if (!isset($_POST['oldpass']) || !checkPassword($_POST['name'], $_POST['oldpass'])) {
    $error->oldpass = true;
}
else if(!isset($_POST['newpass'])){
    $error->newpass = true;
}
else if(!isset($_POST['confirm']) || $_POST['newpass'] != $_POST['confirm']){
    $error->confirm = true;
}
else {
    editPassword($_POST['name'],$_POST['newpass']);
}
echo json_encode($error);