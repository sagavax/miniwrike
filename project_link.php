<?php session_start();?>
<?php include "include/dbconnect.php";?>
<?php include "include/functions.php";?>

<?php
if (isset($_POST['add_new_link'])) {
	$link_name = mysqli_real_escape_string($db, $_POST['link_name']);
	$link_url = mysqli_real_escape_string($db, $_POST['link_url']);
	$link_decription = mysqli_real_escape_string($db, $_POST['link_decription']);
	$date_added = date("Y-m-d H:i:s");
	$user_id = intval($_POST['user_id']);
	$project_id = intval($_POST['project_id']);
	$stream_group = "links";

	$sql = "INSERT INTO project_links (project_id,link_name,link_url,link_description,created_date,added_by) VALUES ($project_id,'$link_name','$link_url','$link_decription','$date_added',$user_id)";
	$result = mysqli_query($db, $sql) or die("MySQL ERROR: " . mysqli_error());

	//pridat do streamu / logu

	$sql = "SELECT max(link_id) as link from project_links where project_id=$project_id";
	$result = mysqli_query($db, $sql) or die("MySQL ERROR: " . mysqli_error());
	$row = mysqli_fetch_array($result);

	while ($row = mysqli_fetch_array($result)) {
		$link_id = $row['link_id'];
	}

	$user_name = GetUserNameById($user_id);
	$project_name = GetProjectName($project_id);

	$text_streamu = "User <a href='project_user_profile.php?id=$user_id'>" . $user_name . "</a> has added new link id <a href='project_link.php?link_id=$link_id&project_id=$project_id'>" . $link_id . "</a> for the project: <a href='project_details.php?project_id=$project_id'>" . $project_name . "</a>";

	$text_streamu = mysql_real_escape_string($text_streamu);
	$datum = date('Y-m-d H:m:s');

	$sql = "INSERT INTO project_stream (project_id,stream_group,user_id,text_of_stream, date_added) VALUES ($project_id,'$stream_group',$user_id,'$text_streamu', '$datum')";
	//echo $sql;
	$result = mysqli_query($db, $sql) or die("MySQL ERROR: " . mysqli_error());

	$url = "project_links.php?project_id=$project_id";
	header('location:' . $url . '');

}

if (isset($_POST['modify_link'])) {
	$link_id = intval($_POST['link_id']);
	$project_id = intval($_POST['project_id']);
	$user_id = intval($_POST['user_id']);
	$link_name = mysqli_real_escape_string($db, $_POST['link_name']);
	$link_url = mysqli_real_escape_string($db, $_POST['link_url']);
	$link_description = mysqli_real_escape_string($db, $_POST['link_description']);
	$stream_group = 'links';

	//echo $user_id;

	$sql = "UPDATE project_links SET link_name='$link_name',link_url='$link_url',link_description='$link_description' WHERE link_id=$link_id";
	//echo $sql;
	$result = mysqli_query($db, $sql) or die("MySQL ERROR: " . mysqli_error());

	//pridat do streamu / logu
	$user_name = GetUserNameById($user_id);
	$project_name = GetProjectName($project_id);

	$text_streamu = "User <a href='project_user_profile.php?id=$user_id'>" . $user_name . "</a> has modified the link id <a href='project_link.php?link_id=$link_id&project_id=$project_id'>" . $link_id . "</a> for the project:" . $project_name;
	$text_streamu = mysql_real_escape_string($text_streamu);
	$datum = date('Y-m-d H:m:s');
	$sql = "INSERT INTO project_stream (project_id,stream_group,user_id,text_of_stream, date_added) VALUES ($project_id,'$stream_group',$user_id,'$text_streamu', '$datum')";
	echo $sql;
	$result = mysqli_query($db, $sql) or die("MySQL ERROR: " . mysqli_error());

	$url = "project_links.php?project_id=$project_id";
	header('location:' . $url . '');

}

?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="sk" lang="sk">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

		<title>Miniwrike - links</title>
		<link href="css/style.css?v1.0" rel="stylesheet" type="text/css" />
		<link href="css/style1.css" rel="stylesheet" type="text/css" />
		<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" rel="stylesheet" type="text/css" />
		<link href='http://fonts.googleapis.com/css?family=PT+Sans:400,700' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=Roboto:400,300,300italic,700,700italic,400italic' rel='stylesheet' type='text/css'>
		<link rel='shortcut icon' href='project.ico'>



	</head>
<body>

		<?php

$user_id = $_SESSION['user_id'];
$project_id = $_SESSION['project_id'];

