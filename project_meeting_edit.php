<?php session_start();?>
<?php include "include/dbconnect.php";?>
<?php include "include/functions.php";?>

<?php
if (isset($_POST['uprav_miting'])) {
	$user_id = 1;
	$user_name = GetUserNameById($user_id);
	$project_id = $_POST['project_id'];
	$meeting_id = $_POST['meeting_id'];
	$project_name = GetProjectName($project_id);
	$meeting_title = $_POST['nazov_mitingu'];
	$datum_mitingu = $_POST['datum_mitingu'];
	$start_time = $_POST['start_time'];
	$end_time = $_POST['end_time'];
	$meeting_type = $_POST['meeting_type'];
	$location = $_POST['location'];
	$atendees = $_POST['atendees'];
	$datum = date('Y-m-d H:i:s');

	$sql = "UPDATE project_meetings SET meeting_title='$meeting_title',date_of_meeting='$datum_mitingu', start_time='$start_time', end_time='$end_time', meeting_type='$meeting_type', location='$location',atendees='$atendees' WHERE id=$meeting_id";
	echo "$sql";
	$result = mysqli_query($db, $sql) or die("MySQL ERROR: " . mysqli_error());

	$sql = "SELECT MAX(id) as meeting_id from project_meetings"; //ziskanie max comment id z tabulky

	$result = mysqli_query($db, $sql) or die("MySQL ERROR: " . mysqli_error());
	while ($row = mysqli_fetch_array($result)) {
		$meeting_id = $row['meeting_id'];
	}

	//pridat do streamu
	$stream_group = 'meeting';
	$text_streamu = "User <a href='project_user_profile.php?id=$user_id'>" . $user_name . "</a> has updated / modified meeting details id: <a href='project_meeting_details.php?meeting_id=$meeting_id'>" . $meeting_id . "</a> for the project <a href='project_details.php?project_id=$project_id'>" . $project_name . "</a>";
	$text_streamu = addslashes($text_streamu);
	$datum = date('Y-m-d H:m:s');
	$sql = "INSERT INTO project_stream (stream_group,project_id,user_id,text_of_stream, date_added) VALUES ('stream_group',$project_id,$user_id,'$text_streamu','$datum')";
	$result = mysqli_query($db, $sql) or die("MySQL ERROR: " . mysqli_error());

	$url = "project_meetings.php?project_id=$project_id";
	header('location:' . $url . '');
}

if (isset($_POST['assign_person'])) {
	$project_id = intval($_POST['project_id']);
	$atendee_id = $_POST['attendee'];
	$meeting_id = $_POST['meeting_id'];
	//skontrolovat ci uz clovek je assignovany na project
	$sql = "SELECT count(*) as assigne_status from project_meetings_atendees where meeting_id=$meeting_id and user_id=$atendee_id";
	//echo $sql;
	$result = mysqli_query($db, $sql) or die("MySQL ERROR: " . mysqli_error());
	while ($row = mysqli_fetch_array($result)) {
		$assigne_status = $row['assigne_status'];
	}

	echo "assignee status: " . $assigne_status;
	//
	if ($assigne_status >= 1) {
		$url = "project_meeting_edit.php?m_id=$meeting_id&project_id=$project_id";
		header('location:' . $url . '');
	} else {
		$user_id = 1;
		$attendee_name = GetUserNameById($atendee_id);

		$assigned_date = date('Y-m-d H:i:s');
		//var_dump($_POST);
		$sql = "INSERT INTO project_meetings_atendees(project_id,meeting_id, user_id, assigned_date) VALUES ($project_id,$meeting_id,$atendee_id,'$assigned_date')";

		$result = mysqli_query($db, $sql) or die("MySQL ERROR: " . mysqli_error());
		//echo $sql;
		//pridat do streamu
		$stream_group = "meeting";
		$text_streamu = "User <a href='project_user_profile.php?user_id=$user_id' class='link'>" . $attendee_name . "</a> has been assigned as atendee for the meeting id: <a href='project_meetings.php?m_id=$meeting_id' class='link'>" . $meeting_id . "</a>";
		$text_streamu = mysql_real_escape_string($text_streamu);
		$datum = date('Y-m-d H:m:s');
		$sql = "INSERT INTO project_stream (stream_group,project_id,user_id,text_of_stream, date_added) VALUES ('$stream_group',$project_id,$user_id,'$text_streamu','$datum')";

		$result = mysqli_query($db, $sql) or die("MySQL ERROR: " . mysqli_error());
		$url = "project_meeting_edit.php?m_id=$meeting_id&project_id=$project_id";
		header('location:' . $url . '');
	}
}

