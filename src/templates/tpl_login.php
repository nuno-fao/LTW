<?php
function draw_login(){
    ?>
    <div id="login_register_outer_box">
        <form action="login_action.php" method="post">
            <div id="login_register_title">
                Login
            </div>
            <div class="login_register_form">
                <input type="text" placeholder="Username" name="name" required>

                <input type="password" placeholder="Password" name="pass" required>

                <div id="buttons-section">
                    <button type="submit">Login</button>
                    <span><a href="" class="no_link_style">Register</a></span>
                </div>
            </div>
        </form>
    </div>
    <?php
}