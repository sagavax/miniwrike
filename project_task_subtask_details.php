<?php session_start();?>
<?php include "include/dbconnect.php";?>
<?php include "include/functions.php";?>



<?php
if (isset($_POST['add_task_comment'])) {
	//pridanie komentu

	$project_id = $_POST['project_cislo'];
	//$user_id=$_POST['user_id'];
	$task_id = $_POST['task_id'];
	$user_id = 1;
	$comment = mysqli_real_escape_string($db, $_POST['task_comment']);
	$date_added = date('Y-m-d H:m:s');

	$sql = "INSERT INTO project_task_subtask_comments (subtask_id,project_id, user_id, post_text, date_added) VALUES ($subtask_id,$project_id, $user_id, '$comment', '$date_addded')";
	//////echo "$sql";
	$result = mysqli_query($db, $sql) or die("MySQL ERROR: " . mysqli_error());

	//ziskanie max subtask id z tabulky
	$sql = "SELECT MAX(subtask_id) as subtask_comment_id from project_task_subtask_comments where project_id=$project_id and subtask_id=$subtask_id";
	$result = mysqli_query($db, $sql) or die("MySQL ERROR: " . mysqli_error());
	while ($row = mysqli_fetch_array($result)) {
		$subtask_comment_id = $row['subtask_comment_id'];
	}

	//pridenie do streamu
	$text_streamu = "User <a href='project_user_profile.php?id=$user_id'> " . $user_id . "</a> has created a new comment id " . $task_comment_id . "of task id = <a href='project_task.php?task_id=$task_id'>" . $task_id . "</a>";
	$text_streamu = mysql_real_escape_string($text_streamu);
	$datum = date('Y-m-d H:m:s');
	$sql = "INSERT INTO project_stream (project_id,user_id,text_of_stream, date_added) VALUES ($project_id,$user_id,'$text_streamu', '$datum')";
	$result = mysqli_query($db, $sql) or die("MySQL ERROR: " . mysqli_error());

	header('Location: project_task_subtask_details.php?subtask_id=' . $_POST['subtask_id'] . '&project_id=' . $_POST['project_id'] . '&user_id=' . $_POST['user_id'] . ''); // presmeruje spat aby sa zbranilo vkladaniu duplicity

}

if (isset($_POST['upload_file'])) {
	// uploadujem file

	$sql = "";
	$result = mysqli_query($db, $sql) or die("MySQL ERROR: " . mysqli_error());

	$text_streamu = "User " . $user_id . " has attached a new file " . $file_name . " to task id = " . $task_id;
	$sql = "INSERT INTO project_stream (project_id,user_id,text_of_stream, date_added) VALUES ($project_id,$user_id,'$text_streamu',date('Y-m-d H:i:s'))";
	//$result=mysqli_query($db, $sql) or die("MySQL ERROR: ".mysqli_error());

	//header('Location: project_task.php?task_id='.$_POST['task_id'].'&project_id='.$_POST['project_id'].''); // presmeruje spat aby sa zbranilo vkladaniu duplicity

}

