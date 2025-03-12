
<?php include "include/dbconnect.php";?>
<?php include "include/functions.php";
session_start();


$new_title = mysqli_real_escape_string($db, $_POST['new_title']);
$meeting_id = $_POST['meeting_id'];
$organizer_id = $_SESSION['user_id'];
$user_name = GetUserNameById($organizer_id);
$project_id = $_POST['project_id'];


//https://devcodef1.com/news/1212875/creating-teams-meetings-with-php


$update_meeting_title = "UPDATE project_meetings set meeting_title='$new_title' WHERE id=$meeting_id";
mysqli_query($db, $update_meeting_title) or die(mysqli_error($db));

//pridat do streamu
$text_streamu = "The meeting id $meeting_id has change to $new_title";
$text_streamu = addslashes($text_streamu);
$add_to_stream = "INSERT INTO project_stream (project_id,user_id,text_of_stream, date_added) VALUES ($project_id,$organizer_id,'$text_streamu',now())";
$result = mysqli_query($db, $add_to_stream) or die("MySQL ERROR: " . mysqli_error($db));