<?php session_start();?>
<?php include "include/dbconnect.php";?>
<?php include "include/functions.php";?>

<?php

$sort = $_GET['sort'];
$project_id = $_GET['project_id'];

if($sort==="asc") {
	$get_assigned_people = "SELECT * 
                        FROM project_assigned_people a
                        JOIN project_users b ON a.user_id = b.user_id
                        WHERE a.project_id = $project_id ORDER BY full_name ASC";

} elseif ($sort=="dsc"){
	$get_assigned_people = "SELECT * 
                        FROM project_assigned_people a
                        JOIN project_users b ON a.user_id = b.user_id
                        WHERE a.project_id = $project_id ORDER BY full_name DESC";
} else {
	$get_assigned_people = "SELECT * 
                        FROM project_assigned_people a
                        JOIN project_users b ON a.user_id = b.user_id
                        WHERE a.project_id = $project_id";
	
}


// Execute the SQL query
$result = mysqli_query($db, $get_assigned_people) or die("MySQLi ERROR: " . mysqli_error($db));

// Loop through the results and display each contact
while ($row = mysqli_fetch_array($result)) {
    // Extract data from the current row
    $full_name = $row['full_name'];
    $id = $row['user_id'];

    // Output HTML for each contact
    echo "<div class='contact' contact-id='$id'>
              <div class='full_name'>$full_name</div>
              <div class='contact_button_group'>
                  <button type='button' name='view_contact' class='blue-badge' title='View details'><i class='fa fa-eye'></i></button>
                  <button type='button' name='edit_contact' class='blue-badge' title='Edit details'><i class='fa fa-edit'></i></button>
                  <button type='button' class='blue-badge' title='Send Email'><i class='fa fa-envelope'></i></button>
                  <button type='button' class='blue-badge' title='Delete Contact'><i class='fa fa-times'></i></button>
              </div>
          </div>";
}

// Free the result set
mysqli_free_result($result);
