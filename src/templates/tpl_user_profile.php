<?php
    function draw_user_aside(){ ?>
        
        <aside id="profile">
            <img src = "<?=getPicturePath()?>" width="200" height="200"/>
            <label>
                <?=$_SESSION['user']?>
            </label>
            <label>
                <?=$_COOKIE['name']?>
            </label>
            <label>
                <?=$_COOKIE['email']?>
            </label>
        </aside>



        <?php
            
        
    }