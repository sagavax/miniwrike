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
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
		<link href='http://fonts.googleapis.com/css?family=PT+Sans:400,700' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=Roboto:400,300,300italic,700,700italic,400italic' rel='stylesheet'>
		<link rel='shortcut icon' href='project.ico'>
		

		   
	</head>
<body>
	<div id="main">
						
			<!-- header -->
				<div id="header">miniwrike<div class="logged_user"><div class="circle"></div><div class="user">Tomas Misura</div></div></div>
            <!-- header -->
            
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
            <div id="middle"> <!-- middle section -->
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