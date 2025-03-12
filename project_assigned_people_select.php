<?php include "include/dbconnect.php";?>
<?php include "include/functions.php";?>
<?php session_start();?>



<?php

	$project_id = $_POST['project_id'];

$sql = "SELECT *, ABS(DATEDIFF(assigned_date, now())) AS duration 
        FROM project_assigned_people 
        WHERE project_id = $project_id"; // Get list of people assigned to project including their duration

$result = mysqli_query($db, $sql) or die("MySQL ERROR: " . mysqli_error($db));
$numrows = mysqli_num_rows($result);

if ($numrows == 0) {
    echo "<span>No people assigned to this project</span>";
} else {
    // echo "<ul>";
    while ($row = mysqli_fetch_array($result)) {
        $id = $row['id'];
        $user_id = $row['user_id'];
        $user_name = GetUserNameById($user_id);
        $assigned_date = $row['assigned_date'];
        $image = "img/non-avatar_32.jpg";
        $duration = $row['duration'];
        
        // echo "<li>";
        echo "<select name='user_id'>";
            echo "<option value=$user_id'>$user_name</option>";
        echo "</selct>"; // assigned_person
    }
}
