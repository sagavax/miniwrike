<?php include "include/dbconnect.php";?>
<?php include "include/functions.php";?>
<?php session_start();?>

<?php
    $person_id = $_POST['person_id'];
	$project_id = $_POST['project_id'];

	

	if ($person_id <> 0) {
		
		$project_id = trim($_POST['project_id']);
		$project_name = GetProjectName($project_id);
		$assigned_by = 1;
		
		$assign_person = "INSERT INTO project_assigned_people (project_id, user_id,assigned_by,assigned_date ) VALUES ($project_id,$person_id,1,now())";
		//echo $sql;
		$result = mysqli_query($db, $assign_person) or die("MySQL ERROR: " . mysqli_error());

		//pridanie do streamu / logu / wallu
		$text_streamu = "User <a href='project_user_profile.php?id=$user_id'>" . $user_name . "</a> has been added to the project <a href='project_details.php?project_id=$project_id'>" . $project_name . "</a>";
		$text_streamu = mysqli_real_escape_string($db, $text_streamu);
		$sql = "INSERT INTO project_stream (project_id,user_id,text_of_stream, date_added) VALUES ($project_id,$assigned_by,'$text_streamu', now())";
		$result = mysqli_query($db, $sql) or die("MySQL ERROR: " . mysqli_error($db));		
	}