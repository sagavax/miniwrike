<?php include "include/dbconnect.php"?>
<?php include "include/functions.php"?>
<?php session_start();


$task_id = $_GET['task_id'];

$update_nr_updates = "SELECT COUNT(*) as nr_updates from project_task_comments WHERE task_id=$task_id";
$result = mysqli_query($db, $update_nr_updates) or die("MySQL ERROR: " . mysqli_error($db));
$row = mysqli_fetch_array($result);
$nr_updates = $row['nr_updates'];


echo $nr_updates;
