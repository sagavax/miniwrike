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

if (isset($_POST['update_miting'])) {
	$project_id = $_POST['project_id'];
	$m_id = $_POST['m_id'];
	$meeting_title = mysqli_real_escape_string($db, $_POST['nazov_mitingu']);
	$meeting_record = mysqli_real_escape_string($db, $_POST['meeting_record']);

	//echo "$id";
	$sql = "UPDATE project_meetings SET meeting_log='$meeting_record', updated=1 WHERE id=$m_id";
	//echo "$sql";
	$result = mysqli_query($db, $sql) or die("MySQL ERROR: " . mysqli_error());
	$url = "project_meetings.php?project_id=$project_id";

	header('location:' . $url . '');

	//$id=$_POST['id'];
	# code...
}

?>


<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="sk" lang="sk">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

		<title>Miniwrike - simple project task manager</title>
		<link href="css/style.css?v1.0" rel="stylesheet" type="text/css" />
		<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" rel="stylesheet" type="text/css" />

		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
		<script type="text/javascript" src="js/facebox.js"></script>
		<link href='http://fonts.googleapis.com/css?family=PT+Sans:400,700' rel='stylesheet' type='text/css'>
		<link rel='shortcut icon' href='project.ico'>

	</head>
<body>
		<?php

$project_id = $_GET['project_id'];
$user_id = $_GET['user_id'];
$m_id = $_GET['m_id'];
echo "Project:$project_id";
echo "meeting id:$m_id";

?>
		<div id="main">


			<!-- header -->
				<?php include "include/header.php";?>
            <!-- header -->

				<?php

$project_id = $_GET['project_id'];

?>
           <?php include "include/menu.php";?>

            <div id="project_title"><!-- project title -->
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
				</div><!-- project title -->

			<!--- middle section -->
			<div id="middle"> <!-- middle section -->
				<div id="project_meetings_wrap">
					<?php

echo "<form action='project_meeting_log.php' method='post' id='uprav_meeting_form'>";
echo "<table id='meeting_logger'>";

$sql = "SELECT * from project_meetings WHERE id=$m_id";
//echo $sql;
$result = mysqli_query($db, $sql) or die("MySQL ERROR: " . mysqli_error());
while ($row = mysqli_fetch_array($result)) {

	//$id=$row['id'];
	$meeting_title = $row['meeting_title'];
	$date_of_meeting = $row['date_of_meeting'];
	$start_time = $row['start_time'];
	$end_time = $row['end_time'];
	$atendees = $row['atendees'];
	$location = $row['location'];
	$meeting_type = $row['meeting_type'];
	$meeting_log = $row['meeting_log'];

	echo "<input type='hidden' value='$m_id' name='m_id'>";
	echo "<input type='hidden' value=$project_id name='project_id'>";
	echo "<tr><td>Nazov meetingu:</td><td><input type='text' name='nazov_mitingu' value='$meeting_title' /></td></tr>";
	echo "<tr><td>Datum meetingu:</td><td><input type='text' name='datum_mitingu' value='$date_of_meeting' /></td></tr>";
	echo "<tr><td>Zaciatok:</td><td><input type='text' name='start_time' value='$start_time' /></td></tr>";
	echo "<tr><td>Koniec:</td><td><input type='text' name='end_time' value='$end_time' /></td></tr>";
	echo "<tr><td>Typ mitingu:</td><td><input type='text' name='meeting_type' value='$meeting_type' /></td></tr>";
	echo "<tr><td>Miesto konania:</td><td><input type='text' name='location' value='$location' /></td></tr>";
	echo "<tr><td>Ucastnici</td><td><input type='text' name='atendees' value='$atendees' /></td></tr>";
	echo "<tr><td>Zaznam</td><td><textarea name='meeting_record'>$meeting_log</textarea></tr>";
	echo "<tr><td colspan='2' style='text-align: right'><button type='submit' name='update_miting' class='blue-badge'>Save meeting</button>";
}
//echo "<tr><td>Text:</td><td><textarea name='text_clanku'>$text_clanku</textarea></td></tr>";
echo "</table>";
echo "</form>";

?>
				</div> <!-- wrapper-->
			</div><!-- middle section -->

			<?php include "include/footer.php";?>


		</div> <!--main wrap -->



</body>
</html>