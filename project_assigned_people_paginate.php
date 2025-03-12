<?php 
include "include/dbconnect.php";
include "include/functions.php";
session_start();

$page = $_GET['page'];
$project_id = $_GET['project_id'];

$itemsPerPage = 10;
$current_page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($current_page - 1) * $itemsPerPage;

$sql = "SELECT *, ABS(DATEDIFF(assigned_date, now())) AS duration 
        FROM project_assigned_people 
        WHERE project_id = $project_id 
        LIMIT $itemsPerPage OFFSET $offset"; // Get list of people assigned to project including their duration

$result = mysqli_query($db, $sql) or die("MySQL ERROR: " . mysqli_error($db));
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
        $duration = $row['duration'];

            $project_role = $row['project_role'];
            if ($project_role != 0) {
                $project_role = htmlspecialchars(GetRoleName($project_role), ENT_QUOTES, 'UTF-8');
            } else {
                $project_role = "<button class='button' name='add_role'><i class='fa fa-plus'></i> Add role</button>";
            }

            $project_technology = $row['project_technology'];
            if ($project_technology != 0) {
                $project_technology = htmlspecialchars(GetTechName($project_technology), ENT_QUOTES, 'UTF-8');
            } else {
                $project_technology = "<button class='button' name='add_technology'><i class='fa fa-plus'></i> Add technology</button>";
            }

        echo "<div class='assigned_person' user-id=$user_id>";
        echo "<div class='person_image'><img src='" . $image . "' alt='" . $user_id . "'></div>";
        echo "<div class='assigned_person_details'>
               <div class='person_name'>$user_name</div>
                <div class='project_role'>$project_role</div>
                <div class='project_technology'>$project_technology</div>
                <span class='assigned_date'>$assigned_date</span>
                <span class='assigned_duration'>$duration days</span>";
        echo "<button type='button' class='button' name='remove_from_project' alt='Remove user from the project'><i class='fa fa-times'></i></button>";
        echo "</div>"; // assigned person details
        echo "</div>"; // assigned person
    }
}
?>
