<?php session_start(); ?>
<?php include("include/dbconnect.php"); ?>
<?php include("include/functions.php"); ?>



<?php
            if (isset($_POST['add_new_comment'])) {
            			$comment=mysql_real_escape_string($_POST['comment']);
            			$project_id=$_POST['project_id'];

            			if ($comment==''){
            				header('Location: project_comments.php?project_id='.$_POST['project_id'].'');	
            			} else {
						
						$user_id = 1;
						
						$date_added=(date('Y-m-d'));	
						$sql="INSERT INTO project_comments (project_id, user_id, comment, date_added) VALUES ($project_id, $user_id, '$comment', '$date_added')";
						
						$result=mysql_query($sql) or die("MySQL ERROR: ".mysql_error());
						
					
						// ****************           pridenie do streamu	************************

						add_to_stream('new_comment',$project_id,$user_id);
											
						// ****************           pridenie do streamu	************************//


						header('Location: project_comments.php?project_id='.$_POST['project_id'].''); // presmeruje spat aby sa zbranilo vkladaniu duplicity					
				}		
						
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
	<div id="main">
			<?php
				$project_id=$_GET['project_id'];
				$project_id=$_SESSION['project_id'];			

			?>
			<!-- header -->
				<?php include ("include/header.php"); ?>
            <!-- header -->
            
           <?php include ("include/menu.php"); ?>
            <div id="middle"> <!-- middle section -->
            	<div id="project_title"><!-- project title -->
	               <?php

						$sql = "SELECT project_name, project_descr from projects where id=$project_id";
						//echo "$sql";
						$result = mysql_query($sql) or die("MySQL ERROR: " . mysql_error());
						while ($row = mysql_fetch_array($result)) {
						    $project_name        = $row['project_name'];
						    $project_description = $row['project_descr'];
						    
						    //echo "<div id='project_short_details_wrap'>";
						    echo "<span style='float:left;font-weight:bold; font-size:26px; font-family: Helvetica, Arial,sans-serif;margin-left:10px'>$project_name</span>"; //boldovo
						    echo "<span style='float:left;font-style:italic; font-size:12px; font-family: Helvetica, Arial,sans-serif;color:#999;margin-left:15px'>$project_description</span>"; //italikom
						    //echo "</div>";
						    
						}

	                ?>
            </div><!-- project title -->
			
			<!--- middle section -->
			
			<div id="add_project_comment">
				 <form accept-charset="utf-8" method="post" id="dev_notes" name="new_dev_note" action="project_comments.php?project_id=<?php echo $project_id; ?>">  
		                <input type="hidden" name="project_id" value="<?php echo $project_id; ?>">
						<!-- <input type="hidden" name="user" value="<?php echo $user_id; ?>">-->
						<tr>
		                    
		                    <td>
		                    		<input type='text' name='comment' autocomplete='off' value=""> 
		                    </td>
		                    <td>
		                    	<button type="submit" name="add_new_comment" class="blue-badge">+ Add</button>
		                    </td>	
		                    
		            </tr>
		            
		           </form> 
	
			</div> <!--- add comment -->
            
            
			<div id="middle"> <!-- middle section -->
        	
				<div id="project_comments_wrap">
				
					<?php 
						$sql="SELECT * from project_comments where project_id=$project_id ORDER BY comment_id DESC";
						//echo $sql;
						$result=mysql_query($sql) or die("MySQL ERROR: ".mysql_error());
						while ($row = mysql_fetch_array($result)) {
							$comment_id=$row['comment_id'];
							$user_id=$row['user_id'];
							$user_name=GetUserNameById($user_id);
							$project_id=$row['project_id'];
							$comment=$row['comment'];
							$date_added=$row['date_added'];
							$image="img/users_pics/".$user_id."/user_".$user_id."_32x32.jpg";

						echo "<div class='comment_post'>";
							echo "<div class='comment_user_picture'><img src='".$image."' alt='".$user_id."'></div>";
							echo "<div class='commented_by'><a href='project_user_profile.php?user_id=$user_id' class='link'>$user_name</a></div>";
							echo "<div class='comment_body'><a href='project_comment.php?comm_id=$comment_id&&project_id=$project_id&action=view'>$comment</a></div>
							<div class='comment_date'>".time_ago($date_added)."</div>
							<div class='comment_delete'><a href='project_comment.php?comm_id=$comment_id&project_id=$project_id&action=delete' class='link'><i class='fa fa-times'></i></a></div>";
						echo "</div>";	
							
				
						}
						
					?>
				<div style="clear:both;"></div>
				</div><!-- project comment wrap -->	
				
         
            </div>
            <div style="clear:both;"></div>
            </div><!-- div middle -->
            <div style="clear:both;"></div>
            
						
			<?php include ("include/footer.php"); ?>
			
		</div><!-- main -->	

</body>
<html>