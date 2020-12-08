<?php
include_once "../database/animal_queries.php";
class reply{
    public $replies, $questionId;

    function create_dic($r_replies,$r_questionId){
        $this->replies = $r_replies;
        $this->questionId = $r_questionId;
    }
}
$error=false;
if(isset($_POST['questionId']) && strlen($_POST['questionId']>=1)){
    $replies = show_question_reply($_POST['questionId']);

    $error = new reply();
    $error->create_dic($replies,$_POST['questionId']);
}
else{
    $error=true;
}

echo json_encode($error);