<?php
 include "include/dbconnect.php";
 include "include/functions.php";

$project_id = $_POST['project_id'];
$task_id = $_POST['task_id'];
$new_deadline = $_POST['new_deadline'];


//change deadline
$change_deadline = "UPDATE project_tasks SET task_deadline='$new_deadline' WHERE task_id=$task_id";
//echo $change_deadline;
$result = mysqli_query($db, $change_deadline) or die("MySQL ERROR: " . mysqli_error($db));

//adding into project stream
$text_streamu = "deadline has been changed to <b>$new_deadline</b>";
$text_streamu = mysqli_real_escape_string($db, $text_streamu);
$stream_group = 'task';
$user_id = 1;
$project_stream = "INSERT INTO project_stream (stream_group,project_id,user_id,text_of_stream, date_added) VALUES ('$stream_group',$project_id,$user_id,'$text_streamu',now())";

mysqli_query($db, $project_stream) or die("MySQL ERROR: " . mysqli_error($db));


//adding into timeline
$timeline_text = "deadline has been changed to <b>$new_deadline</b>";
$task_history = "INSERT INTO project_tasks_timeline (task_id, timeline_text, date_added) VALUES ($task_id,'$timeline_text',now())";
mysqli_query($db, $task_history) or die("MySQL ERROR: " . mysqli_error($db));