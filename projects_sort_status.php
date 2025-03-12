<?php

	include("include/dbconnect.php");
	include("include/functions.php");

	$status = $_POST['status'];

	$find_project = "SELECT * from projects WHERE project_status=$status'";
	 $result = mysqli_query($db, $find_project);

            $alternate = "2";

            while ($row = mysqli_fetch_array($result)) {
            	$id = $row['id'];
            	$project_name = $row['project_name'];
            	//$project_code = $row['project_code'];
            	$project_descr = $row['project_descr'];
            	$customer_id = $row['project_customer'];
            	$established_date = $row['established_date'];
            	$project_status = $row['project_status'];

            	if ($established_date == '0000-00-00') {$established_date = 'N/A';}

            	if ($alternate == "1") {
            		$color = "even";
            		$alternate = "2";
            	} else {
            		$color = "odd";
            		$alternate = "1";
            	}

            	$NrofTask = NrofTasks($id);
            	$customer_name = GetCustomerName($customer_id);

            	echo "<div class='project' project-id=$id project-status=$project_status>";
            	echo "<div class='project_priority'></div>";
            	echo "<h2>$project_name</h2>";
            	echo "<span>1 day ago</span>";
            	echo "<p>$project_descr</p>";
            	echo "<div class='status'>$project_status</div>";
            	//echo "<div class='meta'><div class='members_list'></div><a href='project_details.php?project_id=$id' class='blue-badge'>Enter</a></div>";
            	echo "</div>"; //div project

                }