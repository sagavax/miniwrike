<?php 
include "include/dbconnect.php";
include "include/functions.php";

$status = $_POST['status'];
$project_id = $_POST['project_id'];

$get_tasks_by_status = "SELECT * from project_tasks WHERE task_status='$status' and project_id=$project_id ORDER BY task_id DESC";
//echo $get_tasks_by_status;
$result = mysqli_query($db, $get_tasks_by_status) or die("MySQL ERROR: " . mysqli_error());

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
				//echo "<div class='status_badge' title='Priority'>$priority</div>";
				echo GetStatusList($status);
				echo GetPriorityList($priority);
				//echo "<div class='status_badge' title='Subtasks'>" . NrOfSubtasks($id) . "</div>";
				//echo "<div class='status_badge' title='Status'>$status</div>";
				//echo "<div class='task_action'><button type='button' class='blue-badge' title='View' name='view_task'><i class='fa fa-eye'></i></button><button type='button' class='blue-badge' title='Mark as complete' name='mark_complete'><i class='fa fa-check'></i></button><button type='button' class='blue-badge' name='cancel_task'><i class='fa fa-times' title='Cancel this task'></i></button></div>";
				echo "</div>";
			}
			echo "</div>";

