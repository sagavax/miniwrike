<?php session_start(); ?>
<?php include "include/dbconnect.php" ?>
<?php include "include/functions.php" ?>



<?php
            if (isset($_POST['add_new_task'])) { // novy task



					$project_id=$_POST['project_id'];

					$user_id=$_POST['user_id'];
					$user_id=1;
					$note_text=$_POST['task_text'];
                    $curr_date=date('Y-m-d H:i:s');
                    $date=strtotime(date('Y-m-d H:i:s', strtotime($curr_date)) . " +5 day");
                    $end_date= date('Y-m-d H:i:s', $date);

                    $sql = "INSERT INTO project_tasks (project_id, user_id, task_name, status,task_priority, is_complete,task_created, task_finished, task_deadline) VALUES ($project_id,$user_id,'$note_text','New','Normal','0','$curr_date','','$end_date')";

					$result=mysqli_query($db, $sql) or die("MySQL ERROR: ".mysqli_error($db));

					$sql = "INSERT INTO project_tasks_new (project_id, user_id, task_name, status,task_priority, is_complete,task_created, task_finished, task_deadline) VALUES ($project_id,$user_id,'$note_text','New','Normal','0','$curr_date','','$end_date')";
				    $result=mysqli_query($db, $sql) or die("MySQL ERROR: ".mysqli_error($db));


					mysql_query("INSERT INTO project_statement_log (action,date_added,statement) VALUES ('added_task',now(),'".$sql."')");
					//zapisanie do project streamu/historie

					add_to_stream('new_task',$project_id,$user_id);

					//zapisanie do project streamu/historie

					header('Location: project_tasks.php?project_id='.$_POST['project_id'].''); // presmeruje spat aby sa zabranilo vkladaniu duplicity

			} // novy task

		 if(isset($_POST['view_task'])){
		 	$task_id=intval($_POST['task_id']);
		 	$url="project_task.php?task_id=$task_id";
    		header('location:' . $url . ''); // presmeruje spat aby sa zbranilo vkladaniu duplicity
		 }

  		 if (isset($_POST['mark_complete'])){
  		 	$task_id=intval($_POST['task_id']);
  		 	$sql="UPDATE project_tasks SET status='finished' WHERE task_id=$task_id";
			$result = mysqli_query($db, $sql) or die("MySQL ERROR: " . mysqli_error($db));

	      //pridat do streamu

			$project_id=$_SESSION['project_id'];
			$user_id=$_SESSION['user_id'];
			$text_streamu = "The task id <a href='project_task.php?task_id=$task_id'> " . $task_id . "</a> has been set as complete";
		    $text_streamu = mysql_real_escape_string($text_streamu);
		    $datum        = date('Y-m-d H:m:s');
		    $stream_group = 'task';
		    $user_id=1;
		    $sql          = "INSERT INTO project_stream (stream_group,project_id,user_id,text_of_stream, date_added) VALUES ('$stream_group',$project_id,$user_id,'$text_streamu','$datum')";

	    	$result = mysqli_query($db, $sql) or die("MySQL ERROR: " . mysqli_error($db));
	    	$url="project_tasks.php?project_id=$project_id";
    		header('location:' . $url . ''); // presmeruje spat aby sa zbranilo vkladaniu duplicity
	  	 }

	  	if(isset($_POST['cancel_task'])){
	  		$task_id=intval($_POST['task_id']);
	  		$status=mysqli_real_escape_string($db, $_POST['status']);
	  		if($status=='finished'){
	  			echo "<script>
	  			alert('This task is already finished, cannot be cancelled !';)
	  			</script>";
	  			//if status is finished, cannot be cancelled
	  		  $url="project_tasks.php?project_id=$project_id";
		      header('location:' . $url . ''); // presmeruje spat aby sa zbranilo vkladaniu duplicity
	  		}
	  		$sql="UPDATE project_tasks SET status='cancelled' WHERE task_id=$task_id";
	  		mysql_query("INSERT INTO project_statement_log (action,date_added,statement) VALUES ('cancell_task',now(),'$sql')");

			$result = mysqli_query($db, $sql) or die("MySQL ERROR: " . mysqli_error($db));

			$project_id=$_SESSION['project_id'];
            $user_id=$_SESSION['user_id'];
			$user_id=1;
			$text_streamu = "The task id <a href='project_task.php?task_id=$task_id'> " . $task_id . "</a> has been cancelled";
		    $text_streamu = mysql_real_escape_string($text_streamu);
		    $datum        = date('Y-m-d H:m:s');
		    $stream_group = 'task';
		    $sql          = "INSERT INTO project_stream (stream_group,project_id,user_id,text_of_stream, date_added) VALUES ('$stream_group',$project_id,$user_id,'$text_streamu','$datum')";

		    $result = mysqli_query($db, $sql) or die("MySQL ERROR: " . mysqli_error($db));
		    $url="project_tasks.php?project_id=$project_id";
		    header('location:' . $url . ''); // presmeruje spat aby sa zbranilo vkladaniu duplicity
	  	}
 ?>