if (isset($_POST['remove_atendee'])) {
	$meeting_id = intval($_POST['meeting_id']);
	$assigment_id = intval($_POST['assigment_id']);
	$atendee_id = intval($_POST['atendee_id']);
	//var_dump($_POST);
	$attendee_name = GetUserNameById($atendee_id);

	$sql = "DELETE from project_meetings_atendees WHERE id=$assigment_id and meeting_id=$meeting_id";
	// echo $sql;
	$result = mysqli_query($db, $sql) or die("MySQL ERROR: " . mysqli_error());

	//pridate do streamu
	$user_id = 1;
	$stream_group = 'meetings';
	$project_id = $_SESSION['project_id'];
	$text_streamu = "User <a href='project_user_profile.php?user_id=$assignee_id' class='link'>" . $attendee_name . "</a> has been removed from meeting assigment for the meeting id: <a href='project_meetings.php?m_id=$meeting_id' class='link'>" . $meeting_id . "</a>";
	$text_streamu = mysql_real_escape_string($text_streamu);
	$datum = date('Y-m-d H:m:s');
	$sql = "INSERT INTO project_stream (stream_group,project_id,user_id,text_of_stream, date_added) VALUES ('$stream_group',$project_id,$user_id,'$text_streamu','$datum')";
	echo $sql;
	$result = mysqli_query($db, $sql) or die("MySQL ERROR: " . mysqli_error());
	$url = "project_meeting_edit.php?m_id=$meeting_id&project_id=$project_id";
	header('location:' . $url . '');

}

?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="sk" lang="sk">
   <head>
      <meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
      <title>Miniwrike - simple project task manager</title>
      <link href="css/style.css?v1.0" rel="stylesheet" type="text/css" />
      <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" rel="stylesheet" type="text/css" />
      <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
      <link href='http://fonts.googleapis.com/css?family=PT+Sans:400,700' rel='stylesheet' type='text/css'>
      <link href='http://fonts.googleapis.com/css?family=Roboto:400,300,300italic,700,700italic,400italic' rel='stylesheet' type='text/css'>
      <link rel='shortcut icon' href='project.ico'>
   </head>
   <body>
		<?php
$project_id = $_SESSION['project_id']; // proketove id
$user_id = 1; //uzivatelske id
$id = $_GET['m_id'];

?>


      <div id="main">
         <?php include "include/header.php";?>
         <?php include "include/menu.php";?>

         <div id="middle">
            <!-- middle section -->
            <div id="project_title">
               <!-- project title -->
               <?php
$project_id = $_GET['project_id'];
$sql = "SELECT * from projects where id=$project_id";
$result = mysqli_query($db, $sql) or die("MySQL ERROR: " . mysqli_error());
while ($row = mysqli_fetch_array($result)) {
	$project_name = $row['project_name'];
	$project_description = $row['project_descr'];

	//echo "<div id='project_short_details_wrap'>";
	echo "<span style='float:left;font-weight:bold; font-size:26px; font-family: Roboto, Helvetica, Arial,sans-serif;margin-left:10px'>$project_name<br></span>"; //boldovo
	echo "<span style='float:left;font-style:italic; font-size:12px; font-family: Roboto, Helvetica, Arial,sans-serif;color:#999;margin-left:15px'>$project_description</span>"; //italikom
	//echo "</div>";

}

?>
            </div>
            <!-- project title -->
            <div id="project_meetings_wrap">
               <h3>Meeting scheduler</h3>
               <?php
