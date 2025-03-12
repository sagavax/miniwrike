<?php session_start();?>
<?php include "include/dbconnect.php";?>
<?php include "include/functions.php";?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="sk" lang="sk">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

		<title>Miniwrike - simple project task manager</title>
		<link href="css/style.css?v<?php echo time(); ?>" rel="stylesheet" type="text/css" />
		<link href="css/project_user.css?v<?php echo time(); ?>" rel="stylesheet" type="text/css" />
		<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" rel="stylesheet" type="text/css" />
		<link href='http://fonts.googleapis.com/css?family=Roboto:400,300,300italic,700,700italic,400italic' rel='stylesheet' type='text/css'>
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
		<link href='http://fonts.googleapis.com/css?family=PT+Sans:400,700' rel='stylesheet' type='text/css'>
		<link rel='shortcut icon' href='project.ico'>



	</head>
<body>

	<?php $user_id = $_GET['user_id']; ?>

	<div id="main">

			<!-- header -->
				<?php include "include/header.php";?>
				<?php include "include/menu.php";?>
            <!-- header -->

            <div id="middle"> <!-- middle section -->

	               			<?php

							$get_user_info = "SELECT * FROM project_users WHERE user_id=$user_id";
							$result = mysqli_query($db, $get_user_info) or die("MySQL ERROR: " . mysqli_error());
							while ($row = mysqli_fetch_array($result)) {
								$full_name = $row['full_name'];
								$login = $row['login'];
								$email = $row['email'];
								$phone = $row['phone'];
								$created_date = $row['created_date'];
								$img = $row['profile_photo'];
								///$duration

							}

							?>

	            			<div class="basic_information">
		            			<h3>Basic user information: </h3>
		            			<input type="text" name="" value="<?php echo $full_name; ?>">
		            			<input type="text" name="" value="" placeholder="last name...">
		            			<input type="text" name="user_login" value="<?php echo $login; ?>">
		            			<input type="text" name="" value="<?php echo $email; ?>">
		            			<input type="text" name="" value="<?php echo $phone; ?>">
		            			<span>Created: <?php echo $created_date; ?></span>
	            		    </div>
	            		    
	            		    <div class="user_role_tech_information">
	            		      <h3>Assign a technology for user</h3>	
	            		      <h4>Assigning preferred role and technology for future projects</h4>
	            		      <section><!-- technology -->
	            		      	<select name="technology">
			            		      	<?php
			            		      		$get_technologies = "SELECT * from project_technologies ORDER BY technology_name ASC";
			            		      		$result = mysqli_query($db, $get_technologies) or die("MySQL ERROR: " . mysqli_error());
			            		      		while ($row = mysqli_fetch_array($result)) {
			            		      			$tech_id = $row['tech_id'];
			            		      			$tech_name = $row['technology_name'];
			            		      			echo "<option value='tech_id'>$tech_name</option>";
											}	

			            		      	?>
	            		      	  </select>
	            		      			<button type="button"><i class="fa fa-plus"></i> Assing technology</button>
		            		      		<button type="button"><i class="fa fa-plus"></i> Add new technology</button>
	            		      	</section>
	            		      
		            		     <section><!-- project role -->
		            		     	<select name="project_role">
			            		      	<?php
			            		      		$get_roles = "SELECT * from project_roles ORDER BY role_name ASC";
			            		      		$result = mysqli_query($db, $get_roles) or die("MySQL ERROR: " . mysqli_error());
			            		      		while ($row = mysqli_fetch_array($result)) {
			            		      			$role_id = $row['role_id'];
			            		      			$role_name = $row['role_name'];
			            		      			echo "<option value='role_id'>$role_name</option>";
											}	

			            		      	?>
			            		   	</select>
			            		   	<button type="button"><i class="fa fa-plus"></i>Assing role</button>
		            		        <button type="button"><i class="fa fa-plus"></i> create new role</button>   	
		            		  </section>
	            		    </div><!-- role tech -->
	            </div><!-- project user-->

            </div><!-- div middle -->
			<?php include "include/footer.php";?>

		</div><!-- main -->

</body>
<html>