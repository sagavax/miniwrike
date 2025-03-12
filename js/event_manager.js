const meeting_createButton = document.querySelector(".meeting_save button");
const project_meetings = document.querySelector(".project_meetings");
const dialog_attendees = document.getElementById("meeting_attendees");
const dialog_attendees_new = document.getElementById("meeting_attendees_new");
const dialog_add_change_meeting_location = document.getElementById("meeting_add_change_location");
const project_event_manager_wrap = document.querySelector(".project_event_manager_wrap header");
const new_meeting_dialog = document.getElementById("new_meeting");


project_event_manager_wrap.addEventListener("click", (event)=>{
    if(event.target.tagName==="BUTTON"){
        new_meeting.showModal();
    }
})

meeting_createButton.addEventListener("click", createNewMeeting);

// Show meeting attendees
project_meetings.addEventListener("click", function(event) {
    if (event.target.tagName === "BUTTON") {
        const meetingId = event.target.closest(".meeting").getAttribute("meeting-id");

        if (event.target.name === "attendees") {
            if (dialog_attendees) {
                dialog_attendees.showModal();
                LoadMeetingAttendees(meetingId);
            }
        } else if (event.target.name === "cancel_meeting") {
            // cancelMeeting();
        } else if (event.target.name === "add_location") {
            updateMeetingLocation(meetingId);
            console.log("change location");
        }
    }
});

project_meetings.addEventListener("dblclick", function(event) {
    if (event.target.classList.contains("meeting_title")) {
        const meetingId = event.target.closest(".meeting").getAttribute("meeting-id");
        sessionStorage.setItem("meeting_id", meetingId);
        event.target.contentEditable = true;
        event.target.focus();
        event.target.addEventListener("blur", function() {
            const newMeetingTitle = event.target.innerText;
            event.target.removeAttribute("contenteditable");
            updateMeetingTitle(newMeetingTitle, meetingId);
        });
    }
});

function LoadMeetingAttendees(meetingId) {
    const xhttp = new XMLHttpRequest();
    xhttp.onload = function() {
        if (xhttp.status >= 200 && xhttp.status < 300) {
            const attendeesElement = document.querySelector(".attendees");
            if (attendeesElement) {
                attendeesElement.innerHTML = this.responseText;
            }
            const addNewAttendee = document.querySelector(".add_attendee");
            if (addNewAttendee) {
                addNewAttendee.addEventListener("change", function(event) {
                    if (event.target.tagName === "SELECT") {
                        const userName = event.target.value;
                        console.log(userName);
                    }
                });
            }
        } else {
            console.error("Failed to reload comments. Server responded with status:", xhttp.status);
            alert("Failed to reload comments. Please try again later.");
        }
    };

    xhttp.open("GET", "project_meeting_attendees.php?meeting_id=" + encodeURIComponent(meetingId), true);
    xhttp.send();
}

function createNewMeeting() {
    const xhttp = new XMLHttpRequest();
    xhttp.onload = function() {
        if (xhttp.status >= 200 && xhttp.status < 300) {
            alert("New meeting has been created!");
            document.querySelector("#new_meeting").close();
        } else {
            console.error("Failed to create meeting. Server responded with status:", xhttp.status);
            alert("Failed to create meeting. Please try again later.");
        }
    };

    const meetingTitle = document.querySelector("#new_meeting [name='meeting_title']").value;
    const meetingDescription = document.querySelector("#new_meeting [name='meeting_description']").value;
    const meetingOrganizerId = document.querySelector("#new_meeting [name='meeting_organizer']").getAttribute("user-id");
    const meetingDate = document.querySelector(".meeting_date_time [name='date_start']").value;
    const startTime = document.querySelector(".meeting_date_time [name='start_time']").value;
    const endTime = document.querySelector(".meeting_date_time [name='end_time']").value;
    const typeOfMeeting = document.querySelector("#new_meeting [name='type_of_meeting']").value;
    const projectId = localStorage.getItem("project_id");

    if (meetingTitle === "") {
        alert("Title cannot be empty!");
        return;
    }

    const data = `project_id=${encodeURIComponent(projectId)}&meeting_title=${encodeURIComponent(meetingTitle)}&meeting_description=${encodeURIComponent(meetingDescription)}&organizer_id=${encodeURIComponent(meetingOrganizerId)}&meeting_date=${encodeURIComponent(meetingDate)}&start_time=${encodeURIComponent(startTime)}&end_time=${encodeURIComponent(endTime)}&type_of_meeting=${encodeURIComponent(typeOfMeeting)}`;

    xhttp.open("POST", "project_meeting_create.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(data);
}

function updateMeetingTitle(title, meetingId) {
    const xhttp = new XMLHttpRequest();
    xhttp.onload = function() {
        if (xhttp.status >= 200 && xhttp.status < 300) {
            console.log('Title updated successfully');
        } else {
            console.error('Failed to update title');
        }
    };
    xhttp.open("POST", "project_meeting_title_update.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    const projectId = localStorage.getItem("project_id");
    const data = `new_title=${encodeURIComponent(title)}&meeting_id=${encodeURIComponent(meetingId)}&project_id=${encodeURIComponent(projectId)}`;
    xhttp.send(data);
}

function updateMeetingLocation(meetingId) {
    const xhttp = new XMLHttpRequest();
    xhttp.onload = function() {
        if (xhttp.status >= 200 && xhttp.status < 300) {
            var meetingElement = document.querySelector(`.meeting[meeting-id="${meetingId}"]`);
            console.log(meetingId);
            if (meetingElement) {
                var meetingLocationElement = meetingElement.querySelector('.meeting_location');
                if (meetingLocationElement) {
                    const meetingLocation = "MS Teams";
                    meetingLocationElement.textContent = meetingLocation;
                } else {
                    console.error('Meeting location element not found within the specified meeting element.');
                }
            }
        } else {
            console.error('Failed to update location');
        }
    };
    xhttp.open("POST", "project_meeting_update_location.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    const projectId = localStorage.getItem("project_id");
    const meetingLocation = "MS Teams";  // Assuming this is the new location value
    const data = "meeting_id="+meetingId+"&meeting_location="+meetingLocation+"&project_id="+projectId;
    xhttp.send(data);
}
