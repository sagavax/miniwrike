<?php session_start();?>
<?php include "include/dbconnect.php";?>
<?php include "include/functions.php";?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="sk" lang="sk">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

		<title>Miniwrike - simple project task manager</title>
		<link href="css/style.css?v1.0" rel="stylesheet" type="text/css" />
		<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
		<link href='http://fonts.googleapis.com/css?family=PT+Sans:400,700' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=Roboto:400,300,300italic,700,700italic,400italic' rel='stylesheet'>
		<link rel='shortcut icon' href='project.ico'>



	</head>
<body>
	<div id="main">

			<!-- header -->
				<?php include "include/header.php";?>
				<?php include "include/menu.php";?>
            <!-- header -->


            <div id="middle"> <!-- middle section -->

            	<div class='login_wrap'>
            		<form method="post" action="project_login.php">
	            		<p>
	            			<label for="login">Login:</label><input type="text" name="login_name" value="" id="login">
	            		</p>
	            		<p>
	            			<label for="password">Password:</label><input type="password" name="password" value="" id="password">
	            		</p>
	            		<p>
	            			<button type="submit" class='blue-badge'>login</button>

            	</div>
            </div><!-- div middle -->



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