echo "<form action='project_meeting_edit.php' method='post' id='new_meeting_form'>";
echo "<input type='hidden' name='project_id' value=$project_id>";
echo "<input type='hidden' name='user_id' value=$user_id>";
echo "<input type='hidden' name='meeting_id' value=$id>";
echo "<table id='project_meeting_planner'>";

$sql = "SELECT * from project_meetings WHERE id=$id;";
//echo $sql;
$result = mysqli_query($db, $sql) or die("MySQL ERROR: " . mysqli_error());
$row = mysqli_fetch_array($result);
//$id=$row['id'];
$meeting_title = $row['meeting_title'];
$date_of_meeting = $row['date_of_meeting'];
$start_time = $row['start_time'];
$end_time = $row['end_time'];
$atendees = $row['atendees'];
$location = $row['location'];
$meeting_type = $row['meeting_type'];

echo "<tr><td>Nazov meetingu:</td><td><input type='text' name='nazov_mitingu' value='$meeting_title' /></td></tr>";
echo "<tr><td>Datum meetingu:</td><td><input type='date' name='datum_mitingu' value='" . $row['date_of_meeting'] . "' /></td></tr>";
echo "<tr><td>Zaciatok:</td><td><input type='time' name='start_time' value='" . $row['start_time'] . "' /></td></tr>";
echo "<tr><td>Koniec:</td><td><input type='time' name='end_time' value='" . $row['end_time'] . "' /></td></tr>";
echo "<tr><td>Typ mitingu:</td><td><input type='text' name='meeting_type' value='" . $row['meeting_type'] . "' /></td></tr>";
echo "<tr><td>Miesto konania:</td><td><input type='text' name='location' value='" . $row['location'] . "' /></td></tr>";
echo "<tr><td>Ucastnici:</td><td><select name='attendee'>";
$sql = "SELECT * from project_assigned_people where project_id=$project_id";

$result = mysqli_query($db, $sql) or die("MySQL ERROR: " . mysqli_error());
while ($row = mysqli_fetch_array($result)) {
	$user_id = $row['user_id'];
	echo "<option value=$user_id>" . GetUserNameById($user_id) . "</option>";
}
echo "</select><button type='submit' name='assign_person' class='blue-badge'>OK</button></td></tr>";
echo "<tr><td colspan='2'>";

//list of meeting's attendees
echo "<div id='meeting_atendees'>";

$sql = "SELECT * from project_meetings_atendees WHERE project_id=$project_id and meeting_id=$id";
$result = mysqli_query($db, $sql) or die("MySQL ERROR: " . mysqli_error());
$nr_attendees = mysql_num_rows($result);
if ($nr_attendees == 0) {
	echo "<span style='font-size:12px; color:#999'>No people have been assigned to this meeting</span>";
} else {
	echo "<ul id='meeting_atendees_list'>";
	while ($row = mysqli_fetch_array($result)) {
		$user_id = $row['user_id'];
		$user_name = GetUserNameById($user_id); //ziskam meno
		$assigment_id = $row['id'];
		echo "<li><span style='float:left'><a href='project_user_profile.php?user_id=$user_id' class='link'>$user_name</a></span><form action='project_meeting_edit.php' method='post'><input type='hidden' name='atendee_id' value='$user_id'><input type='hidden' name='assigment_id' value='$assigment_id'><input type='hidden' name='meeting_id' value='$id' ><span style='float:right'><button name='remove_atendee' class='blue-badge'><i class='fa fa-times'></i></button</span></form></li>";
	}
	echo "<div style='clear:both'></div>";
	echo "</ul>";

} //end if

echo "</div>";
echo "</td><tr>";
echo "<tr><td colspan='2'><button type='submit' name='uprav_miting' class='blue-badge'>Update meeting</button>";

//echo "<tr><td>Text:</td><td><textarea name='text_clanku'>$text_clanku</textarea></td></tr>";
echo "</table>";
echo "</form>";

?>
            </div>
         </div>
         <?php include "include/footer.php";?>>
      </div>
   </body>
</html>