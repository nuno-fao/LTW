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
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/animal.css">
</head>
<body>
<?php } ?>

<?php
function draw_header(){
getName();
if(isset($_SESSION['user'])){
    $Bar_code = '
    <header class="logged_in">
    <a id="title" href="../index.php">Projeto Black Dog</a>
    <div id= "username">
        <a id="user" href="user.php?user='.$_SESSION['user'].'"> '.$_COOKIE['name'].'</a>
    </div>
    <section class="login_register">
        <div id="add_pet" class="button" >
            <a href="add_pet.php" class="button-text">Add Pet</a>
        </div>
        <div id="logout" class="button" >
            <a href="../actions/logout_action.php" class="button-text">Logout</a>
        </div>
        
    </section>
    </header>
    ';
}
else{
    $Bar_code = '
    <header>
    <a id="title" href="../index.php">Projeto Black Dog</a>
    <section class="not_logged">
        <div id="register" class="button" >
            <a href="register.php" class="button-text">Sign Up</a>
        </div>
        <div id="login" class="button">
            <a href="login.php" class="button-text">Log In</a>
        </div>
    </section>
    </header>
    ';
}
?>
<?=$Bar_code;?>
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





