<?php
include_once "../database/pet_queries.php";
include_once "../database/user_queries.php";

session_start();

class reply{
    public $questionId, $userName, $reply_txt, $date, $error = false;

    function create_dic($r_questionId,$r_userName,$r_reply_txt,$r_date){
        $this->questionId = $r_questionId;
        $this->userName = $r_userName;
        $this->reply_txt = $r_reply_txt;
        $this->date = $r_date;

    }
}

$error = new reply();

if ($_SESSION['csrf'] !== $_POST['csrf']) {
    $error->questionId = preg_replace("/[^a-zA-Z0-9\s]/", '', $_POST['questionId']);
    $error->error = true;
}
else if(isset($_SESSION['user']) && isset($_POST['questionId']) && isset($_POST['text']) && isset($_POST['userId'])){
    if(strlen($_POST['questionId'])<=0 || strlen($_POST['text']) <=0 || strlen($_POST['userId']) <=0 || strlen($_SESSION['user'])<=0){
        $error->error = true;
    }
    else {
        $date = time();
        $strip_questionId = preg_replace("/[^a-zA-Z0-9\s]/", '', $_POST['questionId']);
        $strip_reply_text = preg_replace("/[^A-Za-zÀ-ÖØ-öø-ÿ0-9\s():.,;?!-]/", '', $_POST['text']);

        $userId = get_user($_SESSION['user'])['userId'];

        add_question_reply($strip_reply_text,$strip_questionId,$date,$userId);
        
        
        $error->create_dic($strip_questionId,$_SESSION['user'],$strip_reply_text,$date);
    }
}
else{
    $error->questionId = preg_replace("/[^a-zA-Z0-9\s]/", '', $_POST['questionId']);
    $error->error = true;
}
echo json_encode($error);
