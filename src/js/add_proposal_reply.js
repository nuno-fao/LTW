let b = -1;

let accept_b;
let deny_b;

let prop;

let curr_id = -1;

function accept(div_id){
    b=0;
    curr_id = div_id;

    prop = document.querySelector("div[id='"+div_id+"']");

    _proposal_id = escapeHtml(document.querySelector("div[id='"+div_id+"'] input[name='proposal_id']").value);
    _csrf = escapeHtml(document.querySelector("div[id='"+div_id+"'] input[name='csrf']").value);
    _petId = escapeHtml(document.querySelector("div[id='"+div_id+"'] input[name='pet_id']").value);


    let request = new XMLHttpRequest();
    request.addEventListener("load",receive)
    request.open("post","../actions/add_proposal_reply_action.php",true);
    request.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
    request.send(encodeForAjax({petId: _petId, csrf: _csrf,reply: 'a',proposal_id: _proposal_id}));

}

function deny(div_id){
    b=1;
    curr_id = div_id;

    prop = document.querySelector("div[id='"+div_id+"']");

    _proposal_id = escapeHtml(document.querySelector("div[id='"+div_id+"'] input[name='proposal_id']").value);
    _csrf = escapeHtml(document.querySelector("div[id='"+div_id+"'] input[name='csrf']").value);
    _petId = escapeHtml(document.querySelector("div[id='"+div_id+"'] input[name='pet_id']").value);

    let request = new XMLHttpRequest();
    request.addEventListener("load",receive)
    request.open("post","../actions/add_proposal_reply_action.php",true);
    request.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
    request.send(encodeForAjax({petId: _petId, csrf: _csrf,reply: 'r',proposal_id: _proposal_id}));

}

function receive(evt){
    let accept_b = document.querySelector("div[id='"+curr_id+"'] button[id='accept_button']");
    let deny_b = document.querySelector("div[id='"+curr_id+"'] button[id='deny_button']");
    if(this.responseText === 'true'){
        return false;
    }
    if(b==1){
        if(document.querySelector("div[id='"+curr_id+"'] button[id='accept_button']")==null) {
            accept_b = create_element("button","accept_button",null,null,"Accept Proposal");
            //accept_b.addEventListener('click',accept);
            accept_b.setAttribute("onclick","accept("+curr_id+")");
            prop.appendChild(accept_b);
        }
        prop.removeChild(deny_b);
        document.querySelector("div[id='"+curr_id+"'] label[id='proposal_state']").innerHTML = "Denied";
    }
    if(b==0){
        if(document.querySelector("div[id='"+curr_id+"'] button[id='deny_button']")==null) {
            deny_b = create_element("button","deny_button",null,null,"Deny Proposal");
            //deny_b.addEventListener('click',deny);
            deny_b.setAttribute("onclick","deny("+curr_id+")");
            prop.appendChild(deny_b);
        }
        prop.removeChild(accept_b);
        document.querySelector("div[id='"+curr_id+"'] label[id='proposal_state']").innerHTML = "Accepted";

    }
}