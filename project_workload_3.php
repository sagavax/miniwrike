<?php session_start(); ?>
<?php include("include/dbconnect.php"); ?>
<?php include("include/functions.php"); ?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="sk" lang="sk">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
		
		<title>Miniwrike - simple project task manager</title>
		<link href="css/style.css?v1.0" rel="stylesheet" type="text/css" />
		<link href="css/font-awesome.css" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
		<link href='https://fonts.googleapis.com/css?family=PT+Sans:400,700' rel='stylesheet' type='text/css'>
		<link href='https://fonts.googleapis.com/css?family=Roboto:400,300,300italic,700,700italic,400italic' rel='stylesheet'>
		<link rel='shortcut icon' href='project.ico'>
		

		   
	</head>
<body>
	<?php 
		echo "Project id:".$_SESSION['project_id'];
	?>	
	<div id="main">
						
			<!-- header -->
				<?php include ("include/header.php"); ?>
				<?php include ("include/menu.php"); ?>
            <!-- header -->
            
           
            <div id="middle"> <!-- middle section -->
            		<div id="project_title"><!-- project title -->
		               <?php
		               	$project_id=$_SESSION['project_id'];
						$user_id=$_SESSION['user_id'];
		                $sql="SELECT * from projects where id=$project_id";
		                $result=mysqli_query($db, $sql) or die("MySQL ERROR: ".mysqli_error());
		                while ($row = mysqli_fetch_array($result)) {
		                    $project_name=$row['project_name'];
		                    $project_description=$row['project_descr'];

		                    
		                   echo "<span class='project_title'>$project_name</span>";   //boldovo
		                    echo "<span class='project_describtion'>$project_description</span>"; //italikom
		                    

		                }

		                ?>
            	</div><!-- project title -->  

            	<div class="project_workload">
            	<?php 
            		echo "<table id='workload'>";
            		echo "<tr><th  colspan='2'><h3> Project workload</h3></th></tr>";
            		echo "<tr><td>Asignee:</td><td>Assigned tasks:</td></tr>";

            		$sql="SELECT * from project_assigned_people WHERE project_id=$project_id";

            		$result=mysqli_query($db, $sql) or die("MySQL ERROR: ".mysqli_error());
            		$nr_of_rec=mysql_num_rows($result);
            		if($nr_of_rec==0){
            			echo "<tr><td colspan='2'><span style='font-style:italic;color:#555'>No people have assigned tasks</span></td></tr>";
            		} else {
		                while ($row = mysqli_fetch_array($result)) {
		                	$user_id=$row['user_id'];
		             $user_name = GetUserNameById($user_id);
		             echo "<tr><td style='width:15%'>$user_name</td><td style='width:85%'>";
		             	$sql1="SELECT task_id from project_task_assigned_people where user_id=$user_id and project_id=$project_id";
		             	$result1=mysql_query($sql1) or die("MySQL ERROR: ".mysqli_error());
		             		 while ($row1 = mysqli_fetch_array($result1)) {
		                	$task_id=$row1['task_id'];
		                	$task=$task_id.'; ';
		                	echo "<a href='project_task.php?task_id=$task_id' class='link'>$task_id</a>"."; "; 	
		                }	
		              }  
		             echo "</td></tr>";
		            
		             //zoznam vsetkych assignovanych taskov 
		             //select a.task_id,a.project_id from project_tasks a, project_task_assigned_people b where a.project_id=b.project_id and a.task_id=b.task_id and a.project_id=12
		             //
		           } 
		            echo "<tr><td>Unassigned tasks:</td><td>";

		            		$sql2="SELECT task_id FROM project_tasks WHERE project_id=$project_id and task_id NOT IN (SELECT task_id FROM project_task_assigned_people where project_id=$project_id)";
		             		$result2=mysql_query($sql2) or die("MySQL ERROR: ".mysqli_error());
		             		while ($row2 = mysqli_fetch_array($result2)) {
		             		$task_id1=$row2['task_id'];
		             		$task1=$task_id1.'; ';
		                	echo "<a href='project_task.php?task_id=$task_id1' class='link'>$task_id1</a>"."; "; 	
		                }	

		            echo "</td></tr>";
    	
		           echo "</table>";
            	?>
            </div> 
            </div><!-- div middle -->
            <div id="footer"><!-- FOOTER -->

				<ul id="footer-left">
					<li>Simple miniproject administrator/manager</li>
					<li>Created by Tomas Misura</li>
				</ul>

			</div> <!-- FOOTER -->

                     
           	<!-- FOOTER -->
			
			
			
		</div><!-- main -->	

</body>
<html>