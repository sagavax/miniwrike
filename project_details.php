<?php session_start();?>
<?php include("include/dbconnect.php"); ?>
<?php include("include/functions.php"); ?>



<?php
            if (isset($_POST['update_basic_info'])) {

                   
                    $project_description=$_POST['project_description']; //update description
					$project_id=$_POST['project_id'];
					$project_status=$_POST['project_status'];
													
                    $sql = "UPDATE projects set project_descr='project_description', project_status='$project_status' WHERE id=$project_id";
					//echo "$sql";
					$result=mysql_query($sql) or die("MySQL ERROR: ".mysql_error());
					header('Location: project_details.php?project_id='.$_POST['project_id'].''); // presmeruje spat aby sa zbranilo vkladaniu duplicity
                    
			}

			if (isset($_POST['add_person'])) { //assign uz existujucicj ludi do projektu
				
				$project_id=$_POST['project_id'];
				$user_name=$_POST['users'];
				$user_id=GetUserIdbyname($user_name);	
				$user_email=GetUserEmailbyname($user_name);
				$assigned_by=$_POST['user_id'];
				$assigned_date=date('Y-m-d H:i:s');
					//print_r($_POST);
						
				//kontrola ci user uz je pridany v projekte

				/* $sql="select $user_id from project_assigned_people where project_id=$project_id";
				$result=mysql_query($sql) or die("MySQL ERROR: ".mysql_error());
				$numrows=mysql_num_rows($result);
				
				if ($numrows > 0)  //ak ano tak ma to vrati na zaciatok
				{ echo "user is already assigned to this project";
				
				header('Location: project_details.php?&project_id='.$_POST['project_id'].''); // presmeruje spat aby sa zbranilo vkladaniu duplicity

				} else //ak nie tak ho supone to dbs*/

					
				$sql="INSERT INTO project_assigned_people (project_id, user_id,email,assigned_by,assigned_date ) VALUES ($project_id,$user_id,'$user_email',1,'$assigned_date')";
				echo "$sql";
				$result=mysql_query($sql) or die("MySQL ERROR: ".mysql_error());
				
				//mail          //posle mu email,ze bol priradeny do nejakeho projektu


				header('Location: project_details.php?&project_id='.$_POST['project_id'].''); // presmeruje spat aby sa zbranilo vkladaniu duplicity
				
			
			}	
     

     		if (isset($_POST['new_person'])) {// vytvorit noveho usera
     			$project_id=$_POST['project_id'];
     			header('Location: project_details.php?project_id='.$_POST['project_id'].''); // presmeruje spat aby sa zbranilo vkladaniu duplicity
     		}
			
			if (isset($_POST['remove_from_project'])) { //remove cloveka z projectu
				$project_id=$_POST['project_id']; //project id
				$user_id=$_POST['user_id']; // id of user to be remove from the project
				$user_name=GetUserNameById($user_id);
				$project_name=GetProjectName($project_id);
				$duration=GetPPlProjectDuration($user_id,$project_id);
				$finished_date=date('Y-m-d H:m:s');
				//$sql="DELETE from project_assigned_people where user_id=$user_id";
				
				//nevymaze uzivatele, ale nastavi mu datum ukoncenia na projecte
				$sql="update project_assigned_people SET finished_date='finished_date' where project_id=$project_id"; 
				$result=mysql_query($sql) or die("MySQL ERROR: ".mysql_error());

				$sql="update project_taks_assigned_people SET finished_date='finished_date' where project_id=$project_id"; 
				$result=mysql_query($sql) or die("MySQL ERROR: ".mysql_error());

				$sql="update project_subtask_task_assigned_people SET finished_date='finished_date' where project_id=$project_id"; 
				$result=mysql_query($sql) or die("MySQL ERROR: ".mysql_error());
				//posle to este mail

				//pridenie do streamu
				$text_streamu = "User <a href='project_user_profile.php?id=$user_id'> ".$user_name."</a> has been removed from the project <a href='project_details.php?project_id=$project_id'>".$project_name."</a>. Time spent on this project is ";
				$text_streamu=mysql_real_escape_string($text_streamu);
				$datum = date('Y-m-d H:m:s');
				$sql="INSERT INTO project_stream (project_id,user_id,text_of_stream, date_added) VALUES ($project_id,$user_id,'$text_streamu', '$datum')";
				$result=mysql_query($sql) or die("MySQL ERROR: ".mysql_error()); 
		

				header('Location: project_details.php?&project_id='.$_POST['project_id'].''); // presmeruje to spat
			}
 ?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="sk" lang="sk">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<meta name="author" content="" />
		<title>Miniwrike - simple project task manager</title>
		<link href="css/style.css" rel="stylesheet" type="text/css" />
		<link href="css/style1.css" rel="stylesheet" type="text/css" />
		<link href="css/font-awesome.css" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
		<script type="text/javascript" src="js/Chart.js"></script>
		<link href='http://fonts.googleapis.com/css?family=PT+Sans:400,700' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=Roboto:400,300,300italic,700,700italic,400italic' rel='stylesheet' type='text/css'>
		<link rel='shortcut icon' href='project.ico'>
		

		   
	</head>
