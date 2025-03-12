<?php
include "include/dbconnect.php";
include "include/functions.php";

$task_id = $_POST['task_id'];
$task_status = $_POST['task_status'];
$project_id = $_POST['project_id'];

$change_status = "UPDATE project_tasks SET task_status = '$task_status' WHERE task_id=$task_id";
mysqli_query($db, $change_status) or die("MySQL ERROR: " . mysqli_error($db));

$text_streamu = "The status of the task id <a href='project_task.php?task_id=$task_id'> " . $task_id . "</a> has been chanegd to <b>$task_status</b>";

$text_streamu = mysqli_real_escape_string($db, $text_streamu);
$stream_group = 'task';
$user_id = 1;
$sql = "INSERT INTO project_stream (stream_group,project_id,user_id,text_of_stream, date_added) VALUES ('$stream_group',$project_id,$user_id,'$text_streamu',now())";

$result = mysqli_query($db, $sql) or die("MySQL ERROR: " . mysqli_error($db));


$timeline_text = "status has been changed to <b>$task_status</b>";
$task_history = "INSERT INTO project_tasks_timeline (task_id, timeline_text, date_added) VALUES ($task_id,'$timeline_text',now())";

mysqli_query($db, $task_history) or die("MySQL ERROR: " . mysqli_error($db));

