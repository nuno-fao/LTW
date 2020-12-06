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

        <section id="user_animals">
            <?php
            $animals = getUserAnimals($user_info[2]);
            foreach ($animals as $animal){
                draw_animal($animal["petId"],$animal["name"],null,$animal["size"],$animal["color"],$animal["location"],null,$user_info[2]);
            }
            ?>
        </section>



        <?php
            
        
    }