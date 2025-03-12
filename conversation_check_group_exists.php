<?php include "include/dbconnect.php";


$new_group = $_GET['new_group_name'];

$check_if_group_exists = "SELECT * from project_conversation_group WHERE gruup_title LIKE '%".$new_group."%'";
$result = mysqli_query($db, $check_if_group_exists) or die("MySQL ERROR: " . mysqli_error());
 $rowcount=mysqli_num_rows($result);

 if($rowcount>0){
 	echo "1";
 }
