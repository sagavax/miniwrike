<?php
include "include/dbconnect.php";
include "include/functions.php";
session_start();

?>


<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="sk" lang="sk">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
		<title>Miniwrike - simple project task manager</title>
		<link href="css/style.css?<?php echo time(); ?>" rel="stylesheet" type="text/css" />
		<link href="css/task.css?<?php echo time(); ?>" rel="stylesheet" type="text/css" />
		<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" rel="stylesheet" type="text/css" />
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
	   <script src="js/task.js" defer></script>
	   <script src="js/clock.js"></script>
	   <script type="text/javascript" src="js/clock.js" defer></script>
      <link href='http://fonts.googleapis.com/css?family=PT+Sans:400,700' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=Roboto:400,300,300italic,700,700italic,400italic' rel='stylesheet' type='text/css'>

		<link rel='shortcut icon' href='project.ico'>

	</head>
<body>

<div id="main">
   <!-- header -->
        <?php 
        		  include "include/header.php";
        		  include "include/menu.php";

        			$project_id = $_SESSION['project_id'];
					$task_id = $_GET['task_id'];
					echo "<script>localStorage.setItem('task_id',$task_id)</script>";
					$user_id = $_SESSION['user_id'];
			?>


			 <?php echo ProjectTitle($project_id); ?>


			   <!-- project title -->
			   <div id="middle">
			     			      <!-- middle section -->
			      <?php
				
						// Select task details from database based on task_id
						$get_task_details = "SELECT * FROM project_tasks WHERE task_id=$task_id";
						$result = mysqli_query($db, $get_task_details) or die("MySQL ERROR: " . mysqli_error($db));

						while ($row = mysqli_fetch_array($result)) {
						    $task_name = $row['task_name'];
						    $status = $row['task_status'];
						    $task_priority = $row['task_priority'];
						    $date_created = $row['task_created'];
						    $date_finished = $row['task_finished'];
						    $deadline = $row['task_deadline'];
						    $task_description = $row['task_description'];
						    $project_id = $row['project_id'];

						    						    // Calculate duration between task_created and task_finished
						    if ($date_finished == '0000-00-00') {
						        $date_finished = 'N/A';

						        // Calculate duration from task_created to current date
						        
						        $sql_duration = "SELECT ABS(DATEDIFF(task_created, NOW())) AS DiffDate FROM project_tasks WHERE task_id=$task_id";
						        $result_duration = mysqli_query($db, $sql_duration) or die("MySQL ERROR: " . mysqli_error($db));

						        while ($row_duration = mysqli_fetch_array($result_duration)) {
						            $duration = $row_duration['DiffDate'];
						        }
						    } else {
						        // Calculate duration from task_created to task_finished
						      
						        $sql_duration = "SELECT ABS(DATEDIFF(task_created, task_finished)) AS DiffDate FROM project_tasks WHERE task_id=$task_id";
						        $result_duration = mysqli_query($db, $sql_duration) or die("MySQL ERROR: " . mysqli_error($db));

						        while ($row_duration = mysqli_fetch_array($result_duration)) {
						            $duration = $row_duration['DiffDate'];
						        }
						    }
						}

						// Example formatting of $diff variable calculation (not directly used in your current logic)
						$diff = strtotime($date_finished) - strtotime($date_created);
						$diff = date('m/d/Y', 1299446702); // Example, not sure of the intended usage

					?>
      <div class="project_task_title">
         <?php echo "$task_name" ?>
      </div>
      <div id="project_task_details_dashboard">
         <!-- project_task_details_dashboard -->
         <h3>Dashboard</h3>
         <div id="info_box_wrap">
            <div class="info_box">
               <div class="info_box_title">Task status</div>
               <div class="info_box_value">
                     <?php
								//echo "status=".$status;
								if ($status == 'finished') {
									echo "<select name='task_status' disabled>";
								} elseif ($status == 'cancelled') {
									echo "<select name='task_status' disabled>";
								} else {echo "<select name='task_status'>";}

								?>
                     <!-- <select name="task_status">-->
                     <option value="<?php echo $status; ?>" selected="selected"><?php echo $status; ?></option>
                     ";
                     <option value="new">new</option>
                     <option value="in progress">in progress</option>
                     <option value="pending">pending</option>
                     <option value="finished">finished</option>
                     <option value="cancelled">cancelled</option>
                     </select>
                </div>
            </div>
            <div class="info_box">
                  <div class="info_box_title">Priority</div>
                  <div class="info_box_value">
                     <?php
								if ($status == 'finished') {
									echo "<select name='task_priority' disabled>";
								} elseif ($status == 'cancelled') {
									echo "<select name='task_priority' disabled>";
								} else {echo "<select name='task_priority'>";}
								?>
                     <option value="<?php echo $task_priority; ?>" selected="selected"><?php echo $task_priority; ?></option>
                     <option value="low">low</option>
                     <option value="normal">normal</option>
                     <option value="high">high</option>
                     </select>
                  </div>
            </div>
            
            <div class="info_box">
                  <div class="info_box_title">Date created:</div>
                  <div class="info_box_value"><?php echo $date_created ?></div>
            </div>
            
            <div class="info_box">
                  <div class="info_box_title">Date finished:</div>
                  <div class="info_box_value"><?php echo $date_finished ?></div>
            </div>
            
            <div class="info_box">
                  <div class="info_box_title">Planned deadline:</div>
                 <!--  <div class="info_box_value"><?php echo $deadline ?><input type="date" name='task_deadline'> <i class="fa fa-calendar"></i></div> -->
                  <div class="info_box_value"><input type="date" name='task_deadline' value="<?php echo $deadline ?>"></div>
            </div>
            
            <div class="info_box">
                  <div class="info_box_title">Total duration:</div>
                  <div class="info_box_value"><?php echo $duration ?> day(s)</div>
            </div>

            <div class="info_box">
                  <div class="info_box_title">Task overdue:</div>
           			 <div class="info_box_value">
	                  	 <?php
							$check_task_overdue = "SELECT task_deadline, task_created FROM project_tasks WHERE task_id = $task_id";
							$result_overdue = mysqli_query($db, $check_task_overdue) or die(mysqli_error($db));

							if (mysqli_num_rows($result_overdue) > 0) {
							    $row_overdue = mysqli_fetch_assoc($result_overdue);

							    $task_deadline = $row_overdue['task_deadline'];
							    $task_created = $row_overdue['task_created'];

							    if ($task_deadline == "0000-00-00" || $task_deadline == null) {
							        // No deadline setup or deadline is null, so set a minimum deadline
							        $set_deadline = "UPDATE project_tasks SET task_deadline = DATE_ADD(task_created, INTERVAL 5 DAY) WHERE task_id = $task_id";
							        mysqli_query($db, $set_deadline);
							    } else {
							        // Deadline is set, check if overdue
							        $today = new DateTime();  // Current date and time
							        $task_deadline = new DateTime($task_deadline);  // Assuming $task_deadline is a string in "Y-m-d" format

							        $interval = $today->diff($task_deadline);  // Calculate difference between $today and $task_deadline

							        if ($interval->invert == 1) {
							            // $interval->invert is 1 if $task_deadline is in the past (overdue)
							            echo "YES (" . $interval->days . " days)";
							        } else {
							            echo "NO";
							        }
							    }
							} else {
							    echo "Task not found or invalid task ID.";
							}
						  ?>

              		</div>
           	 	</div><!-- info box -->
             </div><!--- info box wrap -->
            </div><!-- dashboard -->
             
       
      <!-- project_task_details_dashboard -->

      		 <div class="task_documents">
      		 	<div class="upload_file">
      		 	<input type="file"><button type="button" class="button"><i class="material-icons">attach_file</i></button></div>
      		 	</div>
      		 	<div class="uploaded_files">
      		 		<?php 
      		 			$get_uploaded_files = "SELECT * from project_task_documents WHERE task_id = $task_id";
      		 			$result = mysqli_query($db, $get_uploaded_files) or die("MySQL ERROR: " . mysqli_error($db));
						$num_rows = mysqli_num_rows($result);
						while ($row = mysqli_fetch_array($result)) {
							$id = $row['id'];

							$file_name = $row['file_name'];
							$description = $row['description'];
							$file_size = $row['file_size'];
							$file_extension = $row['file_extension'];
							$uploaded_at = $row['uploaded_at'];

						}
      		 		?>		
      		 	</div>	
      		</div> 	
      		

			<div class="project_task_timelines">
				<h3>Task history/timeline:</h3>

				<div class="task_timeline">
					<?php
						$sql = "SELECT * from project_tasks_timeline where task_id=$task_id ORDER BY action_id DESC LIMIT 5";
						$result = mysqli_query($db, $sql) or die("MySQL ERROR: " . mysqli_error($db));
						$num_rows = mysqli_num_rows($result);
						if ($num_rows == 0) {
							echo "<div class='info_messag''>No timeline available</div>";
						} else {
							while ($row = mysqli_fetch_array($result)) {
								$time_id = $row['action_id'];
								$action_text = $row['timeline_text'];
								$action_time = $row['date_added'];

								echo "<div class='time_line_action'>$action_text</div>";
							}
						}
						?>
					 <div class="timeline_see_more"><button class="button" type="button">See more</button></div>	
				</div>
			 </div>
			
			<div class="project_task_comments">
         <!-- vsetky taskove komentare  + moznost pridat novy komentar-->
         <h3>Task comments</h3>

         <div class="task_comments"><!--task_comments_wrap -->
            <?php
				// get all previous task comments
				$sql = "SELECT * from project_task_comments WHERE task_id=$task_id";
				// in addition get information from use based on user_id
				$result = mysqli_query($db, $sql) or die("MySQL ERROR: " . mysqli_error($db));
				mysqli_query($db, "INSERT INTO project_statement_log (action,date_added,statement) VALUES ('list_of_all_comments',now(),'$sql')");

				$numrows = mysqli_num_rows($result);

				if ($numrows == 0) {echo "<div class='info_messag'>No task comments available</div>";} else {

					while ($row = mysqli_fetch_array($result)) {
						$id = $row['id'];
						$user_id = $row['user_id'];
						$user_name = GetUserNameById($user_id);
						$date_added = $row['date_added'];
						$post_text = $row['post_text'];

						$image = "img/users_pics/" . $user_id . "/user_" . $user_id . "_32x32.jpg";

						echo "<div class='task_comment'>";
  						echo "<div class='project_task_user_image'><img src='" . $image . "' alt='" . $user_id . "'></div>";
  						echo "<div class='task_commented_by'><a href='project_user_profile.php?user_id=$user_id' class='link'>$user_name</a></div>";
                        echo "<div class='task_comment_text'>$post_text</div>";
                        echo "<div class='task_comment_date'>$date_added</div>";
						echo "</div>";
					}
				}
				?>
               
                <form action="project_task.php" method="post">
                     <input type="hidden" name="project_cislo" value="<?php echo $project_id; ?>">
                     <input type="hidden" name="task_id" value="<?php echo $task_id ?>"/>
                     <input type="hidden" name="user_id" value="<?php echo $user_id ?>" />
                     <textarea name="task_comment" placeholder="type comment here..."></textarea>
                     <div class="task_comment_action">
                      	<button type="submit" class="blue-badge" name="add_task_comment" alt="Add task comment"><i class="fa fa-plus"></i></button>
                      </div>
                  </form>

         </div><!--task_comments_wrap -->


      </div>
      <!-- vsetky taskove komentare  + moznost pridat novy komentar-->

        <div class="task_assigned_person">
        	   <h3>Task owner</h3>
        	   <div class="task_assigned_person_wrap">
	        		<?php
	        				$get_task_owner = "SELECT user_id from project_tasks WHERE task_id=$task_id";
	        				//echo $get_task_owner;
	        				$result = mysqli_query($db,$get_task_owner) or die(mysqli_error($db));
	        				$row = mysqli_fetch_array($result);
	        					$user_id = $row['user_id'];	
	        				if($user_id == 0 ){
	        					echo "<button type='button' class='blue-badge' name='add_new_person'><i class='fa fa-plus'></i></button>";
	        				} else {

	        					$task_owner = GetUserNameById($row['user_id']);

	        					echo "<button type='blue-badge' user-id=$user_id>$task_owner</button><button type='button' class='button' name='remove_person' title='unassign the task for $task_owner'><i class='fa fa-times'></i></button>";
	        				}
	        		?>
        		</div>
        </div>
      </div>
      <!--project_task_quick_notes -->
   </div>
   <!-- div middle -->
   <?php include "include/footer.php";?>
