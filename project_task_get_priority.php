<?php
// Ensure connection to the database is established
include "include/dbconnect.php";
include "include/functions.php";

$priority = $_POST['priority'];
$project_id = $_POST['project_id'];

// Validate and sanitize inputs
$priority = mysqli_real_escape_string($db, $priority);
$project_id = mysqli_real_escape_string($db, $project_id);

if ($priority == "0") {
    $get_tasks_by_priority = "SELECT * FROM project_tasks WHERE project_id = $project_id AND task_status NOT IN ('cancelled', 'complete') ORDER BY task_id DESC";
} else {
    $get_tasks_by_priority = "SELECT * FROM project_tasks WHERE task_priority = '$priority' AND project_id = $project_id ORDER BY task_id DESC";
}

// Execute the query
$result = mysqli_query($db, $get_tasks_by_priority) or die("MySQL ERROR: " . mysqli_error($db));

// Check if any tasks are returned
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_array($result)) {
        $id = $row['task_id'];
        $project_id = $row['project_id'];
        $user_id = $row['user_id'];
        $note_text = htmlspecialchars($row['task_name']); // Sanitize output
        $status = $row['task_status'];
        $date_added = $row['task_created'];
        $owner_of_task = GetUserNameById($user_id);
        $priority = $row['task_priority'];

        echo "<div class='task' task-id='$id'>";
        echo "<div class='task_name' title='Note text'>$note_text</div>";
        echo GetStatusList($status);
        echo GetPriorityList($priority);
        echo "</div>";
    }
} else {
    echo "<div>No tasks found for the specified criteria.</div>";
}
?>
