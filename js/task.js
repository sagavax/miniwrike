const timeline_pagination = document.querySelector(".timeline_pagination");
// Select all elements with the class 'info_box'
var info_box_values = document.querySelectorAll(".info_box_value select");
//dialog assig person for task 
const assign_person_to_project = document.getElementById("assign_person_to_project");
//
const dateInput = document.querySelector('input[type="date"][name="task_deadline"]');
//
const task_assigned_person = document.querySelector(".task_assigned_person");
const task_assigned_person_wrap = document.querySelector(".task_assigned_person_wrap");


task_assigned_person_wrap.addEventListener("click", function(event){
    taskId = localStorage.getItem("task_id");
    if(event.target.name==="add_new_person"){
        assign_person_to_project.showModal();    
    } else if (event.target.name==="remove_person"){
        document.querySelector('button[user-id]').remove();
        removeFromTask(taskId);
    }
})


assign_person_to_project.addEventListener("click", function(event){
    if(event.target.tagName==="BUTTON"){
        userId = event.target.getAttribute("user-id");
        taskId = localStorage.getItem("task_id");
        AssignPersonToTask(taskId, userId);
    }
})

info_box_values.forEach(function(info_box) {
    // Add an event listener for the 'change' event to each info_box
    info_box.addEventListener("change", function(event) {
        // Check if the event target is a 'SELECT' element with the name 'task_status'
        if (event.target.tagName === "SELECT" && event.target.name === "task_status") {
            // Get the new status value
            var new_status = event.target.value;
            // Log the new status value
            console.log(new_status);
            // Call the changeStatus function with the new status
             changeStatus(new_status);
        }

         if (event.target.tagName === "SELECT" && event.target.name === "task_priority") {
            // Get the new status value
            var new_priority = event.target.value;
            // Log the new status value
            console.log(new_priority);
            // Call the changeStatus function with the new status
            changePriority(new_priority);
        }
    });
});



dateInput.addEventListener("change", function(){
    changeDeadlime(dateInput.value);    
    console.log(dateInput.value);
})

const timeline_see_more_button = document.querySelector(".timeline_see_more button");
    timeline_see_more_button.addEventListener("click", function(){
        document.getElementById("project_task_full_history").showModal();
        console.log("click");
    })

document.querySelector("#project_task_full_history button").addEventListener("click", ()=> {
    document.getElementById("project_task_full_history").close();
})



timeline_pagination.addEventListener("click", function(event){
    if(event.target.tagName==="BUTTON"){
        const page = event.target.innerText;
        taskFullHistoryPaging(page);
    }
})




