<?php include "include/dbconnect.php";?>
<?php include "include/functions.php";?>
<?php session_start();


$project_id = $_GET['project_id'];


$get_project_managers = "SELECT * from project_managers WHERE project_id=$project_id";
//echo $get_project_managers;
$result = mysqli_query($db, $get_project_managers) or die(mysqli_error($db));

while($row = mysqli_fetch_array($result)){
	$id = $row['id'];
	$project_manager_name = GetUserNameById($id);
	echo "<div class='assigned_person_badge' user-id=$id>" .GetUserNameById($id)."<button type='button' class='button'><i class='fa fa-times'></i></button></div>";
}