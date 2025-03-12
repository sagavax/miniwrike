<?php include "include/dbconnect.php";?>
<?php include "include/functions.php";?>
<?php session_start();?>


<?php
	$user_id = $_POST['user_id'];
	$project_id = $_POST['project_id'];


	//check if this user is already as pm
	// Prepare the SQL statement to check if the user is already a project manager
$check_pm = "SELECT * FROM project_managers WHERE user_id = ? AND project_id = ?";
$stmt_check = $db->prepare($check_pm);
$stmt_check->bind_param('ii', $user_id, $project_id);
$stmt_check->execute();
$result_check = $stmt_check->get_result();

if (mysqli_num_rows($result_check) == 0) {
    // Prepare the SQL statement to assign the user as a project manager
    $assign_as_pm = "INSERT INTO project_managers (user_id, project_id, added_date) VALUES (?, ?, NOW())";
    $stmt_assign = $db->prepare($assign_as_pm);
    $stmt_assign->bind_param('ii', $user_id, $project_id);
    $stmt_assign->execute();
    
    if ($stmt_assign->affected_rows > 0) {
        echo "User assigned as project manager.";
    } else {
        echo "Error: Unable to assign user as project manager.";
    }
    
    $stmt_assign->close();
} else {
    echo "user_is_pm";
}

$stmt_check->close();


	