function changeStatus(new_status){
    const xhttp = new XMLHttpRequest();
     xhttp.onload = function() {
        if (xhttp.status >= 200 && xhttp.status < 300) {
            alert("Task status has been changed to "+new_status);
            GetkTimeline(taskId)
        } else {
            console.error("Failed to change status. Server responded with status:", xhttp.status);
            alert("Failed to chnage status. Please try again later.");
        }
    };
     xhttp.open("POST", "project_task_change_status.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        var taskId = sessionStorage.getItem('task_id');
        var projectId = sessionStorage.getItem('project_id');
        var data = "task_id=" + encodeURIComponent(taskId) + "&task_status=" + encodeURIComponent(new_status)+"&project_id=" + encodeURIComponent(projectId);;
        xhttp.send(data);
}

function changePriority(new_priority){
    const xhttp = new XMLHttpRequest();
     xhttp.onload = function() {
        if (xhttp.status >= 200 && xhttp.status < 300) {
            alert("Priority has been changed to "+ new_priority);
            GetkTimeline(taskId);
        } else {
            console.error("Failed to change status. Server responded with status:", xhttp.status);
            alert("Failed to chnage status. Please try again later.");
        }
    };
     xhttp.open("POST", "project_task_change_priority.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        var taskId = sessionStorage.getItem('task_id');
        var projectId = sessionStorage.getItem('project_id');
        var data = "task_id=" + encodeURIComponent(taskId) + "&task_priority=" + encodeURIComponent(new_priority)+"&project_id=" + encodeURIComponent(projectId);
        xhttp.send(data);
}

function GetkTimeline(taskId){
    const xhttp = new XMLHttpRequest();
     xhttp.onload = function() {
        if (xhttp.status >= 200 && xhttp.status < 300) {
             //document.querySelector(".task_timeline").innerHTML = this.responseText;
            //ChangingStatusInprogress(taskId);
        } else {
            console.error("Failed to change status. Server responded with status:", xhttp.status);
            alert("Failed to chnage status. Please try again later.");
        }
    };
    
    xhttp.open("POST", "project_task_assign_person.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
}

function assignTaskPerson(userId){
     const xhttp = new XMLHttpRequest();
     xhttp.onload = function() {
        if (xhttp.status >= 200 && xhttp.status < 300) {
            //document.querySelector(".task_timeline").innerHTML = this.responseText;
            //ChangingStatusInprogress(taskId);
        } else {
            console.error("Failed to change status. Server responded with status:", xhttp.status);
            alert("Failed to chnage status. Please try again later.");
        }
    };
     var taskId = sessionStorage.getItem('task_id');
     var data = "task_id="+task_id+"&new_user_id="+userId;
     xhttp.open("GET", "project_task_assign_person.php");
     xhttp.send();
}


function changeDeadlime(new_deadline){
    const xhttp = new XMLHttpRequest();
     xhttp.onload = function() {
        if (xhttp.status >= 200 && xhttp.status < 300) {
            alert("Deadline has been changed to "+ new_deadline);
            GetkTimeline(taskId)
        } else {
            console.error("Failed to change deadline, Server responded with status:", xhttp.status);
            alert("Failed to chnage deadline. Please try again later.");
        }
    };
     xhttp.open("POST", "project_task_change_deadline.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        var taskId = sessionStorage.getItem('task_id');
        var projectId = sessionStorage.getItem('project_id');
        var data = "task_id=" + encodeURIComponent(taskId) + "&new_deadline=" + encodeURIComponent(new_deadline)+"&project_id=" + encodeURIComponent(projectId);
        xhttp.send(data);
}


function taskFullHistoryPaging(page){
      const xhttp = new XMLHttpRequest();
     xhttp.onload = function() {
        if (xhttp.status >= 200 && xhttp.status < 300) {
            document.querySelector(".dialog_task_timeline").innerHTML=this.responseText
            
        } else {
            console.error("Failed to change deadline, Server responded with status:", xhttp.status);
            alert("Failed to chnage deadline. Please try again later.");
        }
    };
     xhttp.open("POST", "project_task_full_history_paging.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        var taskId = sessionStorage.getItem('task_id');
        var data = "task_id=" + encodeURIComponent(taskId) + "&page="+page;
        xhttp.send(data);
}


function removeFromTask(taskId){
    const xhttp = new XMLHttpRequest();
     xhttp.onload = function() {
        if (xhttp.status >= 200 && xhttp.status < 300) {
                
        } else {
            console.error("Failed to remove from task, Server responded with status:", xhttp.status);
            alert("Failed to chnage deadline. Please try again later.");
        }
    };
     xhttp.open("POST", "project_task_remove_person.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        var projectId = localStorage.getItem("project_id");
        var taskId = localStorage.getItem('task_id');
        var data = "task_id=" + encodeURIComponent(taskId)+"&project_id="+projectId;
        xhttp.send(data);
}

function AssignPersonToTask(taskId, userId){
     const xhttp = new XMLHttpRequest();
     xhttp.onload = function() {
        if (xhttp.status >= 200 && xhttp.status < 300) {
            document.getElementById("assign_person_to_project").close();
        } else {
            console.error("Failed to assign user, Server responded with status:", xhttp.status);
            alert("Failed to chnage deadline. Please try again later.");
        }
    };
     xhttp.open("POST", "project_task_assign_person.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        var projectId = localStorage.getItem("project_id");
        var data = "task_id=" + encodeURIComponent(taskId)+"&user_id="+userId+"&project_id="+projectId;
        xhttp.send(data);
}