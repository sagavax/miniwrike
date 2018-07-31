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
	<div id="main">
			<?php
				$project_id=$_SESSION['project_id'];
				$user_id=$_SESSION['user_id'];
			?>			
			<!-- header -->
				<?php include ("include/header.php"); ?>
				<?php include ("include/menu.php"); ?>
            <!-- header -->
            
           
            <div id="middle"> <!-- middle section -->
            	<div id="project_title"><!-- project title -->
		               <?php
		               	
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
            <div class="project_contacts_wrap">
            	<div class="add_contact"></div> <!--pridaj novy kontakt -->
            	<div id="contact_detais"></div><!--podrobnosti o kontakte -->
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