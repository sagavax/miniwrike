
<?php

		$project_id = $_SESSION['project_id'];

echo "<div class='project_meetings'>";
	$sql = "SELECT * from project_meetings where project_id=$project_id";
	$result = mysqli_query($db, $sql) or die("MySQL ERROR: " . mysqli_error());
	while ($row = mysqli_fetch_array($result)) {
		$i++;
		$id = $row['id'];
		//$created_by = $row['created_by'];
		$meeting_title = $row['meeting_title'];
		$date_of_meeting = $row['date_of_meeting'];
		$start_time = $row['start_time'];
		$end_time = $row['end_time'];
		$location = $row['location'];
		if($row['location']=="") {
			$location = "<button type='button' class='button' name='add_location' title='add meting location'><i class='fa fa-plus'></i> location</button>";
		}
		//$atendees=$row['atendees'];
		$meeting_type = $row['meeting_type'];
		
		echo "<div class='meeting' meeting-id=$id><div class='meeting_title'>$meeting_title</div><div class='meeting_created'><a href='project_user_profile.php?user_id=$user_id'>" . GetUserNameById($user_id) . "</span></a></div><div class='meeting_date'>$date_of_meeting</div><div class='meeting_start'>$start_time</div><div class='meeting_end'>$end_time</div><div class='metting_attendees'><button type='button' class='blue-badge' name='attendees'>" . NrOfAttendees($id) . "</button></div><div class='meeting_location'>$location</div><div class='meeting_leave'><button type='button' class='button'><i class='fa fa-times' title='Leave from meeting'></i></button></div></div>";
   } //koniec cyklu
 echo "</div>";	
?>
			