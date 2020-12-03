<?php
    include_once('database/animal_queries.php');
    include_once('database/user_queries.php');
    
    function draw_animal_aside($animal){
        $animal_data = get_animal_data($animal);
        $user_name = get_user_by_ID($animal_data['user'])['Name'];
        $photos = get_animal_photos($animal);
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
    }