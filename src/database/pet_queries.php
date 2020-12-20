<?php
include_once('../database/connection.php');
ini_set('session.cookie_httponly', 1);

/**
 * @return array of pets with species names, state name and user username
 */
function get_pets(){
    global $dbh;
    $stmt = $dbh->prepare('SELECT petId,Pets.name,size,color,location,PetState.state,path,gender, Species.specie, Users.userName FROM Pets JOIN Users ON Pets.user=Users.userId JOIN Species ON Pets.species = Species.specieId JOIN PetState ON Pets.state = PetState.petStetId JOIN Photos ON Pets.profilePic=Photos.photoId');
    $stmt->execute();
    return $stmt->fetchAll();
}

/**
 * @param $pet_id
 * @return return the path of the pet's main photo
 */
function get_pet_photo($pet_id){
    global $dbh;
    $stmt = $dbh->prepare('SELECT path from Photos join Pets on Photos.photoId = Pets.profilePic where pet = ? ORDER BY path DESC');
    $stmt->execute(array($pet_id));
    return $stmt->fetchAll()[0]["path"];
}

/**
 * @return array of the species table rows
 */
function get_species(){
    global $dbh;
    $stmt = $dbh->prepare('SELECT * from Species ');
    $stmt->execute(array());
    return $stmt->fetchAll();
}

/**
 * @return array of the states info
 */
function get_states(){
    global $dbh;
    $stmt = $dbh->prepare('SELECT * from PetState ');
    $stmt->execute(array());
    return $stmt->fetchAll();
}

/**
 * @param $specie_name
 * @return get specie id of the $specie_name
 */
function get_specie_id($specie_name){
    global $dbh;
    $stmt = $dbh->prepare('SELECT specieId from Species where specie=?');
    $stmt->execute(array($specie_name));
    return $stmt->fetchAll()[0]['specieId'];
}

/**
 * @param $specie_id
 * @return get specie name of the $specie_id
 */
function get_specie($specie_id){
    global $dbh;
    $stmt = $dbh->prepare('SELECT * from Species where specieId=?');
    $stmt->execute(array($specie_id));
    return $stmt->fetchAll()[0];
}

/**
 * @param $color
 * @return return color id
 */
function get_color_id($color){
    global $dbh;
    $stmt = $dbh->prepare('SELECT color from Colors where color=?');
    $stmt->execute(array($color));
    return $stmt->fetchAll()[0]['color'];
}

/**
 * @return array of the colors
 */
function get_colors(){
    global $dbh;
    $stmt = $dbh->prepare('SELECT color from Colors ');
    $stmt->execute(array());
    return $stmt->fetchAll();
}

/**
 * @param $pet_id
 * @return array with pet info
 */
function get_pet_data($pet_id){
    global $dbh;
    $stmt = $dbh->prepare('SELECT * from Pets where petId=?');
    $stmt->execute(array($pet_id));
    return $stmt->fetchAll()[0];
}

/**
 * @param $pet_id
 * @return get photos of the pet $pet_id
 */
function get_pet_photos($pet_id){
    global $dbh;
    $stmt = $dbh->prepare('SELECT path from Photos where pet=?');
    $stmt->execute(array($pet_id));
    return $stmt->fetchAll();
}

/**
 * @param $state
 * @return get state name of the specifies state id
 */
function get_state_description($state){
    global $dbh;
    $stmt = $dbh->prepare('SELECT state from PetState where petStetId=?');
    $stmt->execute(array($state));
    return $stmt->fetchAll()[0];
}

/**
 * adds pet to database
 * @param $name
 * @param $species
 * @param $size
 * @param $color
 * @param $location
 * @param $state
 * @param $user
 * @param $profilePic
 * @param $gender
 * @return false on querie error
 */
function add_pet($name, $species, $size, $color, $location, $state, $user, $profilePic, $gender){
    global $dbh;
    $stmt = $dbh->prepare('INSERT INTO Pets(name, species,size, color,location,state,user,profilePic,gender) VALUES(?,?,?,?,?,?,?,?,?)');
    return $stmt->execute(array($name,$species,$size,$color,$location,$state,$user,$profilePic,$gender));
}

/**
 * edit pet info
 * @param $name
 * @param $species
 * @param $size
 * @param $color
 * @param $location
 * @param $state
 * @param $gender
 * @param $pet_id
 * @return false on querie error
 */
function edit_pet($name, $species, $size, $color, $location, $gender, $pet_id){
    global $dbh;
    $stmt = $dbh->prepare('UPDATE Pets set name=?, species=?,size=?, color=?,location=?,gender=? where petId=?');
    return $stmt->execute(array($name,$species,$size,$color,$location,$gender,$pet_id));
}

/**
 * @param $pet_name
 * @return return pet with name $pet_name
 */
function get_pet($pet_name){
    global $dbh;
    $stmt = $dbh->prepare('SELECT * from Pets where name=?');
    $stmt->execute(array($pet_name));
    return $stmt->fetchAll();
}

/**
 * @param $photo_path
 * @param $pet_id
 * @return adds photo_path to photo table related to pet_id
 */
