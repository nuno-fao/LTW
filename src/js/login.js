let form_login = document.querySelector("form[id='login_form']");
form_login.addEventListener('submit',loginRequest);

function loginRequest(evt){
    evt.preventDefault();

    let _name = escapeHtml(document.querySelector("input[name='name']").value);
    let _pass = escapeHtml(document.querySelector("input[name='pass']").value);
    let _csrf = escapeHtml(document.querySelector("input[name='csrf']").value)

    let request = new XMLHttpRequest();
    request.addEventListener("load",receiveLogin)
    request.open("post","../actions/login_action.php",true);
    request.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
    request.send(encodeForAjax({name: _name, pass: _pass, csrf: _csrf}));

}

function receiveLogin(evt){
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

    if(answer['user']==true){
        error = true;
        document.querySelector("input[name='name']").value = "";
        document.querySelector("input[name='pass']").value = "";
        document.querySelector("input[name='name']").placeholder = "User Incorrect";
    }

    if(answer['safety_error']==true){
        error = true;
    }
    if(!error){
        window.location.replace("../index.php");
    }
}