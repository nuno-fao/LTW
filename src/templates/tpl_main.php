<?php
include_once('database/animal_queries.php');
function draw_aside(){?>

    <aside id="filter">
        <div id="filterTag">Filter</div>
        <div class="no_bullet" id="filterElement">
            <div class="multipleSelector">
                Species
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
                Gender
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
        </div>
    </aside>
<?php } ?>

<?php
function draw_animal_profiles(){?>
    <div id="animal_profiles">
        <?php
        $animals_array = getAnimals(null,null,null,null,null,null,null,0,20);
        foreach ($animals_array as $animal){
            draw_animal($animal["petId"],$animal["name"],null,$animal["size"],$animal["color"],$animal["location"],null,$animal["user"]);
        }
        ?>
    </div>
<?php }

function draw_animal($pet_id,$name,$species,$size,$color,$location,$state,$user){
    ?>
    <a id="animal_main_page" href = "animal_profile.php?pet_id=<?=$pet_id?>"  >
        <label>
            <?=$name?>
        </label>
        <label>
            <?=$size?>
        </label>
        <label>
            <?=$color?>
        </label>
        <label>
            <?=$location?>
        </label>
        <label>
            <?=$user?>
        </label>
        <img src="<?=get_animal_photo($pet_id)?>" width="200" height="200">
    </a>
    <?php
}