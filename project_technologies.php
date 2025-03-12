<?php
	include("include/dbconnect.php");
	include("include/functions.php");
	session_start();


	$get_techs = "SELECT * from project_technologies";
	$result = mysqli_query($db, $get_techs) or die(mysqli_errno($db));
	while ($row = mysqli_fetch_assoc($result)) {
		$tech_id = $row['tech_id'];
		$tech_name = $row['technology_name'];
		$tech_description = $row['technology_description'];

		echo "<button name='technology' tech-id=$tech_id class='button'>$tech_name</button>";

	}