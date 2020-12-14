let form_login = document.querySelector("form[id='edit_pass_form']");
form_login.addEventListener('submit',editPassRequest);


let _name;

function editPassRequest(evt){
    evt.preventDefault();

    let _oldpass = escapeHtml(document.querySelector("input[name='oldpass']").value);
    let _newpass = document.querySelector("input[name='newpass']").value;
    let _confirm = document.querySelector("input[name='confirm']").value;
    let _csrf = escapeHtml(document.querySelector("input[name='csrf']").value);
    _name = escapeHtml(document.querySelector("input[name='user']").value);


    let request = new XMLHttpRequest();
    request.addEventListener("load",receiveEditPass)
    request.open("post","../actions/edit_pass_action.php",true);
    request.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
    request.send(encodeForAjax({oldpass: _oldpass, newpass: _newpass, confirm: _confirm, name: _name, csrf: _csrf}));

}

function receiveEditPass(evt){
    if(this.responseText === 'true'){
        return false;
    }
    let answer = JSON.parse(this.responseText);
    document.activeElement.blur();

    let error = false;

    let oldpass = document.querySelector("input[name='oldpass']");
    let newpass = document.querySelector("input[name='newpass']");
    let confirm =  document.querySelector("input[name='confirm']");

    if(answer['oldpass']==true){
        error = true;

        
        oldpass.placeholder = "Password Incorrect";
        confirm.placeholder = "New Password";
        newpass.placeholder = "Confirm New Password";

        on_error_animate(oldpass);
    }
    else if(answer['newpass']==true){
        error = true;

        oldpass.placeholder = "Password Incorrect";
        newpass.placeholder = "Password Has Invalid Characters";
        newpass.placeholder = "Confirm New Password";

        on_error_animate(newpass);
    }
    else if(answer['confirm']==true){
        error = true;

        oldpass.placeholder = "Old Password";
        confirm.placeholder = "Passwords Should Match";
        newpass.placeholder = "Passwords Should Match";

        on_error_animate(confirm);
    }

    if(answer['safety_error']==true){
        error = true;
    }
    if(!error){
        window.location.replace("user.php?user=" + _name);
    }
    else{
        oldpass.value = "";
        newpass.value = "";
        confirm.value = "";
    }
}