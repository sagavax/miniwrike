<?php session_start();?>
<?php include "include/dbconnect.php";?>
<?php include "include/functions.php";?>

      <!DOCTYPE html>
      <html xmlns="http://www.w3.org/1999/xhtml" xml:lang="sk" lang="sk">
         <head>
            <meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
            <title>Miniwrike - simple project task manager</title>
            <link href="css/style.css?v1.0" rel="stylesheet" type="text/css" />
            <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" rel="stylesheet" type="text/css" />
            <link href='http://fonts.googleapis.com/css?family=PT+Sans:400,700' rel='stylesheet' type='text/css'>
		    <link href='http://fonts.googleapis.com/css?family=Roboto:400,300,300italic,700,700italic,400italic' rel='stylesheet'>
            <link rel='shortcut icon' href='project.ico'>
         </head>
         <body>

              <?php
echo "Project " . $_SESSION['project_id'];
?>

            <div id="main">
               <!-- header -->
               <?php include "include/header.php";?>
               <?php include "include/menu.php";?>
               <!-- header -->
               <?php

?>

               <div id="middle">
                  <!-- middle section -->
                  <div id="project_title"><!-- project title -->
		               <?php
$project_id = $_SESSION['project_id'];
$user_id = $_SESSION['user_id'];
$sql = "SELECT * from projects where id=$project_id";
$result = mysqli_query($db, $sql) or die("MySQL ERROR: " . mysqli_error());
while ($row = mysqli_fetch_array($result)) {
	$project_name = $row['project_name'];
	$project_description = $row['project_descr'];

	echo "<span style='float:left;font-weight:bold; font-size:26px; font-family: Helvetica, Arial,sans-serif;margin-left:10px'>$project_name<br></span>"; //boldovo
	echo "<span style='float:left;font-style:italic; font-size:12px; font-family: Helvetica, Arial,sans-serif;color:#ddd;margin-left:15px'>$project_description</span>"; //italikom

}

?>
            		</div><!-- project title -->                  <!-- project title -->
                  <div id="project_meetings_wrap">
                     <!-- project_meetings_wrap -->
                     <?php
$id = $_GET['m_id'];

echo "<table id='project_meeting_viewer'>";
$sql = "SELECT * from project_meetings WHERE id=$id";
//echo "$sql";
$result = mysqli_query($db, $sql) or die("MySQL ERROR: " . mysqli_error());
while ($row = mysqli_fetch_array($result)) {
	$i++;
	$id = $row['id'];
	$project_id = $row['project_id'];
	$meeting_title = $row['meeting_title'];
	$date_of_meeting = $row['date_of_meeting'];
	$start_time = $row['start_time'];
	$end_time = $row['end_time'];
	$atendees = $row['atendees'];
	$location = $row['location'];
	$meeting_type = $row['meeting_type'];
	$meeting_log = $row['meeting_log'];

	echo "<tr><td class='bold'>Nazov meetingu:</td><td><input type='text' name='nazov_mitingu' value='$meeting_title' /></td></tr>";
	echo "<tr><td class='bold'>Datum meetingu:</td><td><input type='text' name='datum_mitingu' value='$date_of_meeting' /></td></tr>";
	echo "<tr><td class='bold'>Zaciatok:</td><td><input type='text' name='start_time' value='$start_time' /></td></tr>";
	echo "<tr><td class='bold'>Koniec:</td><td><input type='text' name='end_time' value='$end_time' /></td></tr>";
	echo "<tr><td class='bold'>Typ mitingu:</td><td><input type='text' name='meeting_type' value='$meeting_type' /></td></tr>";
	echo "<tr><td class='bold'>Miesto konania:</td><td><input type='text' name='location' value='$location' /></td></tr>";
	echo "<tr><td class='bold'>Ucastnici</td><td><div id='meeting_atendees'>";

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
			echo "<li><span style='float:left'><a href='project_user_profile.php?user_id=$user_id' class='link'>$user_name</a></span></li>";
		}
		echo "<div style='clear:both'></div>";
		echo "</ul>";

	} //end if

	echo "</div></td></tr>";
	echo "<tr><td>Zaznam:</td><td><div class='meeting_log'>" . nl2br($meeting_log) . "</div></tr>";
	//echo "<tr><td colspan='2'><button type='submit' name='update_miting'>Novy meetingk</button>";
} //echo "<tr><td>Text:</td><td><textarea name='text_clanku'>$text_clanku</textarea></td></tr>";
echo "</table>";

?>
                     <a href="project_meetings.php?project_id=<?php echo $project_id ?>"><< Back</a>
                  </div>
                  <!-- project_meetings_wrap -->
               </div>
               <!-- middle section -->
               <?php include "include/footer.php";?>
            </div>
            <!--main wrap -->
         </body>
      </html>
