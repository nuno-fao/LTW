<?php
function draw_login(){
    ?>
    <div id="login_register_outer_box">
        <form action="actions/login_register_action.php" method="post">
            <div id="login_title">
                Login
            </div>
            <div class="login_form">
                <input type="text" placeholder="Username" name="uname" required>

                <input type="password" placeholder="Password" name="psw" required>

                <div id="buttons-section">
                    <button type="submit">Login</button>
                    <span><a href="" class="no_link_style">Register</a></span>
                </div>
            </div>
        </form>
    </div>
    <?php
}