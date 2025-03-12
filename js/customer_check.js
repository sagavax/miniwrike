
function AddNewCustomer(){
	 	
		const xhttp = new XMLHttpRequest();	

         xhttp.onload = function() {
            customer="";
          //document.querySelector(".project_tasks").innerHTML = this.responseText;
          }

        var customer_input =  document.getElementById('customer_name');
	 	var customer = customer_input.value;
       var customer_description = document.getElementById("customer_description").value;
       var customer_url = document.getElementById("customer_url").value;	
        
         //console.log(task_input);
        if(customer==""){
          customer_input.style.borderWidth = "3px";
          customer_input.style.borderStyle = "solid";
          customer_input.style.borderColor = "red";
          alert("Cannot by empty!!!!");
          setTimeout(input_back_to_normal, 3000);
          
        } else {

        xhttp.open("POST", "project_customer_new.php",true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        var data = "customer_name="+encodeURIComponent(customer_name)+"&customer_url="+encodeURIComponent(customer_url)+"&customer_description="+encodeURIComponent(customer_description);
        xhttp.send(data);
       } 
}

/*
function checkCustomerExists(customer_name){
	    const xhttp = new XMLHttpRequest();
            xhttp.onload = function() {

	   		 if(this.responseText.trim()==1){
          customer.style.borderWidth = "6px solid";
          customer.style.borderColor = "red";
           } else {
           	customer.style.borderWidth = "6px solid";
          customer.style.borderColor = "green";
           }
        
        xhttp.open("POST", "project_customer_check.php",true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        var data = "customer_name="+encodeURIComponent(customer_name);
        xhttp.send(data);
       } 
}*/

function checkCustomerExists(customer_name){
	    console.log("customer_name");
	    const xhttp = new XMLHttpRequest();
            xhttp.onload = function() {

	   		 if(this.responseText.trim()==1){
          customer.style.borderWidth = "3px";
          customer.style.borderColor = "red";
           } else {
           	customer.style.borderWidth = "3px";
          customer.style.borderColor = "green";
           }
        
        xhttp.open("GET", "project_customer_check.php?customer_name="+encodeURIComponent(customer_name));
        xhttp.send();
       } 
}


function input_back_to_normal(){
	 var customer_input =  document.getElementById('customer_name');
	 customer_input.style.borderWidth = "1px";
     customer_input.style.borderColor = "#ddd";
}