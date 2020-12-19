<?php
/**
 *  draw user register section
 */
function draw_register(){
    ?>
    <div id="login_register_outer_box">
        <form action="../actions/register_action.php" method="post" id="register_form">
            <div id="login_register_title">
                Register
            </div>
            <div class="login_register_form">
                <input type="text" placeholder="Username" name="user" required>

                <input type="password" placeholder="Password" name="pass" required>

                <input type="email" placeholder="Email Address" name="e_address" required>

                <input type="text" placeholder="Full Name" name="name" required>

                <div id="buttons-section">
                    <button type="submit">Register</button>
                    <button onclick="window.location.href = '../pages/login.php'">Login</button>
                </div>
            </div>
            <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
        </form>
    </div>
    <?php
}