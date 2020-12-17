<?php
include_once '../templates/tpl_main.php';
function draw_user_aside($user)
{
    $user_info =  get_user($user);
    ?>
    <aside id="user_profile">
        <img src="<?= get_picture_path($user) ?>" width="200" height="200" />
        <label id="user">
            <?= $user ?>
        </label>
        <label id="name">
            <?= $user_info['Name'] ?>
        </label>
        <label id="email">
            <?= $user_info['EmailAddress'] ?>
        </label>
        <?php
        if (isset($_SESSION['user']) && $_SESSION['user'] == $user) {
            ?>
            <script src="../js/user_editing.js" defer></script>
            <button id="edit_user_profile">Edit Profile</button>
            <a id="change_password_link" href="edit_pass.php">Change Password</a>
            <?php
        }
        ?>

    </aside>
    
    
    
    <section id="non_adopted_animals">
        <div class="title">
            <label>User Animals</label>
        </div>
        <section id="non_adopted_list">
            <?php
            $animals = get_user_animals($user_info['userId']);
            foreach ($animals as $animal) {
                if($animal['state']!=3){
                    draw_animal($animal["petId"], $animal["name"], null, $animal["size"], $animal["color"], $animal["location"], null, $user);
                }
            }
            ?>
        </section>
    </section>
    <section id="adopted_animals">
        <div class="title">
            <label>Animals Given To Adoption</label>
        </div>
        <section id="adopted_list">
            <?php
            foreach ($animals as $animal) {
                if($animal['state']==3){
                    draw_animal($animal["petId"], $animal["name"], null, $animal["size"], $animal["color"], $animal["location"], null, $user);
                }
            }
            ?>
        </section>
    </section>

    <br>
    

    <section id="user_favourite_animals">
        <div class="title">
            <label>Favourites</label>
        </div>
        <section id="favourites_list">
            <?php
            $animals = get_user_favourite_animals($user_info['userName']);
            foreach ($animals as $animal) {
                draw_animal($animal["pet"], $animal["name"], null, $animal["size"], $animal["color"], $animal["location"], null, $animal['userName']);
            }
            ?>
        </section>
    </section>

    <br>
    <?php
    if(isset($_SESSION['user']) && $user===$_SESSION['user']) {
        ?>
        
        <section id="user_proposals">
            <div class="title">
                <label>Proposals</label>
            </div>
            <?php
            $user = get_user($_SESSION['user']);
            $proposals = get_proposals_for_user($user['userId']);
            if ($proposals) {
                foreach ($proposals as $proposal) {
                    $pet = get_pet_data($proposal['pet']);
                    draw_proposal($_SESSION['user'], $pet['name'], $proposal['text'], $proposal['state']);
                }
            } else {
                echo "<label>You haven't made any proposals</label>";
            }
            ?>
        </section>

        <br>
        <?php
    }
    if(isset($_SESSION['user']) && $user['userName']===$_SESSION['user']) {
        ?>
        
        <section id="user_posts">
            <div class="title">
                <label>Posts where you asked questions and/or replied</label>
            </div>
            <section id="favourites_list">
                <?php
                $user = get_user($_SESSION['user']);
                $questions = get_questions_participated($user['userId']);
                if ($questions) {
                    foreach ($questions as $question) { ?>
                        <a class="animal_main_page" href = "animal_profile.php?pet_id=<?=$question['pet']?>"  >
                            <div class="animal_box">
                                <img class= "animal_image_box" src="<?=get_pet_photo($question['pet'])?>" width="200" height="200">
                                <label class="question_text_box">
                                    <?=$question['questionTxt']?>
                                </label>
                            </div>
                        </a>
                        <?php
                    }
                }
                else{
                    echo "<label>You haven't made any questions/replies</label>";
                }
                ?>
            </section>
        </section>
        <?php
    }

}
