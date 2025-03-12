
<?php include "include/dbconnect.php";?>
<?php include "include/functions.php";?>

<?php

if (isset($_POST['create_new_user'])) {
	//vytvori noveho uzivatela
	$project_id = $_POST['project_id'];

	$project_eng_fullname = mysqli_real_escape_string($db, $_POST['project_eng_fullname']);
	$project_eng_email = mysqli_real_escape_string($db, $_POST['project_eng_email']);

	check_email($project_eng_email);

	$project_eng_phone = $_POST['project_eng_phone'];
	$project_eng_login = mysqli_real_escape_string($db, $_POST['project_eng_email']);
	$pass_temp = $_POST['project_eng_pass'];
	$project_eng_pass = md5('$pass_temp');
	$project_eng_note = mysqli_real_escape_string($db, $_POST['user_description']);
	$created_date = date("Y-m-d H:m:s");
	$supporting_technology = intval($_POST['project_technology']);

	$sql = "INSERT INTO project_users (full_name, login, password, email, phone, created_date) VALUES ('$project_eng_fullname','$project_eng_login','$project_eng_pass','$project_eng_email','$project_eng_phone','$created_date')";
	$result = mysqli_query($db, $sql) or die("MySQL ERROR: " . mysqli_error());

	//posli email dotycnemu

	$sql = "SELECT MAX(user_id) as new_user_id from project_users";
	$result = mysqli_query($db, $sql) or die("MySQL ERROR: " . mysqli_error());
	while ($row = mysqli_fetch_array($result)) {
		$receiver_id = $row['new_user_id'];
	}

	send_message($sender_id, $receiver_id, $message, $sent_date);

	//header('Location: project_details.php?project_id=$project_id');
	header('Location: project_details.php?project_id=' . $_POST['project_id'] . '');
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
		<link href='http://fonts.googleapis.com/css?family=PT+Sans:400,700' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=Roboto:400,300,300italic,700,700italic,400italic' rel='stylesheet' type='text/css'>
		<script src="ckeditor/ckeditor.js"></script>
		<link rel='shortcut icon' href='project.ico'>



	</head>
<body>

	<?php

//$project_id= $_GET['project_id']; // projetove id
$project_id = $_GET['project_id'];
//$user_id=$_SESSION['user_id'];
$user_id = 1;

?>



	<div id="main">

			<!-- header -->
				<?php include "include/header.php";?>
            <!-- header -->

           <?php include "include/menu.php";?>
            <div id="middle"> <!-- middle section -->
            	<div id="project_title"><!-- project title -->
		            <?php

$sql = "SELECT * from projects where id=$project_id";
$result = mysqli_query($db, $sql) or die("MySQL ERROR: " . mysqli_error());
while ($row = mysqli_fetch_array($result)) {
	$project_name = $row['project_name'];
	$project_description = $row['project_descr'];

	//echo "<div id='project_short_details_wrap'>";
	echo "<span style='float:left;font-weight:bold; font-size:26px; font-family:Roboto, Helvetica, Arial,sans-serif;margin-left:10px'>$project_name<br></span>"; //boldovo
	echo "<span style='float:left;font-style:italic; font-size:12px; font-family:Roboto,Helvetica, Arial,sans-serif;color:#999;margin-left:15px'>$project_description</span>"; //italikom
	//echo "</div>";

}

?>
			   </div><!-- project title -->


            	<div id="create_user_wrap">
            		<form action="project_create_user.php" method="post" name="create_project_user_form">
            		<table class='project_user'>
            			<input type="hidden" name="project_id" value="<?php echo $project_id ?>">
            			<tr>
            				<td>Full name:</td><td><input name="project_eng_fullname" type="text" value=""></td>
            			</tr>
            			<tr>
            				<td>Email:</td><td><input name="project_eng_email" type="text" value=""></td>
            			</tr>
            			<tr>
            				<td>Phone:</td><td><input name="project_eng_phone" type="text" value=""></td>
            			</tr>
            			<tr>
            				<td>Login:</td><td><input name="project_eng_login" type="text" value=""></td>
            			</tr>
            			<tr>
            				<td>Password:</td><td><input name="project_eng_pass" type="password" value=""></td>
            			</tr>
            			<tr>
            				<td>Technology</td><td><select name="project_technology">
            							<?php
$sql = "SELECT * from project_technologies";
$result = mysqli_query($db, $sql) or die("MySQL ERROR: " . mysqli_error());
while ($row = mysqli_fetch_array($result)) {
	echo "<option value=" . $row['techn_id'] . ">" . $row['technology_descr'] . "</option>";
}
?>
            				</select></td>
            			</tr>
            			<tr>
            				<td>Note:</td><td>
            					<textarea name="user_description" id="user_description"></textarea>
            					<script type="text/javascript">
								   		CKEDITOR.replace( 'user_description',
									    {
									        customConfig : 'config1.js'
									    });
								   </script>
            					</td>
            			</tr>
            			<tr>
            				<td colspan="2" style="text-align:right"><button class="blue-badge" name="create_new_user" >Create user</button></td>
            			</tr>
            		</table>
            	</form>
            	</div>

            </div><!-- div middle -->
            <div style="clear:both;"></div>


			<?php include "include/footer.php";?>

		</div><!-- main -->

</body>
<html>