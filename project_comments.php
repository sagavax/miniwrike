<? ob_start(); ?>
<?php include("include/dbconnect.php"); ?>
<?php include("include/functions.php"); ?>



<?php
            if (isset($_POST['add_comment'])) {

						$project_id=$_POST['project_id'];
						//$user_id=$_POST['user_id'];
						//$task_id=1;
						//$project_id = 1;
						$user_id = 1;
						$comment=mysql_real_escape_string($_POST['comment']);
						$date_added=(date('Y-m-d'));	
						$sql="INSERT INTO project_comments (project_id, user_id, comment, date_added) VALUES ($project_id, $user_id, '$comment', '$date_added')";
						
						//print_r($_POST);


						$result=mysql_query($sql) or die("MySQL ERROR: ".mysql_error());
						
					
						// ****************           pridenie do streamu	************************

						
						$sql="SELECT MAX(comment_id) as comment_id from project_comments where project_id=$project_id"; //ziskanie max comment id z tabulky
						
						$result=mysql_query($sql) or die("MySQL ERROR: ".mysql_error());
						while ($row = mysql_fetch_array($result)) {
									$comment_id=$row['comment_id'];
						}
						
														
						$user_name = GetUserNameById($user_id);
						$text_streamu = "User <a href='project_user_profile.php?id=$user_id'> ".$user_name."</a> has created a new comment id <a href='project_comments.php?project_id=$comment_id'>".$comment_id."</a>";
						$text_streamu=addslashes($text_streamu);
						$datum=date('Y-m-d H:m:s');
						$sql="INSERT INTO project_stream (project_id,user_id,text_of_stream, date_added) VALUES ($project_id,$user_id,'$text_streamu','$datum')";
						$result=mysql_query($sql) or die("MySQL ERROR: ".mysql_error());
						$project_id=$_POST['project_cislo'];
						
						
						header('Location: project_comments.php?project_id='.$_POST['project_id'].''); // presmeruje spat aby sa zbranilo vkladaniu duplicity					
						
						// ****************           pridenie do streamu	************************//
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
		    
		<!-- <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
		<script type="text/javascript" src="js/facebox.js"></script> -->
		<link href='http://fonts.googleapis.com/css?family=PT+Sans:400,700' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=Roboto:400,300,300italic,700,700italic,400italic' rel='stylesheet'>
		<link rel='shortcut icon' href='project.ico'>
				
	</head>
<body>

        <?php 
			
				$project_id=$_GET['project_id']; // projektove id	
				if (!isset($_GET['project_id']))
				$project_id=$_POST['project_id'];	
				
				$user_id=1;
				echo "project_id=$project_id";

			?>
         
		<div id="main">
			
			<!-- header -->
			
			<div id="header">miniwrike<div class="logged_user"><div class="circle"></div><div class="user">Tomas Misura</div></div></div>
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
			


            <div id="project_title"><!-- project title -->
               <?php

                $sql="SELECT * from projects where id=$project_id";
               	//echo "$sql";
				$result=mysql_query($sql) or die("MySQL ERROR: ".mysql_error());
                while ($row = mysql_fetch_array($result)) {
                    $project_name=$row['project_name'];
                    $project_description=$row['project_descr'];

                    //echo "<div id='project_short_details_wrap'>";
						echo "<span style='float:left;font-weight:bold; font-size:26px; font-family: Helvetica, Arial,sans-serif;margin-left:10px'>$project_name</span>";   //boldovo
						echo "<span style='float:left;font-style:italic; font-size:12px; font-family: Helvetica, Arial,sans-serif;color:#999;margin-left:15px'>$project_description</span>"; //italikom
                    //echo "</div>";

                }

                ?>
            </div><!-- project title -->
			
			<!--- middle section -->
			
			<div id="add_comment"> <!--- add comment -->
              		<span style="position:relative; float:left;margin-left: 5px">
						
					 <form accept-charset="utf-8" method="post" id="dev_notes" name="new_dev_note" action="project_comments.php?project_id=<?php echo $project_id; ?>">  
		                <input type="hidden" name="project_id" value="<?php echo $project_id; ?>">
						<!-- <input type="hidden" name="user" value="<?php echo $user_id; ?>">-->
						<tr>
		                    
		                    <td>
		                    		<input type='text' name='comment' value=""> 
		                    </td>
		                    <td>
		                    	<button type="submit" name="add_comment" class="blue-badge">Add comment </button>
		                    </td>	
		                    
		            </tr>
		            
		           </form> 
		         </span>
            </div> <!--- add comment -->
            
			<div id="middle"> <!-- middle section -->
        	
				<div id="project_comments_wrap">
				
					<?php 
						$sql="SELECT * from project_comments where project_id=$project_id ORDER BY comment_id DESC";
						$result=mysql_query($sql) or die("MySQL ERROR: ".mysql_error());
						while ($row = mysql_fetch_array($result)) {
							$comment_id=$row['comment_id'];
							$user_id=$row['user_id'];
							$project_id=$row['project_id'];
							$comment=$row['comment'];
							$date_added=$row['date_added'];
					
						echo "<div class='comment_post'>";
							echo "<div class='comment_user_picture'><img src='img/non-avatar_64.jpg' /></div>";
							echo "<div class='comment_body'>$comment</div>";
						echo "</div>";	
							
				
						}
						
					?>
				<div style="clear:both;"></div>
				</div><!-- project comment wrap -->	
				
         
            </div>
            <div style="clear:both;"></div>
            
						
			<!-- FOOTER -->
			
			<div id="footer">
				<ul id="footer-left">
					<li>Simple miniproject administrator/manager</li>
					<li>Created by Tomas Misura</li>
				</ul>		
			</div> <!-- FOOTER -->
			
		</div>
</body>
</html>