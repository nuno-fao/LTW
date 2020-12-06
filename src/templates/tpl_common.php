<?php
include_once('database/user_queries.php');
function draw_head(){
?>
<!DOCTYPE html>
    <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width">
            <title>Projeto Black Dog</title>
            <link rel="stylesheet" href="css/style.css">
            <link rel="stylesheet" href="css/layout.css">
            <link rel="stylesheet" href="css/responsive.css">
        </head>
        <body>
            <?php } ?>

            <?php
            function draw_header(){
            getName();
            $Bar_code = '';
            if(isset($_SESSION['user'])){
                $Bar_code = '
                <section class="login_register">
                    <a id="user" href="user.php?user='.$_SESSION['user'].'"> '.$_COOKIE['name'].'</a>
                    <div id="register" class="button" ><a href="logout_action.php" class="button-text">Logout</a></div>
                </section>
                ';
            }
            else{
                $Bar_code = '
                <section class="login_register">
                    <div id="register" class="button" ><a href="register.php" class="button-text">Register</a></div>
                    <div id="login" class="button"><a href="login.php" class="button-text">Login</a></div>
                </section>
                ';
            }
            ?>
            <header class="top_header">
                <a id="title" href="index.php" class="no_link_style">Projeto Black Dog</a>
                <?=$Bar_code;?>
            </header>
            <div class="body">
                <?php } ?>

                <?php
                function draw_footer(){?>
            </div>
            <footer>
            </footer>
        </body>
    </html>
<?php } ?>





