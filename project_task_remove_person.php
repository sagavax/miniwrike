<?php include "include/dbconnect.php";
		include "include/functions.php";

$task_id = $_POST['task_id'];
$project_id = $_POST['project_id'];

$get_curr_task_owner = "SELECT user_id from project_tasks WHERE task_id = $task_id";
$get_curr_task_owner;
$result = mysqli_query($db, $get_curr_task_owner) or die(mysqli_error($db));
$row = mysqli_fetch_array($result);
$curr_owner =GetUserNameById($row['user_id']);


$remove_from_task = "UPDATE project_tasks SET user_id = 0 WHERE task_id = $task_id";
mysqli_query($db, $remove_from_task) or die(mysqli_error($db));


$text_streamu = "User $curr_owner has been unassigned from task id: $task_id";
	$stream_group = 'task';
	$user_id = 1;
	$text_streamu = mysqli_real_escape_string($db, $text_streamu);
	$update_project_strem = "INSERT INTO project_stream (stream_group,project_id,user_id,text_of_stream, date_added) VALUES ('$stream_group',$project_id,$user_id,'$text_streamu', now())";
    mysqli_query($db, $update_project_strem) or die("MySQL ERROR: " . mysqli_error($db)); 		

//update task time line
$timeline_text = "user $curr_owner unassigned from the task";
$task_history = "INSERT INTO project_tasks_timeline (task_id, timeline_text, date_added) VALUES ($task_id,'$timeline_text',now())";
mysqli_query($db, $task_history) or die("MySQL ERROR: " . mysqli_error($db));