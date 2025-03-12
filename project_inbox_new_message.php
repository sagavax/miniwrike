<?php session_start();?>
<?php include "include/dbconnect.php";?>
<?php include "include/functions.php";?>

<?php

if (isset($_POST['send_message'])) {
	$sender_id = intval($_SESSION['user_id']);
	$receiver_id = intval($_POST['receiver_id']);
	$subject = mysqli_real_escape_string($db, $_POST['subject']);
	$message = mysqli_real_escape_string($db, $_POST['message']);

	$create_message = "INSERT INTO project_mailbox_inbox (project_id,sender_id,receiver_id,subject,message,sent_date,read_date,is_deleted) VALUES ($sender_id,$receiver_id,'$subject','$message',now(),'',0)"; //put into mailbox
	$result = mysqli_query($db, $create_message) or die("MySQL ERROR: " . mysqli_error());
	//echo $sql;
	
	//sent messages
	$sent_message = "INSERT INTO project_mailbox_outbox(receiver_id,sender_id,subject,message,sent_date) VALUES ($project_id,$receiver_id,$sender_id,'$subject','$message',now())"; // instert into sent messages
	echo $sent_message;	
	$result1 = mysqli_query($db, $sent_message) or die("MySQL ERROR: " . mysqli_error());

	$url = "project_inbox.php?user_id=" . $_SESSION['user_id'];
	header('location:' . $url . '');
}

?>

<!DOCTYPE html>
<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

		<title>Miniwrike - simple project task manager</title>
		<link href="css/style.css"?<?php echo time(); ?> rel="stylesheet" type="text/css" />
		<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" rel="stylesheet" type="text/css" />
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
		    <div class='inbox_wrap'>
            	<div class="new_message_wrap">
	            	<div class='inbox_menu'>
	            		<ul>
	            			<li><a href="project_inbox.php?user_id=<?php echo $user_id ?>&project_id=<?php echo $project_id ?>&folder=inbox"><i class="fa fa-inbox"></i> Inbox</a></li>
	            			<li><a href="project_inbox.php?user_id=<?php echo $user_id ?>&project_id=<?php echo $project_id ?>&folder=sent"><i class="fa fa-envelope"></i> Sent</a></li>
	            			<li><a href="project_inbox.php?user_id=<?php echo $user_id ?>&project_id=<?php echo $project_id ?>&folder=trash"><i class="fa fa-trash"></i> Trash</a></li>
	            		</ul>
	            	</div>
	            	<div class="inbox_create_message">
	            		<form action='project_inbox_new_message.php' method="post">
            				<div class="receiver">
            					<span>To:</span>
								<?php
									echo "<select name='receiver_id'>'";
									$sql = "SELECT * from project_users";
									$result = mysqli_query($db, $sql) or die("MySQL ERROR: " . mysqli_error());
									while ($row = mysqli_fetch_array($result)) {
										$user_id = $row['user_id'];
										echo "<option value=$user_id>" . GetUserNameById($user_id) . "</option>";
									}
								echo "</select>";
							   ?>
							</div><!--received -->   			
							<div class='subject'><span>Subject:</span><input type="text" name="subject" value="" autocomplete='off' placeholder="message subject...."></div>
	            			<textarea name="message" placeholder="message text ..."></textarea>

	            			<div class="send_message">
	            				<button type="submit" name="send_message" class="blue-badge">Send</button>
	            			</div>	
	            		</form>
            		</div>
            	</div>
            </div><!--wrap -->

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