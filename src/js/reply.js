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
    let scoob = JSON.parse(this.responseText);
    if(scoob['replies'].length <= 0){
        //there are no replies
    }
    else{
        let question = document.getElementById("article.question[id="+scoob['questionId']+"]");
        let scoobAux=scoob['replies'];
        console.log(scoobAux);
        for(let reply in scoobAux){
            
            // let newspan, newCont;

            // newspan = document.createElement("span");
            // newspan.className="user";
            // newCont = document.createTextNode(escapeHtml(scoob['userName'] + ' replied: '));
            // newspan.appendChild(newCont);
            // newArticle.appendChild(newspan);

            // newspan = document.createElement("span");
            // newspan.className="date";
            // newCont = document.createTextNode(escapeHtml(format_time(scoob['date'])));
            // newspan.appendChild(newCont);
            // newArticle.appendChild(newspan);

            // newspan = document.createElement("p");
            // newCont = document.createTextNode(escapeHtml(scoob['comment_txt']));
            // newspan.appendChild(newCont);
            // newArticle.appendChild(newspan);
        }
    }
}