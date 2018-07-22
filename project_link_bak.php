<?php ob_start();?>
<?php include("include/dbconnect.php"); ?>
<?php include("include/functions.php"); ?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="sk" lang="sk">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
		
		<title>Miniwrike - links</title>
		<link href="css/style.css?v1.0" rel="stylesheet" type="text/css" />
		<link href="css/style1.css" rel="stylesheet" type="text/css" />
		<link href="css/font-awesome.css" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
		<script type="text/javascript" src="js/Chart.js"></script>
		<link href='https://fonts.googleapis.com/css?family=PT+Sans:400,700' rel='stylesheet' type='text/css'>
		<link href='https://fonts.googleapis.com/css?family=Roboto:400,300,300italic,700,700italic,400italic' rel='stylesheet' type='text/css'>
		<link rel='shortcut icon' href='project.ico'>
		

		   
	</head>
<body>
		
		<?php 
				
				$project_id=$_GET['project_id']; // projektove id	
				
				
		?>
			
		
		<div id="main"><!-- main wrapper -->
			
			
			<!-- header -->
			
			<?php include ("include/header.php"); ?>
			<?php include ("include/menu.php"); ?>

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

			<div id="middle"> <!-- middle section -->

			</div><!--middle -->
		</div><!-- main -->	