let form_login = document.querySelector("form[id='register_form']");
form_login.addEventListener('submit',requestRegistry);

document.querySelector("input[name='user']").oninput = function (evt){
    let request = new XMLHttpRequest();
    request.addEventListener("load",receive_user_check);
    request.open("post","../actions/check_user_action.php",true);
    request.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
    request.send(encodeForAjax({user: document.querySelector("input[name='user']").value}));
}

function receive_user_check(evt){
    if(this.responseText === "false"){
        document.querySelector("input[name='user']").style = "color: black"
    }
    else {
        document.querySelector("input[name='user']").style = "color: red"
        on_error_animate(document.querySelector("input[name='user']"));
    }
}


function requestRegistry(evt){
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
    let answer = JSON.parse(this.responseText);
    document.activeElement.blur();

    let error = false;

    if(answer['pass']==true){
        error = true;
        document.querySelector("input[name='pass']").value = "";
        document.querySelector("input[name='pass']").placeholder = "Password incorrect";
    }

    if(answer['user']=="invalid_user"){
        error = true;
        document.querySelector("input[name='user']").value = "";
        document.querySelector("input[name='pass']").value = "";
        document.querySelector("input[name='user']").placeholder = "User not Valid";
    }
    else if(answer['user']=="user_in_use"){
        error = true;
        document.querySelector("input[name='user']").value = "";
        document.querySelector("input[name='pass']").value = "";
        document.querySelector("input[name='user']").placeholder = "User Name already Registered";

    }
    if(answer['email']==true){
        error = true;
        document.querySelector("input[name='email']").value = "";
        document.querySelector("input[name='email']").placeholder = "Email not valid";
    }

    if(answer['name']==true){
        error = true;
        document.querySelector("input[name='name']").value = "";
        document.querySelector("input[name='name']").placeholder = "Name Not Valid";
    }

    if(answer['safety_error']==true){
        error = true;
    }
    if(!error){
        window.location.replace("../index.php");
    }
}