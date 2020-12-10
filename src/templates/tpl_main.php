<?php
include_once('../database/animal_queries.php');
include_once('../database/user_queries.php');
function draw_aside(){?>

    <aside id="filter">
        <div id="filterTag">Filter</div>
        <div class="no_bullet" id="filterElement">
            <div class="multipleSelector">
                <p class="radiotext">Species</p>
                <div>
                    <?php
                    $species = get_species();
                    foreach ($species as $specie){
                        $specie = $specie["specie"];
                        ?>
                        <label>
                            <input type="checkbox" id="<?=$specie?>" name="<?=$specie?>">
                            <span></span>
                            <?=$specie?>
                            <br>
                        </label>
                        <?php
                    }
                    ?>
                </div>
            </div>
            <div class="radioSelector">
                <p class="radiotext">Gender</p>
                <div>
                    <label>
                        <input type="radio" id="male" name="gender" value="male">
                        <span></span>
                        Male
                        <br>
                    </label>
                    <label >
                        <input type='radio' id="female" name="gender" value="female">
                        <span></span>
                        Female
                        <br>
                    </label>
                    <label >
                        <input type='radio' id="all" name="gender" value="all"checked="checked">
                        <span></span>
                        All
                        <br>
                    </label>
                </div>
            </div>
            <div class="white-box">
            </div>
        </div>
    </aside>
<?php } ?>

<?php
function draw_animal_profiles(){?>
    <div class=pets_display>
        <div id="animal_profiles">
            <?php
            $animals_array = getAnimals(null,null,null,null,null,null,null,0,20);
            foreach ($animals_array as $animal){
                draw_animal_small($animal["petId"],$animal["name"],null,$animal["size"],$animal["color"],$animal["location"],null,$animal["user"]);
            }
            ?>
        </div>
    </div>

<?php }



function draw_animal_small($pet_id,$name,$species,$size,$color,$location,$state,$user){
    ?>
    <a class="animal_main_page" href = "animal_profile.php?pet_id=<?=$pet_id?>"  >
        <div class="small_animal_box">
            <img class= "animal_image_box" src="<?=get_animal_photo($pet_id)?>" width="200" height="200">
            <label class="animal_text_box">
                <?=$name?>
            </label>
        </div>
    </a>
    <?php
}

function draw_animal_big($pet_id,$name,$species,$size,$color,$location,$state,$user){
    ?>
    <a class="animal_main_page" href = "animal_profile.php?pet_id=<?=$pet_id?>"  >
        <div class="small_animal_box">
            <img class= "animal_image_box" src="<?=get_animal_photo($pet_id)?>" width="200" height="200">
            <label class="animal_text_box">
                <?=$name?>
            </label>
            <div>
            <label class="details">
                <?=$species?>
            </label>
            <label class="details">
                <?=$size?>
            </label>
            <label class="details">
                <?=$color?>
            </label>
            <label class="details">
                <?=$location?>
            </label>
            <label class="details">
                <?=$user?>
            </label>
            </div>
        </div>
    </a>
    <?php
}