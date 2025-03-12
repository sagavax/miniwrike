<?php session_start();?>
<?php include "include/dbconnect.php";?>
<?php include "include/functions.php";?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="sk" lang="sk">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

		<title>Miniwrike - simple project task manager</title>
		<link href="css/style_test.css" rel="stylesheet" type="text/css" />
		<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
		<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
		<link href='http://fonts.googleapis.com/css?family=PT+Sans:400,700' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=Roboto:400,300,300italic,700,700italic,400italic' rel='stylesheet'>
		<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
		<link rel='shortcut icon' href='project.ico'>

	</head>
<body>
	<?php
$project_id = $_GET['project_id']

?>

	<div id="main">

			<!-- header -->
				<?php include "include/header.php";?>
            <!-- header -->

            <div id="menu"><!--menu -->
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="project_details.php?project_id=<?php echo $project_id ?>">Project details</a></li>
                    <li><a href="project_tasks.php?project_id=<?php echo $project_id ?>">Tasks</a></li>
                    <li><a href="project_comments.php?project_id=<?php echo $project_id ?>">Comments</a></li>
					<li><a href="project_meetings.php?project_id=<?php echo $project_id ?>">Meetings*</a></li>
					<li><a href="project_calendar.php?project_id=<?php echo $project_id ?>">Calendar*</a></li>
                    <li><a href="project_stream.php?project_id=<?php echo $project_id ?>">Time stream*</a></li>
					<li><a href="project_docs.php?project_id=<?php echo $project_id ?>">Docs*</a></li>


                </ul>
            </div> <!--menu -->

            <div id="middle"> <!-- middle section -->
            	<div id="project_title"><!-- project title -->
		               <?php

$sql = "SELECT * from projects where id=$project_id";
$result = mysqli_query($db, $sql) or die("MySQL ERROR: " . mysqli_error());
while ($row = mysqli_fetch_array($result)) {
	$project_name = $row['project_name'];
	$project_description = $row['project_descr'];

	echo "<span style='float:left;font-weight:bold; font-size:26px; font-family: Roboto, Helvetica, Arial,sans-serif;margin-left:10px'>$project_name<br></span>"; //boldovo
	echo "<span style='float:left;font-style:italic; font-size:12px; font-family: Roboto, Helvetica, Arial,sans-serif;color:#999;margin-left:15px'>$project_description</span>"; //italikom
}

?>
            	</div><!-- project title -->

            	<div id="project_task_board"><!--project_task_board -->
            			<div id="task_board_columns_wrap"><!--task board columns wrap -->
            			<div class="task_board_column">
            				<div class="task_board_header">To do:</div>
            				<div class="task_board_tasklist">
            					<ul id="new_tasks" class="connectedSortable">
					            	<?php

$sql = "SELECT * FROM project_tasks WHERE project_id=$project_id and status='New' ORDER BY task_id DESC";

$result = mysqli_query($db, $sql) or die("MySQL ERROR: " . mysqli_error());
while ($row = mysqli_fetch_array($result)) {
	$id = $row['task_id'];
	$project_id = $row['project_id'];
	$user_id = $row['user_id'];
	$note_text = $row['task_name'];
	$status = $row['status'];
	$date_added = $row['colDateCreated'];
	$flag = $row['colFlag'];
	//$project_name=$row['project_name'];
	$project_code = $row['project_code'];
	$date_of_completion = $row['colFinished'];

	echo "<li><div class='task_board_task' id='$id'><a href='project_task.php?task_id=$id&project_id=$project_id'>$note_text</a></div></li>";
}
?>
            					</ul>
            				</div><!-- task_board_tasklist -->
            			</div><!-- task_board_column -->


            			<div class="task_board_column">
            				<div class="task_board_header">In progress:</div>
            				<div class="task_board_tasklist">
            					<ul id="in_progress_tasks" class="connectedSortable">
					            	<?php

$sql = "SELECT * FROM project_tasks WHERE project_id=$project_id and status='In progress' or status='Pending' ORDER BY task_id DESC";

$result = mysqli_query($db, $sql) or die("MySQL ERROR: " . mysqli_error());
while ($row = mysqli_fetch_array($result)) {
	$id = $row['task_id'];
	$project_id = $row['project_id'];
	$user_id = $row['user_id'];
	$note_text = $row['task_name'];
	$status = $row['status'];
	$date_added = $row['colDateCreated'];
	$flag = $row['colFlag'];
	//$project_name=$row['project_name'];
	$project_code = $row['project_code'];
	$date_of_completion = $row['colFinished'];

	echo "<li><div class='task_board_task' id='$id'><a href='project_task.php?task_id=$id&project_id=$project_id'>$note_text</a></div></li>";
}
?>
            					</ul>
            				</div>

            			</div>

            			<div class="task_board_column">
            				<div class="task_board_header">Completed:</div>
            				<div class="task_board_tasklist">
            					<ul id="completed_tasks" class="connectedSortable">
					            	<?php

$sql = "SELECT * FROM project_tasks WHERE project_id=$project_id and status='Completed' or status='Pending' ORDER BY task_id DESC";

$result = mysqli_query($db, $sql) or die("MySQL ERROR: " . mysqli_error());
while ($row = mysqli_fetch_array($result)) {
	$id = $row['task_id'];
	$project_id = $row['project_id'];
	$user_id = $row['user_id'];
	$note_text = $row['task_name'];
	$status = $row['status'];
	$date_added = $row['colDateCreated'];
	$flag = $row['colFlag'];
	//$project_name=$row['project_name'];
	$project_code = $row['project_code'];
	$date_of_completion = $row['colFinished'];

	echo "<li><div class='task_board_task' id='$id'><a href='project_task.php?task_id=$id&project_id=$project_id'>$note_text</a></div></li>";
}
?>
            					</ul>
            				</div>
            			</div>

            		</div><!--task board columns wrap -->
            		<div style="clear:both;"></div>
            	</div><!--project_task_board -->
            	<div style="clear:both;"></div>
            </div><!-- div middle -->
            <div style="clear:both;"></div>


			<?php include "include/footer.php";?>

		</div><!-- main -->

</body>
<html>