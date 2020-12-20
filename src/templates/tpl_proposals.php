<?php

/**
 * draw animal specifies proposal
 * @param $user
 * @param $pet
 * @param $text
 * @param $state
 */
function draw_proposal($user, $pet, $text, $state){
    ?>
    <div class="proposal">
        <div id="proposal_head">
        <label id="proposal-user"><?=$user?> proposed:</label><label><?php
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
        <label id="proposal-text"><?=$text?></label>

    </div>

    <?php
}