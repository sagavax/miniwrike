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

					$result=mysqli_query($db, $sql) or die("MySQL ERROR: ".mysqli_error());
					
					$sql = "INSERT INTO project_tasks_new (project_id, user_id, task_name, status,task_priority, is_complete,task_created, task_finished, task_deadline) VALUES ($project_id,$user_id,'$note_text','New','Normal','0','$curr_date','','$end_date')";
				    $result=mysqli_query($db, $sql) or die("MySQL ERROR: ".mysqli_error());


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
			$result = mysqli_query($db, $sql) or die("MySQL ERROR: " . mysqli_error());

	      //pridat do streamu

			$project_id=$_SESSION['project_id'];
			$user_id=$_SESSION['user_id'];
			$text_streamu = "The task id <a href='project_task.php?task_id=$task_id'> " . $task_id . "</a> has been set as complete";
		    $text_streamu = mysql_real_escape_string($text_streamu);
		    $datum        = date('Y-m-d H:m:s');
		    $stream_group = 'task';
		    $user_id=1;
		    $sql          = "INSERT INTO project_stream (stream_group,project_id,user_id,text_of_stream, date_added) VALUES ('$stream_group',$project_id,$user_id,'$text_streamu','$datum')";
	    	
	    	$result = mysqli_query($db, $sql) or die("MySQL ERROR: " . mysqli_error());	
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
			
			$result = mysqli_query($db, $sql) or die("MySQL ERROR: " . mysqli_error());

			$project_id=$_SESSION['project_id'];
            $user_id=$_SESSION['user_id'];
			$user_id=1;
			$text_streamu = "The task id <a href='project_task.php?task_id=$task_id'> " . $task_id . "</a> has been cancelled";
		    $text_streamu = mysql_real_escape_string($text_streamu);
		    $datum        = date('Y-m-d H:m:s');
		    $stream_group = 'task';
		    $sql          = "INSERT INTO project_stream (stream_group,project_id,user_id,text_of_stream, date_added) VALUES ('$stream_group',$project_id,$user_id,'$text_streamu','$datum')";
		    
		    $result = mysqli_query($db, $sql) or die("MySQL ERROR: " . mysqli_error());
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
		<link href='https://fonts.googleapis.com/css?family=PT+Sans:400,700' rel='stylesheet' type='text/css'>
		<link href='https://fonts.googleapis.com/css?family=Roboto:400,300,300italic,700,700italic,400italic' rel='stylesheet' type='text/css'>
		<link rel='shortcut icon' href='project.ico'>
		

		   
	</head>
    <body>


		<div id="main">
			
				<?php 

				$project_id=$_GET['project_id'];

				?>

				<!-- header -->
				
				<?php include ("include/header.php");
				 include ("include/menu.php"); ?>
				
				<div id="project_title"><!-- project title -->
					<?php
					$project_id=$_GET['project_id'];
					$sql="SELECT * from projects where id=$project_id";
					$result=mysqli_query($db, $sql) or die("MySQL ERROR: ".mysqli_error());
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
								  <input type="hidden"  name="user_id" value="<?php echo $user_id; ?> ">
								<tr>
									<td>
										<input type="text" name="task_text" autocomplete="off"> 
									</td>
									<td>
										<button type="submit" name="add_new_task" class="blue-badge-large"><i class="fa fa-plus"></i></button>
									</td>	
								</tr>
							</table>
					   </form> 
					 </span>
				</div> <!--- add task -->

			   <div id="middle"> <!-- middle section -->
				
				
					<?php 
						echo "<table id='project_tasks'>";
						$sql="SELECT * FROM project_tasks WHERE project_id =$project_id  and status<>'cancelled' ORDER BY task_id DESC";
						
						$result=mysqli_query($db, $sql) or die("MySQL ERROR: ".mysqli_error());
						while ($row = mysqli_fetch_array($result)) {
								$id=$row['task_id'];
								$project_id=$row['project_id'];
								$user_id=$row['user_id'];
								$note_text=$row['task_name'];
								$status=$row['status'];
								$date_added=$row['task_created'];
								$flag=$row['colFlag'];
								$owner_of_task= GetUserNameById($user_id);
								//$project_name=$row['project_name'];
								$project_code=$row['project_code'];
								$date_of_completion=$row['date_finished'];

								if ($alternate == "1") {
									$color = "even";
									$alternate = "2";
								}
								else {
									$color = "odd";
									$alternate = "1";
								}
				
								

							//echo "<tr class='$color' id='".$id."'>";
								echo "<tr id='".$id."'>";								
									echo "<td style='width: 600px'><a href='project_task.php?task_id=$id&project_id=$project_id&user_id=1'>$note_text</a></td><td>$owner_of_task</td><td><div style='border:2px #999 solid;padding:5px;border-radius:5px; text-align:center'>$status</div></td><td>$date_added</td><td><form action='project_tasks.php' method='post'><input type='hidden' name='task_id' value='$id'><button type='submit' class='blue-badge' title='View' name='view_task'><i class='fa fa-eye'></i></button></form></td><td><form action='project_tasks.php' method='post'><input type='hidden' name='task_id' value='$id'><button type='submit' class='blue-badge' title='Mark as complete' name='mark_complete'><i class='fa fa-check'></i></button></form></td><td><form action='project_tasks.php' method='post'><input type='hidden' name='task_id' value='$id'><input type='hidden' name=status value='$status'><button type='submit' class='blue-badge' name='cancel_task'><i class='fa fa-times' title='Cancel this task'></i></button></form></td>";

								}
							echo "</tr>";
						echo "</table>";
						
				 ?>		
						
			
				<!--<div style="clear:both"></div>-->
				
			 </div><!-- middle section -->
			 <div style="clear:both;"></div>
				
							
			<?php include ("include/footer.php"); ?>
			
		</div><!-- main wrapper -->	