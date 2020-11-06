<?php
function draw_aside(){?>

    <aside id="filter">
        <div id="filterTag">Filter</div>
        <div class="no_bullet" id="filterElement">
            <div class="multipleSelector"> 
                    Species 
                    <div> 
                        <label>
                            <input type="checkbox" id="Dog" name="Dog">
                            <span></span>
                            Dog
                            <br>
                        </label>
                        <label >
                            <input type='checkbox' id="Snake" name="Snake">
                            <span></span>
                            Cat
                            <br>
                        </label>
                        <label>
                            <input type='checkbox' id="Snake" name="Snake">
                            <span></span>
                            Snake
                        </label>
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

    <section id="animal_profiles">

    </section>
<?php } ?>
