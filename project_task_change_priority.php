<?php
include "include/dbconnect.php";
include "include/functions.php";

$task_id = $_POST['task_id'];
$task_priority = $_POST['task_priority'];
$project_id = $_POST['project_id'];

$change_priority = "UPDATE project_tasks SET task_priority = '$task_priority' WHERE task_id=$task_id";
mysqli_query($db, $change_priority) or die("MySQL ERROR: " . mysqli_error($db));

$text_streamu = "The priority of the task id <a href='project_task.php?task_id=$task_id'> " . $task_id . "</a> has been chanegd to <b>$task_priority</b>";

$text_streamu = mysqli_real_escape_string($db, $text_streamu);
$stream_group = 'task';
$user_id = 1;
$project_stream = "INSERT INTO project_stream (stream_group,project_id,user_id,text_of_stream, date_added) VALUES ('$stream_group',$project_id,$user_id,'$text_streamu',now())";

mysqli_query($db, $project_stream) or die("MySQL ERROR: " . mysqli_error($db));


$timeline_text = "priority has been changed to <b>$task_priority</b>";
$task_history = "INSERT INTO project_tasks_timeline (task_id, timeline_text, date_added) VALUES ($task_id,'$timeline_text',now())";

mysqli_query($db, $task_history) or die("MySQL ERROR: " . mysqli_error($db));

