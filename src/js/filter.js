let name = null;
let loc = null;
let min = null;
let max = null;
let gender = null;
let tags = null;

let minV = 1;
let maxV = 200;

let minR = document.querySelector('input[id="MinSize"]');
let maxR = document.querySelector('input[id="MaxSize"]');
minR.addEventListener("change",setMin);
maxR.addEventListener("change",setMax);

function setMin(evt){
    console.log(evt.target.value,maxR.value);
    maxR.min = escapeHtml(evt.target.value);
}
function setMax(evt){
    console.log(evt.target.value,minR.value);
    minR.max = escapeHtml(evt.target.value);
}

function apply_filter(){
    name = escapeHtml(document.querySelector('input.textInput#Name[id="Name"]').value).toLowerCase();
    loc = escapeHtml(document.querySelector('input.textInput#Location[id="Location"]').value).toLowerCase();
    min =  escapeHtml(document.querySelector('input.intInput#MinSize[id="MinSize"]').value);
    max =  escapeHtml(document.querySelector('input.intInput#MaxSize[id="MaxSize"]').value);

    if(name=="") name=null;
    if(loc=="") loc=null;
    gender = document.querySelector('input[type=radio]:checked').id;
    if(gender=="all"){
        gender=null;
    }
    else{
        gender=gender[0];
    }

    tags = []
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
    request.addEventListener("load",filter_results);
    request.open("post","../actions/filter_action.php",true);
    request.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
    request.send();

}


function filter_results(evt){
    //console.log("ARGUMENTOS",name,loc,min,max,tags,gender);
    let parsed_response = JSON.parse(this.responseText);
    //console.log("DB",parsed_response);

    let match = [];
    for(let i in parsed_response){
        let animal = parsed_response[i];
        if(matches_filter(animal)){
            match.push(animal);
        }
    }

    if(match.length==0){
        alert("No animals match your search criteria.");
    }
    else{
        let parent = document.getElementById("animal_profiles");
        while (parent.firstChild) {
            parent.firstChild.remove();
        }
        for(let i in match){
            let animal=match[i];
            add_pet_profile(parent,animal["petId"],animal["name"],animal["specie"],animal["size"],animal["color"],animal["location"],animal["userName"],animal["path"]);
        }
    }

}

function add_pet_profile(parent,petId,name,species,size,color,location,user,path){
    
    let newa=create_element("a",null,"animal_main_page",null,null);
    newa.href="animal_profile.php?pet_id="+petId;

    let newdiv=create_element("div",null,"animal_box",null,null);

    let newaux=create_element("img",null,"animal_image_box",null,null);
    newaux.width="200";
    newaux.height="200";
    newaux.src=path;
    newdiv.appendChild(newaux);

    newaux=create_element("label",null,"animal_text_box",null,name);
    newdiv.appendChild(newaux);

    // newaux=create_element("label",null,null,null,species);
    // newdiv.appendChild(newaux);

    newaux=create_element("label",null,null,null,size);
    newdiv.appendChild(newaux);

    newaux=create_element("label",null,null,null,color);
    newdiv.appendChild(newaux);

    newaux=create_element("label",null,null,null,location);
    newdiv.appendChild(newaux);

    // newaux=create_element("label",null,null,null,user);
    // newdiv.appendChild(newaux);

    newa.appendChild(newdiv);

    newdiv.rel="stylesheet"
    newdiv.hred="../css/style.css";
    parent.appendChild(newa);

}

function matches_filter(animal){

    if(name!=null){
        if(! animal["name"].toLowerCase().includes(name)){
            return false;
        }
    }
    if(loc!=null){
        if(! animal["location"].toLowerCase().includes(loc)){
            console.log("loc");
            return false;
        }
    }
    let size = parseFloat(animal["size"]);
    if(size<min){
        console.log("min");
        return false;
    }
    if(max!=null && size>max){
        console.log("max");
        return false;
    }
    if(gender!=null && gender!=animal["gender"]){
        console.log("gender");
        return false;
    }
    if(!tags.includes(animal["specie"]) || !tags.includes(animal["color"]) || !tags.includes(animal["state"])){
        console.log("specie color");
        return false;
    }
    return true;
}