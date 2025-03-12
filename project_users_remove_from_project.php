<?php include "include/dbconnect.php";?>
<?php include "include/functions.php";?>
<?php session_start();?>

<?php

	$project_id = $_POST['project_id'];
	$user_id = $_POST['user_id'];

	//unassign from all tasks
	$unassing_tasks = "UPDATE project_tasks SET user_id = 0 WHERE user_id = $user_id";
	mysqli_query($db,$unassing_tasks) or die(mysqli_error($db));


	//remove from project
	$remove_from_project = "DELETE from project_assigned_people WHERE user_id=$user_id and project_id=$project_id";
	mysqli_query($db,$remove_from_project) or die(mysqli_error($db));


	//add to stream
	$text_streamu = "User".GetUserNameById($user_id)." has been remove from project";
	$text_streamu = addslashes($text_streamu);
	$sql1 = "INSERT INTO project_stream (project_id,user_id,text_of_stream, date_added) VALUES ($project_id,$user_id,'$text_streamu', now())";
	//echo $sql1;
	$result = mysqli_query($db, $sql1) or die("MySQL ERROR: " . mysqli_error($db));