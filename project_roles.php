<?php
	include("include/dbconnect.php");
	include("include/functions.php");
	session_start();

	$get_roles = "SELECT * from project_roles";
    $result = mysqli_query($db, $get_roles) or die(mysqli_errno($db));

	while ($row = mysqli_fetch_assoc($result)) {
		$role_id = $row['role_id'];
		$role_name = $row['role_name'];

		echo "<button name='role' role-id='$role_id' class='button'>$role_name</button>";
	}