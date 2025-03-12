
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

 //document.querySelector("div[data-id='"+att+"']")
 
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
        SetTaskStatus(taskId, selectedValue)
        break;
      // Add additional cases for other select elements if needed
    }
  }
 });

tasks.addEventListener("click", function(event){
	 if (event.target.tagName === 'BUTTON'){
   	   var buttonName = event.target.getAttribute('name');	
   	   console.log('Selected value for status:', buttonName);
   }

   if(event.target.tagName==='I'){ //clicked Forn awesome
   	 var buttonName = event.target.closest("BUTTON").getAttribute("name");
   	 console.log('Selected value for status:', buttonName);	
   }
})


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