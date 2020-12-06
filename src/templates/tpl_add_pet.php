<?php
include_once "database/animal_queries.php";
function draw_add_pet(){
    ?>
    <section>
        <section id="pet_main_photo">
            <img src="img/default_animal_pic.gif"/>
            <div id="add_photo">

            </div>
        </section>
        <section id="pet_info">
            <form action="add_pet_action.php"  method="post" enctype="multipart/form-data">
                <label>Pet Name:</label><input type="text" name="name">
                <label for="length">Animal Length(1 to 200 cm):</label>
                <input type="number" id="size" name="size" min="1" max="200" value="50"> <?//substituir por algo decente com js, css e divs?>

                <label for="dateofbirth">Date Of Birth</label>
                <input type="date" name="dateofbirth" id="dateofbirth">
                <label for="species">Species</label>
                <select name="species" id="species">
                    <?php
                    $species = get_species();
                    print_r($species);
                    foreach ($species as $specie){
                        $out_flag = "<option value=".$specie['specie'].">".$specie['specie']."</option>";
                        echo $out_flag;
                    }
                    ?>
                </select>
                <label for="color">Color</label>
                <select name="color" id="color">
                    <?php
                    $colors = get_colors();
                    print_r($colors);
                    foreach ($colors as $color){
                        $out_flag = "<option value=".$color['color'].">".$color['color']."</option>";
                        echo $out_flag;
                    }
                    ?>
                </select>
                <label for="location">Location</label>
                <input type="text" name="location" id="location">

                <label for="picture">Picture</label>
                <input type="file" name="picture" id="picture">
                <input type="hidden" name="submit" value="submit">
                <input type="submit" value="Add Pet">
            </form>
        </section>

    </section>

    <?php
}