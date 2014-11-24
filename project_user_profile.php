<? ob_start(); ?>
<?php include("include/dbconnect.php"); ?>
<?php include("include/functions.php"); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="sk" lang="sk">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<meta name="author" content="" />
		<title>Miniwrike - simple project task manager</title>
		<link href="css/style.css" rel="stylesheet" type="text/css" />
		<link href="css/font-awesome.css" rel="stylesheet" type="text/css" />
		<link href='http://fonts.googleapis.com/css?family=Roboto:400,300,300italic,700,700italic,400italic' rel='stylesheet' type='text/css'>
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
		<link href='http://fonts.googleapis.com/css?family=PT+Sans:400,700' rel='stylesheet' type='text/css'>
		<link rel='shortcut icon' href='project.ico'>
		

		   
	</head>
<body>
	
	<?php 

		$user_id=$_GET['user_id'];
		echo "user=$user_id";
	?>

	<div id="main">
						
			<!-- header -->
				<div id="header">miniwrike<div class="logged_user"><div class="circle"></div><div class="user">Tomas Misura</div></div></div>
            <!-- header -->
            
            <div id="menu">
                <ul>
                    <li><a href="index.php">Home</a></li>                   
					
                </ul>
            </div>
            <div id="middle"> <!-- middle section -->

	            <div id="project_user_basic_info">
	            	<h3>Basic info:</h3>
	            	
	            			<?php 

	            		$sql="SELECT *  FROM project_users WHERE user_id=$user_id";
	            		//echo "$sql";
	            		$result=mysql_query($sql) or die("MySQL ERROR: ".mysql_error()); 
	            		while ($row = mysql_fetch_array($result)) {
	            			$full_name=$row['full_name'];
	            			$login=$row['login'];
	            			$email=$row['email'];
	            			$phone=$row['phone'];
	            			$created_date=$row['created_date'];
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

	            <div id="project_user_list_of_projects">
	            	<h3>List of the actual projects:</h3>
	            	<ul>
	            	<?php 

	            		$sql="SELECT a.assigned_date,a.user_id, a.project_id, b.project_name, b.project_status FROM project_assigned_people a, projects b WHERE a.user_id=$user_id and a.project_id = b.id";
	            		//echo "$sql";
	            		$result=mysql_query($sql) or die("MySQL ERROR: ".mysql_error()); 
	            		while ($row = mysql_fetch_array($result)) {
	            			$project_id=$row['project_id'];
	            			$project_name=GetProjectNameById($project_id);
	            			$assigned_date=$row['assigned_date'];
	            			$project_status=$row['project_status'];

	            			///$duration

	            			echo "<li><div class='user_details_project_wrap'><div class='user_details_project_name'><a href='project_details.php?project_id=$project_id'>$project_name</a></div><div class='user_details_project_duration'>duration</div><div class='user_details_project_status'>$project_status</div><div class='user_details_project_ass_date'>$assigned_date</div></div></li>";
	            		}	

	            	?>
	            	</ul>	

	            	<h3>List of the past projects:</h3>
	            	<ul>
	            		<?php 
		            		//$sql="SELECT SELECT a.assigned_date, a.user_id, a.project_id, b.project_name, b.project_status FROM project_assigned_people a, projects b WHERE a.user_id =$user_id AND b.project_status='Completed' AND a.project_id = b.id";
		            		
		            		$sql="SELECT a.assigned_date, a.user_id, a.project_id, b.project_name, b.project_status FROM project_assigned_people a, projects b WHERE a.user_id =$user_id AND b.project_status =  'Completed' AND a.project_id = b.id";


		            		///echo "$sql";
		            		$result=mysql_query($sql) or die("MySQL ERROR: ".mysql_error()); 
		            		while ($row = mysql_fetch_array($result)) {
	            			$project_id=$row['project_id'];
	            			$project_name=GetProjectNameById($project_id);
	            			$assigned_date=$row['assigned_date'];
	            			$project_status=$row['project_status'];

	            			///$duration

	            			echo "<li><div class='user_details_project_wrap'><div class='user_details_project_name'><a href='project_details.php?project_id=$project_id'>$project_name</a></div><div class='user_details_project_duration'>duration</div><div class='user_details_project_status'>$project_status</div><div class='user_details_project_ass_date'>$assigned_date</div></div></li>";
	            		}	

	            	?>
	            	</ul>


	            </div>	
	            	<!-- 	2. list of projects user was working on (or still working) -> tasks or subtask, meetings, calculating duration spent on particular project
	 					and percentage 	from overal activities
	 				-->
	            <div id="project_user_list_of_tasks">
	            	<h3>List of the task:</h3>
		           		<?php 
			           		$sql="SELECT * from project_task_assigned_people WHERE user_id=$user_id";
		            		$result=mysql_query($sql) or die("MySQL ERROR: ".mysql_error()); 
		            		while ($row = mysql_fetch_array($result)) {
	            				$task_id=$row['task_id'];
	            				$project_id=$row['project_id'];
	            				$task_name=GetTaskName($task_id);
	            				$task_status=GetTaskStatus($task_id);
	            				$assigned_date=$row['assigned_date'];

	            				echo "<li>
	            					<div class='user_details_task_wrap'>
	            						<div class='user_details_task_name'><a href='project_task_details.php?task_id=$task_id&project_id=$project_id'>$task_name</a></div><div class='user_details_task_duration'>duration</div><div class='user_details_task_status'>$task_status</div><div class='user_details_task_ass_date'>$assigned_date</div>
	            					</div>

	            				</li>";

	            			}	
		           			
				         ?>	
			       	<ul>

	            	</ul>	
	            </div>


	             <div id="project_user_meetings">
	            	<h3>Project meetings:</h3>

	            </div>

	            <div id="project_user_uploaded_docs">
	            	<h3>Uploaded docs:</h3>

	            </div>

	            <div id="project_user_planned_absence">
	            	<h3>Planned absence:</h3>
	            	<!-- 3. planned absense-->

	            </div>
            	

            </div><!-- div middle -->
            <div style="clear:both;"></div>
            
						
			<!-- FOOTER -->
			
			<div id="footer"><!-- FOOTER -->

				<ul id="footer-left">
					<li>Simple miniproject administrator/manager</li>
					<li>Created by Tomas Misura</li>
				</ul>

			</div> <!-- FOOTER -->
			
		</div><!-- main -->	

</body>
<html>