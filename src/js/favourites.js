let form_f = document.querySelector("form[id='favourite_form']");
form_f.addEventListener('submit',submitComment);

function submitComment(evt){
    evt.preventDefault();

    let _petId = escapeHtml(document.querySelector("input[name='petId']").value);
    let _csrf = escapeHtml(document.querySelector("input[name='csrf']").value)

    let request = new XMLHttpRequest();
    request.addEventListener("load",receiveFavourite)
    request.open("post","../actions/favourite_action.php",true);
    request.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
    request.send(encodeForAjax({petId: _petId, csrf: _csrf}));

}

function receiveFavourite(evt){
    if(this.responseText === 'true'){
        return false;
    }
    let button_text = document.querySelector("form[id='favourite_form'] input#fav_button").value;
    if(button_text === "Remove from Favourites"){
        document.querySelector("form[id='favourite_form'] input#fav_button").value = "Add to Favourites";
    }
    else if (button_text === "Add to Favourites"){
        document.querySelector("form[id='favourite_form'] input#fav_button").value = "Remove from Favourites";
    }
    else {
        document.querySelector("form[id='favourite_form'] input#fav_button").value = "ERROR";
    }

}