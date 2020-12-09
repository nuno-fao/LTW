function show_reply(_questionId){
    let request = new XMLHttpRequest();
    request.addEventListener("load",receive_reply);
    request.open("post","../actions/show_reply_action.php",true);
    request.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
    request.send(encodeForAjax({questionId: _questionId}));
}

function receive_reply(evt){
    if(this.responseText == 'true' ){
        //document.getElementById("comment_submit_message").innerHTML="Error Adding Question!";
        return false;
    }
    let parsed_response = JSON.parse(this.responseText);
    let question = document.getElementById("question_id_"+parsed_response['questionId']);
    question.removeChild(question.lastElementChild);
    if(parsed_response['replies'].length <= 0){
        //there are no replies
        let newp, newCont;
        newp = document.createElement("p");
        newCont = document.createTextNode("There are no replies yet");
        newp.appendChild(newCont);
        question.appendChild(newp);
    }
    else{
        
        let replies_aux=parsed_response['replies'];
        //console.log(replies_aux);
        for(let reply in replies_aux){
            let newspan, newCont;

            newspan = document.createElement("span");
            newspan.className="reply_user";
            newCont = document.createTextNode(escapeHtml(replies_aux[reply]['userName'] + ' replied: '));
            newspan.appendChild(newCont);
            question.appendChild(newspan);

            newspan = document.createElement("span");
            newspan.className="reply_date";
            newCont = document.createTextNode(escapeHtml(format_time(replies_aux[reply]['date'])));
            newspan.appendChild(newCont);
            question.appendChild(newspan);

            newspan = document.createElement("p");
            newspan.className="reply_text";
            newCont = document.createTextNode(escapeHtml(replies_aux[reply]['answerTxt']));
            newspan.appendChild(newCont);
            question.appendChild(newspan);
        }
    }

    let newform = document.createElement("form");
    newform.class="replyform";
    newform.id=parsed_response['questionId'];

    let newChild = document.createElement("p");
    let newCont = document.createTextNode("Send A Reply");
    newChild.appendChild(newCont);
    newform.appendChild(newChild);

    newChild = document.createElement("textarea");
    newChild.name = "reply_text";
    newform.appendChild(newChild);

    newChild = document.createElement("input");
    newChild.type="hidden";
    newChild.name="questionId";
    newChild.value=""+parsed_response['questionId']+"";
    newform.appendChild(newChild);

    newChild = document.createElement("input");
    newChild.type="submit";
    newChild.value="submit"
    newform.appendChild(newChild);

    

    question.appendChild(newform);


    let form_r = document.querySelector("form[id='"+parsed_response['questionId']+"']");
    form_r.addEventListener('submit',submitReply);

}

function submitReply(evt){
    evt.preventDefault();
    let _questionId = evt.originalTarget.id;

    let _reply_text = escapeHtml(document.querySelector("form[id='"+_questionId+"'] textarea[name='reply_text']").value);

    let request = new XMLHttpRequest();
    request.addEventListener("load",receiveNewReply)
    request.open("post","../actions/add_reply_action.php",true);
    request.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
    request.send(encodeForAjax({questionId: _questionId, reply_text: _reply_text}));

}

function receiveNewReply(evt){
    let parsed_reply;
    try{
        parsed_reply = JSON.parse(this.responseText);
    }
    catch(expcetion){
        return;
    }

    let textarea = document.querySelector("form[id='"+parsed_reply['questionId']+"'] textarea[name='reply_text']");
    textarea.value="";

    if(parsed_reply['error'] == true){
        textarea.placeholder="You must be logged in...";
        return false;
    }

    
    let question = document.getElementById("question_id_"+parsed_reply['questionId']);
    let form_r = document.querySelector("form[id='"+parsed_reply['questionId']+"']");

    let newspan, newCont;

    newspan = document.createElement("span");
    newspan.className="reply_user";
    newCont = document.createTextNode(escapeHtml(parsed_reply['userName'] + ' replied: '));
    newspan.appendChild(newCont);
    question.insertBefore(newspan,form_r);

    newspan = document.createElement("span");
    newspan.className="reply_date";
    newCont = document.createTextNode(escapeHtml(format_time(parsed_reply['date'])));
    newspan.appendChild(newCont);
    question.insertBefore(newspan,form_r);

    newspan = document.createElement("p");
    newspan.className="reply_text";
    newCont = document.createTextNode(escapeHtml(parsed_reply['reply_txt']));
    newspan.appendChild(newCont);
    question.insertBefore(newspan,form_r);

}