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
    <link href="css/style.css?v<?php echo time(); ?>" rel="stylesheet" type="text/css" />
    <link href="css/workload.css?v<?php echo time(); ?>" rel="stylesheet" type="text/css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
    <link href='http://fonts.googleapis.com/css?family=PT+Sans:400,700' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,300,300italic,700,700italic,400italic' rel='stylesheet'>
    <link rel='shortcut icon' href='project.ico'>
    <script type="text/javascript" src="js/workload.js" defer></script>
</head>
<body>
    <div id="main">
        <?php
	        
	        $project_id = $_SESSION['project_id'];
            echo $project_id;
        ?>

        <!-- header -->
        <?php include "include/header.php"; ?>
        <?php include "include/menu.php"; ?>
        <!-- header -->

        <?php echo ProjectTitle($project_id); ?>

        <div id="middle"> <!-- middle section -->
            <div class="project_workload">
                <div class="assigned_tasks">
                	<h3>Assigned peaople</h3>
                	     		<?php 
							$get_assigned_people = "SELECT * FROM project_assigned_people WHERE project_id=$project_id"; // get list of ppl assigned to project including their duration
							$result = mysqli_query($db, $get_assigned_people) or die("MySQL ERROR: " . mysqli_error($db)); // use the correct variable and include the connection variable in mysqli_error()
							$numrows = mysqli_num_rows($result);
							if ($numrows == 0) {
							    echo "<span>No people assigned to this project</span>";
							} else {
							    while ($row = mysqli_fetch_array($result)) {
							        $id = $row['id'];
							        $user_id = $row['user_id'];
							        $user_name = GetUserNameById($user_id);
							        $assigned_date = $row['assigned_date'];
							        $image = "img/non-avatar_32.jpg";
							        							        
							        echo "<div class='assigned_person'>";
								        echo "<div class='project_person'><span>$user_name</span><button class='button'><i class='fa fa-plus'></i></button></div>";
								        echo "<ul data-id='$user_id' class='person_assigned_tasks'>";
								        	$get_assigned_tasks = "SELECT * from project_tasks WHERE user_id = $user_id and project_id = $project_id and task_status not in ('cancelled','complete')" ;
								        	//echo $get_assigned_tasks;
								        	$result_tasks = mysqli_query($db, $get_assigned_tasks) or die("MySQL ERROR: " . mysqli_error($db)); // use the correct variable and include the connection 
								        	while ($row_tasks = mysqli_fetch_array($result_tasks)) {
										    $user_id = $row_tasks['user_id'];
										    $task_id = $row_tasks['task_id'];
										    $task_status_assigned = $row_tasks['task_status'];

										  echo "<li draggable='true' class='task_id' task-id=$task_id>";
                                            echo "<div class='workload_task'>";
                                                echo "<div class='wrkld_header'><span><a href='#' class='link'><i class='fa fa-times'></i></a></span></div>";
                                                echo "<div class='wrkld_task_name'>".TaskName($task_id)."</div>";
                                                echo "<div class='wrkld_task_status'>$task_status_assigned</div>";
                                            echo "</div>";    
                                          echo "</li>";
										  }
								        echo "</ul>";
								    echo "</div>";
							    }
							}
							?>
                  </div><!-- assigned -tasks -->          
                  <div class="unassigned_tasks">
                    <header><h3>Unassigned active tasks</h3><button class="button"><i class="fa fa-plus"></i></button></header>
                    <main>
                        <ul>
                            <?php
                            $get_unassigned_tasks = "SELECT task_id, task_status FROM project_tasks 
                                                     WHERE project_id = $project_id and user_id=0 
                                                   AND task_status NOT IN ('cancelled', 'complete')";
                            
                            $result_unassigned = mysqli_query($db, $get_unassigned_tasks) or die("MySQL ERROR: " . mysqli_error($db));
                            
                            while ($row_unassigned = mysqli_fetch_array($result_unassigned)) {
                                
                                $task_id = $row_unassigned['task_id'];
                                $task_status_unassigned = $row_unassigned['task_status'];

                                echo "<li draggable='true' class='task_id' task-id=$task_id>";
                                    echo "<div class='workload_task'>";
                                        echo "<div class='wrkld_header'><span><a href='#' class='link'><i class='fa fa-times'></i></a></span></div>";
                                        echo "<div class='wrkld_task_name'>".TaskName($task_id)."</div>";
                                        echo "<div class='wrkld_task_status'>$task_status_unassigned</div>";
                                    echo "</div>";    
                                 echo "</li>";
                            }
                            ?>
                        </ul>
                    </main>
                </div><!-- unassigned -->

                <div class="inactive_tasks">
                    <h3>Inactive tasks (cancelled, complete)</h3>
                    <ul>
                        <?php
                        $get_inactive_tasks = "SELECT task_id,task_status FROM project_tasks 
                                              WHERE project_id = $project_id 
                                              AND task_status IN ('cancelled','complete')";
                        
                        $result_inactive = mysqli_query($db, $get_inactive_tasks) or die("MySQL ERROR: " . mysqli_error($db));
                        
                        while ($row_inactive = mysqli_fetch_array($result_inactive)) {
                            
                            $task_id = $row_inactive['task_id'];
                            $task_status_inactive = $row_inactive['task_status'];

                               echo "<li draggable='true' class='task_id' task-id=$task_id>";
                                echo "<div class='workload_task'>";
                                    echo "<div class='wrkld_header'><span><a href='#' class='link'><i class='fa fa-times'></i></a></span></div>";
                                    echo "<div class='wrkld_task_name'>".TaskName($task_id)."</div>";
                                    echo "<div class='wrkld_task_status'>$task_status_inactive</div>";
                                echo "</div>";    
                             echo "</li>";
                        }
                        ?>
                    </ul>
                </div><!-- inactive tasks -->
            </div><!-- project workload -->  
        </div><!-- div middle -->
        <dialog id="add_new_task_dialog">
            <input type="text" name="add_task" placeholder="Add new task here..."><button type="button" class="button"><i class="fa fa-plus"></i></button>
        </dialog>

        <dialog id="show_unaasigned_tasks">
                    
        </dialog>


        <?php include "include/footer.php"; ?>
        <!-- FOOTER -->
    </div><!-- main -->
</body>
</html>
