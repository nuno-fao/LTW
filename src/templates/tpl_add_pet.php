<?php
include_once "../database/pet_queries.php";

/**
 * draws add pet section
 */
function draw_add_pet(){
    ?>
        <section class="grid_add_pet">
            <section id="pet_info">
                <form action="../actions/add_pet_action.php"  method="post" enctype="multipart/form-data" class="add_edit_pet_form">
                    <label>Pet Name:</label><input type="text" name="name">
                    <label for="size">Animal Length(1 to 200 cm):</label>
                    <input type="number" id="size" name="size" min="1" max="200" value="50">

                    <label for="species">Species</label>
                    <select name="species" id="species">
                        <?php
                        $species = get_species();
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
                        foreach ($colors as $color){
                            $out_flag = "<option value=".$color['color'].">".$color['color']."</option>";
                            echo $out_flag;
                        }
                        ?>
                    </select>
                    <label for="gender">Gender</label>
                    <select name="gender" id="gender">
                        <option value="female">female</option>
                        <option value="male">male</option>
                    </select>
                    <label for="location">Location</label>
                    <input type="text" name="location" id="location">

                    <label for="picture">Picture</label>
                    <input type="file" name="picture" id="picture" accept=".jpg, .jpeg, .png, .gif">
                    <label for="other_pictures">Other Pictures</label>
                    <input type="file" name="other_picture" id="other_pictures" accept=".jpg, .jpeg, .png, .gif" multiple>
                    <input type="hidden" name="submit" value="submit">
                    <input type="submit" value="Add Pet">
                    <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
                </form>
            </section>

        </section>

    <?php
}