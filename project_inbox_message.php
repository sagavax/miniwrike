<?php session_start();?>
<?php include "include/dbconnect.php";?>
<?php include "include/functions.php";?>

<?php
if (isset($_POST['new_mail'])) {
	$url = "project_inbox_new_message.php?sender_id=" . $_SESSION['user_id'];
	header('location:' . $url . '');
}

?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="sk" lang="sk">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
		<title>Miniwrike - simple project task manager</title>
		<link href="css/style.css"?<?php echo time(); ?> rel="stylesheet" type="text/css" />
		<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
		<script type="text/javascript" src="js/mailbox.js" defer></script>
		<link href='http://fonts.googleapis.com/css?family=PT+Sans:400,700' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=Roboto:400,300,300italic,700,700italic,400italic' rel='stylesheet'>

		<link rel='shortcut icon' href='project.ico'>



	</head>
<body>
	<?php
$project_id = $_SESSION['project_id'];
$user_id = $_SESSION['user_id'];

?>
	<div id="main">

			<!-- header -->
				<?php include "include/header.php";?>
				<?php include "include/menu.php";?>
            <!-- header -->


            <div id="middle"> <!-- middle section -->

            <div class='inbox_wrap'>
            <div class='inbox_new_message'><button type="submit" name='new_mail' class="blue-badge"><i class="fa fa-plus"></i> message</button></div>
             <div class="new_message_wrap">
            	<div class='inbox_menu'>
            		<ul>
            			<li><a href="project_inbox.php?user_id=<?php echo $user_id ?>&project_id=<?php echo $project_id ?>&folder=inbox"><i class="fa fa-inbox"></i> Inbox</a></li>
            			<li><a href="project_inbox.php?user_id=<?php echo $user_id ?>&project_id=<?php echo $project_id ?>&folder=sent"><i class="fa fa-envelope"></i> Sent</a></li>
            			<li><a href="project_inbox.php?user_id=<?php echo $user_id ?>&project_id=<?php echo $project_id ?>&folder=trash"><i class="fa fa-trash"></i> Trash</a></li>
            		</ul>
            	</div>
            	
            		<div class='mail_box'>
            			<div class="view_message">
            			<?php
						     $message_id = $_GET['message_id'];
							$sql = "SELECT * from project_mailbox_inbox WHERE message_id='message_id'";
							$result = mysqli_query($db, $sql) or die("MySQL ERROR: " . mysqli_error());

							while ($row = mysqli_fetch_array($result)) {
								$sender_name = GetUserNameById($row['sender_id']);
								$id = $row['mess_id'];
								$subject = substr($row['subject'], 0, 30);
								$sent_date = $row['sent_date'];
								$read_date = $row['read_date'];
								$fl = substr($sender_name, 0, 1);
								$message = substr($row['message'], 0, 50);
								//echo "$read_date";

								
						}

						?>
            		
            		</div><!-- view message -->
              </div>	
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
