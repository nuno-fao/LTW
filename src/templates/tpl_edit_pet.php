<?php
include_once "../database/pet_queries.php";
function draw_edit_pet($pet){

    $pet_data = get_pet_data($pet);
    $user = get_user($_SESSION['user']);
    if ($pet_data['user'] == $user['userId']) {
        ?>
        <form action="../actions/edit_pet_action.php"  method="post" enctype="multipart/form-data" class="add_edit_pet_form">
            <label>Pet Name:</label><input type="text" name="name" value="<?=$pet_data['name']?>">
            <label for="length">Animal Length(1 to 200 cm):</label>
            <input type="number" id="size" name="size" min="1" max="200" value="<?=$pet_data['size']?>"> <?//substituir por algo decente com js, css e divs?>

            <label for="species">Species</label>
            <?php
            ?>
            <select name="species" id="species">
                <?php
                $species = get_species();
                foreach ($species as $specie){
                    if($specie['specie']==get_specie($pet_data['species'])['specie'])
                        $out_flag = "<option value=".$specie['specie']." selected='selected'>".$specie['specie']."</option>";
                    else
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
                    if($pet_data['color'] == $color['color'])
                        $out_flag = "<option value=".$color['color']." selected='selected'>".$color['color']."</option>";
                    else
                        $out_flag = "<option value=".$color['color'].">".$color['color']."</option>";
                    echo $out_flag;
                }
                ?>
            </select>
            <label for="gender">Gender</label>
            <select name="gender" id="gender">
                <?php
                if($pet_data['gender']=='f'){
                    ?>
                    <option value="female" selected='selected'>female</option>
                    <option value="male">male</option>
                    <?php
                }
                else{ ?>
                    <option value="female">female</option>
                    <option value="male" selected='selected'>male</option>
                    <?php
                }
                ?>
            </select>
            <label for="location">Location</label>
            <input type="text" name="location" id="location" value="<?=$pet_data['location']?>">

            <label for="picture">Picture</label>
            <input type="file" name="picture" id="picture" accept=".jpg, .jpeg, .png, .gif">
            <input type="file" name="other_picture" id="other_pictures" accept=".jpg, .jpeg, .png, .gif" multiple>
            <input type="hidden" name="submit" value="submit">
            <input type="hidden" name="pet_id" value="<?=$pet?>">
            <br>
            <input type="submit" value="Confirm Changes">
            <button id="discard_button" >Discard Changes</button>
            <input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
        </form>

        <?php
    }
}