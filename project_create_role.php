<?php
	include("include/dbconnect.php");

	$project_id = $_POST['project_id'];
	$role_name = $_POST['role_name'];


	//create new role
	$create_role = "INSERT into project_roles (role_name) VALUES ('$role_name')";
	mysqli_query($db, $create_role) or die(mysql_errno($db));

	
	//get role id
	$get_role_id="SELECT MAX(role_id) as new_role_id from project_roles";
	$result_role = mysqli_query($db, $get_role_id) or die(mysql_errno($db));
	$row_role = mysqli_fetch_array($result_role);
	$new_role_id = $row_role['new_role_id'];

	//assign this role for the current project
	$assign_role_to_project = "INSERT INTO project_assigned_roles (role_id,project_id) VALUES ($new_role_id,$project_id)";
	mysqli_query($db, $assign_role_to_project) or die(mysql_errno($db));


	//add to stream
	$text_streamu = "New role <b>$role_name</b> has been created aassined for the project <a href='project.php?project_id='$project_id</a>";
	$text_streamu = addslashes($text_streamu);
		$sql = "INSERT INTO project_stream (project_id,user_id,text_of_stream, date_added) VALUES ($project_id,$user_id,'$text_streamu',now())";
	$result = mysqli_query($db, $sql) or die("MySQL ERROR: " . mysqli_error());

