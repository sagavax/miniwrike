/*//get project_id from the url
let url =  new URL(window.location.href);
let search_params = url.searchParams; 
localStorage.setItem("project_id", search_params.get("project_id"));
*/
const assigned_pepple_list_header = document.querySelector(".assigned_people_list header");
const assigned_pepple_list_header_input = document.querySelector(".assigned_people_list header input");
const project_assigned_people_wrap = document.querySelector(".project_assigned_people_wrap");
const roles = document.querySelector("#assign_role");
const techs = document.querySelector("#assign_technology");
var projectId = localStorage.getItem('project_id');
const people = document.querySelector("#assign_person");
//const project_managers_wrap = document.querySelector(".project_managers_wrap");
const project_managers = document.querySelector(".project_managers");
const pm_wrap_header = document.querySelector(".pm_wrap_header");
const alpha_list = document.querySelector(".assign_new_pm_wrap .alpha_list");
const find_use_search_bar_input = document.querySelector(".find_use_search_bar input");
const assigned_people_list = document.querySelector(".assigned_people_list");
const assigned_people_pm_popup = document.querySelector(".assigned_people_pm_popup");
const project_assigned_people_badges = document.querySelector(".project_assigned_people_badges");
const project_users_pagination = document.querySelector(".project_assigned_people_status_bar .pagination");
const add_person_project_role_dialog = document.getElementById("add_person_project_role");
const add_person_project_technology_dialog = document.getElementById("add_person_project_technology");

console.log(projectId);

loadProjectIdSessio();


project_users_pagination.addEventListener("click", (event)=> {
  if(event.target.tagName==="BUTTON"){
     //console.log("click");
     //alert (event.target.innerText);
    paginateProjectAssignedPeople(event.target.innerText);
  }  
})

project_managers.addEventListener("click", (event)=>{
  if(event.target.tagName==="BUTTON"){
    const userId = event.target.closest(".assigned_person_badge").getAttribute("user-id");
    //alert(userId);
    removeUserFromPMs(userId);
  }
})


project_assigned_people_badges.addEventListener("click", (event)=> {
    if(event.target.tagName==="BUTTON"){
        const userId = event.target.closest(".assigned_person_badge").getAttribute("user-id");
        alert(userId);
        removePersonFromProject(userId);
           let userElement = document.querySelector(`div.assigned_person_badge[user-id='${userId}']`);
           project_assigned_people_badges.removeChild(userElement); 
           reloadAssignedPeople(); 
    } 
})



pm_wrap_header.addEventListener("click", function(event){
   if(event.target.tagName==="BUTTON"){
    document.getElementById("project_managers_popup").showModal();
    loadAssignedProjectPeople();
    assigned_people_pm_popup.addEventListener("click", (event)=>{
      if(event.target.tagName==="BUTTON"){
        const userId = event.target.getAttribute("user-id");
        //alert(userId);
        AssignUserForPM(userId);
      }
   })   
}

});

alpha_list.addEventListener("click", (event)=>{
    if(event.target.tagName==="BUTTON"){
        const char = event.target.innerText;
        loadNameByChar(char);
    }
})

find_use_search_bar_input.addEventListener("keyup",(event)=>{
    search_string = find_use_search_bar_input.value;
    searchPeople(search_string);
})




assigned_pepple_list_header.addEventListener("click", function(event){
     if(event.target.tagName==="BUTTON" || event.target.tagName==="I"){
        if(event.target.id=="reload_people"){
            //alert("reload list of people");
        } 

        if(event.target.id=="add_new_person"){
            //alert("aasign new people");
        }
     }
})


assigned_pepple_list_header.addEventListener("keyup", (event)=>{
    if(event.target.tagName==="INPUT"){
        //console.log(assigned_pepple_list_header_input.value);
        const searchPerson = assigned_pepple_list_header_input.value;
        assignedPeopleSearch(searchPerson)
    }
})

