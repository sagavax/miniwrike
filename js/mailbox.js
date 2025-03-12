const mail_box = document.querySelector(".mail_box");

mail_box.addEventListener("click", function(event){
    
    if(event.target.classList.contains("message_subject")){
        console.log("message it...")
    }
    if(event.target.tagName==="I"){
        console.log("trash it...")
    }
})

