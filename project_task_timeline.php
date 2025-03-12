<?php
include "include/dbconnect.php";
include "include/functions.php";


$task_id = $_GET['task_id'];

$sql = "SELECT * from project_tasks_timeline where task_id=$task_id";
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