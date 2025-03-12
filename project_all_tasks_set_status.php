<?php include "include/dbconnect.php";

$status = $_POST['status'];
$project_id = $_POST['project_id'];

$update_status = "UPDATE project_tasks SET task_status='$status' WHERE project_id=$project_id";
$result = mysqli_query($db, $update_status) or die("MySQL ERROR: " . mysqli_error());
