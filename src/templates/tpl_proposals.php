<?php
function draw_proposal($user,$pet,$text,$state){
    ?>
    <div class="proposal">
        <label id="proposal-user"><?=$user?></label>
        <label id="proposal-pet"><?=$pet?></label>
        <label id="proposal-text"><?=$text?></label>
        <label><?php
            switch($state){
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

    <?php
}