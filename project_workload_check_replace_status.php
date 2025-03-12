<?php
include "include/dbconnect.php";
include "include/functions.php";

$task_id = $_POST['task_id'];

$check_status = "SELECT task_status from project_tasks WHERE task_id=$task_id";
$result_status = mysqli_query($db, $check_status) or die("MySQL ERROR: " . mysqli_error($db)); // use the correct 
$row_status = mysqli_fetch_array($result_status);
$status = $row_status['task_status'];
//if status is "new" change it into "in progress"
if($status == "new") {
	$change_status = "UPDATE project_tasks SET task_status='in progress' WHERE task_id=$task_id";
	mysqli_query($db, $change_status) or die("MySQL ERROR: " . mysqli_error($db)); // use the correct 

	echo "in_progress";
}