if (isset($_POST['assign_the_task'])) {
	//priradim userovi task, od tej doby sa bude pocitat ucast agenta na projecte

	$project_id = $_POST['project_id'];
	$task_id = $_POST['task_id'];
	$subtask_id = $_POST['subtask_id'];
	$user_name = $_POST['users'];
	$owner_id = GetUserIdbyname($user_name); // z mena ziskam email
	$user_email = GetUserEmailbyname($user_name); //
	$assigned_by = $_POST['user_id'];
	$assigned_date = date('Y-m-d H:i:s');
	//print_r($_POST);

	$sql = "INSERT INTO project_task_subtask_assigned_people (subtask_id, project_id, email, assigned_by, assigned_date) VALUES ($subtask_id,$project_id,'$user_email',$assigned_by,'$assigned_date')";
	//echo "$sql";
	$result = mysqli_query($db, $sql) or die("MySQL ERROR: " . mysqli_error());

	//header('Location: project_task_subtask_details.php?subtask_id='.$_POST['subtask_id'].'&project_id='.$_POST['project_id'].'&user_id='.$_POST['user_id'].'&task_id='.$_POST['task_id'].''); // presmeruje spat aby sa zbranilo vkladaniu duplicity

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
		<!--<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
		<script type="text/javascript" src="js/facebox.js"></script> -->
		<link href='http://fonts.googleapis.com/css?family=PT+Sans:400,700' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=Roboto:400,300,300italic,700,700italic,400italic' rel='stylesheet' type='text/css'>
		<link rel='shortcut icon' href='project.ico'>

	</head>
<body>

        <?php
$project_id = $_GET['project_id'];
$subtask_id = $_GET['subtask_id'];
$user_id = $_GET['user_id'];
//$task_id=$_GET['task_id'];

echo "subtask_id=$subtask_id<br>";
echo "project_id=$project_id<br>";
$user_id = 1;

?>

		<div id="main">

			<!-- header -->

			<div id="header">miniwrike - subtask <?php echo $subtask_id; ?> of the task <?php echo $task_id; ?> details</div>
           <?php include "include/menu.php";?>

			<!-- header -->

			<!--- middle section -->


			<div id="project_title"><!-- project title -->
               <?php

$sql = "SELECT * from projects where id=$project_id";
////echo "$sql";
//echo "project_id=$project_id";
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


			<div id="middle"> <!-- middle section -->

			<?php

$sql = "SELECT *, ABS(DATEDIFF(subtask_created,  now() ) ) AS duration from project_task_subtasks WHERE subtask_id=$subtask_id";
//echo "$sql";
$result = mysqli_query($db, $sql) or die("MySQL ERROR: " . mysqli_error());
while ($row = mysqli_fetch_array($result)) {
	$task_description = $row['subtask_description'];
	$status = $row['subtask_status'];
	$task_priority = $row['subtask_priority'];
	$date_created = $row['subtask_created'];
	$date_finished = $row['subtask_finished'];
	$deadline = $row['subtask_deadline'];
	$priority = $row['subtask_priority'];
	$duration = $row['subtask_duration'];
	$parent_task = $row['task_id'];

	//$duration1=DATEDIFF($date_created,date('Y-m-d'));

	$dStart = strtotime($date_created);
	$dEnd = strtotime(date('Y-m-d'));
	$dDiff = $dEnd - $dStart;
	//$duration=date('j',$dDiff);
	//echo "duration=".date('j',$dDiff);
	//echo "duration=$duration";

	$diff = strtotime($date_finished) - strtotime($date_created);
	$diff = date('m/d/Y', 1299446702);
	if ($date_finished = '0000-00-00 00:00:00') {$date_finished = 'N/A';}

	//$years = floor($diff / (365*60*60*24));
	//$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
	//$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
}
?>


			  <div id="project_task_title">

					<?php echo "<span style='margin-left:10px'>$task_description</span>" ?>

			  </div>

              <div id="project_task_details_dashboard"><!-- project_task_details_dashboard -->

					<h3>Dashboard</h3>


						<div class="info_box">
							<span class="info_box_title">Parent task:</span>
							<span class="info_box_value"><?php echo "<a href='project_task.php?task_id=$parent_task&project_id=$project_id&user_id=$user_id'>$parent_task</a>"; ?></span>

						</div>
						<div class="info_box">
							<span class="info_box_title">Task status</span>
							<span class="info_box_value"><?php echo $status ?></span>
						</div>
						<div class="info_box">
							<span class="info_box_title">Priority</span>
							<span class="info_box_value"><?php echo $priority ?></span>
						</div>
						<div class="info_box">
							<span class="info_box_title">Date created:</span>
							<span class="info_box_value"><?php echo $date_created ?>
						</div>
						<div class="info_box">
							<span class="info_box_title">Date finished:</span>
							<span class="info_box_value"><?php echo $date_finished ?>
						</div>
						<div class="info_box">
							<span class="info_box_title">Planned deadline:</span>
							<span class="info_box_value"><?php echo $deadline ?>
					   	</div>
						<div class="info_box">
							<span class="info_box_title">Total duration:</span>
							<span class="info_box_value"><?php echo $duration ?>

						</div>
						<div class="info_box">
							<span class="info_box_title">Mark as completed:</span>
							<span class="info_box_value"><?php echo "<input type='checkbox' value=$is_completed name='mark_completed'?>"; ?></span>

						</div>



					<div style="clear:both"></div>
				</div><!-- project_task_details_dashboard -->


				<div id="project_task_details_comments"> <!-- vsetky taskove komentare  + moznost pridat novy komentar-->

					<h3>Task comments</h3>

					<div id="task_commnets_wrap"><!--task_comments_wrap -->
						<ul>
						<?php

// get all previous task comments

$sql = "SELECT * from project_task_subtask_comments WHERE subtask_id=$subtask_id";
//echo "$sql";

// in addition get information from use based on user_id

$result = mysqli_query($db, $sql) or die("MySQL ERROR: " . mysqli_error());
$numrows = mysql_num_rows($result);

if ($numrows == 0) {echo "<span style='font-style:italic; font-size:12px; font-family:'Roboto', Helvetica, Arial,sans-serif;color:#ddd;margin-left:10px; margin-top:10px'>No task comments available</span>";} else {

	while ($row = mysqli_fetch_array($result)) {
		$id = $row['id'];
		$user_id = $row['user_id'];
		$date_added = $row['date_added'];
		$post_text = $row['post_text'];

		$image = "img/non-avatar_32.jpg";

		echo "<li>"; //project_task_comments

		echo "<div class='project_task_post_wrap'>
													<div class='project_task_user_image'><img src='" . $image . "' alt='" . $user_id . "'></div>
													<div class='project_task_post'>$post_text</div>";
		echo "</div>";
		echo "</li>";
	}
}
?>
						</ul>

					</div><!--task_comments_wrap -->


					<form action="project_task_subtasks_details.php?project_id=<?php echo $project_id; ?>&subtask_id=<?php echo $subtask_id; ?>" method="post">
						<table>
							<input type="hidden" name="project_cislo" value="<?php echo $project_id; ?>">
							<input type="hidden" name="subtask_id" value="<?php echo $subtask_id ?>"/>
							<input type="hidden" name="user_id" value="<?php echo $user_id ?>" />

							<tr>
								<td><input autocomplete="off" name="task_comment" type="text" value=""><button type="submit" class="blue-badge" name="add_task_comment" alt="Add task comment">+</button></td>
							</tr>

						</table>
					</form>

				</div> <!-- vsetky taskove komentare  + moznost pridat novy komentar-->


				<!--                                             PROJECT ASSIGNED PERSON  -->

				<div id="project_task_assigned_person"> <!--project_assigned_person -->

					<h3>Task assigned to person:</h3>

					<form action="project_task_subtask_details.php?project_id=<?php echo $project_id; ?>&subtask_id=<?php echo $subtask_id; ?>" method="post">
						<table>
							<input type="hidden" name="project_id" value="<?php echo $project_id; ?>" />
							<input type="hidden" name="task_id" value="<?php echo $task_id; ?>" />
							<input type="hidden" name="subtask_id" value="<?php echo $subtask_id; ?>" />
							<input type="hidden" name="user_id" value="<?php echo $user_id; ?>" />
							<ul>

							<?php

// get all previous task comments

$sql = "SELECT * from project_task_subtask_assigned_people WHERE subtask_id=$subtask_id";
//echo "$sql";
// in addition get information from use based on user_id

$result = mysqli_query($db, $sql) or die("MySQL ERROR: " . mysqli_error());
$numrows = mysql_num_rows($result);

if ($numrows == 0) {echo "<span style='font-style:italic; font-size:12px; font-family: Helvetica, Arial,sans-serif;color:#ccc;margin-left:10px; margin-top:10px'>No ppl assigned to this task</span>";} else {
	//ak existuju nejake poznamky tak ich vypis
	echo "<ul>";
	while ($row = mysqli_fetch_array($result)) {
		$id = $row['id'];
		$owner_id = $row['owner_id'];
		//$user_name=GetUserNameById($owner_id);
		$email = $row['email'];
		$assigned_date = $row['assigned_date'];
		$image = "img/non-avatar_32.jpg";

		echo "<li>"; //project_task_comments
		echo "<div class='project_assigned_ppl_post'><div class='project_assigned_ppl_image'><img src='" . $image . "' alt='" . $user_id . "'></div>
                                                 							<div class='project_assigned_ppl_post_body'><span class='project_assigned_ppl_name'><a href='project_user_profile.php?user_id=$user_id'>$user_name</a></span><span class='assigned_date'>$assigned_date</span><span class='project_assigned_ppl_duration'>$duration days</span><span class='project_assigned_ppl_button'><button type='submit' class='blue-badge' name='remove_from_project' alt='Remove user from the project'><i class='fa fa-times'></i></button></span></div></div>";
		echo "</li>";

	}
}

?>
							</ul>
							<tr>
								<td>
									<form action="project_task.php" method="post">
				                    	<input type="hidden" name="project_id" value="<?php echo $project_id; ?>" />
					                     <input type="hidden" name="task_id" value="<?php echo $task_id; ?>" />
					                     <input type="hidden" name="user_id" value="<?php echo $user_id; ?>" />
					                     <input list="users" name="users" value="">
					                     <datalist id="users">
					                        <?php
$sql = "SELECT * from project_task_assigned_people WHERE project_id=$project_id"; //budem vyberat iba z ludi, ktory su do tohto projektu priradeni
$result = mysqli_query($db, $sql) or die("MySQL ERROR: " . mysqli_error());
while ($row = mysqli_fetch_array($result)) {
	$full_name = $row['full_name'];

	echo "<option value='$full_name'>";
}
?>
				                   	 </datalist>
				                   	 <button type="submit" name="assign_the_task" alt="Assign the user this task" class="blue-badge"><i class="fa fa-plus"></i> <i class="fa fa-user"></i></button>
				                  </form>
				                </td>
							</tr>
							<tr>
								<td><a href="project_task.php?task_id=<?php echo $_GET['task_id'] ?>" class="link"><< Back< to main task</a></td>
							</tr>
						</table>
					</form>

				</div> <!--project_task_quick_notes -->

            </div><!-- div middle -->
            <div style="clear:both;"></div>


			<?php include "include/footer.php";?>

		</div><!-- main -->
</body>
</html>