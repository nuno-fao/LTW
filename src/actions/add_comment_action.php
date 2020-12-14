<?php
include_once "../database/pet_queries.php";
include_once "../database/user_queries.php";


session_start();

class comment{
    public $petId, $userName, $comment_txt, $date;

    function create_dic($r_petId,$r_userName,$r_comm,$r_date){
        $this->petId = $r_petId;
        $this->userName = $r_userName;
        $this->comment_txt = $r_comm;
        $this->date = $r_date;
    }
}

$error = false;

if ($_SESSION['csrf'] !== $_POST['csrf']) {
    $error = true;
}
else if(isset($_SESSION['user']) && isset($_POST['petId']) && isset($_POST['userId']) && isset($_POST['comment_text']) && check_pet($_POST['petId'])){
    if(strlen($_POST['petId'])<=0 || strlen($_POST['userId']) <=0 || strlen($_POST['comment_text']) <=0){
        $error = true;
    }
    else {
        $date = time();
        $strip_petId = preg_replace("/[^a-zA-Z0-9\s]/", '', $_POST['petId']);
        $strip_userId = preg_replace("/[^a-zA-Z0-9\s]/", '', $_POST['userId']);
        $strip_comment = preg_replace("/[^A-Za-zÀ-ÖØ-öø-ÿ0-9\s():.,;_?!-]/", '', $_POST['comment_text']);
        add_question($strip_petId,$strip_userId,$strip_comment,$date);

        $name = get_user_by_ID($strip_userId)['userName'];
        $error = new comment();
        $error->create_dic($strip_petId,$name,$strip_comment,$date);
    }
}
else{
    $error = true;
}
echo json_encode($error);
