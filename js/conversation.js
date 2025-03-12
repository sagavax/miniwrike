const sendGrButton = document.querySelector("#add_group button");
const sendButton = document.querySelector("#add_comment button");
const conv_group_list = document.querySelector(".conv_group_list");


conv_group_list.addEventListener("click", function(event){
  if(event.target.tagName==="BUTTON"){
    const groupId = event.target.getAttribute("data-id");
    sessionStorage.setItem("conv_group",groupId);
    loadConversationGroupChat(groupId);
  }
});


sendGrButton.addEventListener("click", function(){
    CreateGroup();
})

sendButton.addEventListener("click", function(){
    var groupId = sessionStorage.getItem("conv_group")
    CreateFeed(groupId)
})


function loadConversationGroupChat(groupId){
	 const xhttp = new XMLHttpRequest();
   xhttp.onload = function() {
        if (xhttp.status >= 200 && xhttp.status < 300) {
           document.querySelector(".chat").innerHTML=this.responseText;
        }
      }   
   
   xhttp.open("GET", "project_conversation_group_chat.php?groupId="+groupId, true);
        xhttp.send();
}


function loadConversationGroups(){
    projectId = sessionStorage.getItem("project_id");
     const xhttp = new XMLHttpRequest();
   xhttp.onload = function() {
        if (xhttp.status >= 200 && xhttp.status < 300) {
           document.querySelector(".conv_group_list").innerHTML=this.responseText;
        }
      }   
   
   xhttp.open("GET", "project_conversation_groups.php?project_id="+projectId,true);
        xhttp.send();
}

function CreateFeed(groupId){
     const xhttp = new XMLHttpRequest();
     xhttp.onload = function() {
        if (xhttp.status >= 200 && xhttp.status < 300) {
           //document.querySelector(".chat").innerHTML=this.responseText;
            loadConversationGroupChat(groupId)
            document.getElementById("chat_editor").value="";
        }
      }   
   if(groupId==0){
     alert("No conversation group has been selected!")
   } else if (document.getElementById("chat_editor").value==="") {
    alert("Emtpy text") } else {  
   
   var userId = sessionStorage.getItem("user_id");
   var projectId = sessionStorage.getItem("project_id");
   var text = document.getElementById("chat_editor").value;
   var data = "groupId="+groupId+"&user_id="+userId+"&text="+encodeURIComponent(text)+"&project_id="+projectId;
   xhttp.open("POST", "project_conversation_create_feed.php", true);
   xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
   xhttp.send(data);
}
}

function CreateGroup(groupId){
    const xhttp = new XMLHttpRequest();
    xhttp.onload = function() {
        if (xhttp.status >= 200 && xhttp.status < 300) {
            var check_duplicate = this.responseText;
            if(check_duplicate == "group_exists"){
                alert("group exists");
                document.querySelector("#add_group input").value = ""
            } else {
            loadConversationGroups();
            document.querySelector("#add_group input").value = "";
            }
        }
    }

    var groupNameInput = document.querySelector("#add_group input").value;
    if(groupNameInput === ""){
        alert("Cannot be empty!!!");
    } else {
        var userId = sessionStorage.getItem("user_id");
        var projectId = sessionStorage.getItem("project_id");
        var groupName = encodeURIComponent(groupNameInput);
        var data = `user_id=${userId}&group_name=${groupName}&project_id=${projectId}`;

        xhttp.open("POST", "project_conversation_create_group.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send(data);
    }
}
