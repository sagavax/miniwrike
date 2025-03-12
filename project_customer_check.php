<?php include "include/dbconnect.php";

$customer_name = $_POST['customer_name'];

$check_customer_name = "SELECT * from project_customers where customer_name LIKE '%".$customer_name."%';
$result = mysqli_query($db, $check_customer_name) or die("MySQL ERROR: " . mysqli_error());
$rowcount=mysqli_num_rows($result);
if($rowcount)>0 {
	echo 1;
}