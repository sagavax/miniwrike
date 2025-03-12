<?php session_start();?>
<?php include "include/dbconnect.php";?>
<?php include "include/functions.php";?>

 <?php


	$project_id = $_POST['project_id'];
	$organizer_id = $_POST['organizer_id'];
	$user_name = GetUserNameById($organizer_id);
	$project_name=GetProjectName($project_id);
	$meeting_title = mysqli_real_escape_string($db,$_POST['meeting_title']);
	$meeting_description = mysqli_real_escape_string($db, $_POST['meeting_description']);
	$datum_mitingu = $_POST['meeting_date'];
	$start_time = $_POST['start_time'];
	$end_time = $_POST['end_time'];
	$meeting_type = $_POST['type_of_meeting'];
	//$location = $_POST['location'];
	//$atendees = $_POST['atendees'];
	
	/*
	`project_id` INT NOT NULL,
	`organizer_id` INT NULL DEFAULT NULL,
	`meeting_title` VARCHAR(100) NULL DEFAULT NULL COLLATE 'utf8mb3_general_ci',
	`meeting_description` TEXT NULL DEFAULT NULL COLLATE 'utf8mb3_general_ci',
	`date_of_meeting` DATE NOT NULL,
	`start_time` TIME NULL DEFAULT NULL,
	`end_time` TIME NULL DEFAULT NULL,
	`meeting_type` VARCHAR(10) NULL DEFAULT NULL COLLATE 'utf8mb3_general_ci',
	`location` VARCHAR(40) NULL DEFAULT NULL COLLATE 'utf8mb3_general_ci',
	*/


	//create a new meeting
	$new_meeting = "INSERT INTO project_meetings (project_id, organizer_id, meeting_title,meeting_description,date_of_meeting, start_time, end_time, meeting_type,created_date) VALUES ($project_id,$organizer_id,'$meeting_title','$meeting_description','$datum_mitingu','$start_time','$end_time','$meeting_type', now())";
	//echo $new_meeting;
	$result = mysqli_query($db, $new_meeting) or die("MySQL ERROR: " . mysqli_error($db));

	
	//get the lastest meeting
	$get_max_meeting_id = "SELECT MAX(id) as meeting_id from project_meetings";
	$result_meeting = mysqli_query($db, $get_max_meeting_id) or die("MySQL ERROR: " . mysqli_error($db));
	$row_meeting = mysqli_fetch_array($result_meeting);
	$meeting_id = $row_meeting['meeting_id'];


	//pridat do streamu
	$text_streamu = "User <a href='project_user_profile.php?id=$organizer_id'>" . $user_name . "</a> has created a new meeting id: <a href='project_meeting_details.php?meeting_id=$meeting_id'>" . $meeting_id . "</a> for the project <a href='project_details.php?project_id=$project_id'>" . $project_name . "</a>";
	$text_streamu = addslashes($text_streamu);
	$add_to_stream = "INSERT INTO project_stream (project_id,user_id,text_of_stream, date_added) VALUES ($project_id,$organizer_id,'$text_streamu',now())";
	$result = mysqli_query($db, $add_to_stream) or die("MySQL ERROR: " . mysqli_error());

?>
