<?php include "include/dbconnect.php";



$priority = $_POST['priority'];
$project_id = $_POST['project_id'];

$update_status = "UPDATE project_tasks SET task_priority='$priority' WHERE project_id=$project_id";
$result = mysqli_query($db, $update_status) or die("error: " . mysqli_error());
