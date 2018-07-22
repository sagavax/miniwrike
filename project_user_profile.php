<?php session_start(); ?>
<?php include("include/dbconnect.php"); ?>
<?php include("include/functions.php"); ?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="sk" lang="sk">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
		
		<title>Miniwrike - simple project task manager</title>
		<link href="css/style.css?<?php echo time(); ?>" rel="stylesheet" type="text/css" />
		<link href="css/font-awesome.css" rel="stylesheet" type="text/css" />
		<link href='https://fonts.googleapis.com/css?family=Roboto:400,300,300italic,700,700italic,400italic' rel='stylesheet' type='text/css'>
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
		<link href='https://fonts.googleapis.com/css?family=PT+Sans:400,700' rel='stylesheet' type='text/css'>
		<link rel='shortcut icon' href='project.ico'>
		

		   
	</head>
<body>
	
	<?php 

		$user_id=$_GET['user_id'];
	?>

	<div id="main">
						
			<!-- header -->
				<?php include ("include/header.php"); ?>
				<?php include ("include/menu.php"); ?>
            <!-- header -->
            
            
            <div id="middle"> <!-- middle section -->

	            <div id="project_user_basic_info">
	            	<h3>Basic info:</h3>
	            	
	            			<?php 

	            		$sql="SELECT *  FROM project_users WHERE user_id=$user_id";
	            		$result=mysqli_query($db, $sql) or die("MySQL ERROR: ".mysqli_error()); 
	            		while ($row = mysqli_fetch_array($result)) {
	            			$full_name=$row['full_name'];
	            			$login=$row['login'];
	            			$email=$row['email'];
	            			$phone=$row['phone'];
	            			$created_date=$row['created_date'];
	            			$img=$row['profile_photo'];
	            			///$duration
	            		
	            		}	

	            	?>
	            	
	            
	            	<table>
	            		<tr>
	            			<td>Full name:</td><td><?php echo  $full_name; ?></td>
	            		</tr>	
	            		<tr>
	            			<td>login:</td><td><?php echo  $login; ?></td>
	            		</tr>
	            		<tr>
	            			<td>Email:</td><td><?php echo  $email; ?></td>
	            		</tr>
	            		<tr>
	            			<td>phone:</td><td><?php echo  $phone; ?></td>
	            		</tr>
	            		<tr>
	            			<td>Created:</td><td><?php echo  $created_date; ?></td>
	            		</tr>					
	            	</table>	
	            	<!--1. basic information about user -->
	            </div>

	            <div id="project_user_project_list">
	            	<h3>List of the actual projects:</h3>
	            	<ul>
	            	<?php 

	            		$sql="SELECT a.assigned_date,a.user_id, a.project_id, b.project_name, b.project_status FROM project_assigned_people a, projects b WHERE b.project_status not in ('complete','cancelled') and a.user_id=$user_id and a.project_id = b.id";
	            		//echo "$sql";
	            		$result=mysqli_query($db, $sql) or die("MySQL ERROR: ".mysqli_error()); 
	            		while ($row = mysqli_fetch_array($result)) {
	            			$project_id=$row['project_id'];
	            			$project_name=GetProjectNameById($project_id);
	            			$assigned_date=$row['assigned_date'];
							$project_status=$row['project_status'];
							$duration=ProjectDuration($project_id);

	            			///$duration

	            			echo "<li><div class='user_details_project_wrap'><div class='user_details_project_name'><a href='project_details.php?project_id=$project_id'>$project_name</a></div><div class='user_details_project_duration'>$duration days</div><div class='user_details_project_status'>$project_status</div><div class='user_details_project_ass_date'>$assigned_date</div></div></li>";
	            		}	

	            	?>
	            	</ul>	

	            	<h3>List of the past projects:</h3>
	            	<ul>
	            		<?php 
		            		//$sql="SELECT SELECT a.assigned_date, a.user_id, a.project_id, b.project_name, b.project_status FROM project_assigned_people a, projects b WHERE a.user_id =$user_id AND b.project_status='complete' AND a.project_id = b.id";
		            		
		            		$sql="SELECT a.assigned_date, a.user_id, a.project_id, b.project_name, b.project_status FROM project_assigned_people a, projects b WHERE a.user_id =$user_id AND b.project_status in ('complete','Cancelled') AND a.project_id = b.id";


		            		///echo "$sql";
		            		$result=mysqli_query($db, $sql) or die("MySQL ERROR: ".mysqli_error()); 
		            		while ($row = mysqli_fetch_array($result)) {
	            			$project_id=$row['project_id'];
	            			$project_name=GetProjectNameById($project_id);
	            			$assigned_date=$row['assigned_date'];
	            			$project_status=$row['project_status'];
							$duration=ProjectDuration($project_id);	
	            			///$duration

	            			echo "<li>
	            					<div class='user_details_project_wrap'>
	            						<div class='user_details_project_name'><a href='project_details.php?project_id=$project_id'>$project_name</a></div>
	            						<div class='user_details_project_duration'>$duration days</div>
	            						<div class='user_details_project_status'>$project_status</div>
	            						<div class='user_details_project_ass_date'>$assigned_date</div>
	            					</div>
	            				</li>";
	            		}	

	            	?>
	            	</ul>


	            </div>	
	            	<!-- 	2. list of projects user was working on (or still working) -> tasks or subtask, meetings, calculating duration spent on particular project
	 					and percentage 	from overal activities
	 				-->
	            <div id="project_user_task_list">
	            	<h3>List of the task:</h3>
	            	 <ul>
		           		<?php 
			           		$sql="SELECT * from project_task_assigned_people WHERE user_id=$user_id";
							  $result=mysqli_query($db, $sql) or die("MySQL ERROR: ".mysqli_error()); 
		            		while ($row = mysqli_fetch_array($result)) {
	            				$task_id=$row['task_id'];
								$project_id=$row['project_id'];
								$duration=CurrTaskDuration($task_id);
	            				$task_name=GetTaskName($task_id);
	            				$task_status=GetTaskStatus($task_id);
	            				$assigned_date=$row['assigned_date'];

	            				echo "<li>
									<div class='user_details_task_wrap'>
									    <div class='user_details_task_id'>$task_id</div> 
	            						<div class='user_details_task_name'><a href='project_task.php?task_id=$task_id&project_id=$project_id'>$task_name</a></div>
	            						<div class='user_details_task_duration'>$duration</div>
	            						<div class='user_details_task_status'>$task_status</div>
	            						<div class='user_details_task_ass_date'>$assigned_date</div>
	            					</div>

	            				</li>";

	            			}	
		           			
				         ?>	
			       	</ul>	
	            </div>


	             <div id="project_user_meetings">
	            	<h3>Project meetings:</h3>
	            		<ul>
		           		<?php 
			           		$sql="SELECT a.meeting_id, a.project_id, b.id,b.meeting_title, b.date_of_meeting, b.start_time, b.end_time, c.project_name from project_meetings_atendees a, project_meetings b, projects c where a.user_id=$user_id and a.meeting_id=b.id and a.project_id=c.id";
		            		$result=mysqli_query($db, $sql) or die("MySQL ERROR: ".mysqli_error()); 
		            		while ($row = mysqli_fetch_array($result)) {
	            				$meeting_id=$row['meeting_id']; //id mitingu
	            				$meeting_title=$row['meeting_title'];
	            				$start_time=$row['start_time'];
	            				$end_time=$row['end_time'];
	            				
	            				$project_id=$row['project_id'];
	            				$project_name=$row['project_name']; //id projektu


	            				
	            				echo "<li>
	            					<div class='user_details_project_wrap'>
	            						<div class='user_details_project'><a href='project_details.php?project_id=$project_id'>$project_name</a></div>
	            						<div class='user_details_meeting_title'><a href='project_meeting_minutes.php?m_id=$meeting_id'>$meeting_title</a></div>
	            						<div class='user_details_meeting_start_time'>$start_time</div>
	            						<div class='user_details_meeting_end_time'>$end_time</div>
	            						
	            					</div>
	            				</li>";

	            			}	
		           			
				         ?>	
			       	</ul>	


	            </div>

	            <div id="project_user_uploaded_docs">
	            	<h3>Uploaded docs:</h3>

	            		<ul>
		           		<?php 
						    $sql="SELECT a.uploaded_by, a.Uploaded_date, b.project_name,c.full_name from project_documents a, projects b, project_users c where a.uploaded_by=$user_id and a.project_id=b.id and a.Uploaded_by=c.user_id";
							  
		            		$result=mysqli_query($db, $sql) or die("MySQL ERROR: ".mysqli_error()); 
		            		$num=mysqli_num_rows($result);
		            		if ($num==0) {
		            			echo "<div>This user has not uploaded any documents yet</div>";
		            		}
		            		while ($row = mysqli_fetch_array($result)) {
		            			echo "<li>
	            					<div class='user_details_docs'>
	            						<div class='user_details_project'><a href='project_details.php?project_id=$project_id'>".$row['project_name']."</a></div>
	            						<div class='user_details_meeting_title'><a href='project_meeting_minutes.php?m_id=$meeting_id'>$meeting_title</a></div>
	            						<div class='user_details_meeting_start_time'>$start_time</div>
	            						<div class='user_details_meeting_end_time'>$end_time</div>
	            						
	            					</div>
	            				</li>";
	            			}	
	            	   ?>
	            	  	</ul> 		
	            </div>

	            <div id="project_user_planned_absence">
	            	<h3>Planned absence:</h3>
	            	<!-- 3. planned absense-->

	            </div>
            	

            </div><!-- div middle -->
            <div style="clear:both;"></div>
            
						
			<?php include ("include/footer.php"); ?>
			
		</div><!-- main -->	

</body>
<html>