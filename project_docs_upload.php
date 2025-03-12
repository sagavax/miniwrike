<? ob_start(); ?>
<?php
$dbname = "miniwrike";
$dbserver = "localhost";
$dbuser = "root";
$dbpass = "";

$db = mysql_connect("$dbserver", "$dbuser", "$dbpass");
$errno = mysql_errno();
mysql_select_db("$dbname", $db);
mysql_query('set character set utf8;');
mysql_query("SET NAMES `utf8`");

?>

 <?php
if (isset($_POST['upload_file'])) {
	$project_id = $_POST['project_id'];
	$user_id = $_POST['user_id'];

	$sql = "INSET INTO project_docs () VALUES ()";

	/* pridanie do streamu */
	$text_streamu = "User <a href='project_user_profile.php?id=$user_id'>" . $user_name . "</a> has uploaded the file for the project <a href='project_details.php?project_id=$project_id'>" . $project_name . "</a>";
	$text_streamu = addslashes($text_streamu);
	$datum = date('Y-m-d H:m:s');
	$sql = "INSERT INTO project_stream (project_id,user_id,text_of_stream, date_added) VALUES ($project_id,$user_id,'$text_streamu','$datum')";
	$result = mysqli_query($db, $sql) or die("MySQL ERROR: " . mysqli_error());

	$url = "project_docs.php?project_id=$project_id";
	header('location:' . $url . '');

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

		<!--<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>-->
		<script type="text/javascript" src="js/facebox.js"></script>
		<link href='http://fonts.googleapis.com/css?family=PT+Sans:400,700' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=Roboto:400,300,300italic,700,700italic,400italic' rel='stylesheet'
		<link rel='shortcut icon' href='project.ico'>

	</head>
<body>

        <?php
$project_id = $_GET['project'];
$user_id = $_GET['user_id'];

?>

		<div id="main">

			<!-- header -->

			<?php include "include/header.php";?>
            <?php include "include/menu.php";?>
		    <div id="project_title"><!-- project title -->
               <?php
$project_id = $_GET['project_id'];
$sql = "SELECT * from projects where id=$project_id";
$result = mysqli_query($db, $sql) or die("MySQL ERROR: " . mysqli_error());
while ($row = mysqli_fetch_array($result)) {
	$project_name = $row['project_name'];
	$project_description = $row['project_descr'];

	echo "<div id='project_short_details_wrap'>";
	echo "<span style='float:left;font-weight:bold; font-size:26px; font-family: Helvetica, Arial,sans-serif;margin-left:10px'>$project_name<br></span>"; //boldovo
	echo "<span style='float:left;font-style:italic; font-size:12px; font-family: Helvetica, Arial,sans-serif;color:#ddd;margin-left:15px'>$project_description</span>"; //italikom
	echo "</div>";

}

?>
            </div><!-- project title -->

			<!-- header -->

			<!--- middle section -->
			<?php
$project_id = $_GET['project_id'];
$user_id = $_GET['user_id'];

?>
			<div id="middle"> <!-- middle section -->
				<div>
					<form enctype="multipart/form-data" action="project_docs_upload.php" method="POST">
						<input type="hidden" name="MAX_FILE_SIZE" value="30000" />
						<input type="hidden" name="project_id" value="<?php echo $project_id ?>" />
						<input type="hidden" name="user_id" value="<?php echo $user_id ?>" />
						<input type="hidden" name="MAX_FILE_SIZE" value="30000" />
					    <!-- Name of input element determines name in $_FILES array -->
					    Send this file: <input name="userfile" type="file" name="file" />
					    <input type="submit" value="Send File" name="upload_file"/>
				    </form>
				</div>


			</div><!-- middle section -->

			<?php include "include/footer.php";?>


		</div> <!--main wrap -->



</body>
</html>