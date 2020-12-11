let parent = null;

function submitReply(parentId){
    parent = document.getElementById(parentId);
    let _text = escapeHtml(parent.children[1].value);
    let _userId = escapeHtml(parent.children[2].value);
    let _questionId = escapeHtml(parent.children[3].value);
    let _csrf = escapeHtml(parent.children[5].value);

    if(_text.length <= 0){
        alert("Reply must contain something");
        return;
    }

    let request = new XMLHttpRequest();
    request.addEventListener("load",receiveReply)
    request.open("post","../actions/add_reply_action.php",true);
    request.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
    request.send(encodeForAjax({questionId: _questionId, userId: _userId, text: _text, csrf: _csrf}));

}

function receiveReply(evt){

    let parsed_reply;
    try{
        parsed_reply = JSON.parse(this.responseText);
    }
    catch(expcetion){
        return;
    }

    let newdiv = create_element("div",null,"reply",null);

    let newchild = create_element("a","author",null,null);
    let newtext = document.createTextNode(parsed_reply['userName']+" replied:");
    newchild.appendChild(newtext);
    newchild.href="user.php?user="+parsed_reply['userName'];
    newdiv.appendChild(newchild);

    newchild = create_element("span",null,"date",null);
    newtext = document.createTextNode(format_time(parsed_reply['date']));
    newchild.appendChild(newtext);
    newdiv.appendChild(newchild);

    newchild = create_element("p",null,null,null);
    newtext = document.createTextNode(parsed_reply['reply_txt']);
    newchild.appendChild(newtext);
    newdiv.appendChild(newchild);

    // let after = parent;
    // parent = document.getElementById("replies_dropdown_"+parsed_reply['questionId']);
    //console.log(parent,after);
    parent.parentElement.insertBefore(newdiv,parent);

    parent.children[1].value="";

    //console.log(parent);    
}