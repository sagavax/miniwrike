<?php include "include/dbconnect.php";?>
<?php include "include/functions.php";
session_start();

$meeting_id = $_POST['meeting_id'];
$meeting_location = mysqli_real_escape_string($db, $_POST['meeting_location']);
$project_id = $_POST['project_id'];
$organizer_id = $_SESSION['user_id'];

$update_location = "UPDATE project_meetings SET location='$meeting_location' WHERE id=$meeting_id";
mysqli_query($db, $update_location) or die(mysqli_error($db));

//pridat do streamu
$text_streamu = "The location of the meeting has been changed to $meeting_location";
$text_streamu = addslashes($text_streamu);
$add_to_stream = "INSERT INTO project_stream (project_id,user_id,text_of_stream, date_added) VALUES ($project_id,$organizer_id,'$text_streamu',now())";
$result = mysqli_query($db, $add_to_stream) or die("MySQL ERROR: " . mysqli_error($db));