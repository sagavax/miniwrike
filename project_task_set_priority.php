<?php include "include/dbconnect.php";



$priority = $_POST['priority'];
$task_id = $_POST['task_id'];

$update_status = "UPDATE project_tasks SET task_priority='$priority' WHERE task_id=$task_id";
$result = mysqli_query($db, $update_status) or die("error: " . mysqli_error());