</div>


<dialog id="project_task_full_history">
	<header>
		<span>Show task full history: </span>
		<button type="button" class="button"><i class="fa fa-times"></i></button>
	</header>
	<div class="dialog_task_timeline">
		<?php
			 //reparatio for paging
         $itemsPerPage = 10;
         $initial_page = 1;
         $current_page = isset($_POST['page']) ? $_POST['page'] : 1;
         $offset = ($current_page - 1) * $itemsPerPage;


			$sql = "SELECT * from project_tasks_timeline where task_id=$task_id LIMIT $itemsPerPage OFFSET $offset";
			$result = mysqli_query($db, $sql) or die("MySQL ERROR: " . mysqli_error($db));
			$num_rows = mysqli_num_rows($result);
			if ($num_rows == 0) {
				echo "<div class='info_messag''>No timeline available</div>";
			} else {
				while ($row = mysqli_fetch_array($result)) {
					$time_id = $row['action_id'];
					$action_text = $row['timeline_text'];
					$action_time = $row['date_added'];

					echo "<div class='time_line_action'>$action_text</div>";
				}
			}
	    ?>          
	</div>					
	   <?php
       // Calculate the total number of pages
       $get_pages = "SELECT COUNT(*) as total FROM project_tasks_timeline where task_id=$task_id";
       $result=mysqli_query($db, $get_pages);
       $row = mysqli_fetch_array($result);
       $totalItems = $row['total'];
       $totalPages = ceil($totalItems / $itemsPerPage);

      // Display pagination links
			echo "<div class='timeline_pagination'>";
			for ($i = 1; $i <= $totalPages; $i++) {
			    echo "<button type='button' class='button'>" . $i . "</button>";
			}
			echo "</div>";

	   ?>
</dialog>

<dialog id="assign_person_to_project">
	<div class="dialog_header"><button type="button" class="close_button"><i class="fa fa-times"></i></div>
	<?php
		 $get_all_project_users = "SELECT * from project_assigned_people WHERE project_id=$project_id";
		 $result=mysqli_query($db, $get_all_project_users) or die(mysqli_error($db));
		 while ($row = mysqli_fetch_array($result)){
		 	$user_id = $row['user_id'];
		 	$user_name = GetUserNameById($user_id);

		 	echo "<button type='button' class='button' user-id=$user_id>$user_name</button>";

		 }

	?>
</dialog>

<!-- main -->
</body>
</html>
