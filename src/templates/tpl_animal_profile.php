<?php
include_once('../database/pet_queries.php');
include_once('../database/user_queries.php');

function draw_animal_aside($animal){
    $animal_data = get_pet_data($animal);
    $user_name = get_user_by_ID($animal_data['user'])['userName'];
    $state = get_state_description($animal_data['state']);
    ?>
    <aside id="animal_profile" class="animal_profile_box">

        <img src="<?=get_pet_photo($animal)?>" class="profile_img">
        <label>
            <?=$animal_data['name']?>
        </label>
        <label>
            <?=$animal_data['size']?>
        </label>
        <label>
            <?=$animal_data['color']?>
        </label>
        <label>
            <?=get_specie($animal_data['species'])['specie']?>
        </label>
        <label>
            <?=$animal_data['location']?>
        </label>
        <label>
        <a id="owner_profile" href="user.php?user=<?=$user_name?>">
            <?=$user_name?>
        </a>
        </label>
        <div id="change_state_div"> 
            <?php
            if(isset($_SESSION['user'])){
                $user = get_user($_SESSION['user']);
                if ($animal_data['user'] == $user['userId']) {
                    if($state['state']=='For Adoption'){?>
                        <?=$state["state"]?>
                        <form action="../actions/change_state_action.php" method="post">
                            <input type="hidden" name="petId" value="<?=$animal?>">
                            <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
                            <input type="hidden" name="new_state" value="2">
                            <input type="submit" name="submit" value="Next">
                        </form>
        
                        <?php
                    }
                    else if($state['state']=='Proposal Accepted'){?>
                        <form action="../actions/change_state_action.php" method="post">
                            <input type="hidden" name="petId" value="<?=$animal?>">
                            <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
                            <input type="hidden" name="new_state" value="1">
                            <input type="submit" name="submit" value="Previous">
                        </form>
                        <?=$state["state"]?>
                        <form action="../actions/change_state_action.php" method="post">
                            <input type="hidden" name="petId" value="<?=$animal?>">
                            <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
                            <input type="hidden" name="new_state" value="3">
                            <input type="submit" name="submit" value="Next">
                        </form>
        
                        <?php
                    }
                    else if($state['state']=='Addopted'){?>
                        <form action="../actions/change_state_action.php" method="post">
                            <input type="hidden" name="petId" value="<?=$animal?>">
                            <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
                            <input type="hidden" name="new_state" value="2">
                            <input type="submit" name="submit" value="Previous">
                        </form>
                        <?=$state["state"]?>
                        <?php
                    }
                }
                else{ ?>
                    <label><?=$state["state"]?></label>
                    <?php
                }
            }
            else{ ?>
                <label><?=$state["state"]?></label>
                <?php
            }
            ?>
        </div>
        <?php
        if(isset($_SESSION['user'])){
            ?>
            <section  id = "favourites">
                <?php
                if(!check_pet_user_association($_SESSION['user'],$animal)){
                    ?>
                    <form action="../actions/favourite_action.php" method="POST"  id = "favourite_form">
                        <input type="hidden" name="petId" value="<?=$animal?>">
                        <input type="submit" id="fav_button" value="Add to Favourites">
                        <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
                    </form>
                    <?php
                }
                else{
                    ?>
                    <form action="../actions/favourite_action.php" method="POST"  id = "favourite_form">
                        <input type="hidden" name="petId" value="<?=$animal?>">
                        <input type="submit" id="fav_button" value="Remove from Favourites">
                        <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
                    </form>
                    <?php
                }
                ?>
            </section>
            <?php
            $pet = get_pet_data($animal);
            $user = get_user($_SESSION['user']);
            if ($pet['user'] == $user['userId']) {
                ?>
                <section  id = "remove_pet">
                    <form action="../actions/delete_pet_action.php" method="POST"  id = "remove_pet_form">
                        <input type="hidden" name="pet_id" value="<?=$animal?>">
                        <input type="submit" id="remove_button" value="Remove Pet">
                        <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
                    </form>
                </section>
                <section  id = "remove_pet">
                    <form action="../pages/edit_pet.php" method="POST"  id = "remove_pet_form">
                        <input type="hidden" name="pet_id" value="<?=$animal?>">
                        <input type="submit" id="edit_button" value="Edit Pet">
                        <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
                    </form>
                </section>

                <?php
            }
        }
        ?>
    </aside>

    <?php
}

function draw_animal_profile($animal){
    $photos = get_pet_photos($animal);
    ?>
    <section id="animal_main_section">
        <section id="gallery">
            <?php
            foreach($photos as $photo){
                ?>
                <div class=gallery_photo>
                    <img src = "<?=$photo['path']?>" width=auto height=200/>
                </div>

                <?php
            }
            ?>
        </section>
    </section>
    <?php
}

