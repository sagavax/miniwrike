<?php session_start();?>
<?php include("include/dbconnect.php"); ?>
<?php include("include/functions.php"); ?>



<?php
            if (isset($_POST['add_task_comment'])) { //pridanie komentu

				$project_id=$_POST['project_cislo'];
				//$user_id=$_POST['user_id'];
				$task_id=$_POST['task_id'];
				$user_id = 1;
				$user_name = GetUserNameById($user_id);
				$comment=mysql_real_escape_string($_POST['task_comment']);
				$date_added=date('Y-m-d H:m:s');	
				
				$sql="INSERT INTO project_task_comments (task_id,project_id, user_id, post_text, date_added) VALUES ($task_id,$project_id, $user_id, '$comment', '$date_addded')";
				////echo "$sql";
				$result=mysql_query($sql) or die("MySQL ERROR: ".mysql_error());
						
				//ziskanie max task id z tabulky
				$sql="SELECT MAX(id) as task_comment_id from project_task_comments where project_id=$project_id and task_id=$task_id";
				$result=mysql_query($sql) or die("MySQL ERROR: ".mysql_error());
				while ($row = mysql_fetch_array($result)) {
					$task_comment_id=$row['task_comment_id'];
				}
							
				//pridenie do streamu
				$text_streamu = "User <a href='project_user_profile.php?id=$user_id'> ".$user_name."</a> has created a new comment id ".$task_comment_id."of task id = <a href='project_task_details.php?task_id=$task_id'>".$task_id."</a>";
				$text_streamu=mysql_real_escape_string($text_streamu);
				$datum = date('Y-m-d H:m:s');
				$sql="INSERT INTO project_stream (project_id,user_id,text_of_stream, date_added) VALUES ($project_id,$user_id,'$text_streamu', '$datum')";
				$result=mysql_query($sql) or die("MySQL ERROR: ".mysql_error()); 
				
				
				header('Location: project_task_details.php?task_id='.$_POST['task_id'].'&project_id='.$_POST['project_id'].''); // presmeruje spat aby sa zbranilo vkladaniu duplicity*/
                    
			}	
			
			if (isset($_POST['add_task_subtask'])) {//pridanie subtasku
				$task_id=$_POST['task_id'];
				$project_id = $_POST['project_number'];
				$user_id = $_POST['user_id'];
				$subtask_name=mysql_real_escape_string($_POST['subtask_name']);
				$date_added=date('Y-m-d H:m:s');
				$subtask_deadline=strtotime(date('Y-m-d', strtotime($curr_date)) . " +5 day");
                $end_date= date('Y-m-d', $date);	
				
				$sql="INSERT INTO project_task_subtasks (task_id, project_id, user_id, task_description,status, priority, task_created, task_finished, task_deadline) VALUES ($task_id,$project_id, $user_id,'$subtask_name', 'new','normal','$date_added','','$subtask_deadline')";
				$result=mysql_query($sql) or die("MySQL ERROR: ".mysql_error());
				//echo "$project_id";
				//print_r( $_POST );
				header('Location: project_task_details.php?task_id='.$_POST['task_id'].'&project_id='.$_POST['project_id'].'');
				
				
				//pridenie do streamu
				
				//ziskanie max task id z tabulky
				$sql="SELECT MAX(subtask_id) as subtask_id from project_task_subtasks where project_id=$project_id and task_id=$task_id";
				$result=mysql_query($sql) or die("MySQL ERROR: ".mysql_error());
				while ($row = mysql_fetch_array($result)) {
					$subtask_id=$row['subtask_id'];
				}
					
					
				
				$text_streamu = "User ".$user_id." has created a new subtask id ".$sutask_id." of task id = ".$task_id;
				$datum=date('Y-m-d H:m:s');
				$sql="INSERT INTO project_stream (project_id,user_id,text_of_stream, date_added) VALUES ($project_id,$user_id,'$text_streamu',$datum)";
				$result=mysql_query($sql) or die("MySQL ERROR: ".mysql_error());
												
				header('Location: project_task_details.php?task_id='.$_POST['task_id'].'&project_id='.$_POST['project_id'].'');
			}  
			
			if(isset($_POST['add_quick_note'])) { // rychla poznamka
				$project_id=$_POST['project_id'];
				//$user_id=$_POST['user_id'];
				$task_id=$_POST['task_id'];
				$user_id = 1;
				$curr_date=date('Y-m-d H:m:s');
				$quick_note=mysql_real_escape_string($_POST['quick_note']);
				$sql="INSERT INTO project_task_quick_notes (task_id, project_id, user_id,date_added,post_text) VALUES ($task_id, $project_id, $user_id, '$curr_date', '$quick_note')";
				
				$result=mysql_query($sql) or die("MySQL ERROR: ".mysql_error());
			
			
				//ziskanie max task id z tabulky
				$sql="SELECT MAX(id) from project_task_quick_notes where project_id=$project_id and task_id=$task_id";
				$result=mysql_query($sql) or die("MySQL ERROR: ".mysql_error());
				while ($row = mysql_fetch_array($result)) {
					$quick_note_id=$row['id'];
				}
				
				//pridenie do streamu
				$user_name = GetUserNameById($user_id);
				$text_streamu = "User ".$user_name." has created a new quick_note id ".$quick_note_id." of task id = ".$task_id;
				$text_streamu=addslashes($text_streamu);
				$date_added=date('Y-m-d H:i:s');
				$sql="INSERT INTO project_stream (project_id,user_id,text_of_stream, date_added) VALUES ($project_id,$user_id,'$text_streamu','$date_added')";
				$result=mysql_query($sql) or die("MySQL ERROR: ".mysql_error());
					
				
				//header('Location: project_task_details.php?task_id='.$_POST['task_id'].'&project_id='.$_POST['project_id'].'');
			
			
			}
			
			if(isset($_POST['upload_file'])) { // uploadujem file
			
			
				$sql="";
				$result=mysql_query($sql) or die("MySQL ERROR: ".mysql_error());
				
				
				$text_streamu = "User ".$user_id." has attached a new file ".$file_name." to task id = ".$task_id;
				$sql="INSERT INTO project_stream (project_id,user_id,text_of_stream, date_added) VALUES ($project_id,$user_id,'$text_streamu',date('Y-m-d H:i:s'))";
				//$result=mysql_query($sql) or die("MySQL ERROR: ".mysql_error());
								
				//header('Location: project_task_details.php?task_id='.$_POST['task_id'].'&project_id='.$_POST['project_id'].''); // presmeruje spat aby sa zbranilo vkladaniu duplicity
			
			}
			
			if (isset($_POST['assign_the_task'])) { //priradim userovi task, od tej doby sa bude pocitat ucast agenta na projecte

				$project_id=$_POST['project_id'];
				$task_id=$_POST['task_id'];
				$user_name=$_POST['users'];
				$user_id=GetUserIdbyname($user_name);	
				$user_email=GetUserEmailbyname($user_name);
				$assigned_by=$_POST['user_id'];
				$assigned_date=date('Y-m-d H:i:s');
				//print_r($_POST);
				
				$sql="INSERT INTO project_task_assigned_people (task_id, project_id, user_id, email, assigned_by, assigned_date) VALUES ($task_id, $project_id, $user_id,'$user_email',$assigned_by,'$assigned_date')";
				echo "$sql";
				$result=mysql_query($sql) or die("MySQL ERROR: ".mysql_error());
				
				header('Location: project_task_details.php?task_id='.$_POST['task_id'].'&project_id='.$_POST['project_id'].'&user_id='.$_POST['user_id'].''); // presmeruje spat aby sa zbranilo vkladaniu duplicity
				
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
		<!--<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
		<script type="text/javascript" src="js/facebox.js"></script> -->
		<link href='http://fonts.googleapis.com/css?family=PT+Sans:400,700' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=Roboto:400,300,300italic,700,700italic,400italic' rel='stylesheet' type='text/css'>
		<link rel='shortcut icon' href='project.ico'>
				
	</head>
<body>

        <?php 
			$project_id=$_SESSION['project_id'];
			//echo "session=$project_id<br>";
			$task_id=$_GET['task_id'];
			echo "task_id=$task_id";
			if (!isset($_GET ['project_id'])) {$project_id = $_POST['project_id'];}
			echo "project_id=$project_id";
			$user_id = $_GET['user_id'];
					
			
		?>
         
		<div id="main">
			
			<!-- header -->
			
			<div id="header">miniwrike - project comments</div>
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
			
			<!-- header -->
			
			<!--- middle section -->
			
			
			<div id="project_title"><!-- project title -->
               <?php

                $sql="SELECT * from projects where id=$project_id";
                //echo "$sql";
                //echo "project_id=$project_id";
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
			
            
			<div id="middle"> <!-- middle section -->
        	
			<?php

                            $sql="SELECT *, ABS(DATEDIFF(task_created,  now() ) ) AS duration from project_tasks WHERE task_id=$task_id";
                            //echo "$sql"; TIMESTAMPDIFF(MONTH,'{$start_time_str}','{$end_time_str}') AS m
                            $result=mysql_query($sql) or die("MySQL ERROR: ".mysql_error());
                            while ($row = mysql_fetch_array($result)) {
                                    $task_description=$row['colNoteText'];
                                    $status=$row['status'];
									$task_priority=$row['task_priority'];
                                    $date_created=$row['task_created'];
                                    $date_finished=$row['task_finished'];
                                    $deadline = $row['task_deadline'];
                                    $priority=$row['priority'];
                                    $duration=$row['duration'];
                                    $is_completed=$row['is_completed'];

                                    //$duration1=DATEDIFF($date_created,date('Y-m-d'));

                                    $dStart = strtotime($date_created);
									$dEnd = strtotime(date('Y-m-d'));
									$dDiff = $dEnd - $dStart;
									$duration=date('j',$dDiff);
                                    //echo "duration=".date('j',$dDiff);
                                    //echo "duration=$duration";
                         
	                            $diff = strtotime($date_finished)-strtotime($date_created);
                                $diff = date('m/d/Y', 1299446702);
                                		if ($date_finished = '0000-00-00 00:00:00') {$date_finished='N/A';}

                                //$years = floor($diff / (365*60*60*24));
                                //$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
                                //$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
                            }
                        ?>	
			  	
			
			  <div id="project_task_title">
				
					<?php echo "<span style='margin-left:10px'>$task_description</span>" ?>
				
			  </div>	
			
              <div id="project_task_details_dashboard"><!-- project_task_details_dashboard -->
					
					<h3>Dashboard</h3>
					
						<div id="info_box_wrap" style="width:100%;float:left; min-height:250px">
							<div class="info_box">
								<span class="info_box_title">Task status</span>
								<span class="info_box_value"><?php echo $status ?></span>
							</div>
							<div class="info_box">
								<span class="info_box_title">Priority</span>
								<span class="info_box_value"><?php echo $task_priority ?></span>
							</div>
							<div class="info_box">
								<span class="info_box_title">Date created:</span>
								<span class="info_box_value"><?php echo $date_created ?>
							</div>
							<div class="info_box">
								<span class="info_box_title">Date finished:</span>
								<span class="info_box_value"><?php echo $date_finished ?>
							</div>
							<div class="info_box">
								<span class="info_box_title">Planned deadline:</span>
								<span class="info_box_value"><?php echo $deadline ?>	
						   	</div>
							<div class="info_box">
								<span class="info_box_title">Total duration:</span>
								<span class="info_box_value"><?php echo $duration ?>	
						   
							</div>
							<div class="info_box">
								<span class="info_box_title">Mark as completed:</span>
								<span class="info_box_value"><?php echo "<input type='checkbox' value=$is_completed ?>"; ?></span>
						   
							</div>
						</div> <!--info box wrap -->
						<div style="width:100%;height:40px; line-height:40px;margin-bottom:0px;float:left">
							<span style="float:right;margin-right:5px"><button class="blue-badge-large" type="submit" name="update_statuses">Update</button></span>
						</div>
					
					<div style="clear:both"></div>   
				</div><!-- project_task_details_dashboard -->

				
				<div id="project_task_details_comments"> <!-- vsetky taskove komentare  + moznost pridat novy komentar-->
						
					<h3>Task comments</h3>
					
					<div id="task_commnets_wrap"><!--task_comments_wrap -->
						<ul>
						<?php
								
							// get all previous task comments
								
							$sql="SELECT * from project_task_comments WHERE task_id=$task_id";
							//echo "$sql";
								
							// in addition get information from use based on user_id
								
							$result=mysql_query($sql) or die("MySQL ERROR: ".mysql_error());
							$numrows= mysql_num_rows($result);
								
							if ($numrows==0) {echo "<span style='font-style:italic; font-size:12px; font-family:'Roboto', Helvetica, Arial,sans-serif;color:#ddd;margin-left:10px; margin-top:10px'>No task comments available</span>";} else {
								
								while ($row = mysql_fetch_array($result)) {
									$id=$row['id'];
									$user_id=$row['user_id'];
									$date_added=$row['date_added'];
									$post_text=$row['post_text'];
									
									$image="img/non-avatar_32.jpg";
									
									echo "<li>"; //project_task_comments
										
										echo "<div class='project_task_post_wrap'>
													<div class='project_task_user_image'><img src='".$image."' alt='".$user_id."'></div>
													<div class='project_task_post'>$post_text</div>";
										echo "</div>";
									echo "</li>";	
								}
							}
							?>
						</ul>	
						
					</div><!--task_comments_wrap -->
						
					
					<form action="project_task_details.php?project_id=<?php echo $project_id; ?>&task_id=<?php echo $task_id; ?>" method="post">
						<table>
							<input type="hidden" name="project_cislo" value="<?php echo $project_id; ?>">
							<input type="hidden" name="task_id" value="<?php echo $task_id ?>"/>
							<input type="hidden" name="user_id" value="<?php echo $user_id ?>" />
							
							<tr>	
								<td><input name="task_comment" type="text" value=""><button type="submit" class="blue-badge" name="add_task_comment" alt="Add task comment">+</button></td>
							</tr>		
					
						</table>
					</form>
				
				</div> <!-- vsetky taskove komentare  + moznost pridat novy komentar-->

				<div id="project_task_subtasks"> <!-- vsetky taskove komentare  + moznost pridat novy komentar-->

					<h3>Subtasks:</h3>

					
					<div id="task_subtasks_wrap"> <!--subtask wrap -->
						<ul>
						
							<?php

							//get all subtasks
							$sql="SELECT * from project_task_subtasks WHERE task_id=$task_id";
							//echo "$sql";

							// in addition get information from use based on user_id

							$result=mysql_query($sql) or die("MySQL ERROR: ".mysql_error());
							$numrows= mysql_num_rows($result);

							if ($numrows==0) {echo "<span style='font-style:italic; font-size:12px; font-family:'Roboto', Helvetica, Arial,sans-serif;color:#ddd;margin-left:10px; margin-top:10px'>No subtasks available</span>";} else {

								while ($row = mysql_fetch_array($result)) {
									
									$subtask_id=$row['subtask_id'];
									$user_id=$row['user_id'];
									$task_created=$row['task_created'];
									$task_deadline=$row['task_deadline'];
									$post_text=$row['task_description'];

									$dStart = strtotime($task_created);
									$dEnd = strtotime(date('Y-m-d'));
									$dDiff = $dEnd - $dStart;
									$duration=date('j',$dDiff);
                                    

									echo "<li>"; //project_task_comments
										echo "<div class='project_subtask_post'><span class='subtask_title'><a href='project_task_subtask_details.php?subtask_id=$subtask_id&project_id=$project_id&task_id=$task_id'>$post_text</a><span class='subtask_date'>$task_created</span><span class='subtask_duration'>$duration</span></div>";
									echo "</li>";
								}
							}
							?>
							
						</ul>
					</div> <!--subtask wrap -->
					
					
					<form action="project_task_details.php?task_id=<?php echo $task_id; ?>" method="post">
						<table>
							<input type="hidden" name="project_number" value="<?php echo $project_id; ?>" />
							<input type="hidden" name="task_id" value="<?php echo $task_id; ?>" />
							<input type="hidden" name="user_id" value="<?php echo $user_id; ?>" />
	
							<tr>
								<td><input name="subtask_name" type="text" value=""><button type="submit" class="blue-badge" name="add_task_subtask" alt="Add subtask">+</button></td> <!-- subtask button -->
							</tr>

						</table>
					</form>

				</div> <!-- vsetky taskove komentare  + moznost pridat novy komentar-->

					
				<div id="project_task_details_attachements"> <!--project_task_details_attachements -->	
						<h3>Attachements:</h3>
						<!--- formular na upload -->
						<div id="project_task_details_filelist">
							
							<?php
									$sql="SELECT * from project_task_attachements WHERE task_id=$task_id";
									//echo "$sql";
									$result=mysql_query($sql) or die("MySQL ERROR: ".mysql_error());
									$numrows= mysql_num_rows($result);
									
									if ($numrows==0) {echo "<span style='font-style:italic; font-size:12px; font-family:'Roboto', Helvetica, Arial,sans-serif;color:#ddd;margin-left:10px; margin-top:10px'>No attachements available</span>";} else {
								
								while ($row = mysql_fetch_array($result)) {
									
									$id=$row['id'];
									$user_id=$row['$user_id'];
									$path=$row['path'];
									$file_name=$row['file_name'];
									$file_type=$row['file_type'];
									$date_added=$row['date_added'];
									$image="img/non-avatar_32.jpg";

									
									 echo "<li>"; //project_task_comments
											echo "<div class='project_subtask_post'><div class='project_task_user_image'><img src='".$image."' alt='".$user_id."'></div>
                                                        							<div class='project_task_post'>$file_name, $date_added</div></div>";
										echo "</li>";

								}
							
                              }
							?>	
							
						</div>
						<div id="project_task_details_upload_form">
							<form action="project_task_details.php?project_id=<?php echo $project_id; ?>&task_id=<?php echo $task_id; ?>" method="post">
								<table width="500" border="0" align="left" cellpadding="0" cellspacing="0">
								   	<tr>
								   		<td>File: </td><td><input size="25" name="file" type="file" style="font-family:'Roboto',Verdana, Arial, Helvetica, sans-serif; font-size:10pt"/><td><input type="submit" id="mybut" name="upload_file" value="Upload" name="Submit"/></td>
								        </td>
									</tr>
								</table>
							</form>
						</div>	
				
				</div><!--project_task_details_attachements -->	
				<div style="clear:both;"></div>
				
				<div id="project_task_details_quick_notes"> <!--project_task_quick_notes -->	
				
					<h3>Quick notes:</h3>
					
					<form action="project_task_details.php?project_id=<?php echo $project_id; ?>&task_id=<?php echo $task_id; ?>" method="post">
						<table>
							<input type="hidden" name="project_id" value="<?php echo $project_id; ?>" />
							<input type="hidden" name="task_id" value="<?php echo $task_id; ?>" />
							<input type="hidden" name="user_id" value="<?php echo $user_id; ?>" />
								
								
							<?php
								
                                // get all previous task comments

                                $sql="SELECT * from project_task_quick_notes WHERE task_id=$task_id";
                                //echo "$sql";
                                // in addition get information from use based on user_id

                                $result=mysql_query($sql) or die("MySQL ERROR: ".mysql_error());
                                $numrows= mysql_num_rows($result);

                                if ($numrows==0) {echo "<span style='font-style:italic; font-size:12px; font-family:'Roboto', Helvetica, Arial,sans-serif;color:#ddd;margin-left:10px; margin-top:10px'>No task comments available</span>";} else { //ak existuju nejake poznamky tak ich vypis

                                    while ($row = mysql_fetch_array($result)) {
                                        $id=$row['id'];
                                        $user_id=$row['user_id'];
                                        $date_added=$row['date_added'];
                                        $post_text=$row['post_text'];

                                        echo "<tr>"; //project_task_comments
                                            echo "<td><div class='project_task_quick_note_wrap'>
                                                        <div class='project_task_user_image'><img src='".$image."' alt='".$user_id."'></div>
                                                        <div class='project_task_post'>$post_text</div></div></td>";
                                        echo "</tr>";//project_task_comments
                                    }
                                }
							?>
							<tr>	
								<td><input type="text" name="quick_note" value=""><button type="submit" class="blue-badge" name="add_quick_note" alt="Add quick note">+</button></td>
							</tr>			
					
						</table>
					</form>
				
				</div> <!--project_task_quick_notes -->
				
				<!--                                             PROJECT ASSIGNED PERSON  -->		

				<div id="project_task_assigned_person"> <!--project_assigned_person -->	
				
					<h3>Task assigned to person:</h3>
					
					<form action="project_task_details.php?project_id=<?php echo $project_id; ?>&task_id=<?php echo $task_id; ?>" method="post">
						<table>
							<input type="hidden" name="project_id" value="<?php echo $project_id; ?>" />
							<input type="hidden" name="task_id" value="<?php echo $task_id; ?>" />
							<input type="hidden" name="user_id" value="<?php echo $user_id; ?>" />
							<ul>	
								
							<?php
								
                                // get all previous task comments

                                $sql="SELECT *,ABS(DATEDIFF(assigned_date,  now() ) ) AS duration from project_task_assigned_people WHERE task_id=$task_id";
                                //echo "$sql";
                                // in addition get information from use based on user_id

                                $result=mysql_query($sql) or die("MySQL ERROR: ".mysql_error());
								$numrows= mysql_num_rows($result);

                                if ($numrows==0) {echo "<span style='font-style:italic; font-size:12px; font-family: Helvetica, Arial,sans-serif;color:#ccc;margin-left:10px; margin-top:10px'>No ppl assigned to this task</span>";} else { //ak existuju nejake poznamky tak ich vypis

                                    while ($row = mysql_fetch_array($result)) {
                                        $id=$row['id'];
                                        $user_id=$row['user_id'];
                                        $user_name=GetUserNameById($user_id);
										$email=$row['email'];
										$assigned_date=$row['assigned_date'];
                                        $image="img/non-avatar_32.jpg";
										$duration=$row['duration'];

                                        echo "<li>"; //project_task_comments
											echo "<div class='project_assigned_ppl_post'><div class='project_assigned_ppl_image'><img src='".$image."' alt='".$user_id."'></div>
                                                 							<div class='project_assigned_ppl_post_body'><span class='project_assigned_ppl_name'><a href='project_user_profile.php?user_id=$user_id'>$user_name</a></span><span class='assigned_date'>$assigned_date</span><span class='project_assigned_ppl_duration'>$duration days</span><span class='project_assigned_ppl_button'><button type='submit' class='blue-badge' name='remove_from_project' alt='Remove user from the project'><i class='icon-remove'></i></button></span></div></div>";
										echo "</li>";
                                        
                                    }
                                } 
							?>
							</ul>
							<tr>	
								<td><input list="users" name="users" value="">
										 <datalist id="users">
											

											<?php 
												$sql="SELECT * from project_task_assigned_people WHERE project_id=$project_id"; //budem vyberat iba z ludi, ktory su do tohto projektu priradeni
												$result=mysql_query($sql) or die("MySQL ERROR: ".mysql_error());
												while ($row = mysql_fetch_array($result)) {
													$full_name=$row['full_name'];
													
													echo "<option value='$full_name'>";
												}
											?>
										 
										 </datalist><button type="submit" name="assign_the_task" alt="Assign the user this task" class="blue-badge">+</button></td>
							</tr>			
					
						</table>
					</form>
				
				</div> <!--project_task_quick_notes -->

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
</html>