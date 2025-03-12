<?php 
include "include/dbconnect.php";
include "include/functions.php";
session_start();

$user_id = $_POST['user_id'];
$task_id = $_POST['task_id'];

$assign_task = "UPDATE project_tasks SET user_id = $user_id WHERE task_id=$task_id";
$result = mysqli_query($db, $assign_task) or die("MySQL ERROR: " . mysqli_error($db)); // use the correct variable and include the connection 

//change status of the tasks

//check task_status
$check_status = "SELECT task_status from project_tasks WHERE task_id=$task_id";
$result_status = mysqli_query($db, $check_status) or die("MySQL ERROR: " . mysqli_error($db)); // use the correct 
$row_status = mysqli_fetch_array($result_status);
$status = $row_status['task_status'];
//if status is "new" change it into "in progress"
if($status == "new") {
	$change_status = "UPDATE project_tasks SET task_status='in progress' WHERE task_id=$task_id";
	mysqli_query($db, $change_status) or die("MySQL ERROR: " . mysqli_error($db)); // use the correct 
}
?>
