<?php
	include("include/dbconnect.php");
	include("include/functions.php");
	session_start();

	$project_id = $_POST['project_id'];
	$tech_id = $_POST['tech_id'];
	$user_id = $_SESSION['user_id'];

	$tech_name = GetTechName($tech_id);

	$assign_tech_to_project = "INSERT INTO project_assigned_technologies (tech_id,project_id, added_date) VALUES ($tech_id,$project_id, now())";
	//echo $assign_tech_to_project;
	mysqli_query($db, $assign_tech_to_project) or die(mysqli_errno($db));

	//add to stream
	$text_streamu = "The technology <b>$tech_name</b> has been added for the project <a href='project.php?project_id='$project_id</a>";
	$text_streamu = addslashes($text_streamu);
		$sql = "INSERT INTO project_stream (project_id,user_id,text_of_stream, date_added) VALUES ($project_id,$user_id,'$text_streamu',now())";
	$result = mysqli_query($db, $sql) or die("MySQL ERROR: " . mysqli_error());
