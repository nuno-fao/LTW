<?php
include_once "../database/db_user.php";
include_once('../database/user_queries.php');
include_once("../pages/security_functions.php");
session_start();
if (!isset($_SESSION['csrf'])) {
    $_SESSION['csrf'] = generate_random_token();
}

class _error{
    public $text_error = false;
    public $safety_error = false;

    function has_error(){
        return $this->text_error || $this->safety_error;
    }
}

$error = new _error();

$user = get_user($_SESSION['user'])['userId'];

$error->text_error = (!isset($_POST['proposal_text']) || strlen($_POST['proposal_text']) <=0 );

$strip_comment = preg_replace("/[^a-zA-Z0-9\s():.,;_?!-]/", '', $_POST['proposal_text']);
$striped_animal = preg_replace("/[^a-zA-Z0-9\s():.,;_?!-]/", '', $_POST['pet_id']);

if ($_SESSION['csrf'] !== $_POST['csrf']) {
    $error->safety_error = true;
}
else if (!$error->has_error()) {
    add_proposal($user,$striped_animal,$strip_comment);
}

header('Location: ' . '../pages/animal_profile.php?pet_id='.$striped_animal);