<body>
		
		<?php 
				
				$project_id=$_GET['project_id']; // projektove id	
				if (!isset($_GET['project_id']))
				$project_id=$_POST['project_id'];		
				echo "project=$project_id";
				
			?>
			
		
		<div id="main"><!-- main wrapper -->
			
			
			<!-- header -->
			
			<div id="header">miniwrike<div class="logged_user"><div class="circle"></div><div class="user">Tomas Misura</div></div></div>
            <div id="menu">
                <!-- <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="project_details.php?project_id=<?php echo $project_id ?>">Project details</a></li>
                    <li><a href="project_tasks.php?project_id=<?php echo $project_id ?>">Tasks</a></li>
                    <li><a href="project_comments.php?project_id=<?php echo $project_id ?>">Comments</a></li>
					<li><a href="project_meetings.php?project_id=<?php echo $project_id ?>">Meetings*</a></li>
					<li><a href="project_calendar.php?project_id=<?php echo $project_id ?>">Calendar*</a></li>
                    <li><a href="project_stream.php?project_id=<?php echo $project_id ?>">Time stream*</a></li>
					<li><a href="project_docs.php?project_id=<?php echo $project_id ?>">Docs*</a></li>
					
                </ul> -->
				<ul id="breadcrumb">
                    <li><a href="index.php"><span class="icon icon-home"></span></a></li>
                    <li><a href="project_details.php?project_id=<?php echo $project_id ?>">Project details</a></li>
                    <li><a href="project_tasks.php?project_id=<?php echo $project_id ?>">Tasks</a></li>
                    <li><a href="project_comments.php?project_id=<?php echo $project_id ?>">Comments</a></li>
					<li><a href="project_meetings.php?project_id=<?php echo $project_id ?>">Meetings*</a></li>
					<li><a href="project_calendar.php?project_id=<?php echo $project_id ?>">Calendar*</a></li>
                    <li><a href="project_stream.php?project_id=<?php echo $project_id ?>">Time stream*</a></li>
					<li><a href="project_docs.php?project_id=<?php echo $project_id ?>">Docs*</a></li>
					
                </ul>
            </div>
			
			
			<!-- header -->
			
			<!--- middle section -->
			
						
			<div id="middle"> <!-- middle section -->
			
				<section id="project_header">
					
					<h3>Project details<h3>
					
					<form action="project_details.php?project_id=<?php echo $project_id ?>" method="post">
						<table id="project_details">
						
							<?php
							$sql="SELECT *,ABS(DATEDIFF(established_date,  now() ) ) AS duration from projects WHERE id=$project_id";
							$result=mysql_query($sql) or die("MySQL ERROR: ".mysql_error());
							while ($row = mysql_fetch_array($result)) {
									$id=$row['id'];
									$project_code=$row['project_code'];
									$project_name=$row['project_name'];
									$project_description=$row['project_descr'];
									$project_status=$row['project_status'];
									$project_created=$row['established_date'];
									$customer_id=$row['project_customer'];
									$customer_name = GetCustomerName($customer_id);
									$duration=$row['duration'];
							
							echo "<input type='hidden' name='project_id' value='$project_id'>";
							echo "<tr>";
								echo "<td>Project name:</td><td style='font-weight:bold; font-size:14px'>$project_name</td>";
							echo "</tr>";
							echo "<tr>";	
								echo "<td>Project code:</td><td>$project_code</td>";
							echo "</tr>";	
								echo "<td>Project description:</td><td><textarea name='project_description'>$project_description</textarea></td>";
							echo "</tr>";
							echo "</tr>";	
								echo "<td>Customer:</td><td><input type='text' name='project_customer' value='$customer_name'></td>";
							echo "</tr>";
							echo "</tr>";	
								echo "<td>Project status:</td><td><input list='project_status' name='project_status' value='$project_status'>
											<datalist id='project_status'>
												<option value='New'>
												<option value='In progress'>
												<option value='Pending'>
												<option value='Cancelled'>
												<option value='Completed'>
																						
											</datalist>
								
								</td>";
							echo "</tr>";
							echo "</tr>";	
								echo "<td>Project created:</td><td><span style='font-weight:bold; font-size:14px'>$project_created</span></td>";
							echo "</tr>";
							echo "<tr>";	
								echo "<td colspan='2' style='text-align:right'><button type='submit' name='update_basic_info' class='blue-badge-large'>Update</button></td>";
							echo "</tr>";
									
							}
							?>
						
						</table>
					</form>
			
				</section><div style="clear:both"></div> 			
				
				<div id="project_details_dashboard"><!--project_details_dashboard -->

					<h3>Dashboard</h3>
					
						<div class="info_box">
								<span class="info_box_title">Status:</span>
								<span class="info_box_value"><?php echo $project_status; ?></span>
						</div>					
						<div class="info_box">
								<span class="info_box_title">Total tasks</span>
								<span class="info_box_value"><?php echo NrofTasks($project_id); ?></span>
						</div>
						<div class="info_box">
								<span class="info_box_title">Total subtasks</span>
								<span class="info_box_value"><?php echo NrofSubTasks($project_id); ?></span>
						</div>
						<div class="info_box">
								<span class="info_box_title">Total comments</span>
								<span class="info_box_value"><?php echo NrofComments($project_id); ?></span>
						</div>
						<div class="info_box">
								<span class="info_box_title">Total people: </span>
								<span class="info_box_value"><?php echo NrofAssignedppl($project_id); ?></span>
						</div>
						<div class="info_box">
								<span class="info_box_title">Total meetings:</span>
								<span class="info_box_value"><?php echo NrofProjMeetings($project_id); ?></span>
						</div>
						<div class="info_box">
								<span class="info_box_title">Number of docs</span>
								<span class="info_box_value"><?php echo NumberofDocs($project_id); ?></span>							
						</div>
						<div class="info_box">
								<span class="info_box_title">Total duration</span>
								<span class="info_box_value"><?php echo $duration; ?></span>
						</div>

						<div class="info_box">
								<span class="info_box_title">Total assigned tasks:</span>
								<span class="info_box_value"><?php echo $duration; ?></span>
						</div>

						<div class="info_box">
								<span class="info_box_title">Total assigned subtasks:</span>
								<span class="info_box_value"><?php echo $duration; ?></span>
						</div>
				
				</div> <!--project_details_dashboard -->

												
				<div id="project_assigned_ppl"><!-- list of assigned ppl to project, add ppl, created new ppl -->
					
					<h3> Assigned people to the project </h3>

					<ul>

					<?php 
							
							
								$sql="SELECT *,ABS(DATEDIFF(assigned_date,  now() ) ) AS duration from project_assigned_people WHERE project_id=$project_id";
								$result=mysql_query($sql) or die("MySQL ERROR: ".mysql_error());
								$numrows=mysql_num_rows($result);
								if ($numrows==0) {echo "<span style='font-style:italic; font-size:12px; font-family: Helvetica, Arial,sans-serif;color:#999;margin-left:10px; margin-top:20px;float:left;width:100%'>No ppl assigned to this project</span>";} else {
										
										
										while ($row = mysql_fetch_array($result)) {
											$id=$row['id'];
											$user_id=$row['user_id'];
											$user_name=GetUserNameById($user_id);
											$assigned_date=$row['assigned_date'];
											$image="img/non-avatar_32.jpg";
											$duration=$row['duration'];
											

                                        echo "<li>"; 
											echo "<div class='project_assigned_ppl_post'><div class='project_assigned_ppl_image'><img src='".$image."' alt='".$user_id."'></div>
                                                 							<div class='project_assigned_ppl_post_body'><span class='project_assigned_ppl_name'><a href='project_user_profile.php?user_id=$user_id'>$user_name</a></span><span class='assigned_date'>$assigned_date</span><span class='project_assigned_ppl_duration'>$duration days</span><span class='project_assigned_ppl_button'><button type='submit' class='blue-badge' name='remove_from_project' alt='Remove user from the project'><i class='icon-remove'></i></button></span></div></div>";
										echo "</li>";

										}
										
									}
							?>
							
						</ul>	

					<form action="project_details.php?project_id=<?php echo $project_id ?>" method="post">
						<table>
						
							<input type="hidden" name="project_id" value="<?php echo $project_id; ?> ">
							<tr>	
								<td>
									<input list="users" name="users"><datalist id="users">
											<?php 
												$sql="SELECT full_name from project_users";
												$result=mysql_query($sql) or die("MySQL ERROR: ".mysql_error());
												while ($row = mysql_fetch_array($result)) {
													$full_name=$row['full_name'];
													
													echo "<option value='$full_name'>";
												}
											?>
										 
								</datalist>
									
									
									<button type="submit" name="add_person" alt="Add ppl to project" class="blue-badge">Add person</button><a href="project_create_user.php?project_id=<?php echo $project_id; ?>" alt="Create new person" class="blue-badge">Create new user</a></td>
							</tr> 
							
						</table>    
					</form>   	
				
				</div><!-- list of assigned ppl to project, add ppl, created new ppl -->
				<div style="clear:both;"></div> 
            </div><!-- middle section -->
            			
			<!-- FOOTER -->
			
			<div id="footer">
				<ul id="footer-left">
					<li>Simple miniproject administrator/manager</li>
					<li>Created by Tomas Misura</li>
				</ul>		
			</div> <!-- FOOTER -->
			
		</div><!--main wrap -->
</body>
</html>