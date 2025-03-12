<?php include "include/dbconnect.php";?>
<?php include "include/functions.php";?>
<?php session_start();


$search_string = $_GET['search_string'];


$get_peple = "SELECT * from project_users WHERE last_name LIKE '%".$search_string."%'";
$result = mysqli_query($db, $get_peple) or die(mysqli_error($db));

while ($row = mysqli_fetch_array($result)) {
        $user_id = $row['user_id'];
        $user_name = GetUserNameById($user_id);
        
echo "<button type='button' class='button'>$user_name</button>";   
}