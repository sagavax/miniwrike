<?php include "include/dbconnect.php";

$status = $_POST['status'];
$task_id = $_POST['task_id'];

$update_status = "UPDATE project_tasks SET task_status='$status' WHERE task_id=$task_id";
$result = mysqli_query($db, $update_status) or die("MySQL ERROR: " . mysqli_error());
