<?php

	include("include/dbconnect.php");

	$project_id = $_POST['project_id'];
	$status = $_POST['status'];

	
	//get current statu
	$get_curr_status ="SELECT project_status from project where project_id=$project_id";
	$result_status = mysqli_query($db, $get_curr_status) or die(mysqli_errno($db));
	$row_status = mysqli_fetch_array($result_status);
	$project_old_status = $row_status['project_status'];

	//update status
	$update_status = "UPDATE projects SET project_status='$status' WHERE project_id=$project_id";
	$result = mysqli_query($db, $update_status) or die(mysqli_errno($db));

	//add to stream
	$text_streamu = "status for the project has been changed from <b>$project_old_status</b> to <b>$status</b>";
	$text_streamu = addslashes($text_streamu);
		$sql = "INSERT INTO project_stream (project_id,user_id,text_of_stream, date_added) VALUES ($project_id,$user_id,'$text_streamu',now())";
	$result = mysqli_query($db, $sql) or die("MySQL ERROR: " . mysqli_error());
