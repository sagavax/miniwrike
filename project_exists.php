<?php session_start();
 include "include/dbconnect.php";
 include "include/functions.php";


$project_name = mysqli_real_escape_string($db, $_POST['new_project']);

$check_project = "SELECT project_name from projects WHERE project_name LIKE '%project_name%'";
$result = mysqli_query($db, $check_project) or die(mysqli_error($db));
$row = while (mysqli_fetch_array($result)) {
	$project_name = $row['project_name'];
}

echo $project_name;