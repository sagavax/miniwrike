<?php
	include("include/dbconnect.php");
	include("include/functions.php");
	session_start();


	$project_id = $_POST['project_id'];
	$role_id = $_POST['role_id'];
	$user_id = $_SESSION['user_id'];

	//assign this role for the current project
	$assign_role_to_project = "INSERT INTO project_assigned_roles (role_id, project_id, added_date) VALUES ($role_id, $project_id, now())";
	mysqli_query($db, $assign_role_to_project) or die(mysqli_errno($db));

	$role_name = GetRoleName($role_id);

	$text_streamu = "The role <b>$role_name</b> has been added for the project <a href='project.php?project_id=$project_id'>$project_id</a>";
	$text_streamu = mysqli_real_escape_string($db, $text_streamu);
	$sql = "INSERT INTO project_stream (project_id, user_id, text_of_stream, date_added) VALUES ($project_id, $user_id, '$text_streamu', NOW())";
	$result = mysqli_query($db, $sql) or die("MySQL ERROR: " . mysqli_error($db));