<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="sk" lang="sk">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

		<title>Miniwrike - simple project task manager - tasks</title>
		<link href="css/style.css?v1.0" rel="stylesheet" type="text/css" />
		<link href="css/font-awesome.css" rel="stylesheet" type="text/css" />
		<!-- <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>-->
		<link href='http://fonts.googleapis.com/css?family=PT+Sans:400,700' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=Roboto:400,300,300italic,700,700italic,400italic' rel='stylesheet' type='text/css'>
		<link rel='shortcut icon' href='project.ico'>



	</head>
    <body>

				<?php

					//$project_id=$_GET['project_id'];
					$project_id=$_SESSION['project_id'];
					//echo "$project_id";
				?>

		<div id="main">

				<!-- header -->

				<?php include ("include/header.php");
				 	  include ("include/menu.php"); ?>

				<div id="project_title"><!-- project title -->
					<?php
						$project_id=$_SESSION['project_id'];

						$sql="SELECT * from projects where id=$project_id";

						$result=mysqli_query($db, $sql) or die("MySQL ERROR: ".mysqli_error($db));
							while ($row = mysqli_fetch_array($result)) {
								$project_name=$row['project_name'];
								$project_description=$row['project_descr'];

								//echo "<div id='project_short_details_wrap'>";
								echo "<span style='float:left;font-weight:bold; font-size:26px; font-family: Roboto, Helvetica, Arial,sans-serif;margin-left:10px'>$project_name<br></span>";   //boldovo
								echo "<span style='float:left;font-style:italic; font-size:12px; font-family: Roboto, Helvetica, Arial,sans-serif;color:#999;margin-left:15px'>$project_description</span>"; //italikom
								//echo "</div>";

							}

						?>
				</div><!-- project title -->

				<div id="add_task"> <!--- add task -->
						<span style="position:relative; float:left;margin-left:5px">
						  <form accept-charset="utf-8" method="post" id="dev_notes" name="new_dev_note" action="project_tasks.php?project_id=<?php echo $project_id; ?>">
							  <table>

								  <input type="hidden" name="project_id" value="<?php echo $project_id; ?>">

								<tr>
									<td>
										<input type="text" name="task_text" autocomplete="off" placeholder="type name of a new task or string to search">
									</td>
									<td>
										<button type="submit" name="add_new_task" class="blue-badge"><i class="fa fa-plus"></i></button>
									</td>
									<td>
										<button type="submit" name="search_task" class="blue-badge"><i class="fa fa-search"></i></button>
									</td>
								</tr>
							</table>
					   </form>
					 </span>
				</div> <!--- add task -->

			   <div id="middle"> <!-- middle section -->

			   		<div class="filter_wrap">
			   			<span style='margin-left:5px'>Filter according:</span>
			   				<div>
			   					<span>status: </span>
			   						<form action="project_tasks.php" method="post">
			   							<select name="task_status_filter">
			   								<option value="new">new</option>
											<option value="in progress">in progress</option>
											<option value="pending">pending</option>
											<option value="finished">finished</option>
											<option value="cancelled">cancelled</option>
			   							</select>
			   							<button name="filter_status" class="blue-badge">OK</button>
			   						</form>
			   				</div>
			   				<div>
			   					<span>priority: </span>
			   						<form action="project_tasks.php" method="post">
			   							<select name="task_priority_filter">
			   								<option value="low">low</option>
				               				<option value="normal" selected="selected">normal</option>
											<option value="high">high</option>
			   							</select>
			   							<button name="filter_priority" class="blue-badge">OK</button>
			   						</form>
			   				</div>
			   		</div><!-- filter wrap -->

					<?php


						echo "<table id='project_tasks'>";
						if(isset($_POST['filter_status'])){

							$status=mysqli_real_escape_string($db, $_POST['task_status_filter']);
							//var_dump($_POST);
							$sql="SELECT * from project_tasks WHERE project_id=$project_id and task_status='$status'";

							//echo $sql;
						} elseif (isset($_POST['filter_priority'])) {
							$priority=mysqli_real_escape_string($db, $_POST['task_priority_filter']);
							$sql="SELECT * from project_tasks WHERE project_id=$project_id and task_priority='$priority'";


						} elseif(isset($_POST['search_task'])){
							$search_string=mysqli_real_escape_string($db, $_POST['task_text']);
							$sql="SELECT * from project_tasks WHERE task_name LIKE '%$search_string%'";
						} else {
							$sql="SELECT * FROM project_tasks WHERE project_id =$project_id  and task_status not in ('cancelled','finished') ORDER BY task_id DESC";
						}


						$result=mysqli_query($db, $sql) or die("MySQL ERROR: ".mysqli_error($db));

						// mysql_query("INSERT INTO project_statement_log (action,date_added,statement) VALUES ('filter_tasks',now(),'$sql')");


						while ($row = mysqli_fetch_array($result)) {
								$id=$row['task_id'];
								$project_id=$row['project_id'];
								$user_id=$row['user_id'];
								$note_text=$row['task_name'];
								$status=$row['task_status'];
								$date_added=$row['task_created'];
								//$flag=$row['colFlag'];
								$owner_of_task= GetUserNameById($user_id);
								$priority=$row['task_priority'];
								//$project_name=$row['project_name'];
								//$project_code=$row['project_code'];
								//$date_of_completion=$row['date_finished'];



							//echo "<tr class='$color' id='".$id."'>";
								echo "<tr id='".$id."'>";
									echo "<td style='width: 600px'><a href='project_task.php?task_id=$id&project_id=$project_id&user_id=1'>$note_text</a></td><td><div class='status_badge'>$priority</div></td><td><div class='status_badge'>$status</div></td><td>$date_added</td><td><form action='project_tasks.php' method='post'><input type='hidden' name='task_id' value='$id'><button type='submit' class='blue-badge' title='View' name='view_task'><i class='fa fa-eye'></i></button></form></td><td><form action='project_tasks.php' method='post'><input type='hidden' name='task_id' value='$id'><button type='submit' class='blue-badge' title='Mark as complete' name='mark_complete'><i class='fa fa-check'></i></button></form></td><td><form action='project_tasks.php' method='post'><input type='hidden' name='task_id' value='$id'><input type='hidden' name=status value='$status'><button type='submit' class='blue-badge' name='cancel_task'><i class='fa fa-times' title='Cancel this task'></i></button></form></td>";

								}
							echo "</tr>";
						echo "</table>";

				 ?>


				<!--<div style="clear:both"></div>-->

			 </div><!-- middle section -->
			 <div style="clear:both;"></div>


			<?php include ("include/footer.php"); ?>

		</div><!-- main wrapper -->
