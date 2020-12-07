<?php
include_once('database/animal_queries.php');
include_once('database/user_queries.php');

session_start();

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
        <section id = "favourites">
            <?php
            if(!check_pet_user_association($_SESSION['user'],$animal)){
                ?>
                <form action="./favourite_action.php" method="POST">
                    <input type="hidden" name="petId" value="<?=$animal?>">
                    <input type="submit" value="Add to Favourites">
                </form>
                <?php
            }
            else{
                ?>
                <form action="./favourite_action.php" method="POST">
                    <input type="hidden" name="petId" value="<?=$animal?>">
                    <input type="submit" value="Remove from Favourites">
                </form>
                <?php
            }
            ?>
        </section>

        <?php
    }
}