function draw_animal_comments($animal){
    $questions = get_pet_questions($animal);
    if(count($questions)){
        ?>
        <section id="questions">
            <?php foreach ($questions as $question){
                $replies = show_question_reply($question['questionId']);
                ?>
                <article class="question" id="question_id_<?=$question['questionId']?>">
                    <!-- <span class="question_id"><?=$question['questionId']?></span> -->
                    <div id="question_header">
                        <a id="author" href="user.php?user=<?=$question['userName']?>">
                            <?=$question['userName']?> asked:
                        </a>
                        <span class="date"><?=date('Y-m-d H:i:s', $question['date']);?></span>
                        <div class="drop_down">
                            <button onclick="dropdown('replies_dropdown_<?=$question['questionId']?>')" class="dropdown_button">Show Replies</button>
                        </div>
                    </div>
                    <p id="question_text"><?=$question['questionTxt']?></p>
                    <div id="replies_dropdown_<?=$question['questionId']?>" class="dropdown_content">
                        <?php
                        if($replies){
                            foreach ($replies as $reply){?>
                                <div class="reply">
                                    <a id="author" href="user.php?user=<?=$reply['userName']?>">
                                        <?=$reply['userName']?> replied:
                                    </a>
                                    <span class="date"><?=date('Y-m-d H:i:s', $reply['date']);?></span>
                                    <p><?=$reply['answerTxt']?></p>
                                </div>
                                <?php
                            }
                        }
                        else{ ?>
                            <p>There are no replies to this question yet</p>
                            <?php
                        }

                        if(isset($_SESSION['user'])){
                            $userID = get_user($_SESSION['user'])['userId'];
                            ?>
                            <div id="reply_<?=$question['questionId']?>" class="reply_area">
                                <p>Send a reply...</p>
                                <textarea name="reply_text"></textarea>
                                <input type="hidden" name="userId" value="<?=$userID?>">
                                <input type="hidden" name="questionId" value="<?=$question['questionId']?>">
                                <input type="submit" value="submit" onclick="submitReply('reply_<?=$question['questionId']?>')">
                                <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
                            </div>
                        <?php }
                        ?>
                    </div>
                </article>
                <?php
            }
            ?>

            <?php if(isset($_SESSION['user'])){
                $userID = get_user($_SESSION['user'])['userId'];
                ?>
                <script src="../js/comments.js" defer></script>
                <form id="ask_question">
                    <p>Ask a question...</p>
                    <textarea name="comment_text"></textarea>
                    <input type="hidden" name="petId" value="<?=$animal?>">
                    <input type="hidden" name="userId" value="<?=$userID?>">
                    <input type="submit" value="submit">
                    <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
                </form>
            <?php } ?>

        </section>
        <?php
    }
    else{
        if(isset($_SESSION['user'])){
            $userID = get_user($_SESSION['user'])['userId'];
            ?>
            <section id="questions">
                <script src="../js/comments.js" defer></script>
                <form id="ask_question">
                    <p>Ask a question...</p>
                    <textarea name="comment_text"></textarea>
                    <input type="hidden" name="petId" value="<?=$animal?>">
                    <input type="hidden" name="userId" value="<?=$userID?>">
                    <input type="submit" value="submit">
                    <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
                </form>
            </section>
        <?php }
    }
}

function draw_proposals($user,$animal){
    $proposals = null;
    if($user == null){
        $proposals = get_proposals_for_pet($animal);
        if($proposals!=null){
            echo '<script src="../js/add_proposal_reply.js" defer></script>';
            echo "<section id='proposals' >";
            foreach ($proposals as $proposal){
                $user = get_user_by_ID($proposal['user']);
                $pet = get_pet_data($proposal['pet']);
                ?>
                <div class="proposal" id=<?=$proposal['proposalId']?>>
                    <input type="hidden" name="csrf" value=<?=$_SESSION['csrf']?>>
                    <input type="hidden" name="proposal_id" value=<?=$proposal['proposalId']?>>
                    <input type="hidden" name="pet_id" value=<?=$pet['petId']?>>
                    <div id="proposal_head">
                        <label id="proposal-user"><?=$user['userName']?> proposed:</label><label id="proposal_state"><?php
                            switch($proposal['state']){
                                case 0:
                                    echo "For Review";
                                    break;
                                case 1:
                                    echo "Accepted";
                                    break;
                                case 2:
                                    echo "Denied";
                                    break;
                            }
                            ?>
                        </label>
                    </div>
                    <label id="proposal-text"><?=$proposal['text']?></label>

                    <?php
                    if($proposal['state']==0){
                        echo "    <button id='accept_button' onclick=accept(".$proposal['proposalId'].")>Accept Proposal</button>
                                  <button id='deny_button' onclick=deny(".$proposal['proposalId'].")>Deny Proposal</button>";
                    }
                    elseif ($proposal['state']==1){
                        echo "<button id='deny_button' onclick=deny(".$proposal['proposalId'].")>Deny Proposal</button>";
                    }
                    elseif ($proposal['state']==2){
                        echo "<button id='accept_button' onclick=accept(".$proposal['proposalId'].")>Accept Proposal</button>";
                    }
                    ?>
                </div>
                <?php
            }
            echo "</section>";
        }
    }
    else{
        $user_data = get_user($user);
        $proposals = get_proposals($user_data['userId'],$animal);
        echo "<section id='proposals'>";
        if($proposals!=null){
            foreach ($proposals as $proposal){
                $pet = get_pet_data($proposal['pet']);
                draw_proposal($user_data['userName'],$pet['name'],$proposal['text'],$proposal['state']);
            }
        }
        ?>
        <div id="add_proposal">
            <label>Add A proposal</label>
            <form id="proposal_form" action="../actions/add_proposal_action.php" method="post">
                <textarea id="proposal-text" name="proposal_text" rows="4" cols="50"></textarea>
                <br><br>
                <input type="submit" value="Submit">
                <input type="hidden" name="csrf" value=<?=$_SESSION['csrf']?>>
                <input type="hidden" name="pet_id" value=<?=$animal?>>
            </form>
        </div>
        </section>
        <?php

    }
}
