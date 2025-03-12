<?php
	include("include/dbconnect.php");
	include("include/functions.php");
	session_start();


	$role_id = $_POST['role_id'];
	$user_id = $_POST['user_id'];
	$project_id = $_POST['project_id'];


	//check if this role has been already assigned
	$get_curr_role = "SELECT project_role from project_assigned_people WHERE project_id=$project_id and user_id=$user_id";
	$result = mysqli_query($db, $get_curr_role) or die(mysqli_errno($db));
	$row = mysqli_fetch_assoc($result);
	$curr_role = $row['project_role'];
	if($curr_role == 0){
		$text_streamu = "The user <b>".GetUserNameById($user_id)."</b> has been assigned into of <b>".GetRolename($role_id)."</b> role";
	} else {
		"The user <b>".GetUserNameById($user_id)."</b> has switched from current role of <b>".GetRoleName($curr_role)."</b> into <b>".GetRoleName($role_id);
	}


	//assign role 
	$assign_role = "UPDATE project_assigned_people SET project_role = $role_id WHERE user_id=$user_id and project_id=$project_id";
	mysqli_query($db, $assign_role) or die(mysqli_errno($db));


	//stream
	$text_streamu = addslashes($text_streamu);
		$sql = "INSERT INTO project_stream (project_id,user_id,text_of_stream, date_added) VALUES ($project_id,$user_id,'$text_streamu',now())";
	$result = mysqli_query($db, $sql) or die("MySQL ERROR: " . mysqli_error());