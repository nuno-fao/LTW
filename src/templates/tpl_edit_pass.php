<?php
/**
 * draw password edition section
 */
function draw_edit_pass(){
    ?>
    <div id="edit_pass_box">
        <form action="../actions/login_action.php" method="post" class="edit_pass_form">
            <div id="edit_pass_title">
                Change Password
            </div>
            <div class="edit_pass_form">
                <input type="password" placeholder="Old Password" name="oldpass" required>

                <input type="password" placeholder="New Password" name="newpass" required>

                <input type="password" placeholder="Confirm New Password" name="confirm" required>
                
                <button type="submit">Confirm</button>
            </div>
            <input type="hidden" name="user" value="<?=$_SESSION['user']?>">
            <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
        </form>
    </div>
    <?php
}
