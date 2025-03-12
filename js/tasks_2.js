
 const task_names = document.querySelectorAll(".task_name");
 //console.log(tasks);
 for(var i=0; i<task_names.length;i++){
 	
 	var task_name = task_names[i];

 	task_name.addEventListener("click",function(){
 			//alert(this.closest(".task").getAttribute("task-id"));
 		
 		const task_id = this.closest(".task").getAttribute("task-id");
 		window.location.href="project_task.php?task_id="+task_id;
 	})
 }




/*const tasks_filtered_by = document.querySelector(".filter");

tasks_filtered_by.addEventListener('change', function(event) {
  if (event.target.tagName === 'SELECT') {
    var selectName = event.target.getAttribute('name');
    var selectedValue = event.target.value; // You can move this line outside the switch statement since it's common to all cases
    
    switch (selectName) {
      case 'priority':
        //console.log('Selected value for priority:', selectedValue);
        //get project id
        projectId = sessionStorage.getItem("project_id");
        //set mass task priority
        GetTasksByPriority(projectId, selectedValue); 
        break;
      case 'status':
        //console.log('Selected value for status:', selectedValue);
        //get project id
        projectId = sessionStorage.getItem("project_id");
        //set new status
        GetTasksByStatus(projectId, selectedValue)
        break;
      // Add additional cases for other select elements if needed
    }
  }
 });*/


//tasks mass actio
const tasks_mass_action = document.querySelector(".project_tasks_mass_action");

tasks_mass_action.addEventListener('change', function(event) {
  if (event.target.tagName === 'SELECT') {
    var selectName = event.target.getAttribute('name');
    var selectedValue = event.target.value; // You can move this line outside the switch statement since it's common to all cases
    var projectId = sessionStorage.getItem("project_id");
    switch (selectName) {
      case 'priority':
        console.log('Selected value for priority:', selectedValue);
        //get project id
        projectId = sessionStorage.getItem("project_id");
        //set mass task priority
        SetTaskMassPriority(projectId, selectedValue); 
        break;
      case 'status':
        console.log('Selected value for status:', selectedValue);
        //get project id
        projectId = sessionStorage.getItem("project_id");
        //set new status
        SetTaskMassStatus(projectId, selectedValue)
        break;
      // Add additional cases for other select elements if needed
       case 'filter_status':  
       console.log('Selected value for status', selectedValue);         
       GetTasksByStatus(projectId, selectedValue);
       break;
       case 'filter_priority':  
       console.log('Selected value for priority', selectedValue);         
       GetTasksByPriority(projectId, selectedValue)
       break;
    }
  }
 });


 
const tasks = document.querySelector(".project_tasks");

tasks.addEventListener('change', function(event) {
  if (event.target.tagName === 'SELECT') {
    var selectName = event.target.getAttribute('name');
    var taskId = event.target.closest(".task").getAttribute("task-id");
    var selectedValue = event.target.value; // You can move this line outside the switch statement since it's common to all cases
    
    switch (selectName) {
      case 'priority':
      	console.log('Selected value for priority:', selectedValue);
        //set task priority
        SetTaskPriority(taskId, selectedValue); 
        break;
      case 'status':
      	console.log('Selected value for status:', selectedValue);
        //set new status
        SetTaskStatus(taskId, selectedValue);
        break;
      // Add additional cases for other select elements if needed
     
    }
  }
 });

tasks.addEventListener("click", function(event) {
    // Check if the clicked element is a button
    if (event.target.tagName === 'BUTTON') {
        var buttonName = event.target.getAttribute('name');
        console.log('Selected value for status:', buttonName);
        if(buttonName==='mark_complete'){
          const taskId = event.target.closest(".task").getAttribute("task-id");
          const parent =  event.target.closest(".task_action");
          parent.removeChild(buttonName);
          SetTaskComplete(taskId);
        }
        if (buttonName==='cancel_task'){
          const taskId = event.target.closest(".task").getAttribute("task-id");
          SetTaskCancelled(taskId);
        }
    }

    // Check if the clicked element is an <i> (icon) inside a button
    if (event.target.tagName === 'I') {
        // Find the closest button element and retrieve its name attribute
        var buttonName = event.target.closest("BUTTON").getAttribute("name");
         if(buttonName==='mark_complete'){
          const taskId = event.target.closest(".task").getAttribute("task-id");
                  
          SetTaskComplete(taskId);

          //remove complete task button
          //const parent =  event.target.closest(".task_action");
          //const buttonToRemove = parent.querySelector("button[name='mark_complete']");
          //buttonToRemove.remove();
        }

        if (buttonName==='cancel_task'){
          const taskId = event.target.closest(".task").getAttribute("task-id");
          SetTaskCancelled(taskId);
        }

    }
});



