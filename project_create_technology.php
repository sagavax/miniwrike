<?php
	include("include/dbconnect.php");
	session_start();

	$project_id = $_POST['project_id'];
	$tech_name = $_POST['tech_name'];


	//create new role
	$create_tech = "INSERT into project_technologies (technology_name) VALUES ('$tech_name')";
	mysqli_query($db, $create_role) or die(mysql_errno($db));

	
	//get role id
	$get_role_id="SELECT MAX(tech_id) as new_tech_id from project_technologies";
	$result_tech = mysqli_query($db, $get_tech_id) or die(mysqli_errno($db));
	$row_tech = mysqli_fetch_array($result_tech);
	$new_tech_id = $row_role['new_tech_id'];

	//assign this role for the current project
	$assign_tech_to_project = "INSERT INTO project_assigned_technologies (techn_id,project_id) VALUES ($new_tech_id,$project_id)";
	mysqli_query($db, $assign_tech_to_project) or die(mysqli_errno($db));


	//add to stream
	$text_streamu = "New technology <b>$tech_name</b> has been created and aassined for the project <a href='project.php?project_id='$project_id</a>";
	$text_streamu = addslashes($text_streamu);
		$sql = "INSERT INTO project_stream (project_id,user_id,text_of_stream, date_added) VALUES ($project_id,$user_id,'$text_streamu',now())";
	$result = mysqli_query($db, $sql) or die("MySQL ERROR: " . mysqli_error());

