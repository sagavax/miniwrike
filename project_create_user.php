<?php include("include/dbconnect.php"); ?>
<?php include("include/functions.php"); ?>

<?php 

	if (isset($_POST['create_new_user'])) { //vytvori noveho uzivatela
		$project_id=$_POST['project_id'];
		

		$project_eng_fullname=$_POST['project_eng_fullname'];
		$project_eng_email=addslashes($_POST['project_eng_email']);
		$project_eng_phone=$_POST['project_eng_phone'];
		$project_eng_login=$_POST['project_eng_login'];
		$pass_temp=$_POST['project_eng_pass'];
		$project_eng_pass=md5('$pass_temp');
		$project_eng_note=addslashes($_POST['project_eng_note']);
		$created_date=date("Y:m:d H:m:s");
	
			
		$sql="INSERT INTO project_users (full_name, login, password, email, phone, created_date) VALUES ('$project_eng_fullname','$project_eng_login','$project_eng_pass','$project_eng_email','$project_eng_phone','$created_date')";
		$result=mysql_query($sql) or die("MySQL ERROR: ".mysql_error());
		
		//posli email dotycnemu
		
		
		/* $emailTo = 'youremailhere@googlemail.com'; 
        $subject = 'Submitted message from '.$name; 
        $sendCopy = trim($_POST['sendCopy']); 
        $body = "Name: $name \n\nEmail: $email \n\nComments: $comments"; 
        $headers = 'From: ' .' <'.$emailTo.'>' . "\r\n" . 'Reply-To: ' . $email;  
  
        mail($emailTo, $subject, $body, $headers);  
          
        // set our boolean completion value to TRUE  
        $emailSent = true;  */
		
		
		/*$emailTo = '$project_eng_email'; 
        $subject = 'New project user has been created!'; 
        $sendCopy = trim($_POST['sendCopy']); 
        $body = "This is to inform you that a new project user <b>$project_eng_login</b> has been created has been created \n\n with the password: $pass_temp \n\n"; 
        $headers = 'From: ' .' <'.$emailTo.'>' . "\r\n" . 'Reply-To: ' . $email;  */
  
        /* mail($emailTo, $subject, $body, $headers);  */
          
        // set our boolean completion value to TRUE  
        /* $emailSent = true;  */
		
			
		//header('Location: project_details.php?project_id=$project_id');
		header('Location: project_details.php?project_id='.$_POST['project_id'].'');
	}

?>

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
		<link href='http://fonts.googleapis.com/css?family=Roboto:400,300,300italic,700,700italic,400italic' rel='stylesheet' type='text/css'>
		<link rel='shortcut icon' href='project.ico'>
		

		   
	</head>
<body>

	<?php 
				
				$project_id= $_GET['project_id']; // projetove id			
				echo "project=$project_id";
				
			?>

	

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
            	<div id="project_title"><!-- project title -->
		            <?php

		                $sql="SELECT * from projects where id=$project_id";
		                $result=mysql_query($sql) or die("MySQL ERROR: ".mysql_error());
		                while ($row = mysql_fetch_array($result)) {
		                    $project_name=$row['project_name'];
		                    $project_description=$row['project_descr'];

		                    //echo "<div id='project_short_details_wrap'>";
								echo "<span style='float:left;font-weight:bold; font-size:26px; font-family:Roboto, Helvetica, Arial,sans-serif;margin-left:10px'>$project_name<br></span>";   //boldovo
								echo "<span style='float:left;font-style:italic; font-size:12px; font-family:Roboto,Helvetica, Arial,sans-serif;color:#999;margin-left:15px'>$project_description</span>"; //italikom
		                    //echo "</div>";

		                }

		            ?>
			   </div><!-- project title -->
	
            	
            	<form action="project_create_user.php" method="post" name="create_project_user_form">
            		<table>
            			<input type="hidden" name="project_id" value="<?php echo $project_id ?>">
            			<tr>
            				<td>Full name:</td><td><input name="project_eng_fullname" type="text" value=""></td>
            			</tr>
            			<tr>
            				<td>Email:</td><td><input name="project_eng_email" type="text" value=""></td>
            			</tr>
            			<tr>
            				<td>Phone:</td><td><input name="project_eng_phone" type="text" value=""></td>
            			</tr>
            			<tr>
            				<td>Login:</td><td><input name="project_eng_login" type="text" value=""></td>
            			</tr>
            			<tr>
            				<td>Password:</td><td><input name="project_eng_pass" type="password" value=""></td>
            			</tr>
            			<tr>
            				<td>Confirm password:</td><td><input name="project_eng_pass_conf" type="password" value=""></td>
            			</tr>
            			<tr>
            				<td>Note:</td><td><textarea name="project_eng_note"></textarea></td>
            			</tr>
            			<tr>
            				<td colspan="2"><button class="blue-badge" name="create_new_user">Create user</button></td>
            			</tr>
            		</table>
            	</form>					
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