function SetTaskPriority(taskId, priority){
	console.log(taskId, priority);
 	const xhttp = new XMLHttpRequest();
          xhttp.onload = function() {

          }
          
        xhttp.open("POST", "project_task_set_priority.php",true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        var data = "task_id="+encodeURIComponent(taskId)+"&priority="+encodeURIComponent(priority);                
        xhttp.send(data);
}
	


function SetTaskStatus(taskId, status){
	console.log(taskId, status);
	const xhttp = new XMLHttpRequest();
          xhttp.onload = function() {

          }
          
        xhttp.open("POST", "project_task_set_status.php",true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        var data = "task_id="+encodeURIComponent(taskId)+"&status="+encodeURIComponent(status);                
        xhttp.send(data);
}


function SetTaskComplete(taskId){
  const xhttp = new XMLHttpRequest();
          xhttp.onload = function() {
            alert("Task has been completed")
          }
          
        xhttp.open("POST", "project_task_mark_complete.php",true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        var data = "task_id="+encodeURIComponent(taskId);                
        xhttp.send(data);
}

function SetTaskCancelled(taskId){
  const xhttp = new XMLHttpRequest();
          xhttp.onload = function() {
            alert("Task has been cancelled")
          }
          
        xhttp.open("POST", "project_task_mark_cancelled.php",true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        var data = "task_id="+encodeURIComponent(taskId);                
        xhttp.send(data);
}



function SetTaskMassPriority(projectId, priority){
  
  const xhttp = new XMLHttpRequest();
          xhttp.onload = function() {

          }
          
        xhttp.open("POST", "project_all_tasks_set_priority.php",true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        var data = "project_id="+encodeURIComponent(projectId)+"&priority="+encodeURIComponent(priority);                
        xhttp.send(data);
}
  


function SetTaskMassStatus(projectId, status){
  
  const xhttp = new XMLHttpRequest();
          xhttp.onload = function() {

          }
          
        xhttp.open("POST", "project_all_tasks_set_status.php",true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        var data = "project_id="+encodeURIComponent(projectId)+"&status="+encodeURIComponent(status);                
        xhttp.send(data);
}


function GetTasksByPriority(projectId, priority){
 
  const xhttp = new XMLHttpRequest();
          xhttp.onload = function() {
            document.querySelector(".project_tasks").innerHTML = this.responseText;
          }
        projectId = sessionStorage.getItem("project_id");  
        xhttp.open("POST", "project_task_get_priority.php",true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        var data = "project_id="+encodeURIComponent(projectId)+"&priority="+encodeURIComponent(priority);                
        xhttp.send(data);
}
  


function GetTasksByStatus(projectId, status){
  
  const xhttp = new XMLHttpRequest();
          xhttp.onload = function() {
            document.querySelector(".project_tasks").innerHTML = this.responseText;
          }
        projectId = sessionStorage.getItem("project_id");  
        xhttp.open("POST", "project_task_get_status.php",true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        var data = "project_id="+encodeURIComponent(projectId)+"&status="+encodeURIComponent(status);                
        xhttp.send(data);
}


function reload_tasks(projectId){

  const xhttp = new XMLHttpRequest();
          xhttp.onload = function() {
            document.querySelector(".project_tasks").innerHTML = this.responseText;
          }
        projectId = sessionStorage.getItem("project_id");  
        xhttp.open("POST", "project_tasks_reload.php",true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        var data = "project_id="+encodeURIComponent(projectId);                
        xhttp.send(data);
}



const add_task = document.getElementById("add_task");

add_task.addEventListener("click", function(event) {
    var projectId = sessionStorage.getItem("project_id");

    // Check if the clicked element is a button
    if (event.target.tagName === 'BUTTON') {
          ProjectTaskCreate(projectId);
        }
    // Check if the clicked element is an <i> (icon) inside a button
    if (event.target.tagName === 'I') {
          ProjectTaskCreate(projectId);
     }
          
});


function ProjectTaskCreate(projectId){
   
 const xhttp = new XMLHttpRequest();
var projectId = sessionStorage.getItem("project_id");
var task_input = document.querySelector("#add_task input");

// Define the callback function for the XMLHttpRequest
xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
        alert("New task has been added");
        task_input.value = "";
        reload_tasks(projectId); // Use projectId directly, without the '$' prefix
    }
};

var task_name = task_input.value;
if (task_name == "") {
    task_input.style.borderWidth = "3px";
    task_input.style.borderStyle = "solid";
    task_input.style.borderColor = "red";
    alert("Cannot be empty!!!!");
    setTimeout(input_back_to_normal, 3000);
} else {
    xhttp.open("POST", "project_task_create.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    var data = "project_id=" + encodeURIComponent(projectId) + "&task_name=" + encodeURIComponent(task_name);
    xhttp.send(data);

       } 
}


function input_back_to_normal(){
   var task_input = document.querySelector("#add_task input");
   task_input.style.borderWidth = "1px";
   task_input.style.borderColor = "#666";
}

