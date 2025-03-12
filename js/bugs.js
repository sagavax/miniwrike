const footer = document.querySelector(".bug_footer");
footer.addEventListener("click",function(ev){
    const bugId =sessionStorage.getItem("bug_id");
    if(ev.target.tagName==="BUTTON"){
        buttonName=ev.target.name;
        if(buttonName==="reopen_bug"){
            BugReopened(bugId)   
        } else if (buttonName==="bug_set_fixed"){
            BugFixed(bugId);
        }
     }   
})

 function BugFixed(bugId){
    const xhttp = new XMLHttpRequest();
          xhttp.onload = function() {
            alert("bug has been fixed;");
            footer.innerHTML="";
            footer.innerHTML="<button type='button' title='mark the bug as fixed' class='button small_button' name='reopen_bug'>Reopen</button><div class='span_modpack'>fixed</div>";
          }
          
        xhttp.open("POST", "bug_set_fixed.php",true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        var data = "bug_id="+encodeURIComponent(bugId);                
        xhttp.send(data);
}


function BugReopened(bugId){
      const xhttp = new XMLHttpRequest();
          xhttp.onload = function() {
            alert("bug has been reopened;")
            //footer remove all content
            footer.innerHTML="";
            //set new
            footer.innerHTML="<button type='button' title='mark the bug as fixed' name='bug_set_fixed' class='button'><i class='fa fa-check'></i></button>"
          }
          
        xhttp.open("POST", "bug_set_reopened.php",true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        var data = "bug_id="+encodeURIComponent(bugId);                
        xhttp.send(data);
}