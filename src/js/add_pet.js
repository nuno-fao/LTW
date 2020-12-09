let form_add_pet = document.querySelector("section[id='pet_info'] form");
form_add_pet.addEventListener('submit',add_pet);

function add_pet(evt){
    evt.preventDefault();

    let _name = escapeHtml(document.querySelector("input[name='name']").value);

    let request = new XMLHttpRequest();
    request.addEventListener("load",recieve_add_pet)
    request.open("post","../actions/add_pet_action.php",true);
    request.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
    request.send(encodeForAjax({name: _name}));

}

function recieve_add_pet(evt){
    if(this.responseText === 'true'){
        return false;
    }
}