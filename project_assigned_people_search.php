<?php 
include "include/dbconnect.php";
include "include/functions.php";
session_start();

$project_id = $_GET['project_id'];
$searched_person = $_GET['string'];
$itemsPerPage = 10;
$current_page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($current_page - 1) * $itemsPerPage;

$sql = "SELECT a.*, ABS(DATEDIFF(assigned_date, now())) AS duration, b.full_name 
        FROM project_assigned_people a, project_users b 
        WHERE project_id = $project_id 
        AND b.full_name LIKE '%".$searched_person."%' 
        AND a.user_id = b.user_id";

$result = mysqli_query($db, $sql) or die("MySQL ERROR: " . mysqli_error($db));
$numrows = mysqli_num_rows($result);

if ($numrows == 0) {
    echo "<span>No people assigned to this project</span>";
} else {
    while ($row = mysqli_fetch_assoc($result)) {
        $id = $row['id'];
        $user_id = $row['user_id'];
        $user_name = GetUserNameById($user_id);
        $assigned_date = $row['assigned_date'];
        $image = "img/non-avatar_32.jpg";
        $duration = $row['duration'];

        echo "<div class='assigned_person' user-id=$user_id>";
        echo "<div class='person_image'><img src='" . $image . "' alt='" . $user_id . "'></div>";
        echo "<div class='assigned_person_details'>
                <div class='person_name'>$user_name</div>
                <span class='assigned_date'>$assigned_date</span>
                <span class='assigned_duration'>$duration days</span>";
        echo "<button type='button' class='button' name='remove_from_project' alt='Remove user from the project'><i class='fa fa-times'></i></button>";
        echo "</div>"; // assigned person details
        echo "</div>"; // assigned person
    }
}
?>