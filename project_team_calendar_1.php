<?session_start(); ?>
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
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
		<link href='http://fonts.googleapis.com/css?family=PT+Sans:400,700' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=Roboto:400,300,300italic,700,700italic,400italic' rel='stylesheet'>
		<link rel='shortcut icon' href='project.ico'>
		

		   
	</head>
<body>
	<div id="main">
							
			<!-- header -->
				<?php 
					$_SESSION['project_id']=12;
		               	$_SESSION['user_id']=1;
				include ("include/header.php");
				include ("include/menu.php"); ?>
            <!-- header -->
            
           
            <div id="middle"> <!-- middle section -->
            	<div id="project_title"><!-- project title -->
		               <?php

		               	$project_id=$_SESSION['project_id'];
						$user_id=$_SESSION['user_id'];
		                $sql="SELECT * from projects where id=$project_id";
		                $result=mysql_query($sql) or die("MySQL ERROR: ".mysql_error());
		                while ($row = mysql_fetch_array($result)) {
		                    $project_name=$row['project_name'];
		                    $project_description=$row['project_descr'];

		                   
		                    echo "<span style='float:left;font-weight:bold; font-size:26px; font-family: Helvetica, Arial,sans-serif;margin-left:10px'>$project_name<br></span>";   //boldovo
		                    echo "<span style='float:left;font-style:italic; font-size:12px; font-family: Helvetica, Arial,sans-serif;color:#ddd;margin-left:15px'>$project_description</span>"; //italikom
		                    

		                }

		                ?>
            	</div><!-- project title --> 
            	<div id="project_calendar">
            		<?php
	            		echo "<table id='workload'>";
            			echo "<tr><th  colspan='2'><h3> team calendar </h3></th></tr>";
            			echo "<tr><td>team member</td><td></td></tr>";

	            		$sql="SELECT * from project_assigned_people WHERE project_id=$project_id";

	            		$result=mysql_query($sql) or die("MySQL ERROR: ".mysql_error());
	            		$nr_of_rec=mysql_num_rows($result);
	            		 while ($row = mysql_fetch_array($result)) {
			                	$user_id=$row['user_id'];
			            		$user_name = GetUserNameById($user_id);
		             	
		             	echo "<tr><td style='width:15%'>$user_name</td><td style='width:85%'></td></tr>";
		             }
		              echo "</table>";
		            ?> 	
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