//remove person from the projects
project_assigned_people_wrap.addEventListener("click", function(event) {
    if (event.target.name === "remove_from_project") { // click on remove 
        const userId = event.target.closest(".assigned_person").getAttribute("user-id");
        console.log(event.target.name, userId);
        //removePersonFromProject(userId);
    }
    if (event.target.matches(".person_name")) {
        alert(event.target.innerText, userId);
    }
    if (event.target.name === "add_role") {
        const userId = event.target.closest(".assigned_person").getAttribute("user-id");
        console.log(event.target.name, userId);
        //AssignRole(userId);
        //alert("Assign role");
        add_person_project_role_dialog.showModal()
        if(add_person_project_role_dialog){
            GetRoles();
            add_person_project_role_dialog.addEventListener("click", (event)=>{
                if(event.target.tagName==="BUTTON"){
                    const roleId = event.target.getAttribute("role-id");
                    console.log(roleId, userId);
                    AssignRole(userId, roleId);
                }
            })
        }
    } 
    if (event.target.name === "add_technology") {
        const userId = event.target.closest(".assigned_person").getAttribute("user-id");
        console.log(event.target.name, userId);
        add_person_project_technology_dialog.showModal();
        if(add_person_project_technology_dialog){
            GetTechnologies();
            add_person_project_technology_dialog.addEventListener("click", (event)=>{
                if(event.target.tagName==="BUTTON"){
                    const techId = event.target.getAttribute("tech-id");
                    console.log(techId, userId);
                    AssignTech(userId, techId);
                }
            })
        }
    }
});

//assigne close action for all dialog close buttons
let elements = document.querySelectorAll(".dialog_header button");
elements.forEach((element) => {
    element.addEventListener('click', function() {
       dialogId = this.closest("dialog").id;
       //console.log(dialogId);	
       closedialog(dialogId);
    });
});


document.getElementById("add_new_person").addEventListener("click", ()=> {
	document.getElementById("assign_person").showModal();
})

document.getElementById("reload_people").addEventListener("click", () => reloadAssignedPeople());

document.getElementById("add_new_role").addEventListener("click", function(){
	document.getElementById("assign_role").showModal();
})

document.getElementById("add_new_technology").addEventListener("click", function(){
	document.getElementById("assign_technology").showModal();
})



//assign technology(ies)
// Assign technology(ies

techs.addEventListener("change", function(event) {
    if (event.target.tagName === "SELECT") {
        const tech_id = event.target.options[event.target.selectedIndex].value;
        const technology = event.target.options[event.target.selectedIndex].text.trim();

        const projectId = localStorage.getItem("project_id");

        GetAllAssignedTechnologies(projectId, function(assigned_techs) {
            console.log(assigned_techs); // Log the assigned technologies for debugging

            // Ensure case-insensitive comparison
            const techExists = assigned_techs.map(t => t.toLowerCase()).indexOf(technology.toLowerCase()) !== -1;

            if (techExists) {
                alert("Already assigned");
            } else {
                AssignProjectTechnology(tech_id, projectId);
                // alert("Not assigned"); // This seems unnecessary if AssignProjectTechnology is called
            }
        });
    }
});

roles.addEventListener("change", function(event) {
    if (event.target.tagName === "SELECT") {
        const role_index = event.target.options[event.target.selectedIndex].value;
        const role = event.target.options[event.target.selectedIndex].text.trim();
        console.log(role);
        
        const projectId = localStorage.getItem("project_id");

        GetAllAssignedRoles(projectId, function(assigned_roles) {
            console.log(assigned_roles); // Log the assigned roles array

            // Ensure case-insensitive comparison
            const roleExists = assigned_roles.map(r => r.toLowerCase()).indexOf(role.toLowerCase()) !== -1;

            if (roleExists) {
                alert("Already assigned");
            } else {
                AssignProjectRole(role_index, projectId);
                // alert("not assigned"); // This seems unnecessary if AssignProjectRole is called
            }
        });
    }
});



people.addEventListener("change", function(event) {
    if (event.target.tagName === "SELECT") {
        const person_index = event.target.options[event.target.selectedIndex].value;
        const person = event.target.options[event.target.selectedIndex].text.trim();
        console.log(person_index);
        
        const projectId = localStorage.getItem("project_id");

        AssignProjectPerson(person_index, projectId);
    }
});

//get all assigned user for project
function GetAssignedPeople(projectId){
     const xhttp = new XMLHttpRequest();
      xhttp.onload = function() {
        if (xhttp.status >= 200 && xhttp.status < 300) {
           reloadAssignedPeople()
        }
      }     
     
     xhttp.open("GET", "project_assigned_people_select.php?project_id=" + encodeURIComponent(projectId), true);
        //var data = "project_id=" + encodeURIComponent(projectId) + "&person_id=" + encodeURIComponent(personId);
        //console.log(data);
        xhttp.send();
}

function searchPeople(search_string){
      const xhttp = new XMLHttpRequest();
    xhttp.onload = function() {
        if (xhttp.status >= 200 && xhttp.status < 300) {
            document.querySelector(".found_people_list").innerHTML = xhttp.responseText;
        } else {
            console.error('Failed to load assigned people');
        }
    };

     xhttp.open("GET", "project_users_search.php?search_string="+search_string, true);
     xhttp.send();
}


