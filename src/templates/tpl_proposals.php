<?php
function draw_proposal($user,$pet,$text,$state){
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
        </div>
        </label>
        <label id="proposal-text"><?=$text?></label>

    </div>

    <?php
}