?>


		<div id="main"><!-- main wrapper -->


			<!-- header -->

			<?php include "include/header.php";?>
			<?php include "include/menu.php";?>

			<?php echo ProjectTitle($project_id); ?>

			<div id="middle"> <!-- middle section -->
				<?php
$action = $_GET['action'];

if ($action == 'new') {
	//add new link

	if (!isset($_GET['project_id'])) {
		$project_id = $_SESSION['project_id'];
	}

	?>
						<form action="project_link.php" method="post">
							<input type="hidden" name="project_id" value=<?php echo $project_id; ?>>
							<input type="hidden" name="user_id" value="1">
							<table id="the_link">
								<tr><td>Name:</td><td><input name="link_name"></td></tr>
								<tr><td>Url:</td><td><input name="link_url"></td></tr>
								<tr><td>description:</td><td><textarea name="link_desc"></textarea></td></tr>
								<tr><td><button name="add_new_link" type="submit" class="blue-badge">Add link</button></td></tr>
							</table>
						    </form>
				<?php
} elseif ($action == 'view') {
	$link_id = $_GET['link_id'];

	$sql = "SELECT * from project_links WHERE link_id=$link_id";
	$result = mysqli_query($db, $sql) or die("MySQL ERROR: " . mysqli_error());
	$row = mysqli_fetch_array($result);
	$link_name = $row['link_name'];
	$link_url = $row['link_url'];
	$link_description = $row['link_description'];

	echo "<table id='the_link'>";
	echo "<tr><td>Name:</td><td>$link_name</td></tr>";
	echo "<tr><td>Url:</td><td>$link_url</td></tr>";
	echo "<tr><td>description:</td><td><textarea name='link_desc'>$link_description</textarea></tr>";
	echo "<tr><td><a href='project_links.php?project_id=$project_id' class='link'><< Back</a><td></tr>";
	echo "</table>";

} elseif ($action == 'edit') {

	$link_id = $_GET['link_id'];

	$sql = "SELECT * from project_links WHERE link_id=$link_id";
	$result = mysqli_query($db, $sql) or die("MySQL ERROR: " . mysqli_error());
	$row = mysqli_fetch_array($result);
	$link_name = $row['link_name'];
	$link_url = $row['link_url'];
	$link_decription = $row['link_decription'];

	echo "<form action='project_link.php' method='post'>";
	echo "<input type='hidden' name='project_id' value=$project_id>";
	echo "<input type='hidden' name='link_id' value=$link_id>";
	echo "<input type='hidden' name='user_id' value=1>";
	echo "<table id='the_link'>";
	echo "<tr><td>Name:</td><td><input name='link_name' value='$link_name'></td></tr>";
	echo "<tr><td>Url:</td><td><input name='link_url' value='$link_url'></td></tr>";
	echo "<tr><td>description:</td><td><textarea name='link_desc'>$link_decription</textarea></tr>";
	echo "<tr><td colspan='2' style='text-align:right'><button name='modify_link' type='submit' class='blue-badge'>Save changes</button></td></td>";
	echo "<tr><td colspan='2'><a href='project_links.php?project_id=$project_id' class='link'><< Back</a><td></tr>";
	echo "</table>";
	echo "</form>";

} elseif ($action == 'delete') {
	$link_id = $_GET['link_id'];
	$user_id = 1;
	$project_id = $_GET['project_id'];

	$stream_group = "links";

	$sql = "DELETE from project_links WHERE link_id=$link_id";
	$result = mysqli_query($db, $sql) or die("MySQL ERROR: " . mysqli_error());

	//pridanie do streamu / logu / wallu
	$user_name = GetUserNameById($user_id);
	$project_name = GetProjectName($project_id);

	$text_streamu = "User <a href='project_user_profile.php?id=$user_id'>" . $user_name . "</a> has removed the link from the project: <a href='project_details.php?project_id=12'" . $project_name . "</a>";
	$text_streamu = mysql_real_escape_string($text_streamu);
	$datum = date('Y-m-d H:m:s');
	$sql = "INSERT INTO project_stream (project_id,stream_group,user_id,text_of_stream, date_added) VALUES ($project_id,'$stream_group',$user_id,'$text_streamu', '$datum')";
	//echo $sql;
	$result = mysqli_query($db, $sql) or die("MySQL ERROR: " . mysqli_error());

	$url = "project_links.php?project_id=$project_id";
	header('location:' . $url . '');
}

?>
			</div><!--middle -->
		</div><!-- main -->