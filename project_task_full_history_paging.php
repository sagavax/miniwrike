<?php
include "include/dbconnect.php";
include "include/functions.php";

$page = $_POST['page'];
$task_id = $_POST['task_id'];

$itemsPerPage = 10;
$current_page = isset($_POST['page']) ? $_POST['page'] : 1;
$offset = ($current_page - 1) * $itemsPerPage;

$get_page_history = "SELECT * FROM project_tasks_timeline WHERE task_id = $task_id LIMIT $itemsPerPage OFFSET $offset";
$result = mysqli_query($db, $get_page_history) or die("MySQL ERROR: " . mysqli_error($db));
$num_rows = mysqli_num_rows($result);

while ($row = mysqli_fetch_array($result)) {
    $time_id = $row['action_id'];
    $action_text = $row['timeline_text'];
    $action_time = $row['date_added'];
     echo "<div class='time_line_action'>$action_text</div>";
 }
