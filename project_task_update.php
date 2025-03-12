<?php include "include/dbconnect.php";
		include "include/functions.php";
$user_id = 1;
$task_id = $_POST['task_id'];
$update_text = mysqli_real_escape_string($db, $_POST['update_text']);
$project_id = $_POST['project_id'];
//$user_id = $_POST['user_id']; // Ensure that you are getting user_id from the form or session

$update_task_text = "INSERT INTO project_task_comments (task_id, user_id, project_id, post_text, date_added) VALUES ($task_id, $user_id, $project_id, '$update_text', NOW())";
$update_task_text;
mysqli_query($db, $update_task_text)  or die("MySQL ERROR: " . mysqli_error($db));

//add to stream
$get_newest_id = "SELECT MAX(id) as task_comment_id from project_task_comments where project_id=$project_id and task_id=$task_id";
	$result = mysqli_query($db, $get_newest_id) or die("MySQL ERROR: " . mysqli_error($db));
	while ($row = mysqli_fetch_array($result)) {
		$task_comment_id = $row['task_comment_id'];
	}

	//pridenie informacie do streamu / logu / wallu
	$text_streamu = "task id $task_id has been updated";
	$stream_group = 'task';
	$text_streamu = mysqli_real_escape_string($db, $text_streamu);
	$update_project_strem = "INSERT INTO project_stream (stream_group,project_id,user_id,text_of_stream, date_added) VALUES ('$stream_group',$project_id,$user_id,'$text_streamu', now())";
    mysqli_query($db, $update_project_strem) or die("MySQL ERROR: " . mysqli_error($db)); 		

//update task time line
$timeline_text = "new update created";
$task_history = "INSERT INTO project_tasks_timeline (task_id, timeline_text, date_added) VALUES ($task_id,'$timeline_text',now())";
mysqli_query($db, $task_history) or die("MySQL ERROR: " . mysqli_error($db));
