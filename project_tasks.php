<?php session_start(); ?>
<?php include "include/dbconnect.php" ?>
<?php include "include/functions.php" ?>



<?php
            if (isset($_POST['add_new_task'])) { // novy task


                    
					$project_id=$_POST['project_id'];
					
					$user_id=$_POST['user_id'];
					$user_id=1;
					$note_text=$_POST['add_note'];
                    $curr_date=date('Y-m-d H:i:s');
                    $date=strtotime(date('Y-m-d H:i:s', strtotime($curr_date)) . " +5 day");
                    $end_date= date('Y-m-d H:i:s', $date);
                    
                
					//vytvorenie noveho project tasku
								
                    $sql = "INSERT INTO project_tasks (project_id, user_id, colNoteText, status,task_priority, is_completed,task_created, task_finished, task_deadline) VALUES ($project_id,$user_id,'$note_text','New','Normal','0','$curr_date','','$end_date')";
					$result=mysql_query($sql) or die("MySQL ERROR: ".mysql_error());
					


					//zapisanie do project streamu/historie

					
					//ziskanie max task id z tabulky
					$sql="SELECT MAX(task_id) as task_id from project_tasks where project_id=$project_id";
					
					$result=mysql_query($sql) or die("MySQL ERROR: ".mysql_error());
					while ($row = mysql_fetch_array($result)) {
								$task_id=$row['task_id'];
					}
					
									
					//pridenie do streamu
					$user_name = GetUserNameById($user_id);
					$text_streamu = "User <a href='project_user_profile.php?user_id=$user_id'> ".$user_name."</a> has created a new task id <a href='project_task_details.php?task_id=$task_id&project_id=$project_id'>".$task_id."</a>";
					$text_streamu=addslashes($text_streamu);
					$datum=date('Y-m-d H:m:s');
					$sql="INSERT INTO project_stream (project_id,user_id,text_of_stream, date_added) VALUES ($project_id,$user_id,'$text_streamu','$datum')";
					//echo "$sql";
					$result=mysql_query($sql) or die("MySQL ERROR: ".mysql_error());
					//$project_id=$_POST['project_cislo'];
					
					header('Location: project_tasks.php?project_id='.$_POST['project_id'].''); // presmeruje spat aby sa zabranilo vkladaniu duplicity
				
			} // novy task


   		$_SESSION['project_id'] = $project_id;
   		 
 ?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="sk" lang="sk">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<meta name="author" content="" />
		<title>Miniwrike - simple project task manager - tasks</title>
		<link href="css/style.css" rel="stylesheet" type="text/css" />
		<link href="css/font-awesome.css" rel="stylesheet" type="text/css" />
		<!-- <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>-->
		<link href='http://fonts.googleapis.com/css?family=PT+Sans:400,700' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=Roboto:400,300,300italic,700,700italic,400italic' rel='stylesheet' type='text/css'>
		<link rel='shortcut icon' href='project.ico'>
		

		   
	</head>
<body>


		<?php 
				  $project_id=$_GET['project_id']; // projektove id	
				if (!isset($_GET['project_id']))
				$project_id=$_POST['project_id'];	
				
				$user_id=1;
				echo "project_id=$project_id";
					//echo "project=$project or project_id=$project_id";
				
				?>


		<div id="main">
			
			

				<!-- header -->
				
				<div id="header">miniwrike<div class="logged_user"><div class="circle"></div><div class="user">Tomas Misura</div></div></div>
				<div id="menu">
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
				</div>

				
				
				
				<div id="project_title"><!-- project title -->
					<?php

					$sql="SELECT * from projects where id=$project_id";
					$result=mysql_query($sql) or die("MySQL ERROR: ".mysql_error());
						while ($row = mysql_fetch_array($result)) {
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
										<input type='text' name='add_note' size='100'> 
									</td>
									<td>
										<button type="submit" name="add_new_task">Add task </button>
									</td>	
								</tr>
							</table>
					   </form> 
					 </span>
				</div> <!--- add task -->

			   <div id="middle"> <!-- middle section -->
				
				
					<?php 
						echo "<table id='project_tasks'>";
						$sql="SELECT * FROM project_tasks WHERE project_id =$project_id ORDER BY task_id DESC";
						
						$result=mysql_query($sql) or die("MySQL ERROR: ".mysql_error());
						while ($row = mysql_fetch_array($result)) {
								$id=$row['task_id'];
								$project_id=$row['project_id'];
								$user_id=$row['user_id'];
								$note_text=$row['colNoteText'];
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
				
								

							echo "<tr class='$color' id='".$id."'>";
								
								echo "<td style='width: 700px'><a href='project_task_details.php?task_id=$id&project_id=$project_id&user_id=1'>$note_text</a></td><td>$owner_of_task</td><td>$status</td><td>$date_added</td>";
								
								}
							echo "</tr>";
						echo "</table>";
						
				 ?>		
						
			
				<div style="clear:both"></div>
				
			 </div><!-- middle section -->
			 <div style="clear:both;"></div>
				
							
				<!-- FOOTER -->
				
				<div id="footer">
					<ul id="footer-left">
						<li>Simple miniproject administrator/manager</li>
						<li>Created by Tomas Misura</li>
					</ul>		
				</div> <!-- FOOTER -->
			
		</div><!-- main wrapper -->	