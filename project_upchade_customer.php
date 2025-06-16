<?php
	include("include/dbconnect.php");	

$customer_id = $_POST['customer_id'];
$project_id = $_POST['project_id'];

$update_project_customer = "UPDATE projects SET project_customer=$customer_id WHERE project_id=$project_id";
$result = mysqli_query($db, $update_project_customer) or die("MySQLi ERROR: " . mysqli_error($db));

?>
