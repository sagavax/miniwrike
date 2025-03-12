const addButton = document.querySelector(".add_project button"); //add new project button
const projects = document.getElementById("projects_grid"); // list of projects
const create_new_project = document.getElementById("create_new_project"); //create new project_dialog
const project_name = document.getElementById("project_name"); //project title
const project_code = document.getElementById("project_code"); //project title
const project_action = document.querySelector(".project_action"); //project action bar


project_name.addEventListener("keyup", function(){
  var modifiedString = project_name.value.replace(/ /g, "_");
  project_code.value = modifiedString;

})


projects.addEventListener("click", function(event){
  var project_id = event.target.closest(".project").getAttribute("project-id");
  //localStorage.setItem('project_id',project_id);
  window.location.href="project.php?project_id=" + project_id;
})



addButton.addEventListener("click", function(){
  create_new_project.showModal();
  //window.location.href="project_add.php";
})


const search_input = document.querySelector(".search input");

search_input.addEventListener("keyup", function(){
  const xhttp = new XMLHttpRequest();
   xhttp.onload = function() {
        if (xhttp.status >= 200 && xhttp.status < 300) {
           document.querySelector("#projects_grid").innerHTML=this.responseText;
        }
      }   
   
   xhttp.open("GET", "projects_search.php?q="+search_input.value, true);
        xhttp.send();
})

sortButtonsWrap = document.querySelector(".projects_sort");
sortButtonsWrap.addEventListener("click",function(event){
  if(event.target.tagName="BUTTON"){
    buttonName = event.target.name;
    console.log(buttonName);
  }
})

project_action.addEventListener("click", function(eveny){
  if(event.target.tagName==="BUTTON"){
    if(event.target.name==="new_project"){
        if(project_name.value===""){
          alert("project name can not be empty!!!!");
          project_name.focus();
        } else {
            //createNewProject();  
        }
        
    } 
    if(event.target.name==="history_back"){
      create_new_project.close();
    }
  }
})