function loadNameByChar(char){
    const xhttp = new XMLHttpRequest();
    xhttp.onload = function() {
        if (xhttp.status >= 200 && xhttp.status < 300) {
            document.querySelector(".found_people_list").innerHTML = xhttp.responseText;
        } else {
            console.error('Failed to load assigned people');
        }
    };

     xhttp.open("GET", "project_users_find_by_char.php?char="+char, true);
     xhttp.send();
}


function loadAssignedProjectPeople() {
    const xhttp = new XMLHttpRequest();
    xhttp.onload = function() {
        if (xhttp.status >= 200 && xhttp.status < 300) {
            document.querySelector(".assigned_people_pm_popup").innerHTML = xhttp.responseText;
        } else {
            console.error('Failed to load assigned people');
        }
    };

    xhttp.open("POST", "project_assigned_people_buttons.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    
    const projectId = localStorage.getItem("project_id");
    if (projectId) {
        const data = "project_id=" + encodeURIComponent(projectId);
        xhttp.send(data);
    } else {
        console.error('No project ID found in localStorage');
    }
}



function LoadProjectManagers(){
     const xhttp = new XMLHttpRequest();
      xhttp.onload = function() {
        if (xhttp.status >= 200 && xhttp.status < 300) {
           document.querySelector(".project_managers").innerHTML = xhttp.responseText;                     
        }
      }     
     
     xhttp.open("GET", "project_managers_load.php?project_id="+projectId, true);
        //console.log(data);
        xhttp.send();
}

function AssignProjectPerson(personId, projectId){
     const xhttp = new XMLHttpRequest();
      xhttp.onload = function() {
        if (xhttp.status >= 200 && xhttp.status < 300) {
            //remove select

            //reload list of unassigned perople
            GetAssignedPeople(projectId);
        }
      }     
     
     xhttp.open("POST", "project_assign_person.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        var data = "project_id=" + encodeURIComponent(projectId) + "&person_id=" + encodeURIComponent(personId);
        //console.log(data);
        xhttp.send(data);
}



//assigne role(s)
function AssignProjectRole(roleId, projectId){
	 const xhttp = new XMLHttpRequest();
	  xhttp.onload = function() {
        if (xhttp.status >= 200 && xhttp.status < 300) {
        	GetLastestRole(projectId);
        }
      } 	
	 
	 xhttp.open("POST", "project_assign_role.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        var data = "project_id=" + encodeURIComponent(projectId) + "&role_id=" + encodeURIComponent(roleId);
        //console.log(data);
        xhttp.send(data);
}

                                                                                     
//assign technology(ies)
function AssignProjectTechnology(techId, projectId){
	 const xhttp = new XMLHttpRequest();
	  xhttp.onload = function() {
        if (xhttp.status >= 200 && xhttp.status < 300) {
        	GetLastestTechnology(projectId);	
        }
      } 	
	 
	 xhttp.open("POST", "project_assign_technology.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        var data = "project_id=" + encodeURIComponent(projectId) + "&tech_id=" + encodeURIComponent(techId);
        xhttp.send(data);
}



//create role
function CreateProjectRole(projectId){
	 const xhttp = new XMLHttpRequest();
	  xhttp.onload = function() {
        if (xhttp.status >= 200 && xhttp.status < 300) {

        }
      } 	
	 
	 xhttp.open("POST", "project_create_role.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        var data = "project_id=" + encodeURIComponent(projectId) + "&role_name=" + encodeURIComponent(roleId);
        xhttp.send(data);
}



//create technology
function CreateProjectTechnology(projectId){
	 const xhttp = new XMLHttpRequest();
	  xhttp.onload = function() {
        if (xhttp.status >= 200 && xhttp.status < 300) {

        }
      } 	
	 
	 xhttp.open("POST", "project_create_technolgy.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        var data = "project_id=" + encodeURIComponent(projectId) + "&tech_id=" + encodeURIComponent(techId);
        xhttp.send(data);
}


function GetLastestTechnology(projectId){
	 const xhttp = new XMLHttpRequest();
	  xhttp.onload = function() {
        if (xhttp.status >= 200 && xhttp.status < 300) {
        	const jsonData = JSON.parse(this.responseText); // Parse the JSON response
        	//console.log(jsonData);
        	for (var i = 0; i < jsonData.length; i++) {
				    var tech = jsonData[i];
				    
				    //console.log(role);
				    const button = document.createElement("button");
				    button.classList.add("button");
				    button.textContent = tech.technology_name;
				    
				    var addNewTechButton = document.getElementById('add_new_technology');

		            document.querySelector(".project_technologies").insertBefore(button, addNewTechButton); // Insert new button before the add_new_role button
				    //document.querySelector(".project_technologies").appendChild(button); // Append button to the .project_technologies element
			}	
        }
      } 	
    xhttp.open("GET", "project_get_latest_tech.php?project_id="+projectId, true);
    xhttp.send();
}

function GetLastestRole(projectId){
	const xhttp = new XMLHttpRequest();
	  xhttp.onload = function() {
        if (xhttp.status >= 200 && xhttp.status < 300) {
        	const jsonData = JSON.parse(this.responseText); // Parse the JSON response
        	for (var i = 0; i < jsonData.length; i++) {
				    var role = jsonData[i];
				    //console.log(role);
				    const button = document.createElement("button");
				    button.classList.add("button");
				    button.textContent = role.role_name;

		            var addNewRoleButton = document.getElementById('add_new_role');

		            document.querySelector(".project_roles").insertBefore(button, addNewRoleButton); // Insert new button before the add_new_role button
				    //document.querySelector(".project_roles").appendChild(button); // Append button to the .project_roles element
				}
        }
      } 	
    xhttp.open("GET", "project_get_latest_role.php?project_id="+projectId, true);
    xhttp.send();
}


function GetAllAssignedRoles(projectId, callback){
	const xhttp = new XMLHttpRequest();
	  xhttp.onload = function() {
        if (xhttp.status >= 200 && xhttp.status < 300) {
        	const jsonData = JSON.parse(this.responseText); // Parse the JSON response
        	var assigned_roles = [];
        	for (var i = 0; i < jsonData.length; i++) {
				    
				    var role = jsonData[i];
				    assigned_roles.push(role.role_name);
				}
		  callback(assigned_roles);		
        }
      } 	
    xhttp.open("GET", "project_get_list_assigned_roles.php?project_id="+projectId, true);
    xhttp.send();
}

function GetAllAssignedTechnologies(projectId, callback){
	const xhttp = new XMLHttpRequest();
	  xhttp.onload = function() {
        if (xhttp.status >= 200 && xhttp.status < 300) {
        	const jsonData = JSON.parse(this.responseText); // Parse the JSON response
        	var assigned_techs = [];
        	for (var i = 0; i < jsonData.length; i++) {
				    
				    var tech = jsonData[i];
				    assigned_techs.push(tech.technology_name);
				}
		  callback(assigned_techs);		
        }
      } 	
    xhttp.open("GET", "project_get_list_assigned_techs.php?project_id="+projectId, true);
    xhttp.send();
}




function closedialog(dialogId){
	console.log(dialogId);
	document.getElementById(dialogId).close();
}


function removePersonFromProject(userId){
      const xhttp = new XMLHttpRequest();
      xhttp.onload = function() {
        if (xhttp.status >= 200 && xhttp.status < 300) {
            let userElement = document.querySelector(`div.assigned_person_badge[user-id='${userId}']`);
            console.log(userElement);
            project_assigned_people_wrap.removeChild(userElement);
            alert("Removed from project");
        }
      }     
     
        xhttp.open("POST", "project_users_remove_from_project.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        var projectId = localStorage.getItem("project_id");
        var data = "project_id=" + encodeURIComponent(projectId)+"&user_id="+userId;
        xhttp.send(data);
}


function reloadAssignedPeople(){
     const xhttp = new XMLHttpRequest();
      xhttp.onload = function() {
        if (xhttp.status >= 200 && xhttp.status < 300) {
            document.querySelector(".project_assigned_people_wrap").innerHTML = xhttp.responseText;
            document.querySelector(".project_assigned_people_status_bar").innerHTML = "Reload done";
        }

      }     
     
     xhttp.open("POST", "project_assigned_people.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        var projectId = localStorage.getItem("project_id");
        var data = "project_id=" + encodeURIComponent(projectId);
        xhttp.send(data);
}

function loadProjectIdSessio(){
        // Create an XMLHttpRequest object
var xhr = new XMLHttpRequest();
xhr.open('POST', 'project_store_session.php', true);
xhr.setRequestHeader('Content-Type', 'application/json');

// Define a callback function
xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
        // Parse the JSON response
        var response = JSON.parse(xhr.responseText);
        console.log(response);
        console.log('Success:', response);
    }
};

// Send the project_id to the backend
xhr.send(JSON.stringify({ project_id: projectId }));
}


function AssignUserForPM(userId){
      const xhttp = new XMLHttpRequest();
      xhttp.onload = function() {
        if (xhttp.status >= 200 && xhttp.status < 300) {
                project_managers.innerHTML="";
                LoadProjectManagers();     
        }   
      }     
     
     xhttp.open("POST", "project_assign_user_for_pm.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        var projectId = localStorage.getItem("project_id");
        var data = "project_id=" + encodeURIComponent(projectId)+"&user_id="+encodeURIComponent(userId);
        xhttp.send(data);
}


function LoadProjectManagers(){
   const xhttp = new XMLHttpRequest(); 
   xhttp.onload = function() {
        if (xhttp.status >= 200 && xhttp.status < 300) {
            project_managers.innerHTML = xhttp.responseText;           
        }
      }     
     
     var data = "project_id=" + encodeURIComponent(projectId);
     xhttp.open("GET", "project_managers_load.php?"+data, true);
     xhttp.send();   
}



//remove user as PM 
function removeUserFromPMs(userId){
    const xhttp = new XMLHttpRequest(); 
   xhttp.onload = function() {
        if (xhttp.status >= 200 && xhttp.status < 300) {
            let userElement = document.querySelector(`div.assigned_person_badge[user-id='${userId}']`);
            project_managers.removeChild(userElement);                      
        }
      }     
     
     xhttp.open("POST", "project_remove_pm.php", true);
     xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
     var data = "project_id=" + encodeURIComponent(projectId)+"&user_id="+userId;
     xhttp.send(data);   
}

function paginateProjectAssignedPeople(page){
      const xhttp = new XMLHttpRequest(); 
   xhttp.onload = function() {
        if (xhttp.status >= 200 && xhttp.status < 300) {
            project_assigned_people_wrap.innerHTML = xhttp.responseText;           
        }
      }     
     
     const  projectId = localStorage.getItem("project_id");
     var data = "project_id=" + encodeURIComponent(projectId)+"&page="+page;
     xhttp.open("GET", "project_assigned_people_paginate.php?"+data, true);
     xhttp.send(); 
}


function assignedPeopleSearch(searchPerson){
        const xhttp = new XMLHttpRequest(); 
   xhttp.onload = function() {
        if (xhttp.status >= 200 && xhttp.status < 300) {
            project_assigned_people_wrap.innerHTML = xhttp.responseText;           
        }
      }     
     
     const  projectId = localStorage.getItem("project_id");
     var data = "project_id=" + encodeURIComponent(projectId)+"&string="+searchPerson;
     xhttp.open("GET", "project_assigned_people_search.php?"+data, true);
     xhttp.send(); 
}

function GetTechnologies(){
         const xhttp = new XMLHttpRequest(); 
        xhttp.onload = function() {
        if (xhttp.status >= 200 && xhttp.status < 300) {
            project_assigned_people_wrap.innerHTML = xhttp.responseText;           
        }
      }     
     
     xhttp.open("GET", "project_technologies.php", true);
     xhttp.send(); 
}

function AssignRole(userId, roleId){
     const xhttp = new XMLHttpRequest();
    xhttp.onload = function() {
        if (xhttp.status >= 200 && xhttp.status < 300) {
           document.getElementById("add_person_project_role")/close();
        }
    };

    xhttp.open("POST", "project_assign_person_role.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    
    const projectId = localStorage.getItem("project_id");
    
        const data = "project_id=" + encodeURIComponent(projectId)+"&role_id="+roleId+"&user_id="+userId;
        xhttp.send(data);
    
}

function AssignTech(userId, techId){
       const xhttp = new XMLHttpRequest();
    xhttp.onload = function() {
        if (xhttp.status >= 200 && xhttp.status < 300) {
           document.getElementById("add_person_project_technology").close();
        }
    };

    xhttp.open("POST", "project_assign_person_technology.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    
    const projectId = localStorage.getItem("project_id");

        const data = "project_id=" + encodeURIComponent(projectId)+"&tech_id="+techId+"&user_id="+userId;
        xhttp.send(data);
    
}



function GetRoles(){
    const xhttp = new XMLHttpRequest(); 
        xhttp.onload = function() {
        if (xhttp.status >= 200 && xhttp.status < 300) {
            add_person_project_role_dialog.innerHTML = xhttp.responseText;           
        }
      }     
     
     xhttp.open("GET", "project_roles.php?", true);
     xhttp.send(); 
}


function GetTechnologies(){
       const xhttp = new XMLHttpRequest(); 
        xhttp.onload = function() {
        if (xhttp.status >= 200 && xhttp.status < 300) {
            add_person_project_technology_dialog.innerHTML = xhttp.responseText;           
        }
      }     
     
     xhttp.open("GET", "project_technologies.php?", true);
     xhttp.send(); 
}
