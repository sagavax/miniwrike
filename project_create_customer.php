<?php

	include "include/dbconnect.php";

   $customer_name = $_POST['customer_name'];
	$customer_description = mysqli_real_escape_string($db,$_POST['customer_description']);
	$customer_url = mysqli_real_escape_string($db, $_POST['customer_url']);
	$created_by = $_POST['user_id'];
	$create_customer = "INSERT INTO project_customers (customer_name, customer_description,customer_url,customer_added,created_by) VALUES ('$customer_name','$customer_description','$customer_url',now(),$created_by)";
	//echo "$sql";
	$result = mysqli_query($db, $create_customer) or die("MySQL ERROR: " . mysqli_error());


	$text_streamu = "A new custonr <b>customer_name has been added</b>";
	$text_streamu = mysqli_real_escape_string($db,$text_streamu);
	$add_to_stream = "INSERT INTO project_stream (project_id,user_id,text_of_stream, date_added) VALUES ($project_id,$user_id,'$text_streamu',now())";
	$result = mysqli_query($db, $add_to_stream or die("MySQL ERROR: " . mysqli_error());

	echo "<script>
		alert('New customer '+$customer_name+' has been created')
	</script>";