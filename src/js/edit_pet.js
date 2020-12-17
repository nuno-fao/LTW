let form_edit_pet = document.querySelector("form");
form_edit_pet.addEventListener('submit',edit_pet);

let discard_edit_pet = document.getElementById("discard_button");
discard_edit_pet.onclick = function (e){
    e.preventDefault();
    window.location.replace("animal_profile.php?pet_id="+escapeHtml(document.querySelector("input[name='pet_id']").value));
};

console.log(form_edit_pet,discard_edit_pet);

let _name ;
let _length ;
let _species;
let _color;
let _gender ;
let _location ;
let _csrf ;
let _pet_id;

let request ;


let fileInput ;
let file;
let formData ;


let other_pics;
let pic_input = fileInput = document.getElementById("picture");
pic_input.onchange = function (e){
}

function edit_pet(evt){
    evt.preventDefault();

    _name = (document.querySelector("input[name='name']"));
    _length = (document.querySelector("input[name='size']"));
    _species = (document.querySelector("select[name='species']"));
    _color = (document.querySelector("select[name='color']"));
    _gender = (document.querySelector("select[name='gender']"));
    _location = (document.querySelector("input[name='location']"));
    _csrf = (document.querySelector("input[name='csrf']"));
    _pet_id = (document.querySelector("input[name='pet_id']"));

    request = new XMLHttpRequest();
    request.addEventListener("load",receive_edit_pet)
    request.open("post","../actions/edit_pet_action.php",true);
    //request.setRequestHeader('Content-Type','multipart/form-data');


    fileInput = document.getElementById("picture");
    other_pics = document.getElementById("other_pictures");
    file = fileInput.files[0];
    formData = new FormData();
    for (let i = 0; i<other_pics.files.length;i++){
        formData.append('picture'+i.toString(),other_pics.files[i])
    }

    formData.append('picture', file);
    formData.append('name',escapeHtml(_name.value));
    formData.append('size',escapeHtml(_length.value));
    formData.append('species',escapeHtml(_species.value));
    formData.append('color',escapeHtml(_color.value));
    formData.append('gender',escapeHtml(_gender.value));
    formData.append('location',escapeHtml(_location.value));
    formData.append('csrf',escapeHtml(_csrf.value));
    formData.append('pet_id',escapeHtml(_pet_id.value));
    formData.append('submit',"submit");
    request.send(formData);

}

function receive_edit_pet(evt){
    if(this.responseText == true){
        return false;
    }
    let error = false;
    let parsed_reply = JSON.parse(this.responseText);
    if(parsed_reply['main_pic'] == true){
        on_error_animate(fileInput);
        fileInput.style="color: red";
        error = true;
    }
    else {
        fileInput.style="color: black";
    }
    if(parsed_reply['name']){
        on_error_animate(_name);
        _name.style="color: red";
        error = true;
    }
    else {
        _name.style="color: black";
    }

    if(parsed_reply['size']){
        on_error_animate(_length);
        _length.style="color: red";
        error = true;
    }
    else {
        _length.style="color: black";
    }
    if(parsed_reply['species']){
        on_error_animate(_species);
        _species.style="color: red";
        error = true;
    }
    else {
        _species.style = "color: black";
    }

    if(parsed_reply['color']){
        on_error_animate(_color);
        _color.style="color: red";
        error = true;
    }
    else {
        _color.style="color: black";
    }

    if(parsed_reply['location']){
        on_error_animate(_location);
        _location.style="color: red";
        error = true;
    }
    else {
        _location.style="color: black";
    }

    if(parsed_reply['gender']){
        on_error_animate(_gender);
        _gender.style="color: red";
        error = true;
    }
    else {
        _gender.style="color: black";
    }
    if(parsed_reply['safety_error']){
        on_error_animate(fileInput);
        fileInput.style="color: red";
        error = true;
    }
    else {
        fileInput.style="color: black";
    }
    if(parsed_reply['other_pics']){
        on_error_animate(other_pics);
        other_pics.style="color: red";
        error = true;
    }
    else {
        other_pics.style="color: black";
    }
    console.log(error);
    if(!error)
        window.location.replace("animal_profile.php?pet_id="+escapeHtml(parsed_reply['pet_id']));
}