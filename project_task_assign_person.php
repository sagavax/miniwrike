<?php include "include/dbconnect.php";
		include "include/functions.php";

$task_id = $_POST['task_id'];
$user_id = $_POST['user_id'];
$project_id = $_POST['project_id'];

$assign_to_task = "UPDATE project_tasks SET user_id = $user_id WHERE task_id = $task_id";
mysqli_query($db, $assign_to_task) or die(mysqli_error($db));


$curr_owner = GetUserNameById($user_id);

$text_streamu = "User <b>$curr_owner</b> has been assigned to task id: $task_id";
$stream_group = 'task';
$user_id = 1;
$text_streamu = mysqli_real_escape_string($db, $text_streamu);
$update_project_strem = "INSERT INTO project_stream (stream_group,project_id,user_id,text_of_stream, date_added) VALUES ('$stream_group',$project_id,$user_id,'$text_streamu', now())";
mysqli_query($db, $update_project_strem) or die("MySQL ERROR: " . mysqli_error($db)); 		

//update task time line
$timeline_text = "user $curr_owner assigned to the task";
$task_history = "INSERT INTO project_tasks_timeline (task_id, timeline_text, date_added) VALUES ($task_id,'$timeline_text',now())";
mysqli_query($db, $task_history) or die("MySQL ERROR: " . mysqli_error($db));