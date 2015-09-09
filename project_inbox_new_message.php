<?php session_start(); ?>
<?php include("include/dbconnect.php"); ?>
<?php include("include/functions.php"); ?>

<?php 

	if(isset($_POST['send_message'])){
		$sender_id=intval($_SESSION['user_id']);
		$project_id=$_SESSION['project_id'];
		$receiver_id=intval($_POST['receiver_id']);
		$sent_date=date('Y-m-d H:i:s');
		$subject=mysql_real_escape_string($_POST['subject']);
		$message=mysql_real_escape_string($_POST['message']);

		$sql="INSERT INTO project_mailbox_inbox (project_id,sender_id,receiver_id,subject,message,sent_date,read_date,is_deleted) VALUES ($project_id,$sender_id,$receiver_id,'$subject','$message','$sent_date','$read_date',0)"; //put into mailbox
		$result=mysql_query($sql) or die("MySQL ERROR: ".mysql_error());
		//echo $sql;	
		//send_message($sender_id,$receiver_id,$subject,$message,date);


		$sql1="INSERT INTO project_mailbox_outbox(project_id,receiver_id,sender_id,subject,message,sent_date) VALUES ($project_id,$receiver_id,$sender_id,'$subject','$message','$sent_date')"; // instert into sent messages
		$result1=mysql_query($sql1) or die("MySQL ERROR: ".mysql_error());
		
		$url="project_inbox.php?user_id=".$_SESSION['user_id'];
     	header('location:'.$url.'');
	}	

?>

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
	<?php 
		$project_id=$_SESSION['project_id'];
		$user_id=$_SESSION['user_id'];
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
		                $result=mysql_query($sql) or die("MySQL ERROR: ".mysql_error());
		                while ($row = mysql_fetch_array($result)) {
		                    $project_name=$row['project_name'];
		                    $project_description=$row['project_descr'];

		                    
		                    echo "<span style='float:left;font-weight:bold; font-size:26px; font-family: Helvetica, Arial,sans-serif;margin-left:10px'>$project_name<br></span>";   //boldovo
		                    echo "<span style='float:left;font-style:italic; font-size:12px; font-family: Helvetica, Arial,sans-serif;color:#ddd;margin-left:15px'>$project_description</span>"; //italikom
		                    

		                }

		                ?>
            	</div><!-- project title -->  

            <div class='inbox_wrap'>
            <div class='inbox_filter'><button type="submit" name='new_mail' class="blue-badge"><i class="fa fa-plus"></i> message</button></div>
            	<div class='inbox_menu'>
            		<ul>
            			<li><a href="project_inbox.php?user_id=<?php echo $user_id ?>&project_id=<?php echo $project_id ?>&folder=inbox"><i class="fa fa-inbox"></i> Inbox</a></li>
            			<li><a href="project_inbox.php?user_id=<?php echo $user_id ?>&project_id=<?php echo $project_id ?>&folder=sent"><i class="fa fa-envelope"></i> Sent</a></li>
            			<li><a href="project_inbox.php?user_id=<?php echo $user_id ?>&project_id=<?php echo $project_id ?>&folder=trash"><i class="fa fa-trash"></i> Trash</a></li>
            		</ul>
            	</div>
            	<div class="inbox">
            		<form action='project_inbox_new_message.php' method="post">
	            		<table id='new_mail'>
	            			<tr>
	            				<td>To:</td><td><div class="receiver">
	            									<?php 
	            									echo "<select name='receiver_id'>'";
	            									$sql="SELECT * from project_users";
	            									$result=mysql_query($sql) or die("MySQL ERROR: ".mysql_error());
	            									while ($row = mysql_fetch_array($result)) {
	            										$user_id=$row['user_id'];
	            										echo "<option value=$user_id>".GetUserNameById($user_id)."</option>";
	            									}
	            									echo "</select>";
													?>
	            								<div>
	            								

	            								</td>
	            			</tr>
	            			<tr>	
	            				<td>Subject:</td><td><input type="text" name="subject" value=""></td>
	            			</tr>
	            			<tr>
	            				<td colspan="2"><textarea name="message"></textarea></td>
	            			</tr>
	            			<tr>
	            				<td colspan="2"><button type="submit" name="send_message" class="blue-badge">Send</button></td>
	            			</tr>		
	            		</table>
            		</form>
            	</div>

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