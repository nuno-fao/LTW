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
    $strip_Id = preg_replace("/[^0-9]/", '', $_POST['questionId']);
    $replies = show_question_reply($strip_Id);
    $error = new add_pet_reply();
    $error->create_dic($replies,$strip_Id);
}
else{
    $error=true;
}

echo json_encode($error);