function add_pet_photo_to_db($photo_path, $pet_id){
    global $dbh;
    $stmt = $dbh->prepare('INSERT INTO Photos(path,pet) VALUES(?,?)');
    $stmt->execute(array($photo_path,$pet_id));

    $stmt = $dbh->prepare('SELECT photoid from Photos where path=?');
    $stmt->execute(array($photo_path));
    return $stmt->fetchAll()[0]['photoId'];
}

function change_pet_photo_id($pet_id, $photo_id){
    global $dbh;
    $stmt = $dbh->prepare('UPDATE Pets SET profilePic = ? WHERE petId = ?;');
    return $stmt->execute(array($photo_id,$pet_id));
}

/**
 * @param $pet_id
 * @return true if the pet exists
 */
function check_pet($pet_id) {
    global $dbh;

    $stmt = $dbh->prepare('SELECT * FROM Pets WHERE petId = ?');
    $stmt->execute(array($pet_id));
    $length = count($stmt->fetchAll());
    return $length>0;
}

/**c
 * heck if the $pet_id is on favourite list of the $user_name pets
 * @param $user_name
 * @param $pet_id
 * @return true if $pet_id is on favourite list of the $pet_id
 */
function check_pet_user_association($user_name, $pet_id) {
    global $dbh;
    $stmt = $dbh->prepare('SELECT * FROM Favourites WHERE user = ? AND pet = ?');
    $stmt->execute(array($user_name,$pet_id));
    $length = count($stmt->fetchAll());
    return $length>0;
}

/**
 * add pet_id to user favourite lists
 * @param $user_name
 * @param $pet_id
 */
function add_pet_favourite($user_name, $pet_id){
    global $dbh;
    $stmt = $dbh->prepare('Insert into Favourites(user,pet) values (?,?);');
    $stmt->execute(array($user_name,$pet_id));
}

/**
 * add pet_id from user favourite lists
 * @param $user_name
 * @param $pet_id
 */
function remove_pet_favourite($user_name, $pet_id){

    global $dbh;
    $stmt = $dbh->prepare('DELETE FROM Favourites WHERE user = ? AND pet = ?;');
    $stmt->execute(array($user_name,$pet_id));
}


/**
 * @param $pet_id
 * @return array with pet questions
 */
function get_pet_questions($pet_id){
    global $dbh;
    $stmt = $dbh->prepare('SELECT questionId, userName, date, questionTxt FROM Questions JOIN Users ON Questions.user = Users.userId WHERE pet = ?');
    $stmt->execute(array($pet_id));

    return $stmt->fetchAll();
}


/**
 * adds question to pet
 * @param $pet_id
 * @param $user_id
 * @param $comment_text
 * @param $date
 */
function add_question($pet_id, $user_id, $comment_text, $date){
    global $dbh;
    $stmt = $dbh->prepare('INSERT INTO Questions (questionTxt,pet,date,user) VALUES (?,?,?,?)');
    $stmt->execute(array($comment_text,$pet_id,$date,$user_id));
}


/**
 * @param $question_id
 * @return array with pets reply of the specifies question
 */
function show_question_reply($question_id){
    global $dbh;
    $stmt = $dbh->prepare('SELECT answerId, userName, Questions.date, answerTxt, Answers.question FROM ((Answers JOIN Users ON Answers.author = Users.userId) JOIN Questions ON Questions.questionId = Answers.question) WHERE Questions.questionId = ?');
    $stmt->execute(array($question_id));

    return $stmt->fetchAll();
}

function add_question_reply($answer_txt, $question, $date, $author){
    global $dbh;
    $stmt = $dbh->prepare('INSERT INTO Answers (answerTxt,question,date,author) VALUES (?,?,?,?)');
    $stmt->execute(array($answer_txt,$question,$date,$author));
}

/**
 * @param $pet_id
 * @return int with the accepted proposals of the pet specified with $pet_id
 */
function accepted_proposals($pet_id){
    global $dbh;
    $stmt = $dbh->prepare('select * from Proposals where pet=? and state=1');
    $stmt->execute(array($pet_id));
    return count($stmt->fetchAll());
}

/**
 * removes pet entries on database(on delete cascade not working so foreign keys references need to be removed "by hand"
 * @param $pet_id
 */
function remove_pet($pet_id){
    global $dbh;
    $stmt1 = $dbh->prepare('DELETE from Pets where petId=?');
    $stmt1 ->execute(array($pet_id));
    $stmt2 = $dbh->prepare('DELETE from Photos where pet=?');
    $stmt2 ->execute(array($pet_id));
    $questions = $dbh->prepare('Select * from Questions where pet=?');
    $questions ->execute(array($pet_id));

    $del_answer = $dbh->prepare('DELETE from Answers where question=?');
    foreach ($questions as $question){
        $del_answer->execute(array($question['questionId']));
    }

    $stmt4 = $dbh->prepare('DELETE from Questions where pet=?');
    $stmt4 ->execute(array($pet_id));

    $stmt4 = $dbh->prepare('DELETE from Proposals where pet=?');
    $stmt4 ->execute(array($pet_id));
}

/**
 * changes the pet state
 * @param $pet_id
 * @param $state
 */
function update_state($pet_id, $state){
    global $dbh;
    $stmt = $dbh->prepare('UPDATE Pets SET state=? WHERE petId=?');
    $stmt->execute(array($state,$pet_id));
}
