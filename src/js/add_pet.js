let form_add_pet = document.querySelector("section[id='pet_info'] form");
form_add_pet.addEventListener('submit',add_pet);

function add_pet(evt){
    evt.preventDefault();

    let _name = escapeHtml(document.querySelector("input[name='name']").value);
    let _length = escapeHtml(document.querySelector("input[name='size']").value);
    let _dateofbirth = escapeHtml(document.querySelector("input[name='dateofbirth']").value);
    let _species = escapeHtml(document.querySelector("select[name='species']").value);
    let _color = escapeHtml(document.querySelector("select[name='color']").value);
    let _gender = escapeHtml(document.querySelector("select[name='gender']").value);
    let _location = escapeHtml(document.querySelector("input[name='location']").value);
    let _csrf = escapeHtml(document.querySelector("input[name='csrf']").value);

    let request = new XMLHttpRequest();
    request.addEventListener("load",recieve_add_pet)
    request.open("post","../actions/add_pet_action.php",true);
    //request.setRequestHeader('Content-Type','multipart/form-data');


    var fileInput = document.getElementById("picture");
    var file = fileInput.files[0];
    var formData = new FormData();
    formData.append('picture', file);
    formData.append('name',_name);
    formData.append('size',_length);
    formData.append('dateofbirth',_dateofbirth);
    formData.append('species',_species);
    formData.append('color',_color);
    formData.append('gender',_gender);
    formData.append('location',_location);
    formData.append('csrf',_csrf);
    formData.append('submit',"submit");
    request.send(formData);

}

function recieve_add_pet(evt){
    if(this.responseText == true){
        return false;
    }


}