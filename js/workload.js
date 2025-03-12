const assigned_tasks = document.querySelector(".assigned_tasks");
const unassigned_tasks = document.querySelector(".unassigned_tasks");
const inactive_tasks  = document.querySelector(".inactive_tasks");
const drop_targets = document.querySelectorAll(".person_assigned_tasks"); // Use a common class for all drop targets
var add_task_button = document.querySelector(".unassigned_tasks header button");
var wrkldd_tasks = document.querySelectorAll(".task_id");
const assigned_people = document.querySelectorAll(".assigned_person");
const show_unaasigned_tasks_dialog = document.getElementById("show_unaasigned_tasks");


assigned_tasks.addEventListener("click", function(event){
    if(event.target.tagName === 'LI'){
        const taskID = event.target.getAttribute("task-id");
        console.log(taskID);
    }
});


unassigned_tasks.addEventListener("click", function(event){
    if(event.target.tagName === 'LI'){
        //const taskID = event.target.getAttribute("task-id");
		event.dataTransfer.clearData();
  		event.dataTransfer.setData("text/plain", event.target.getAttribute("task-id"));
  		console.log("i am dragging unassigned: "+ event.target.getAttribute("task-id"));
    }
});

inactive_tasks.addEventListener("click", function(event){
    if(event.target.tagName === 'LI'){
        const taskID = event.target.getAttribute("task-id");
        console.log(taskID);
    }
});


unassigned_tasks.addEventListener("dragstart", function(event){
	if(event.target.tagName === 'LI'){
	   //event.dataTransfer.clearData();
  		event.dataTransfer.setData("Text", event.target.getAttribute("task-id"));
  		console.log("i am dragging unassigned: "+ event.target.getAttribute("task-id"));
        sessionStorage.setItem("task-id",event.target.getAttribute("task-id"));
  	}	
})

inactive_tasks.addEventListener("dragstart", function(event){
	 if(event.target.tagName === 'LI'){
	 	  // Clear the drag data cache (for all formats/types)
  		//event.dataTransfer.clearData();
  		event.dataTransfer.setData("Text", event.target.getAttribute("task-id"));
  		console.log("i am dragging inactive"+ event.target.getAttribute("task-id"));
        sessionStorage.setItem("task-id",event.target.getAttribute("task-id"));
	 }
})







document.addEventListener("dragover", function(event) {
    if (event.target.classList.contains("person_assigned_tasks")) {
        console.log("dragOver on target:", event.target.getAttribute('data-id'));
        event.preventDefault(); // Prevent default to allow drop
    }
});


assigned_tasks.addEventListener("dragstart", function(event){
    if(event.target.tagName === 'LI'){
       //event.dataTransfer.clearData();
        event.dataTransfer.setData("Text", event.target.getAttribute("task-id"));
        console.log("i am dragging unassigned: "+ event.target.getAttribute("task-id"));
    }   
})



add_task_button.addEventListener("click", function(){
    document.getElementById("add_new_task_dialog").showModal();
})    

var add_new_task_dialog_button = document.querySelector("#add_new_task_dialog button");
add_new_task_dialog_button.addEventListener("click", function(){
    var projectId = sessionStorage.getItem("project_id");
    CreateTask(projectId);
})



function handleDrop(event) {
    const taskId = event.dataTransfer.getData("Text");
    const listItem = document.querySelector("[task-id='" + taskId + "']");
    
    event.preventDefault();
    event.target.appendChild(listItem); // Ensure we append to the correct target
    var userId = event.target.getAttribute('data-id');
    console.log("Task with ID: "+ taskId+" assigned to user ID: "+userId );
    //assign a task
    AssignTask(taskId, userId);
    //reload unassigned tasks
    CheckReplaceStatus(taskId);   
    //reloadUnassignedTasks(projectId)
}


// Attach drop event listener to each drop target
drop_targets.forEach(drop_target => {
    drop_target.addEventListener("drop", handleDrop);
});


assigned_people.forEach(function(assignedPerson){
    assignedPerson.addEventListener("click", function(event){
        if(event.target.tagName === "BUTTON"){
            //alert("hello");
            show_unaasigned_tasks_dialog.showModal();
            if(show_unaasigned_tasks_dialog){
                projectId = localStorage.getItem("project_id");
                LoadUnassignedTasks(projectId)
            }    
        }     
    });
});


/*// Iterate over each task
wrkldd_tasks.forEach(function(wrkldd_task) {
    // Add click event listener to each task
    wrkldd_task.addEventListener("click", function() {
        var taskId = this.getAttribute("task-id");
        window.location.href='project_task.php?task_id='+taskId;
        console.log(taskId);
    });
});
*/

function AssignTask(taskId, userId){
	const xhttp = new XMLHttpRequest();
	 xhttp.onload = function() {
        if (xhttp.status >= 200 && xhttp.status < 300) {
            alert("Task has been assigned");
            //ChangingStatusInprogress(taskId);
        } else {
            console.error("Failed to create comment. Server responded with status:", xhttp.status);
            alert("Failed to create comment. Please try again later.");
        }
    };
     xhttp.open("POST", "project_workload_assign_task.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        var data = "task_id=" + encodeURIComponent(taskId) + "&user_id=" + encodeURIComponent(userId);
        xhttp.send(data);
}


function reloadUnassignedTasks(){
     var projectId = sessionStorage.getItem("project_id");
     const xhttp = new XMLHttpRequest();     
	 xhttp.onload = function() {
        if (xhttp.status >= 200 && xhttp.status < 300) {
            
            document.querySelector("#add_new_task_dialog input").value="";
            document.querySelector("#add_new_task_dialog").close();
            document.querySelector(".unassigned_tasks main").innerHTML = this.responseText;
        } else {
            console.error("Failed to reload tasks. Server responded with status:", xhttp.status);
            alert("Failed to create comment. Please try again later.");
        }
    };
     xhttp.open("GET", "project_workload_unassigned_tasks.php?project_id="+projectId, true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send();
}

function CreateTask(projectId){
    const xhttp = new XMLHttpRequest();
     xhttp.onload = function() {
        if (xhttp.status >= 200 && xhttp.status < 300) {
            alert("Task has been created");
            reloadUnassignedTasks(projectId);
        } else {
            console.error("Failed to create task. Server responded with status:", xhttp.status);
            alert("Failed to create Task. Please try again later.");
        }
    };
if(taskText===""){
     alert("Cannot be empty");
} else {
    var taskText = document.querySelector("#add_new_task_dialog input").value
    var data = "project_id=" + encodeURIComponent(projectId)+"&task_name="+encodeURIComponent(taskText);
    xhttp.open("POST", "project_task_create.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(data);       
    }
}


function CheckReplaceStatus(taskId){
    const xhttp = new XMLHttpRequest();
     xhttp.onload = function() {
        if (xhttp.status >= 200 && xhttp.status < 300) {
            response = this.responseText;
            if(response==="in_progress"){
                const liElement = document.querySelector(`li[task-id="${taskId}"]`);
                const statusDiv = liElement.querySelector('.wrkld_task_status');
                statusDiv.textContent = "in progress";
            }
            //change status in
        } else {
            console.error("Failed to create comment. Server responded with status:", xhttp.status);
            alert("Failed to create comment. Please try again later.");
        }
    };
     xhttp.open("POST", "project_workload_check_replace_status.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        var data = "task_id=" + encodeURIComponent(taskId);
        xhttp.send(data);
}