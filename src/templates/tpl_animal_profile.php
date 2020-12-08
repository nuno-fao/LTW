<?php
include_once('../database/animal_queries.php');
include_once('../database/user_queries.php');

function draw_animal_aside($animal){
    $animal_data = get_animal_data($animal);
    $user_name = get_user_by_ID($animal_data['user'])['userName'];
    $state = get_state_description($animal_data['state']);
    ?>

    <aside id="animal_profile">

        <img src="<?=get_animal_photo($animal)?>" width="300" height="300">
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
            <?=$animal_data['location']?>
        </label>
        <a id="owner_profile" href="user.php?user=<?=$user_name?>">
            <?=$user_name?>
        </a>

        <label>
            <?=$state['state']?>
        </label>

    </aside>

    <?php
}

function draw_animal_profile($animal){
    $photos = get_animal_photos($animal);
    $questions = get_animal_questions($animal);
    ?>
    <section id="burrrrrrrp">

        <section id="gallery">
            <?php
            foreach($photos as $photo){
                ?>
                <div class=gallery_photo>
                    <img src = "<?=$photo['path']?>" width=250 height=250/>
                </div>

                <?php
            }
            ?>
        </section>
    </section>
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
    }?>

    <section id="questions">
            <?php foreach ($questions as $question){ ?>
                <article class="question">
                    <span class="user"><?=$question['userName']?> asked:</span>
                    <span class="date"><?=date('Y-m-d H:i:s', $question['date']);?></span>
                    <p><?=$question['questionTxt']?></p>
                </article>
            <?php } ?>
        
        <?php if(isset($_SESSION['user'])){ 
                $userID = getUser($_SESSION['user'])['userId'];
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
                <span id="comment_submit_message"></span>
    <?php } ?>

    </section>

    <?php
}