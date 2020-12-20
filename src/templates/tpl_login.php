<?php
ini_set('session.cookie_httponly', 1);
/**
 *  draw login section
 */
function draw_login(){
    ?>
    <div id="login_register_outer_box">
        <form action="../actions/login_action.php" method="post" id="login_form">
            <div id="login_register_title">
                Login
            </div>
            <div class="login_register_form">
                <input type="text" placeholder="Username" name="name" required>

                <input type="password" placeholder="Password" name="pass" required>

                <div id="buttons-section">
                    <button type="submit">Login</button>
                    <button onclick="window.location.href = '../pages/register.php'">Register</button>
                </div>
            </div>
            <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
        </form>
    </div>
    <?php
}