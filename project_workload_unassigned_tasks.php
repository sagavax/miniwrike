<?php
include "include/dbconnect.php";
include "include/functions.php";

$project_id = $_GET['project_id'];

$get_unassigned_tasks = "SELECT * FROM project_tasks 
                         WHERE project_id = $project_id 
                         AND user_id = 0 
                         AND task_id NOT IN (SELECT task_id FROM project_task_assigned_people WHERE project_id = $project_id) 
                         AND task_status NOT IN ('cancelled','complete')";

$result = mysqli_query($db, $get_unassigned_tasks) or die("MySQL ERROR: " . mysqli_error($db));

echo "<ul>";

while ($row = mysqli_fetch_array($result)) {
    $task_id = $row['task_id'];
    $task_status = $row['task_status'];

    echo "<li draggable='true' class='task_id' task-id='$task_id'>";
        echo "<div class='workload_task'>";
            echo "<div class='wrkld_header'><span><a href='#' class='link'><i class='fa fa-times'></i></a></span></div>";
            echo "<div class='wrkld_task_name'>" . TaskName($task_id) . "</div>";
            echo "<div class='wrkld_task_status'>$task_status</div>";
        echo "</div>";    
    echo "</li>";
}

echo "<ul>";

?>

