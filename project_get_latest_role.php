<?php

	include("include/dbconnect.php");

	$project_id = $_GET['project_id'];

	$get_latest_role = "SELECT a.id,a.role_id, b.role_id, b.role_name FROM project_assigned_roles a, project_roles b WHERE a.project_id=$project_id AND a.role_id = b.role_id ORDER BY a.id DESC LIMIT 1";
	$result = mysqli_query($db, $get_latest_role) or die(mysqli_errno($db));

	if($result) {
	    $rows = array(); // Initialize an empty array to store rows
	    
	    // Fetch each row from the result set
	    while($row = mysqli_fetch_assoc($result)) {
	        $rows[] = $row; // Add the row to the array
	    }
	    
	    // Convert the array of rows into JSON format
	    $json = json_encode($rows);
	    
	    // Print or return the JSON data
	    echo $json;
	} else {
	    // Handle the case where the query fails
            echo "Error executing query: " . mysqli_error($db);
	}