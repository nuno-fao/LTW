let user_edit_button = document.querySelector("button[id=edit_user_profile]");
user_edit_button.addEventListener('click',edit_request);

function edit_request(evt){
    evt.preventDefault();

    let _user = escapeHtml(document.querySelector("input[name='user']").value);
    let _email = escapeHtml(document.querySelector("input[name='e_address']").value);
    let _name = escapeHtml(document.querySelector("input[name='name']").value);
    let _pass = escapeHtml(document.querySelector("input[name='pass']").value);
    let _csrf = escapeHtml(document.querySelector("input[name='csrf']").value);

    let request = new XMLHttpRequest();
    request.addEventListener("load",receiveRegistry);
    request.open("post","../actions/register_action.php",true);
    request.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
    request.send(encodeForAjax({name: _name, pass: _pass, csrf: _csrf, user: _user, e_address: _email}));

}
function receiveRegistry(evt){
    if(this.responseText === 'true'){
        return false;
    }
}



let user_make_change_button = document.querySelector("button[id=edit_user_profile]");
user_make_change_button.addEventListener('click',make_change_user_request);

function make_change_user_request(evt){
    evt.preventDefault();

    let _user = escapeHtml(document.querySelector("input[name='user']").value);
    let _email = escapeHtml(document.querySelector("input[name='e_address']").value);
    let _name = escapeHtml(document.querySelector("input[name='name']").value);
    let _pass = escapeHtml(document.querySelector("input[name='pass']").value);
    let _csrf = escapeHtml(document.querySelector("input[name='csrf']").value);

    let request = new XMLHttpRequest();
    request.addEventListener("load",receiveRegistry);
    request.open("post","../actions/register_action.php",true);
    request.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
    request.send(encodeForAjax({name: _name, pass: _pass, csrf: _csrf, user: _user, e_address: _email}));

}
