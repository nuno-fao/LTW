<?php
    include_once 'templates/tpl_main.php';
    function draw_user_aside($user){
        $user_info =  getUser($user);
        ?>
        <aside id="user_profile">
            <img src = "<?=getPicturePath($user)?>" width="200" height="200"/>
            <label>
                <?=$user?>
            </label>
            <label>
                <?=$user_info['Name']?>
            </label>
            <label>
                <?=$user_info['EmailAddress']?>
            </label>
        </aside>

        <div>
            <label>User Animals</label>
        </div>
        <section id="user_animals">
            <?php
            $animals = getUserAnimals($user_info['userId']);
            foreach ($animals as $animal){
                draw_animal($animal["petId"],$animal["name"],null,$animal["size"],$animal["color"],$animal["location"],null,$user);
            }
            ?>
        </section>

        <br>
        <div>
            <label>Favourites</label>
        </div>

        <section id="user_favourite_animals">
            <?php
            $animals = getUserFavouriteAnimals($user_info['userName']);
            foreach ($animals as $animal){
                draw_animal($animal["pet"],$animal["name"],null,$animal["size"],$animal["color"],$animal["location"],null,$animal['userName']);
            }
            ?>
        </section>
        <?php
            
        
    }