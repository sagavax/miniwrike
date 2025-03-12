<?php include "include/dbconnect.php";?>
<?php include "include/functions.php";?>
<?php session_start();?>


<?php
	$user_id = $_POST['user_id'];
	$project_id = $_POST['project_id'];

	$remove_as_pm = "DELETE from project_managers WHERE user_id=$user_id and project_id=$project_id";
	$result = mysqli_query($db, $remove_as_pm) or die(mysqli_error($db));
