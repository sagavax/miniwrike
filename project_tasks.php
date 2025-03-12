<?php include "include/dbconnect.php"?>
<?php include "include/functions.php"?>
<?php session_start();?>

<!DOCTYPE html>
<html lang="en">
<head>
	 <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Miniwrike - simple project task manager - tasks</title>
    <link href="css/style.css?v<?php echo time(); ?>" rel="stylesheet" type="text/css" />
    <link href="css/tasks.css?v<?php echo time(); ?>" rel="stylesheet" type="text/css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" rel="stylesheet" type="text/css" />
    <link href='http://fonts.googleapis.com/css?family=PT+Sans:400,700' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,300,300italic,700,700italic,400italic'
        rel='stylesheet' type='text/css'>
     <link rel='shortcut icon' href='project.ico'>
     <script type="text/javascript" src="js/tasks.js" defer></script>
     <script type="text/javascript" src="js/clock.js" defer></script>
     
</head>

<body>
    <div id="main">

        <!-- header -->

        <?php include "include/header.php";
			include "include/menu.php";?>


      <?php
		$project_id = $_SESSION['project_id'];
     	echo ProjectTitle($project_id);

		?>

        
        <div id="middle">
            <!-- middle section -->
  <div class="project_tasks_mass_action">Set status for all tasks: 
  		<select name="status">
  			<option value="new">new</option>
  			<option value="in progress">in progress</option>
  			<option value="pending">pending</option>
  			<option value="complete">complete</option>
  			<option value="cancelled">cancelled</option>
  		</select>	
  			or prioity for 
		<select name="priority">
  			<option value="low">low</option>
  			<option value="normal">normal</option>
  			<option value="high">high</option>
  			<option value="critical">critical</option>
  		</select>	

  		 or filter tasks: 
  		  <select name="filter_status">
            <option value=0>--- status ---</option>
            <option value="new">new</option>
            <option value="in progress">in progress</option>
            <option value="pending">pending</option>
            <option value="complete">complete</option>
            <option value="cancelled">cancelled</option>
            </select>

          <select name="filter_priority">
          	<option value=0>--- priority ---</option>
            <option value="low">low</option>
            <option value="normal">normal</option>
            <option value="high">high</option>
          </select>
      </div>      	

      	<div class="search">
            <input type="text" name="task_text" autocomplete="off"
                placeholder="string to search"><button type="button" name="search_task"
                class="blue-badge"><i class="fa fa-search"></i></button>
        </div>


         	<div id="add_task"><!-- add task -->
				<button type="button" name="add_new_task" class="blue-badge"><i class="fa fa-plus"></i></button>
			</div><!-- add task -->
	
			<div class="project_tasks">
                <?php


        	        $itemsPerPage = 10;

                     $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
                     $offset = ($current_page - 1) * $itemsPerPage;

        			$get_active_tasks = "SELECT * FROM project_tasks WHERE project_id =$project_id  and task_status not in ('cancelled','complete') ORDER BY task_id DESC LIMIT $itemsPerPage OFFSET $offset";

        	    	$result = mysqli_query($db, $get_active_tasks) or die("MySQL ERROR: " . mysqli_error($db));

        		    while ($row = mysqli_fetch_array($result)) {
        				$id = $row['task_id'];
        				$project_id = $row['project_id'];
        				$user_id = $row['user_id'];
        				$note_text = $row['task_name'];
        				$status = $row['task_status'];
        				$date_added = $row['task_created'];
        				//$flag=$row['colFlag'];
        				$owner_of_task = GetUserNameById($user_id);
        				$priority = $row['task_priority'];

        				//echo "<tr class='$color' id='".$id."'>";
        				echo "<div class='task' task-id=$id>";
        				echo "<div class='task_name' title='Note text'>$note_text</div>";
        				echo "<div class='task_updates' task-id=$id>".GetCountTaskUpdates($id)."</div>";
        				echo "<div class='task_owner'>".GetTaskOwner($id)."</div>";
        				echo "<div class='task_priority $priority' title='Priority'>$priority</div>";
        				if($row['task_status'] == "in progress"){
        					$status = "in_progress";
        				}	
        				echo "<div class='task_status $status' title='Status'>".$row['task_status']."</div>";
        							 
        				//echo "<div class='task_status $status' title='Status'>".$row['task_status']."</div>";

        				echo "<div class='task_created' title='date when created'>$date_added</div>";
        				//echo GetStatusList($status);
        			    //echo GetPriorityList($priority);
        				//echo "<div class='status_badge' title='Subtasks'>" . NrOfSubtasks($id) . "</div>";
        				//echo "<div class='task_action'><button type='button' class='blue-badge' title='View' name='view_task'><i class='fa fa-eye'></i></button><button type='button' class='blue-badge' title='Mark as complete' name='mark_complete'><i class='fa fa-check'></i></button><button type='button' class='blue-badge' name='cancel_task'><i class='fa fa-times' title='Cancel this task'></i></button></div>";
        				echo "</div>";
        			}
        			?>
			</div><!-- project _tasks -->
    			<?php
                    // Calculate the total number of pages
                    $sql = "SELECT COUNT(*) as total FROM project_tasks where project_id=$project_id  and task_status not in ('cancelled','complete')";
                    $result=mysqli_query($db, $sql);
                    $row = mysqli_fetch_array($result);
                    $totalItems = $row['total'];
                    $totalPages = ceil($totalItems / $itemsPerPage);

                    // Display pagination links
                    echo '<div class="pagination">';
                    for ($i = 1; $i <= $totalPages; $i++) {
                        echo '<a href="?page=' . $i . '"">' . $i . '</a>';
                        //echo '<a href="?project_id='.$project_id.'&page=' . $i . '"">' . $i . '</a>';
                        //echo '<a href="?page=' . $i . '" class="button app_badge">' . $i . '</a>';
                    }
                    echo '</div>';
                 ?>
		    </div><!-- middle section -->
       
        <?php include "include/footer.php";?>

    </div><!-- main wrapper -->
    <div id ="task_priority_popup">

    	<ul>
    		<li><button type="button">low</button></li>
    		<li><button type="button">normal</button></li>
    		<li><button type="button">high</button></li>
    		<li><button type="button">critical</button></li>
    	</ul>
    </div>
    
    <div id ="task_status_popup">
    	<ul>
    		<li><button type="button">new</button></li>
    		<li><button type="button">in progress</button></li>
    		<li><button type="button">pending</button></li>
    		<li><button type="button">cancel</button></li>
    		<li><button type="button">finish</button></li>
    	</ul>
    </div>

    <dialog id="add_new_update">
    	<div class="dialog_header"><button type="button" class="close_button"><i class="fa fa-times"></i></button></div>
    	<textarea name="task_update" id="editor" placeholder="task update...."></textarea>
    	<div class="dialog_action"><button class="button">Update</button></dialog>
    </dialog>

    <dialog id="add_new_task_dialog">
        <div class="dialog_header"><button type="button" class="close_button"><i class="fa fa-times"></i></button></div>
        <input type="text" name="task_name" placeholder="Enter the task name....";>
        <div class="dialog_action"><button class="blue-badge" name="create_task" type="button">Create task</button></div>   
    </dialog>