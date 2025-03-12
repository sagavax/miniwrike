<?php session_start();?>
<?php include "include/dbconnect.php";?>
<?php include "include/functions.php";?>



<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="sk" lang="sk">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
		<title>Miniwrike - simple project task manager</title>
		<link href="css/style.css?v<?php echo time(); ?>" rel="stylesheet" type="text/css" />
		<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
		<link href='http://fonts.googleapis.com/css?family=PT+Sans:400,700' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=Roboto:400,300,300italic,700,700italic,400italic' rel='stylesheet'>
		<link rel='shortcut icon' href='project.ico'>



	</head>
<body>
	<div id="main">
			<?php
			$project_id = $_SESSION['project_id']

?>
			<!-- header -->
				<?php include "include/header.php";?>
            <!-- header -->

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

			<!--- middle section -->



			<div id="middle"> <!-- middle section -->

				<div id="project_comments_wrap">



<?php
$comment_id = $_GET['comm_id'];
$action = $_GET['action'];
$project_id = $_GET['project_id'];

if ($action == 'view') {
	$sql = "SELECT * from project_comments WHERE comment_id=$comment_id";
	$result = mysqli_query($db, $sql) or die("MySQL ERROR: " . mysqli_error());

	while ($row = mysqli_fetch_array($result)) {
		$comment = $row['comment'];
		$date_added = $row['date_added'];
		$user_id = $row['user_id'];
		$created_by = GetUserNameById($user_id);

		echo "<h3>View comment id : $comment_id</h3>";
		echo "<table id='comment_view'>";
		echo "<tr><td>Comment id:$comment_id</td></tr>";
		echo "<tr><td>$comment</td></tr>";
		echo "<tr><td>$created_by</td></tr>";
		echo "<tr><td>$date_added</td></tr>";
		echo "<tr><td><a href='project_comments.php?project_id=$project_id' class='link'><< Back</a></td></tr>";
		echo "</table>";
	} //end while
} elseif ($action == 'delete') {
	$comment_id = $_GET['comm_id'];

	$sql = "DELETE from project_comments WHERE comment_id=$comment_id";

	$result = mysqli_query($db, $sql) or die("MySQL ERROR: " . mysqli_error());

	// ****************           pridenie do streamu	************************

	$user_id = 1;

	add_to_stream('remove_comment', $_SESSION['project_id'], $user_id);

	header('Location: project_comments.php?project_id=' . $_SESSION['project_id'] . '');
} //end if

?>

				</div><!-- project comment wrap -->


            </div>
            <div style="clear:both;"></div>
            </div><!-- div middle -->
            <div style="clear:both;"></div>


			<?php include "include/footer.php";?>

		</div><!-- main -->

</body>
<html>