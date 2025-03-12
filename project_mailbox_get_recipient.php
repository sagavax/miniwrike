	<?php session_start();?>
	<?php include "include/dbconnect.php";?>
	<?php include "include/functions.php";?>


	<?php $user_id = $_GET['user_id'];

	// SQL query to get user info
$get_user_info = "SELECT * FROM project_users WHERE user_id=$user_id";
$result = mysqli_query($db, $get_user_info) or die("MySQL ERROR: " . mysqli_error($db));

// Array to hold the user info
$user_info = array();

// Fetch the result and store it in the array
while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
    $user_info = array(
        'user_id' => $row['user_id'],
        'full_name' => $row['full_name'],
      );
}

// Convert the array to JSON
$user_info_json = json_encode($user_info);

// Output the JSON (for example, if you want to return it from an API endpoint)
echo $user_info_json;
