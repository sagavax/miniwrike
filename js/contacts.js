const manage_contacts = document.querySelector(".manage_contacts");

manage_contacts.addEventListener("click", function(event) {
  if (event.target.tagName === "BUTTON") {
    if (event.target.name === "sort_ascending") {
      sortAscending();
    } 

    if (event.target.name === "sort_descending") {
      sortDescending();
    }

    if (event.target.name === "add_contact") {
      addNewContact();
    }
  }
});

const project_contacts = document.querySelector(".project_contacts");
project_contacts.addEventListener("click", function(event) {
  // Check if the clicked element is a <button> element
  if (event.target.tagName === "BUTTON") {
    handleButtonClick(event.target.name);
    }

  // Check if the clicked element is an <i> (icon) element
  if (event.target.tagName === "I") {
    // Traverse up the DOM tree to find the parent <button> element
    var buttonElement = event.target.closest("button");
    if (buttonElement) {
      handleButtonClick(buttonElement.name);
    }
  }
});


function handleButtonClick(buttonName) {
  switch (buttonName) {
    case "view_contact":
      // Handle view details action
      document.getElementById("view_user_details_dialog").showModal();
       var contactId = event.target.closest(".contact").getAttribute("contact-id");
        const dialog = document.getElementById("view_user_details_dialog");
        if (dialog) {
         const isOpen = dialog.open;
        viewUserDetails(contactId);
        }
       //console.log(contactId);
      break;
    case "edit_contact":
      // Handle edit details action
      document.getElementById("edit_user_details_dialog").showModal();
       var contactId = event.target.closest(".contact").getAttribute("contact-id");
       const edit_dialog = document.getElementById("edit_user_details_dialog");
       if (edit_dialog) {
         const isOpen = edit_dialog.open;
        editUserDetails(contactId);
        }
      break;
    case "send_message":
      // Show the send new mail dialog
      document.getElementById("send_new_mail_dialog").showModal();
      const mail_dialog = document.getElementById("send_new_mail_dialog");
      var contactId = event.target.closest(".contact").getAttribute("contact-id");
       if (mail_dialog) {
         const isOpen = mail_dialog.open;
         getMessageRecipient(contactId);
         getMessageSender();

         const sender = document.querySelector("#send_new_mail_dialog [name='message_sender']").value;
         const recipient = document.querySelector("#send_new_mail_dialog [name='message_recipient']").value;
         if(sender===recipient){
          document.querySelector(".send_message_action button").disabled=true;
          }
         }
      break;
    case "remove_contact":
      // Handle remove contact action
      var contactId = event.target.closest(".contact").getAttribute("contact-id");
      removeFromProject($contactId);
      alert("remove from project");
      break;
    default:
      // Handle other cases or do nothing
      break;
  }
}




function addNewContact(){
  document.getElementById("add_contact_dialog").showModal();
}


function sortAscending(){
   const xhttp = new XMLHttpRequest();
   xhttp.onload = function() {
        if (xhttp.status >= 200 && xhttp.status < 300) {
           document.querySelector(".project_contacts").innerHTML=this.responseText;
        }
      }   
   projectId = sessionStorage.getItem("project_id");
   xhttp.open("GET", "project_contacts_sorted.php?sort=asc&project_id="+projectId, true);
        xhttp.send();
}

function sortDescending(){
   const xhttp = new XMLHttpRequest();
   xhttp.onload = function() {
        if (xhttp.status >= 200 && xhttp.status < 300) {
           document.querySelector(".project_contacts").innerHTML=this.responseText;
        }
      }   
   projectId = sessionStorage.getItem("project_id");
   xhttp.open("GET", "project_contacts_sorted.php?sort=dsc&project_id="+projectId, true);
        xhttp.send();
}

function sendMessage(){

}


function viewUserDetails(contactId){
    console.log("view user")
   const xhttp = new XMLHttpRequest();
   xhttp.onload = function() {
        if (xhttp.status >= 200 && xhttp.status < 300) {
           //document.querySelector(".project_contacts").innerHTML=this.responseText;
           const userDetails = JSON.parse(this.responseText);
           console.log(userDetails);
            document.querySelector("#view_user_details_dialog [name='first_name']").value = userDetails.first_name;
            document.querySelector("#view_user_details_dialog [name='last_name']").value = userDetails.last_name;
            document.querySelector("#view_user_details_dialog [name='login']").value = userDetails.login;
            document.querySelector("#view_user_details_dialog [name='email']").value = userDetails.email;
            document.querySelector("#view_user_details_dialog [name='phone']").value = userDetails.phone;
            document.querySelector("#view_user_details_dialog [name='created_date']").value = userDetails.created_date;
        }
      }   
   xhttp.open("GET", "project_user_detail?user_id="+contactId, true);
   xhttp.send();
}

function editUserDetails(contactId){
   console.log("edit user")
   const xhttp = new XMLHttpRequest();
   xhttp.onload = function() {
        if (xhttp.status >= 200 && xhttp.status < 300) {
           //document.querySelector(".project_contacts").innerHTML=this.responseText;
           const userDetails = JSON.parse(this.responseText);
           console.log(userDetails);
            document.querySelector("#edit_user_details_dialog [name='first_name']").value = userDetails.first_name;
            document.querySelector("#edit_user_details_dialog [name='last_name']").value = userDetails.last_name;
            document.querySelector("#edit_user_details_dialog [name='login']").value = userDetails.login;
            document.querySelector("#edit_user_details_dialog [name='email']").value = userDetails.email;
            document.querySelector("#edit_user_details_dialog [name='phone']").value = userDetails.phone;
          }
      }   
   xhttp.open("GET", "project_user_detail?user_id="+contactId, true);
   xhttp.send();
}




function removeFromProject(contactId) {
  const xhttp = new XMLHttpRequest();
  xhttp.onload = function() {
    if (xhttp.status >= 200 && xhttp.status < 300) {
      alert("User has been removed from the project");
    }
  };

  const projectId = sessionStorage.getItem("project_id");
  const data = "project_id=" + projectId + "&user_id=" + contactId;

  xhttp.open("POST", "project_users_remove_from_project.php", true);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhttp.send(data);
}


function getMessageSender(){
  const xhttp = new XMLHttpRequest();
   xhttp.onload = function() {
        if (xhttp.status >= 200 && xhttp.status < 300) {
           //document.querySelector(".project_contacts").innerHTML=this.responseText;
           const userDetails = JSON.parse(this.responseText);
            document.querySelector("#send_new_mail_dialog [name='message_sender']").value = userDetails.full_name;
        }
      }   
   var recipientId = sessionStorage.getItem("logged_user_id")
   xhttp.open("GET", "project_mailbox_get_sender?user_id="+recipientId, true);
   xhttp.send();
}



function getMessageRecipient(contactId){
  const xhttp = new XMLHttpRequest();
   xhttp.onload = function() {
        if (xhttp.status >= 200 && xhttp.status < 300) {
           //document.querySelector(".project_contacts").innerHTML=this.responseText;
           const userDetails = JSON.parse(this.responseText);
            console.log(userDetails);
            document.querySelector("#send_new_mail_dialog [name='message_recipient']").value = userDetails.full_name;
            sessionStorage.setItem("recipient_id",userDetails.user_id)
           }
      }   
   xhttp.open("GET", "project_mailbox_get_recipient?user_id="+contactId, true);
   xhttp.send();
}
