let accept_b = document.querySelector("button[id='accept_button']");
let deny_b = document.querySelector("button[id='deny_button']");

let prop = document.querySelector("div[class='proposal']");

console.log(accept_b,deny_b);

if(accept_b !=null)
    accept_b.addEventListener('click',accept);
if(deny_b != null)
    deny_b.addEventListener('click',deny);

let b = -1;

function accept(evt){
    evt.preventDefault();
    b=0;

    let _proposal_id = escapeHtml(document.querySelector("input[name='proposal_id']").value);
    let _csrf = escapeHtml(document.querySelector("input[name='csrf']").value);
    let _petId = escapeHtml(document.querySelector("input[name='petId']").value);


    let request = new XMLHttpRequest();
    request.addEventListener("load",receive)
    request.open("post","../actions/add_proposal_reply_action.php",true);
    request.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
    request.send(encodeForAjax({petId: _petId, csrf: _csrf,reply: 'a',proposal_id: _proposal_id}));

}

function deny(evt){
    evt.preventDefault();
    b=1;

    let _proposal_id = escapeHtml(document.querySelector("input[name='proposal_id']").value);
    let _csrf = escapeHtml(document.querySelector("input[name='csrf']").value);
    let _petId = escapeHtml(document.querySelector("input[name='petId']").value);


    let request = new XMLHttpRequest();
    request.addEventListener("load",receive)
    request.open("post","../actions/add_proposal_reply_action.php",true);
    request.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
    request.send(encodeForAjax({petId: _petId, csrf: _csrf,reply: 'r',proposal_id: _proposal_id}));

}

function receive(evt){
    if(this.responseText === 'true'){
        return false;
    }
    if(b==1){
        if(document.querySelector("button[id='accept_button']")==null) {
            accept_b = create_element("button","accept_button",null,null,"Accept Proposal");
            accept_b.addEventListener('click',accept);
            prop.appendChild(accept_b);
        }
        prop.removeChild(deny_b);
        document.querySelector("label[id='proposal_state']").innerHTML = "Denied";
    }
    if(b==0){
        if(document.querySelector("button[id='deny_button']")==null) {
            deny_b = create_element("button","deny_button",null,null,"Deny Proposal");
            deny_b.addEventListener('click',deny);
            prop.appendChild(deny_b);
        }
        prop.removeChild(accept_b);
        document.querySelector("label[id='proposal_state']").innerHTML = "Accepted";

    }
}