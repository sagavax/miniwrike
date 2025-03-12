const add_comment = document.querySelector(".add_project_comment");
const comment_input = document.querySelector(".add_project_comment input");

add_comment.addEventListener("click", function(event) {
    var projectId = sessionStorage.getItem("project_id");

    // Check if the clicked element is a button or an <i> (icon) inside a button
    if (event.target.tagName === 'BUTTON' || event.target.tagName === 'I') {
        if (comment_input.value.trim() === "") {
            alert("Cannot be empty!");
        } else {
            ProjectCommentCreate(projectId);
        }
    }
});

function ProjectCommentCreate(projectId) {
    const xhttp = new XMLHttpRequest();
    const comment_input = document.querySelector(".add_project_comment input");

    xhttp.onload = function() {
        if (xhttp.status >= 200 && xhttp.status < 300) {
            comment_input.value = "";
            CommentsReload(projectId);
        } else {
            console.error("Failed to create comment. Server responded with status:", xhttp.status);
            alert("Failed to create comment. Please try again later.");
        }
    };

    var comment = comment_input.value.trim(); // Trim whitespace from input
    if (comment === "") {
        comment_input.style.borderWidth = "3px";
        comment_input.style.borderStyle = "solid";
        comment_input.style.borderColor = "red";

        setTimeout(input_back_to_normal, 3000);
    } else {
        xhttp.open("POST", "project_comment_create.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        var data = "project_id=" + encodeURIComponent(projectId) + "&comment=" + encodeURIComponent(comment);
        xhttp.send(data);
    }
}

function input_back_to_normal() {
    var comment_input = document.querySelector(".add_project_comment input");
    comment_input.style.borderWidth = "1px";
    comment_input.style.borderColor = "#666";
}

function CommentsReload(projectId) {
    const xhttp = new XMLHttpRequest();
    xhttp.onload = function() {
        if (xhttp.status >= 200 && xhttp.status < 300) {
            document.querySelector(".project_comments").innerHTML = this.responseText;
        } else {
            console.error("Failed to reload comments. Server responded with status:", xhttp.status);
            alert("Failed to reload comments. Please try again later.");
        }
    };

    xhttp.open("GET", "project_comments_reload.php?project_id=" + encodeURIComponent(projectId), true);
    xhttp.send();
}

