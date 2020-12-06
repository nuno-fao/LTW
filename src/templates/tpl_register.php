<?php
function draw_register(){
    ?>
    <div id="login_register_outer_box">
        <form action="register_action.php" method="post">
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
                    <span><a href="Login" class="no_link_style">Login</a></span>
                </div>
            </div>
        </form>
    </div>
    <?php
}