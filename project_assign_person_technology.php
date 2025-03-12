<?php
	include("include/dbconnect.php");
	include("include/functions.php");
	session_start();


	$tech_id = $_POST['tech_id'];
	$user_id = $_POST['user_id'];
	$project_id = $_POST['project_id'];


	//get current technology
	$get_curr_tech = "SELECT project_technology from project_assigned_people WHERE project_id=$project_id and user_id=$user_id";
	$result = mysqli_query($db, $get_curr_tech) or die(mysqli_errno($db));
	$row = mysqli_fetch_assoc($result);
	$curr_tech = $row['project_technology'];
	if($curr_tech == 0){
		$text_streamu = "The user <b>".GetUserNameById($user_id)."</b> has been assigned into technology of <b>".GetTechname($tech_id)."</b>";
	} else {
		"The user <b>".GetUserNameById($user_id)."</b> has switched from current technology <b>".GetTechName($project_technology)."</b> into technology of <b>".GetTechName($tech_id);
	}


	//assign role 
	$assign_tech = "UPDATE project_assigned_people SET project_technology = $tech_id WHERE user_id=$user_id and project_id=$project_id";
	mysqli_query($db, $assign_tech) or die(mysqli_errno($db));


	//stream
	
	$text_streamu = addslashes($text_streamu);
		$sql = "INSERT INTO project_stream (project_id,user_id,text_of_stream, date_added) VALUES ($project_id,$user_id,'$text_streamu',now())";
	$result = mysqli_query($db, $sql) or die("MySQL ERROR: " . mysqli_error());