function apply_filter(){
    let name = escapeHtml(document.querySelector('input.textInput#Name[id="Name"]').value);
    let location = escapeHtml(document.querySelector('input.textInput#Location[id="Location"]').value);
    let min =  escapeHtml(document.querySelector('input.intInput#MinSize[id="MinSize"]').value);
    let max =  escapeHtml(document.querySelector('input.intInput#MaxSize[id="MaxSize"]').value);

    
    let gender = document.querySelector('input[type=radio]:checked').id;
    if(gender=="all"){
        gender=null;
    }
    else{
        gender=gender[0];
    }

    let tags = []
    let checkboxes = document.querySelectorAll('input[type=checkbox]:checked');
    for (let i = 0; i < checkboxes.length; i++) {
        tags.push(checkboxes[i].name)
    }



    min=parseInt(min); 
    max=parseInt(max);

    if(min!=NaN && max!=NaN){
        if(max<min){
            alert("Filter Max size is lower than Min size!");
            return;
        }
    }
    else{
        if(min==NaN){
            min=0;
        }
        if(max==NaN){
            max=null;
        }

    } 

    let request = new XMLHttpRequest();
    request.addEventListener("load",function (){filter_results(name,location,min,max,tags,gender)});
    request.open("post","../actions/filter_action.php",true);
    request.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
    request.send();

}


function filter_results(name,location,min,max,tags,gender){
    console.log("ARGUMENTOS",name,location,min,max,tags,gender);
    console.log(this.responseText);
    let parsed_response = JSON.parse(this.responseText);
    console.log("DB",parsed_response);


}