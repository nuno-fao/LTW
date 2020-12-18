<?php
include_once('../database/user_queries.php');
function draw_head($page_name){
?>
    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width">
    <title>Black Dog- <?=$page_name?></title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/layout.css">
    <link rel="stylesheet" href="../css/responsive.css">
</head>
<body>
<?php } ?>



<?php
function draw_header($location){
get_name();
if(isset($_SESSION['user'])){
    $Bar_code = '
    <section class="login_register">
        <a id="user" href="user.php?user='.$_SESSION['user'].'"> '.$_COOKIE['name'].'</a>
        <div id="add-pet" class="button" ><a href="add_pet.php" class="button-text">Add Pet</a></div>
        <div id="register" class="button" ><a href="../actions/logout_action.php" class="button-text">Logout</a></div>
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
<header>
    <div id="navbar">
        <a id="title" href="../index.php" class="no_link_style">Projeto Black Dog</a>
        <?=$Bar_code;?>
    </div>
    <div id="navigation"><?php echo $location ?></div>
</header>
<div class="body">
    <?php 
    }


function draw_footer(){?>
    </div>
    <footer>
        <div class="footer">
            <div class="text">
                <p>Projeto Black Dog</p>
            </div>
            <div class="text">
                <p>2020</p>
            </div>
            
        </div>
    </footer>
    </body>
    </html>
    <?php } ?>





