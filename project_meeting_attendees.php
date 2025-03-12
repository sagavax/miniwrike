<?php 
 include "include/dbconnect.php";
 include "include/functions.php";
 session_start();


$meeting_id = $_GET['meeting_id'];


 $get_attendees = "SELECT * from project_meetings_atendees WHERE meeting_id=$meeting_id";
 $result = mysqli_query($db, $get_attendees) or die(mysqli_error($db));

 while($row = mysqli_fetch_array($result)){
 		$id = $row['id'];
 		$user_id = $row['user_id'];
 		$user_name = GetUserNameById($user_id);

 		echo "<div class='attendee' attendee-id=$id>";
 			echo "<div class='attendee_name'>$user_name</div><button type='button' title='remove from meeting'><i class='fa fa-times'></i></button>";
 		echo "</div>";

 }

 echo "<div class='add_attendee'><select name='attendees'>";
$get_new_attendees = "SELECT user_id  FROM project_users WHERE user_id NOT IN ( SELECT user_id FROM project_meetings_atendees 
        WHERE meeting_id = $meeting_id)";


// Execute the query
$result_new_attendees = mysqli_query($db, $get_new_attendees) or die(mysqli_error($db));

// Loop through the result set and generate option elements
while ($row_new_attendees = mysqli_fetch_array($result_new_attendees)) {
    $user_id = $row_new_attendees['user_id']; // Correctly access the array
    echo "<option value='$user_id'>" . GetUserNameById($user_id) . "</option>";
}
 echo"</select><button class='button'><i class='fa fa-plus'></i></button></div>";


