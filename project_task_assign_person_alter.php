<?php
 include "include/dbconnect.php";
 include "include/functions.php";

 $project_id = $_POST['project_id'];
	$task_id = $_POST['task_id'];
	$user_name = $_POST['users'];
	$user_id = $_POST['user_id'];


		$assign_person = "INSERT INTO project_task_assigned_people (task_id, project_id, user_id, assigned_by, assigned_date) VALUES ($task_id, $project_id, $user_id,$assigned_by,now())";
		echo $assign_person;
		$result = mysqli_query($db, $assign_person) or die("MySQL ERROR: " . mysqli_error($db));

		mysqli_query($db, "INSERT INTO project_statement_log (action,date_added,statement) VALUES ('assign_task',now())");

		//pridat do streamu

		$text_streamu = "The task id <a href='project_task.php?task_id=$task_id'> " . $task_id . "</a> has been re-assigned to user <a href='project_user_profile.php?user_id=$user_id' class='link'>" . $user_name . "</a>";
		$text_streamu = mysqli_real_escape_string($db, $text_streamu);
		$datum = date('Y-m-d H:m:s');
		$stream_group = 'task';
		$sql = "INSERT INTO project_stream (stream_group,project_id,user_id,text_of_stream, date_added) VALUES ('$stream_group',$project_id,$user_id,'$text_streamu','$datum')";

		mysqli_query($db, "INSERT INTO project_statement_log (action,date_added,statement) VALUES ('add_to_stream',now())");

		$result = mysqli_query($db, $sql) or die("MySQL ERROR: " . mysqli_error($db));