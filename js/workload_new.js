const assigned_tasks = document.querySelector(".assigned_tasks");
const unassigned_tasks = document.querySelector(".unassigned_tasks");
const inactive_tasks  = document.querySelector(".inactive_tasks");

assigned_tasks.addEventListener("click", function(event){
    if(event.target.tagName === 'LI'){
        const taskID = event.target.getAttribute("task-id");
        //console.log(taskID);
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
  	}	
})

inactive_tasks.addEventListener("dragstart", function(event){
	 if(event.target.tagName === 'LI'){
	 	  // Clear the drag data cache (for all formats/types)
  		//event.dataTransfer.clearData();
  		event.dataTransfer.setData("Text", event.target.getAttribute("task-id"));
  		console.log("i am dragging inactive"+ event.target.getAttribute("task-id"));
	 }
})





const drop_targets = document.querySelectorAll(".person_assigned_tasks"); // Use a common class for all drop targets

document.addEventListener("dragover", function(event) {
    if (event.target.classList.contains("person_assigned_tasks")) {
        console.log("dragOver on target:", event.target.getAttribute('data-id'));
        event.preventDefault(); // Prevent default to allow drop
    }
});


function handleDrop(event) {
    const taskId = event.dataTransfer.getData("Text");
    const listItem = document.querySelector("[task-id='" + taskId + "']");
    
    event.preventDefault();
    event.target.appendChild(listItem); // Ensure we append to the correct target
    var userId = event.target.getAttribute('data-id');
    console.log("Task with ID: "+ taskId+" assigned to user ID: "+userId );
    //assign a task
    AssignTask(taskId, userId)
    //reload unassigned tasks
    //reloadUnassignedTasks(projectId)
}


var wrkldd_tasks = document.querySelectorAll(".task_id");

// Iterate over each task
wrkldd_tasks.forEach(function(wrkldd_task) {
    // Add click event listener to each task
    wrkldd_task.addEventListener("click", function() {
        var taskId = this.getAttribute("task-id");
        window.location.href='project_task.php?task_id='+taskId;
        console.log(taskId);
    });
});


function AssignTask(taskId, userId){
	const xhttp = new XMLHttpRequest();
	 xhttp.onload = function() {
        if (xhttp.status >= 200 && xhttp.status < 300) {
            alert("Task has been assigned");
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


function reloadUnassignedTasks(project_id){
	 xhttp.onload = function() {
        if (xhttp.status >= 200 && xhttp.status < 300) {
            alert("Task has been assigned");
        } else {
            console.error("Failed to reload tasks. Server responded with status:", xhttp.status);
            alert("Failed to create comment. Please try again later.");
        }
    };
     xhttp.open("GET", "project_workload_unassigned_tasks.php?project_id="+projectId, true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send();
}