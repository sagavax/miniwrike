<?php session_start();
 include "include/dbconnect.php";
 include "include/functions.php";



if (isset($_POST['history_back'])) {
	header("location:projects.php");
}	


if (isset($_POST['new_project'])) {

	$project_name = mysqli_real_escape_string($db, $_POST['project_name']);
	$project_code = mysqli_real_escape_string($db, $_POST['project_code']);
	$project_descr = mysqli_real_escape_string($_POST['project_description']);
	$project_customer = $_POST['project_customer'];

	$sql = "INSERT INTO projects (project_name,project_code, project_customer,project_descr, established_date, project_status) VALUES ('$project_name','$project_code','$project_customer','$project_descr',now(),'new')";
	$result = mysqli_query($db, $sql) or die("MySQL ERROR: " . mysqli_error());

	//Add2Log("new_project",$text_streamu,$datum);

	// ****************           pridenie do streamu	************************

	$sql = "SELECT MAX(id) as project_id from projects"; //ziskanie max comment id z tabulky

	$result = mysqli_query($db, $sql) or die("MySQL ERROR: " . mysqli_error());
	while ($row = mysqli_fetch_array($result)) {
		$project_id = $row['project_id'];
	}

	$user_id = 1;
	$user_name = GetUserNameById($user_id);
	$project_name = GetProjectName($project_id);
	$text_streamu = "User <a href='project_user_profile.php?id=$user_id'> " . $user_name . "</a> has created a new project id <a href='project_details.php?project_id=$project_id'>" . $project_name . "</a>";
	$text_streamu = addslashes($text_streamu);
	$sql = "INSERT INTO project_stream (project_id,user_id,text_of_stream, date_added) VALUES ($project_id,$user_id,'$text_streamu',now())";
	$result = mysqli_query($db, $sql) or die("MySQL ERROR: " . mysqli_error());

	echo "<script>
		alert('New project $project_name has been created')
	</script>";

	$url = "project_details.php?project_id=$project_id";
	header("Location: $url");

}

if (isset($_POST['new_customer'])) {
//idem zadat noveho zakaznika

	header('Location: project_customer_add.php');

}
?>

<html>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="sk" lang="sk">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<meta name="description" content="" />
<meta name="keywords" content="" />
<meta name="author" content="" />
	<title>Miniwike</title>
    <link href="css/style.css?v<?php echo time(); ?>" rel="stylesheet" type="text/css" />
    <link rel='shortcut icon' href='project.ico'>
    <script type="text/javascript" src="js/clock.js" defer></script>
    <script type="text/javascript" src="js/customer_add.js" defer></script>
    <script type="text/javascript" src="js/project_add.js" defer></script>
    <link href='http://fonts.googleapis.com/css?family=PT+Sans:400,700' rel='stylesheet' type='text/css'>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" rel="stylesheet" type="text/css" />
    </head>
<body>
		<div id="main">
			 <?php include "include/header.php";?>
		
    	<div id="middle"> <!-- list of projects -->
      	 <div class="create_new_project_wrap">
      	 <div class="create_new_project">
		    <form accept-charset="utf-8" method="post" action="project_add.php">
				<input type="text" name="project_name" id="project_name" placeholder="project name" autocomplete="off" /> <!-- meno projektu -->

				<input type="text" name="project_code" id="project_code" placeholder="project code" autocomplete="off" /> <!-- kod projectu -->

				<div class="customer_wrap">								
					<?php echo GetCustomerList() ?><button type="button" name="new_customer" title='Ad new customer'><i class="fa fa-plus"></i></button></div>
				<textarea name="project_description" onkeyup="textAreaAdjust(this)" id="project_description" placeholder="Describe this project..."></textarea><!-- popis projectu -->
				<div class="project_action">

					<button type="submit" name="history_back">Back</button>
					<button type="submit" name="new_project"><i class="fa fa-plus"></i> New project</button>

				</div><!-- create new project -->
			  </form>
			 </div><!-- new project--> 
			</div> <!-- project mgmt wrap -->

            </div> <!-- middle -->

            <div style="clear:both;"></div>
			<?php include "include/footer.php";?>
		</div>
		<script type="text/javascript">
			function textAreaAdjust(element) {
				  element.style.height = "1px";
				  element.style.height = (25+element.scrollHeight)+"px";
				}
		</script>
</body>
</html>