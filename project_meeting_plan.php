<?php session_start();?>
<?php include "include/dbconnect.php";?>
<?php include "include/functions.php";?>


 <?



/*	Názov	Typ	Zotriedenie	Atribúty	Nulový	Predvolené	Extra	Akcia
	 1	id	int(11)
	 2	date_of_meeting	datetime
	 3	start_time
	 4	end_time
	 5	atendees
	 6	meeting_log	text
	 7	created_date
*/
 ?>

 <?php

if (isset($_POST['novy_miting'])) {
	$user_id = 1;
	$user_name = GetUserNameById($user_id);
	$project_id = $_POST['project_id'];
	$project_name = GetProjectName($project_id);
	$meeting_title = $_POST['nazov_mitingu'];
	$datum_mitingu = $_POST['datum_mitingu'];
	$start_time = $_POST['start_time'];
	$end_time = $_POST['end_time'];
	$meeting_type = $_POST['meeting_type'];
	$location = $_POST['location'];
	$atendees = $_POST['atendees'];
	$datum = date('Y-m-d H:i:s');

	$sql = "INSERT INTO project_meetings (meeting_title,date_of_meeting, start_time, end_time,project_id, meeting_type, location,atendees, meeting_log, created_date) VALUES ('$meeting_title','$datum_mitingu','$start_time','$end_time',$project_id,'$meeting_type','$location','$atendees','', '$datum')";
	//echo "$sql";
	$result = mysqli_query($db, $sql) or die("MySQL ERROR: " . mysqli_error());

	$sql = "SELECT MAX(id) as meeting_id from project_meetings"; //ziskanie max comment id z tabulky

	$result = mysqli_query($db, $sql) or die("MySQL ERROR: " . mysqli_error());
	while ($row = mysqli_fetch_array($result)) {
		$meeting_id = $row['meeting_id'];
	}

	//pridat do streamu
	$text_streamu = "User <a href='project_user_profile.php?id=$user_id'>" . $user_name . "</a> has created a new meeting id: <a href='project_meeting_details.php?meeting_id=$meeting_id'>" . $meeting_id . "</a> for the project <a href='project_details.php?project_id=$project_id'>" . $project_name . "</a>";
	$text_streamu = addslashes($text_streamu);
	$datum = date('Y-m-d H:m:s');
	$sql = "INSERT INTO project_stream (project_id,user_id,text_of_stream, date_added) VALUES ($project_id,$user_id,'$text_streamu','$datum')";
	$result = mysqli_query($db, $sql) or die("MySQL ERROR: " . mysqli_error());

	//$url="project_meetings.php?project_id=$project_id";
	$url = "project_meeting_edit.php?m_id=$meeting_id&project_id=$project_id";
	header("Location: $url");
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

$project_id = $_GET['project_id']; // proketove id
//$project_id=$_SESSION['project_id'];
$user_id = $_GET['id']; //uzivatelske id
$day = $_GET['day']; // input z mitingoveho kalendara

?>
		<div id="main">


			 <?php include "include/header.php";?>
            <?php include "include/menu.php";?>


			<div id="middle"> <!-- middle section -->
				<div id="project_title"><!-- project title -->
	               <?php

$sql = "SELECT project_name, project_descr from projects where id=$project_id";
//echo "$sql";
$result = mysqli_query($db, $sql) or die("MySQL ERROR: " . mysqli_error());
while ($row = mysqli_fetch_array($result)) {
	$project_name = $row['project_name'];
	$project_description = $row['project_descr'];

	//echo "<div id='project_short_details_wrap'>";
	echo "<span style='float:left;font-weight:bold; font-size:26px; font-family: Helvetica, Arial,sans-serif;margin-left:10px'>$project_name</span>"; //boldovo
	echo "<span style='float:left;font-style:italic; font-size:12px; font-family: Helvetica, Arial,sans-serif;color:#999;margin-left:15px'>$project_description</span>"; //italikom
	//echo "</div>";

}

?>
            </div><!-- project title -->
				<div id="project_meetings_wrap">
				  <h3>Meeting scheduler</h3>
				  <?php
echo "<form action='project_meeting_plan.php' method='post' id='new_meeting_form'>";
echo "<input type='hidden' name='project_id' value=$project_id>";
echo "<table id='project_meeting_planner'>";
echo "<tr><td>Nazov meetingu:</td><td><input type='text' name='nazov_mitingu' value='' /></td></tr>";

/*if (isset($_GET['day'])) { //klikol som nan z kalendara
								$day=$_GET['day'];
								$datum_mitingu=$day;
							} else {$datum_mitingu='';}	*/

echo "<tr><td>Datum meetingu:</td><td><input type='date' name='datum_mitingu' value='" . $_GET['day'] . "' /></td></tr>";
echo "<tr><td>Zaciatok:</td><td><input type='time' name='start_time' value='' /></td></tr>";
echo "<tr><td>Koniec:</td><td><input type='time' name='end_time' value='' /></td></tr>";
echo "<tr><td>Typ mitingu:</td><td><input type='text' name='meeting_type' value='' /></td></tr>";
echo "<tr><td>Miesto konania:</td><td><input type='text' name='location' value='' /></td></tr>";
echo "<tr><td colspan='2'><button type='submit' name='novy_miting'>New meeting</button>";
//echo "<tr><td>Text:</td><td><textarea name='text_clanku'>$text_clanku</textarea></td></tr>";
echo "</table>";
echo "</form>";

?>

				</div>

			</div>

			<?php include "include/footer.php";?>

		</div>

</body>
</html>