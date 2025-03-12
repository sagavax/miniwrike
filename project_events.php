
<?php include "include/dbconnect.php";?>
<?php include "include/functions.php";
session_start();
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="sk" lang="sk">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

		<title>Miniwrike - simple project task manager</title>
		<link href="css/style.css"?<?php echo time(); ?> rel="stylesheet" type="text/css" />
		<link href="css/events.css"?<?php echo time(); ?> rel="stylesheet" type="text/css" />
		<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" rel="stylesheet" type="text/css" />
		<link href='http://fonts.googleapis.com/css?family=PT+Sans:400,700' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=Roboto:400,300,300italic,700,700italic,400italic' rel='stylesheet'>
		<script type="text/javascript" src="js/event_manager.js" defer></script>
		<script type="text/javascript" src="js/clock.js" defer></script>
		<link rel='shortcut icon' href='project.ico'>



	</head>
	<body>
		<?php	
				$project_id = $_SESSION['project_id'];
				echo "<script>console.log(localStorage.getItem('project_id'))</script>";
			
			?>

		<div id="main">
			<!-- header -->

		<?php include "include/header.php";?>
           <?php include "include/menu.php";?>

			 <?php echo ProjectTitle($project_id); ?>

				<div id="middle"> <!-- middle section -->
					<div class="project_event_manager_wrap">
						<div class="event_manager_menu"><span>Project event manager</span><div class="event_button_group"><button class="button">Meetings</button><button class="button">Deadlines</button></div></div>
						<header><button type="button" class="button"><i class="fa fa-plus"></i> Add meeting</button></header>
						<div class="event_content">
							<?php include "project_meetings.php"; ?>
						</div>
					</div><!-- project_event_manager_wrap -->
				

				</div><!-- middle section -->

			<?php include "include/footer.php";?>


		</div> <!--main wrap -->
			<dialog id="new_meeting">
				<input type="text" name="meeting_title" placeholder="meeting title">
				<textarea name="meeting_description" id="" placeholder="meeting description"></textarea>
				<div class="orgenizer_wrap">
					<input user-id="<?php echo $_SESSION['user_id'] ?>" type="text" name="meeting_organizer" value="<?php echo GetUserNameById($_SESSION['user_id']); ?>" >
					<button type="button" class="button">Change</button>
				</div>	

				<div class="meeting_date_time">
					<input type="date" name="date_start">
					<span>Start: </span><input type="time" name="start_time"> <span>End: </span><input type="time" name="end_time">
				</div>
					<div class="meeting_tech">
					<select name="type_of_meeting">
						<option value="0">----- choose thhe meeting type -----</option>
						<option value="1">Meeting room</option>
						<option value="2">Google meet</option>
						<option value="3">Teams</option>
						<option value="4">Webex</option>
						<option value="5">Zoom</option>
					</select>
				</div>
					Meeting: <!-- <div class="button_group"><button type="button" class="button">Zoom</button><button type="button" class="button">Teams</button><button type="button" class="button">Webex</button><button type="button" class="button">Google meet</button></div>-->

					<div class="meeting_save"><button type="button" class="button">Create meeting</button></div> 
					</div>
				</div>	
			</dialog>	
			
			<dialog id="meeting_attendees">
				<div class="attendees"></div>			
			</dialog>

			<dialog id="meeting_add_attendee">
				<div class="attendees"></div>
			</dialog>

			<dialog id="meeting_add_attendee_new">
				<div class="attendees"></div>
			</dialog>

			<dialog id="meeting_add_change_location">
				
			</dialog>
	

</body>
</html>