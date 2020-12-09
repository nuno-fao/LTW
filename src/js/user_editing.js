let user_edit_button = document.querySelector("button[id=edit_user_profile]");
user_edit_button.addEventListener('click',edit_request);

let _user ;
let _name ;
let _email ;

let user_info ;
let script ;

let new_user ;
let new_name ;
let new_email ;

let discard_changes_button ;
let make_changes_button;

function edit_request(evt) {
    evt.preventDefault();

    _user = document.querySelector("aside[id='user_profile'] label[id='user']");
    _name = document.querySelector("aside[id='user_profile'] label[id='name']");
    _email = document.querySelector("aside[id='user_profile'] label[id='email']");

    user_info = document.querySelector("aside[id='user_profile']");
    user_info.removeChild(_user);
    user_info.removeChild(_name);
    user_info.removeChild(_email);
    user_info.removeChild(user_edit_button);
    script = document.querySelector("aside[id='user_profile'] script");

    new_user = create_element("input", "user", null, escapeHtml(_user.innerHTML).trim(), null);
    new_name = create_element("input", "name", null, escapeHtml(_name.innerHTML).trim(), null);
    new_email = create_element("input", "email", null, escapeHtml(_email.innerHTML).trim(), null);
    new_user.type = "text";
    new_name.type = "text";
    new_email.type = "text";

    discard_changes_button = create_element("button", "discard_button", null, null, "Discard Changes");
    make_changes_button = create_element("button", "make_changes", null, null, "Make Changes");

    make_changes_button.addEventListener('click', make_change_user_request);
    discard_changes_button.addEventListener('click', discard_changes);

    user_info.insertBefore(new_user, script);
    user_info.insertBefore(new_name, script);
    user_info.insertBefore(new_email, script);
    user_info.appendChild(make_changes_button);
    user_info.appendChild(discard_changes_button);
}
function make_change_user_request(evt){

    let request = new XMLHttpRequest();
    request.addEventListener("load",receive_edition);
    request.open("post","../actions/edit_user_action.php",true);
    request.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
    request.send(
        encodeForAjax(
            {
                name: escapeHtml(new_name.value).trim(),
                csrf: document.querySelector('input[id="csrf"]').value,
                user: remove_spaces(escapeHtml(new_user.value).trim()),
                e_address: remove_spaces(escapeHtml(new_email.value).trim())
            }
        )
    );

}


function receive_edition(evt){
    let answer = this.responseText;
    if(answer == true){
        alert("Not Logged In");
        return false;
    }
    try {
        answer = JSON.parse(this.responseText);
    }
    catch (err){
    }
    let error = false;

    if(answer['user']==true){
        on_error_animate(new_user);
        new_user.style = "color: red";
        error = true;
    }
    else {
        new_user.style = "color: black";
    }
    if(answer['email']==true){
        on_error_animate(new_email);
        new_email.style = "color: red";
        error = true;
    }
    else {
        new_email.style = "color: black";
    }
    if(answer['name']==true){
        on_error_animate(new_name);
        new_name.style = "color: red";
        error = true;
    }
    else {
        new_name.style = "color: black";
    }
    if(!error){
        if(new_user.value!=remove_spaces(_user.innerHTML)){
            window.location.replace("user.php?user="+escapeHtml(new_user.value));
        }
        else reset_user_info();
    }
}

function reset_user_info(){
    user_info.removeChild(new_user);
    user_info.removeChild(new_name);
    user_info.removeChild(new_email);
    user_info.removeChild(discard_changes_button);
    user_info.removeChild(make_changes_button);

    _user.innerHTML=escapeHtml(new_user.value).trim()+" ";
    _name.innerHTML=escapeHtml(new_name.value).trim()+" ";
    _email.innerHTML=escapeHtml(new_email.value).trim()+" ";
    user_info.appendChild(_user);
    user_info.appendChild(_name);
    user_info.appendChild(_email);
    user_info.appendChild(user_edit_button);

}

function discard_changes(evt){
    evt.preventDefault();

    user_info.removeChild(new_user);
    user_info.removeChild(new_name);
    user_info.removeChild(new_email);
    user_info.removeChild(discard_changes_button);
    user_info.removeChild(make_changes_button);

    user_info.appendChild(_user);
    user_info.appendChild(_name);
    user_info.appendChild(_email);
    user_info.appendChild(user_edit_button);
}
