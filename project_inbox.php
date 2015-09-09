<?php session_start(); ?>
<?php include("include/dbconnect.php"); ?>
<?php include("include/functions.php"); ?>

<?php 
	if(isset($_POST['new_mail'])){
		$url="project_inbox_new_message.php?sender_id=".$_SESSION['user_id'];
		header('location:'.$url.'');
	}

?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="sk" lang="sk">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
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
            <div class='inbox_filter'><form action='project_inbox.php' method="post"><button type="submit" name='new_mail' class="blue-badge"><i class="fa fa-plus"></i> Message</button></form></div>
            	<div class='inbox_menu'>
            		<ul>
            			<li><a href="project_inbox.php?user_id=<?php echo $user_id ?>&project_id=<?php echo $project_id ?>&folder=inbox"><i class="fa fa-inbox"></i> Inbox</a></li>
            			<li><a href="project_inbox.php?user_id=<?php echo $user_id ?>&project_id=<?php echo $project_id ?>&folder=sent"><i class="fa fa-envelope"></i> Sent</a></li>
            			<li><a href="project_inbox.php?user_id=<?php echo $user_id ?>&project_id=<?php echo $project_id ?>&folder=trash"><i class="fa fa-trash"></i> Trash</a></li>
            		</ul>
            	</div>
            	<div class="inbox">
            		<table id='mail_box'>
            			<?php
            				if(!isset($_GET['folder'])){ // chned ako sa nacita oprazovka
            						$folder='inbox';} // tak default folder je inbox
            						 else { //inac sa nacita ten folder ktory je nacitany
            							$folder=$_GET['folder'];
            							 }
            					if($folder=='inbox'){
            						$sql="SELECT sender_id,sent_date,subject,message,read_date from project_mailbox_inbox WHERE receiver_id=".$_SESSION['user_id']." ORDER BY sent_date DESC";
            						    $result=mysql_query($sql) or die("MySQL ERROR: ".mysql_error());	
		            					
            						    while ($row = mysql_fetch_array($result)) {
		            							$sender_name=GetUserNameById($row['sender_id']);
		            							$subject=substr($row['subject'],0,30);
		            							$sent_date=$row['sent_date'];
		            							$read_date=$row['read_date'];
		            							$fl=substr($sender_name,0,1);
		            							$message=substr($row['message'],0,50);
		            							//echo "$read_date";
		            							

		            						echo "<a style='display:block' href='project_inbox.php?m_id='><div class='message'>";
		            							echo "<div class='fl'>$fl</div>";
		            							if($read_date<>'0000-00-00 00:00:00') {// sprava nie je precitana
		            								echo "<div class='message_receiver'>$sender_name</div><div class='message_subject'>$subject</div";
		            							} else {echo "<div class='message_receiver'><b>$sender_name</b></div><div class='message_subject'><b>$subject</b></div>";}	
		            							echo "<div class='message_text'>$message</div><div class='message_trash'><i class='fa fa-trash'></i></div>";	
		            						echo "</div></a>"; // message	
		            					} //end while	

		            					} elseif ($folder=='sent'){
		            						$sql="SELECT * from project_mailbox_outbox WHERE sender_id=".$_SESSION['user_id']." ORDER BY sent_date DESC";
		            						$result=mysql_query($sql) or die("MySQL ERROR: ".mysql_error());
		            						while ($row = mysql_fetch_array($result)) {
		            							$receiver_name=GetUserNameById($row['receiver_id']);
		            							$subject=substr($row['subject'],0,30);
		            							$sent_date=$row['sent_date'];
		            							$fl=substr($receiver_name,0,1);

		            						echo "<a style='display:block' href='project_inbox.php?m_id='><div class='message'>";
		            							echo "<div class='fl'>$fl</div><div class='message_receiver'>$receiver_name</div><div class='message_subject'>$subject</div><div class='sent_date'>$sent_date</div><div class='message_trash'><i class='fa fa-trash'></i></div>";	
		            						echo "</div></a>"; // message	
		            						}

            					} elseif ($folder=='trash') {
            						$sql="SELECT * from project_mailbox_inbox WHERE receiver_id=".$_SESSION['user_id']." and is_deleted=1";
            						$result=mysql_query($sql) or die("MySQL ERROR: ".mysql_error());
            						$num=mysql_num_rows($result);
            							if($num==0){
            								echo "No messages in trash";
            							}
            						
            						
            					}
            				
            				
            				
            			?>
            		</table>

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